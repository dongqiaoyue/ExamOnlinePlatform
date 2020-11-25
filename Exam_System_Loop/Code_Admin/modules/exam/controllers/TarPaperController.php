<?php

namespace app\modules\exam\controllers;

use app\models\exam\Examprocess;
use app\models\system\TbcuitmoonDictionary;
use app\modules\front\controllers\ExamController;
use common\commonFuc;
use app\models\exam\Exampaper;
use app\models\teachplan\Examplan;
use app\models\teachplan\Teachingclassmannage;
use app\models\teachplan\Teachingclassdetails;
use app\models\systembase\Studentinfo;
use app\models\exam\Paper;
use app\models\question\Questions;
use Yii;


require_once __DIR__.'/../../../web/component/excel/PHPExcel/IOFactory.php';
class TarPaperController extends \app\controllers\BaseController
{
	public function actionIndex()
	{
        $com = new commonFuc();
		return $this->render('index',['now_term'=>$com->getNowTerm(),]);

	}
	public function actionGetPaper()
	{
		if(\Yii::$app->request->isPost)
    	{
    		$post=\Yii::$app->request->post();
            $res = Exampaper::find()->where(['ExamPlanBh'=>$post['examPlan'],'DealState'=>'2','TeachingClassID'=>$post['classID']])->orderBy('CAST(Score as SIGNED) DESC')->asArray()->all();
			// $res = self::GetList($post['examPlan'], $post['classID'], 'DealState', '2');
			echo json_encode($res);
    	}

	}


