<?php

namespace app\modules\aid\controllers;
use app\models\teachplan\Teachingclassdetails;
//学生信息获取
use app\models\systembase\Studentinfo;
//提问
use app\models\aid\Question;

use app\models\aid\Gradescoreset;
//出勤模型
use app\models\aid\Attendancerecord;

use app\models\teachplan\Teachingclassmannage;
use app\models\aid\Studentswork;
use app\models\aid\Staticmodulepercent;
use app\models\aid\Commonhomework;
//综合成绩

require_once __DIR__.'/../../../web/component/excel/PHPExcel/IOFactory.php';
class SumGradeController extends \app\controllers\BaseController
{
	public $enableCsrfValidation=false;
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionGetGradeSumAll()
    {
    	if(\Yii::$app->request->isPost)
    	{
    		$post = \Yii::$app->request->post();
    		if(isset($post['TeachingClassID']) && $post['TeachingClassID'])
    		{
    			//获取所学生信息
    			$allStu = (new \yii\db\Query())
	            ->select(Studentinfo::tableName().'.StuNumber,Name,Sex')
	            ->from(Studentinfo::tableName())
	            ->leftJoin(Teachingclassdetails::tableName(),
                    Teachingclassdetails::tableName().'.StuNumber='.Studentinfo::tableName().'.StuNumber')
	            ->where(['TeachingClassID'=>$post['TeachingClassID']])
	            ->orderBy('StuNumber ASC')
	            ->All();
	            //获取模块配置信息
	            $modulePercent = Staticmodulepercent::find()->where(['TeachingClassID'=>$post['TeachingClassID']])->asArray()->one();
	            //获取ABCDE的总分
        		$grade_set = Gradescoreset::find()->where(['TeachingClassID'=>$post['TeachingClassID']])->asArray()->all();
        		//获取作业布置次数
        		$all_homework = Commonhomework::find()->where(['TeachClass'=>$post['TeachingClassID'],'IsStuSee'=>'1'])->orderBy('DeadTime')->asArray()->all();
	        		// HomeworkID
	        	$homework_count = count($all_homework);
        		// $homework_count = count(Commonhomework::find()->where(['TeachClass'=>$post['TeachingClassID'],'IsStuSee'=>'1'])->asArray()->all());
        		$each_homework = $homework_count ? $modulePercent['HomeworkPercent']*1.0/$homework_count : 0;
        		// $sum_grade = 0;
        		// for($m=0; $m<count($grade_set); $m++)
        		// 	$sum_grade += $grade_set[$m]['Score'];
	            for($i=0; $i<count($allStu); $i++)
	            {
	            	$allStu[$i]['attentionScore'] = 0;
	            	$allStu[$i]['attentionRecord'] = '';
	            	$allStu[$i]['homeworkScore'] = 0;
	            	$allStu[$i]['homeworkScoreGrade'] = '';
	            	$allStu[$i]['questionScore'] = 0;
	            	$allStu[$i]['questionScoreGrade'] = '';
	            	//获取每个学生出勤记录和分数
	            	$att = Attendancerecord::find()->where(['TeachClass'=>$post['TeachingClassID'],'StudentNum'=>$allStu[$i]['StuNumber']])->orderBy('AttendanceDate')->asArray()->all();
	            	//出勤情况
	            	//出勤分数 = 出勤所占分数*（出勤次数/总次数）
	            	
	            	$each_att = count($att) ? $modulePercent['AttendancePercent']*1.0/count($att) : 0;
	            	for($j=0; $j<count($att); $j++)
	            	{
	            		$allStu[$i]['attentionRecord'] .= $att[$j]['AttendanceState']==1 ? '到|' : '未|';
	            		$allStu[$i]['attentionScore'] += $att[$j]['AttendanceState']==1 ? $each_att : 0;
	            	}
	            	//获取每个学生平时作业情况
	            	for($j=0; $j<count($all_homework); $j++)
		            	{
		            		$work ='' ;
		            		$work = Studentswork::find()->where(['HomeworkID'=>$all_homework[$j]['HomeworkID'],'StudentNum'=>$allStu[$i]['StuNumber']])->asArray()->one();
		            	
		            		if($work == NULL)
		            		{
		            			$allStu[$i]['homeworkScoreGrade'] .= '未提交'.'|';
		            			$allStu[$i]['homeworkScore'] += 0;
		            		}
		            		else
		            		{
		            			$allStu[$i]['homeworkScoreGrade'] .= $work['ScoreGrade'] ? $work['ScoreGrade'].'|' : '未批阅|';
		            			for($n=0; $n<count($grade_set); $n++)
		            				if(trim($grade_set[$n]['GradeName']) == trim($work['ScoreGrade']))
		            				{

		            					$allStu[$i]['homeworkScore'] += $each_homework*1.0*($grade_set[$n]['Score']/10.0);
		            					break;
		            				}
			            		
		            		}
		            		
		            	}
	            
	            	//获取每个学生提问情况

	            	$question = Question::find()->where(['TeachClass'=>$post['TeachingClassID'],'StudentNum'=>$allStu[$i]['StuNumber']])->orderBy('ScoreGrade ASC')->asArray()->all();
	            	for($j=0; $j<count($question); $j++)
	            		$allStu[$i]['questionScoreGrade'] .= $question[$j]['ScoreGrade'].'|';
	            	//获取提问分数  分数=所获最高等级的分数*该等级所占比例
	            	//提问所存分数需要修改
	            	if(count($question) > 0)
	            	{
	            		//获取当前学生回答问题的最大ABCDE
	            		$aim_grade = Gradescoreset::find()->where(['TeachingClassID'=>$post['TeachingClassID'],'GradeName'=>$question[0]['ScoreGrade']])->asArray()->one()['Score'];
	            		//计算当前学生的回答问题分数
	            		$allStu[$i]['questionScore'] =  $modulePercent['QuestionPercent']*($aim_grade*1.0/10.0);
	            	}
	            	$allStu[$i]['sum'] = (int)($allStu[$i]['questionScore'] + $allStu[$i]['homeworkScore'] + $allStu[$i]['attentionScore']);
	            }
	            
	            // print_r($allStu);
	            echo json_encode($allStu);
    		}
    	}
    }

