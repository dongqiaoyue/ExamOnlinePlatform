<?php
namespace app\modules\grade\controllers;

use app\controllers\BaseController;
use app\models\exam\Exampaper;
use app\models\grade\Stuscore;
use app\models\system\TbcuitmoonDictionary;
use app\models\teachplan\Examplan;
use app\models\teachplan\Teachingclassmannage;
use common\commonFuc;
use Yii;

require_once __DIR__.'/../../../web/component/excel/PHPExcel/IOFactory.php';


class GradeController extends BaseController
{

    public function actionIndex()
    {
        $m_dic = new TbcuitmoonDictionary();
        $com = new commonFuc();
        $m_stu_score = new Stuscore();

        $Info = Yii::$app->request->get();
        $Where = [];
        if (isset($Info['classID'])) {
            $Where['ExamPlanBh'] = $Info['examPlan'];
            $Where['TeachingClassID'] = $Info['classID'];
            $Data['ExamPlan_Choice'] = $Info['examPlan'];
            $Data['ClassID_Choice'] = $Info['classID'];
            $Data['Term_Choice'] = $Info['term'];
        } else {
            $Data['Term_Choice'] = false;
            $Data['ExamPlan_Choice'] = false;
            $Data['ClassID_Choice'] = false;
            $Data['Term_Choice'] = false;
        }
        $Tmp = $m_stu_score->find()->where($Where);
        $Tmp_One = clone $Tmp;
        $Pages = $com->Tab($Tmp_One);

        return $this->render('index',[
            'term' => $m_dic->getDictionaryList('学期'),
            'pages' => $Pages,
            'list' => $Tmp/*->limit($Pages->limit)->offset($Pages->offset)*/->orderBy("StuNumber ASC")->all(),
            'choice' => $Data,
            'now_term' => $com->getNowTerm(),
        ]);
    }

    /**
     * 导出成绩
     */
    public function actionOutputExcel()
    {
        $PHPExcel = new \PHPExcel();

        $info = Yii::$app->request->get();
        $Grade = Stuscore::find()->where([
            'ExamPlanBh' => $info['teachPlan'],
            'TeachingClassID' => $info['classId'],
        ])->orderBy("StuNumber")->all();
        $ClassName = Teachingclassmannage::findOne(['TeachingClassID' => $info['classId']])
            ->TeachingName;
        $TeachingPlanName = Examplan::findOne(['ExamPlanBh' => $info['teachPlan']])
            ->ExamPlanName;
        $PHPExcel->getProperties()->setTitle($TeachingPlanName.'-'.$ClassName);
        $PHPExcel->setActiveSheetIndex(0);
        $i = 2;
        $PHPExcel->getActiveSheet()->setCellValue("A1",'学号');
        $PHPExcel->getActiveSheet()->setCellValue("B1",'姓名');
        $PHPExcel->getActiveSheet()->setCellValue("C1",'考试成绩');
        $PHPExcel->getActiveSheet()->setCellValue("D1",'考试计划');
        $PHPExcel->getActiveSheet()->setCellValue("E1",'开始时间');
        $PHPExcel->getActiveSheet()->setCellValue("F1",'结束时间');

        foreach ($Grade as $item) {
            $Tmp = $item->student;
            $PHPExcel->getActiveSheet()->setCellValue("A".$i,$item->StuNumber);
            $PHPExcel->getActiveSheet()->setCellValue("B".$i,$Tmp->Name);
            $PHPExcel->getActiveSheet()->setCellValue("C".$i,$item->ExamScore);
            $PHPExcel->getActiveSheet()->setCellValue("D".$i,$TeachingPlanName);
            $PHPExcel->getActiveSheet()->setCellValue("E".$i,$item->StarTime);
            $PHPExcel->getActiveSheet()->setCellValue("F".$i,$item->EndTime);
            $i++;
        }

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition:attachment;filename="'.$TeachingPlanName.'-'.$ClassName.'.xls"');
        $objWriter= \PHPExcel_IOFactory::createWriter($PHPExcel,'Excel5');
        $objWriter->save('php://output');
    }
}