	/**
	 * @Author      codelover
	 * @DateTime    2017-06-18
	 * @Description 用于获取试卷
	 * @param       string        $ExamPlan    考试计划ID
	 * @param       string        $ClassID     班级ID
	 * @param       string        $Filed       筛选条件（字段名）
	 * @param       string        $SubmitStage 筛选条件值
	 */
	public function GetList($ExamPlan,$ClassID, $Filed, $SubmitStage)
    {

        $m_exam_paper = new Exampaper();
        $m_exam_plan = new Examplan();
        $m_teach_class_detail = new Teachingclassdetails();


        $Where = ['and',"$Filed='$SubmitStage'"];
        $Type = $m_exam_plan->findOne([
            'ExamPlanBh' => $ExamPlan
        ]);
        if ($Type->Type == '1') {
            $SonExamPlan = $m_exam_plan->find()->select(['ExamPlanBh'])
                ->where([
                    'CreateUser' => $Type->ExamPlanBh
                ]);
            $ExamPlanSelect = ['in','ExamPlanBh',$SonExamPlan];
            $Student = $m_teach_class_detail->find()->select(['StuNumber'])
                ->where([
                    'TeachingClassID' => $ClassID,
                ]);
            $StudentSelect = ['in','StudentID',$Student];
            $Where[] = $ExamPlanSelect;
            $Where[] = $StudentSelect;
        } else {
            $Tmp_Two = $ExamPlan;
            $Where[] = "ExamPlanBh='$Tmp_Two'";
            $Tmp_Two = $ClassID;
            $Where[] = "TeachingClassID='$Tmp_Two'";
        }
        $Tmp = $m_exam_paper->find()->where($Where)->orderBy('CAST(Score as SIGNED) DESC')->asArray()->all();
        return $Tmp;
    }
    /**
     * @Author      codelover
     * @DateTime    2017-06-19
     * @Description 获取归档试卷
     * @return      binary        文件
     */
    public function actionGetTar()
    {
        if(\Yii::$app->request->isPost)
        {

            $com = new commonFuc();
            $post=\Yii::$app->request->post();
            if(isset($post['classID']) && isset($post['examPlan']))
            {
                $allClass = Examplan::find()->where(['ExamPlanBh'=>$post['examPlan']])->asArray()->one()['TeachingClassID'];
                $allClass = explode('|',$allClass);
                $allStu = [];
                foreach ($allClass as $key => $value) {
                    $allStu[] = Teachingclassdetails::find()->select("StuNumber")->where(['TeachingClassID'=>$value])->asArray()->all();
                }
                $id = $com->create_id();
                $path = $_SERVER['DOCUMENT_ROOT'].'/tar_file/'.$id;
                // .$value1['StuNumber'].'.xls'
                if (!file_exists($path))
                {
                    mkdir($path);
                }
                foreach ($allStu as $key => $value) {
                    foreach ($value as $key1 => $value1) {
                        $this->TarAStu($path,$value1['StuNumber'],$post['examPlan']);
                    }
                }
                //shell_exec("zip -jr ".$_SERVER['DOCUMENT_ROOT'].'/tar_file/'.$id.".zip ".$path."/");
                shell_exec("cd tar_file;tar cf ".$id.".zip ".$id."/");
                echo $id;
                // var_dump($allStu);
                // Teachingclassdetails::find()->where([''])
            }
        }
    }
    /**
     * @Author      codelover
     * @DateTime    2017-06-19
     * @Description [Description]
     * @param       [type]        $DirPath  [description]
     * @param       [type]        $stuID    [description]
     * @param       [type]        $Examplan [description]
     */
    public function TarAStu($DirPath,$stuID,$Examplan)
    {

        $PHPExcel = new \PHPExcel();
        $res = [];
        $paper = Exampaper::find()->where(['ExamPlanBh'=>$Examplan,'StudentID'=>$stuID])->asArray()->one();
        $exam = Examplan::find()->where(['ExamPlanBh'=>$Examplan])->asArray()->one();

        $PHPExcel->getProperties()->setTitle($paper['StudentID'].$paper['StuName'].$exam['ExamPlanName']);
        $PHPExcel->setActiveSheetIndex(0);
        $PHPExcel->getActiveSheet()->setCellValue('A1','序号');
        $PHPExcel->getActiveSheet()->setCellValue('B1','题目');
        $PHPExcel->getActiveSheet()->setCellValue('C1','学生答案');
        $PHPExcel->getActiveSheet()->setCellValue('D1','标准答案');
        $PHPExcel->getActiveSheet()->setCellValue('E1','得分');
        $PHPExcel->getActiveSheet()->setCellValue('F1','备注');
        $allinfo = Examprocess::find()
        ->select(Questions::tableName().".QuestionBh as QuestionBh, ".Questions::tableName().".Answer as rightAns, ".Examprocess::tableName().".Answer as stuAns, ".Examprocess::tableName().".Score as score, Description")
        ->where(['PaperID'=>$paper['PaperID']])
        ->leftJoin(Questions::tableName(),Questions::tableName().".QuestionBh=".Examprocess::tableName().".QuestionBh")
        ->asArray()
        ->all();
        // htmlspecialchars
        $i = 2;

        foreach ($allinfo as $key => $value) {

            $PHPExcel->getActiveSheet()->setCellValue('A'.$i,$i-1);
            $PHPExcel->getActiveSheet()->setCellValue('B'.$i,str_replace('&nbsp;','',strip_tags($value['Description']))." ");
            //反正这儿就是要加单引号引起来，不然特么的有些学生答案就是不能打包，靠，一个bug一天
            $PHPExcel->getActiveSheet()->setCellValue('C'.$i,(string)("'".$value['stuAns']."'"));
            $PHPExcel->getActiveSheet()->setCellValue('D'.$i,$value['rightAns']." ");
            $PHPExcel->getActiveSheet()->setCellValue('E'.$i,$value['score']." ");
            $PHPExcel->getActiveSheet()->setCellValue('F'.$i,'');
            $PHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);

            $PHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(12);
            $PHPExcel->getActiveSheet()->getStyle('B')->getAlignment()->setWrapText(true);
            $PHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
            // $PHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(12);
            // $PHPExcel->getActiveSheet()->getStyle('C')->getAlignment()->setWrapText(true);
            $i++;
        }
        // var_dump($allinfo);
        $objWriter= \PHPExcel_IOFactory::createWriter($PHPExcel,'Excel5');
        $objWriter->save($DirPath.'/'.$stuID.$paper['StuName'].$exam['ExamPlanName']."--".$paper['Score']."分".'.xls');



    }
}
