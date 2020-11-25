<?php

namespace app\modules\aid\controllers;
//出勤模型
use app\models\aid\Attendancerecord;
//字典
use app\models\system\TbcuitmoonDictionary;
//公共函数
use common\commonFuc;
//
use app\models\teachplan\Teachingclassmannage;
//教学学生
use app\models\teachplan\Teachingclassdetails;
//学生信息获取
use app\models\systembase\Studentinfo;
// use yii\db\Connection;


//平时点名
class StudentCheckController extends \app\controllers\BaseController
{
    public $enableCsrfValidation=false;
    public function actionIndex()
    {
    	$m_Dic = new TbcuitmoonDictionary();
    	$term_choice="请选择学期";
    	$class_choice="请选择计划班";
    	$date_choice="请选择日期";
        return $this->render('index',[
        	'term' => $m_Dic->getDictionaryList('学期'),
        	'term_choice'=>$term_choice,
        	'class_choice'=>$class_choice,
        	'date_choice'=>$date_choice,
        	]
        	);
    }
    //根据学期获取班级
    public function actionGetclass()
    {
    	if(\Yii::$app->request->isPost)
    	{
    		$post=\Yii::$app->request->post();
    		if(isset($post['term']))
    		{
    			$classAll=Teachingclassmannage::find()->where(
                ['Term'=>$post['term'],
                'TeacherName'=>\Yii::$app->session->get('UserName'),
                'CourseID'=>\Yii::$app->session->get('courseCode')
                ])->asArray()->all();
                //print_r($classAll);
                $array=array();
                for($i=0; $i<count($classAll); $i++)
                	$array['obj'.$i]=$classAll[$i];
               // var_dump($array);
                echo json_encode($array,JSON_UNESCAPED_UNICODE);
    		}
    	}
    }
    //获取已点到的日期
    public function actionGetdate()
    {
    	if(\Yii::$app->request->isPost)
    	{
    		$post=\Yii::$app->request->post();
    		if(isset($post['TeachingClassID']))
    		{
    			$res=array();
    			$date=Attendancerecord::find()->where(
    			    'TeachClass=:TeachingClassID',
                    [':TeachingClassID'=>$post['TeachingClassID']])
                    ->groupBy('AttendanceDate')
                    ->asArray()
                    ->all();

    			for($i=0; $i<count($date); $i++)
    					$res['date'.$i]=$date[$i];
    			echo json_encode($res,JSON_UNESCAPED_UNICODE);
    		}
    		
    	}
    }
    //获取班级上的学生信息
    public function actionGetstudent()
    {
    	if(\Yii::$app->request->isPost)
    	{
    		$post=\Yii::$app->request->post();
    		if(isset($post['TeachingClassID']))
    		{
    			
    			$stu_info = (new \yii\db\Query())
	            ->select(Studentinfo::tableName().'.StuNumber,Name,Sex,ClassName')
	            ->from(Studentinfo::tableName())
	            ->leftJoin(Teachingclassdetails::tableName(),
                    Teachingclassdetails::tableName().'.StuNumber='.Studentinfo::tableName().'.StuNumber')
	            ->where(['TeachingClassID'=>$post['TeachingClassID']])
	            ->orderBy('StuNumber ASC')
	            ->All();
    			echo json_encode($stu_info,JSON_UNESCAPED_UNICODE);
    		}
    	}
    }
    //获取状态
    public function actionGetstate()
    {
    	if(\Yii::$app->request->isPost)
    	{
    		$post=\Yii::$app->request->post();
    		if(isset($post['AttendanceDate']) && isset($post['TeachClass']))
    		{
    			$res=array();
    			$post['AttendanceDate'] = $post['AttendanceDate']=='now' ? date('Y-m-d') : $post['AttendanceDate'];
    			$state=Attendancerecord::find()->where(
    				['TeachClass'=>$post['TeachClass'],
    				'AttendanceDate'=>$post['AttendanceDate']])->asArray()->all();
    			for($i=0; $i<count($state); $i++)
    			{
    				$res['state'.$i]=$state[$i];
    			}
    			echo json_encode($res,JSON_UNESCAPED_UNICODE);
    		}
    	}
    }
    //新增点到信息
    public function actionAddcheck()
    {
    	$attendanceInfo='';
    	$student='';
    	$allstudent='';
    	
    	$com = new commonFuc();
    	if(\Yii::$app->request->isPost)
    	{
    		$post=\Yii::$app->request->post();
    		if(isset($post['StuNumber']) && isset($post['TeachingClassID']) && isset($post['state']))
    		{
    			$post['state']=$post['state'] ? '1' : '0';
    			$time=date('Y-m-d');
    			$student=Studentinfo::find()->where(['StuNumber'=>$post['StuNumber']])->asArray()->one();

    			$isadd=Attendancerecord::find()->where(['TeachClass'=>$post['TeachingClassID'],
                    'AttendanceDate'=>$time])->asArray()->all();
    			if(count($isadd)==0)
    			{
    				var_dump('is here');
    				$allstudent=Teachingclassdetails::find()->where(['TeachingClassID'=>$post['TeachingClassID']])
                        ->asArray()->all();
    				//如果这个日期没有信息，就添加所有学生信息到出勤记录中，并且默认没有出勤
    				$transaction = \Yii::$app->db->beginTransaction();
					try{
					    for($i=0; $i<count($allstudent); $i++)
	    				{
	    					$studentx=Studentinfo::find()->where(['StuNumber'=>$allstudent[$i]['StuNumber']])
                                ->asArray()->one();
	    					$attendanceInfo=new Attendancerecord();
							$attendanceInfo['AttendaceRecordID'] = $com->create_id();
							$attendanceInfo['StudentName']=$studentx['Name'];
							$attendanceInfo['StudentNum']=$studentx['StuNumber'];
							$attendanceInfo['TeachClass']=$post['TeachingClassID'];
							$attendanceInfo['AttendanceDate']=$time;
							$attendanceInfo['AttendanceState']='0';
							$attendanceInfo->save();
	    				}
					   $transaction->commit(); //提交事务
					}catch(Exception $e){
					    $transaction->rollback(); //回滚事务
					}		
    			}
    			else
    			{
    				$attendanceInfo=Attendancerecord::find()->where(['TeachClass'=>$post['TeachingClassID'],
                        'AttendanceDate'=>$time,'StudentNum'=>$post['StuNumber']])
                        ->asArray()
                        ->one();
    				Attendancerecord::updateAll(['AttendanceState'=>$post['state']],
                        ['AttendaceRecordID'=>$attendanceInfo['AttendaceRecordID']]);
    				echo "1";
    			}
    		}
    	}
    }

}