    public function actionGetGradeExcel()
    {
    	$teachName = '';
    	$objectPHPExcel = new \PHPExcel();
        $objectPHPExcel->setActiveSheetIndex(0);
        if(\Yii::$app->request->isGet)
    	{
    		$post = \Yii::$app->request->get();
	    	if(isset($post['TeachingClassID']) && $post['TeachingClassID'])
	    		{
	    			$teachName = Teachingclassmannage::find()->where(['TeachingClassID'=>$post['TeachingClassID']])->asArray()->one()['TeachingName'];
	    			//获取所学生信息
	    			$allStu = (new \yii\db\Query())
		            ->select(Studentinfo::tableName().'.StuNumber,Name,Sex')
		            ->from(Studentinfo::tableName())
		            ->leftJoin(Teachingclassdetails::tableName(),
	                    Teachingclassdetails::tableName().'.StuNumber='.Studentinfo::tableName().'.StuNumber')
		            ->where(['TeachingClassID'=>$post['TeachingClassID']])
		            ->orderBy('StuNumber ASC')
		            ->All();
		            //获取模块配置信息
		            $modulePercent = Staticmodulepercent::find()->where(['TeachingClassID'=>$post['TeachingClassID']])->asArray()->one();
		            //获取ABCDE的总分
	        		$grade_set = Gradescoreset::find()->where(['TeachingClassID'=>$post['TeachingClassID']])->asArray()->all();
	        		//获取作业布置次数，所有学生必须提交的作业
	        		$all_homework = Commonhomework::find()->where(['TeachClass'=>$post['TeachingClassID'],'IsStuSee'=>'1'])->orderBy('DeadTime')->asArray()->all();
	        		$homework_count = count($all_homework);
	        		$each_homework = $homework_count ? $modulePercent['HomeworkPercent']*1.0/$homework_count : 0;
		            for($i=0; $i<count($allStu); $i++)
		            {
		            	$allStu[$i]['attentionScore'] = 0;
		            	$allStu[$i]['attentionRecord'] = '';
		            	$allStu[$i]['homeworkScore'] = 0;
		            	$allStu[$i]['homeworkScoreGrade'] = '';
		            	$allStu[$i]['questionScore'] = 0;
		            	$allStu[$i]['questionScoreGrade'] = '';
		            	//获取每个学生出勤记录和分数
		            	$att = Attendancerecord::find()->where(['TeachClass'=>$post['TeachingClassID'],'StudentNum'=>$allStu[$i]['StuNumber']])->orderBy('AttendanceDate')->asArray()->all();
		            	//出勤情况
		            	//出勤分数 = 出勤所占分数*（出勤次数/总次数）
		            	$each_att = count($att) ? $modulePercent['AttendancePercent']*1.0/count($att) : 0;
		            	for($j=0; $j<count($att); $j++)
		            	{
		            		// $allStu[$i]['attentionScore'] += $att[$j]['Score'];
		            		$allStu[$i]['attentionRecord'] .= $att[$j]['AttendanceState']==1 ? '到|' : '未|';
		            		$allStu[$i]['attentionScore'] += $att[$j]['AttendanceState']==1 ? $each_att : 0;
		            	}
		            	//获取每个学生平时作业情况
		            	for($j=0; $j<count($all_homework); $j++)
		            	{
		            		$work ='' ;
		            		$work = Studentswork::find()->where(['HomeworkID'=>$all_homework[$j]['HomeworkID'],'StudentNum'=>$allStu[$i]['StuNumber']])->asArray()->one();
		            	
		            		if($work == NULL)
		            		{
		            			$allStu[$i]['homeworkScoreGrade'] .= '未提交'.'|';
		            			$allStu[$i]['homeworkScore'] += 0;
		            		}
		            		else
		            		{
		            			$allStu[$i]['homeworkScoreGrade'] .= $work['ScoreGrade'] ? $work['ScoreGrade'].'|' : '未批阅|';
		            			for($n=0; $n<count($grade_set); $n++)
		            				if(trim($grade_set[$n]['GradeName']) == trim($work['ScoreGrade']))
		            				{

		            					$allStu[$i]['homeworkScore'] += $each_homework*1.0*($grade_set[$n]['Score']/10.0);
		            					break;
		            				}
			            		
		            		}
		            		
		            	}
		            	//获取每个学生提问情况

		            	$question = Question::find()->where(['TeachClass'=>$post['TeachingClassID'],'StudentNum'=>$allStu[$i]['StuNumber']])->orderBy('ScoreGrade ASC')->asArray()->all();
		            	for($j=0; $j<count($question); $j++)
		            		$allStu[$i]['questionScoreGrade'] .= $question[$j]['ScoreGrade'].'|';
		            	//获取提问分数  分数=所获最高等级的分数*该等级所占比例
		            	//提问所存分数需要修改
		            	if(count($question) > 0)
		            	{
		            		//获取当前学生回答问题的最大ABCDE
		            		$aim_grade = Gradescoreset::find()->where(['TeachingClassID'=>$post['TeachingClassID'],'GradeName'=>$question[0]['ScoreGrade']])->asArray()->one()['Score'];
		            		//计算当前学生的回答问题分数
		            		$allStu[$i]['questionScore'] =  $modulePercent['QuestionPercent']*($aim_grade*1.0/10.0);
		            	}
		            	$allStu[$i]['sum'] = (int)($allStu[$i]['questionScore'] + $allStu[$i]['homeworkScore'] + $allStu[$i]['attentionScore']);
		            }
		            $sheet = ['A','B','C','D','E','F','G','H','I','J','K'];
		            //设置宽度
		            foreach ($sheet as $value)
		            	$objectPHPExcel->setActiveSheetIndex(0)->getColumnDimension($value)->setWidth(15);
		            //设置表头
		            $objectPHPExcel->setActiveSheetIndex(0)

				                 //Excel的第A列，uid是你查出数组的键值，下面以此类推
				                  ->setCellValue('A1', '学号')   
				                  ->setCellValue('B1', '姓名')
				                  ->setCellValue('C1', '性别')
				                  ->setCellValue('D1', '出勤记录')
				                  ->setCellValue('E1', '出勤得分')
				                  ->setCellValue('F1', '作业记录')
				                  ->setCellValue('G1', '作业得分')
				                  ->setCellValue('H1', '提问记录')
				                  ->setCellValue('I1', '提问得分')
				                  ->setCellValue('J1', '其他')
				                  ->setCellValue('K1', '总分')
				                  ;

		            foreach($allStu as $k => $v){

				    $num=$k+2;
				    //写入数据
				    $objectPHPExcel->setActiveSheetIndex(0)

				                 //Excel的第A列，uid是你查出数组的键值，下面以此类推
				                  ->setCellValue('A'.$num, $v['StuNumber'])
				                  ->setCellValue('B'.$num, $v['Name'])
				                  ->setCellValue('C'.$num, $v['Sex'])
				                  ->setCellValue('D'.$num, $v['attentionRecord'])
				                  ->setCellValue('E'.$num, $v['attentionScore'])
				                  ->setCellValue('F'.$num, $v['homeworkScoreGrade'])
				                  ->setCellValue('G'.$num, $v['homeworkScore'])
				                  ->setCellValue('H'.$num, $v['questionScoreGrade'])
				                  ->setCellValue('I'.$num, $v['questionScore'])
				                  ->setCellValue('J'.$num, '0')
				                  ->setCellValue('K'.$num, $v['sum'])
				                  ;
				    }

				    $objectPHPExcel->getActiveSheet()->setTitle('User');
				    $objectPHPExcel->setActiveSheetIndex(0);
				    header('Content-Type: application/vnd.ms-excel');
				    header('Content-Disposition: attachment;filename="'.$teachName.'总成绩.xls"');
				    header('Cache-Control: max-age=0');
				    $objWriter = \PHPExcel_IOFactory::createWriter($objectPHPExcel, 'Excel5');
				    $objWriter->save('php://output');
				    exit;
	    		}
	    }
	    else
	    	echo '参数不对';
    	
    }
}
