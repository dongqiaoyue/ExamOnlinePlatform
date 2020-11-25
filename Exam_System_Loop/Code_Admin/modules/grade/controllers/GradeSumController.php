<?php
namespace app\modules\grade\controllers;

use app\controllers\BaseController;
use app\models\exam\Exampaper;
use app\models\system\TbcuitmoonDictionary;
use app\models\teachplan\Examplan;
use app\models\teachplan\Teachingclassdetails;
use app\models\teachplan\Teachingclassmannage;
use common\commonFuc;
use app\models\systembase\Studentinfo;
use Yii;

require_once __DIR__.'/../../../web/component/excel/PHPExcel/IOFactory.php';

class GradeSumController extends BaseController
{
    public function actionIndex()
    {
        $m_dic = new TbcuitmoonDictionary();
        $com = new commonFuc();
        $m_exam_paper = new Exampaper();
        $m_exam_plan  = new Examplan();
        $m_teach_class_detail = new Teachingclassdetails();

        $Info = Yii::$app->request->get();
        $Where['DealState'] = '1';
        if (isset($Info['classID'])) {
            $Where['TeachingClassID'] = $Info['classID'];
            $courseCode = Yii::$app->session->get('courseCode');
            $ClassSelect = $m_exam_plan->find()->where([
                'and',
                "CourseID='$courseCode'",
                "Type='2'",
                ['like','TeachingClassID',$Info['classID']]
            ])->orderBy('StarTime');
            $ExamPlan = $ClassSelect->all();
//            foreach ($ExamPlan as $key=>$item) {
//
//            }
            $Student = $m_teach_class_detail->find()->where([
                'TeachingClassID' => $Info['classID']
            ])->orderBy("StuNumber ASC");
            $CloneStudent = clone $Student;
            $Pages = $com->Tab($CloneStudent);
            foreach ($Student->all() as $k=>$item) {
                $Tmp_Info['list'][$k]['info'] = $item->student;
                foreach ($ExamPlan as $key=>$va) {
                    $Tmp = $m_exam_paper->findOne([
                        'StudentID' => $item->StuNumber,
                        'ExamPlanBh' => $va->ExamPlanBh,
                        // 'DealState' => '2',
                    ]);
                    if ($Tmp) {
                        if ($Tmp->Score == '') {
                            $Tmp_Info['list'][$k][$key+1] = '还未批阅';
                        } else {
                            $Tmp_Info['list'][$k][$key+1] = $Tmp->Score;
                        }
                    } else {
                        $Tmp_Info['list'][$k][$key+1] = '还未考试';
                    }
                }
            }



            $Tmp_Info['examPlan'] = $ExamPlan;
            $Tmp_Info['pages'] = $Pages;
            $Tmp_Info['count'] = $ClassSelect->count();
            $Tmp_Info['choice']['ClassID_Choice'] = $Info['classID'];
            $Tmp_Info['choice']['Term_Choice'] = $Info['term'];
        } else {
            $Tmp_Info['choice']['ClassID_Choice'] = false;
            $Tmp_Info['choice']['Term_Choice'] = false;
//            $Data['ClassID_Choice'] = false;
//            $Data['Term_Choice'] = false;
        }
        $Tmp_Info['term'] = $m_dic->getDictionaryList('学期');
        $Tmp_Info['now_term'] = $com->getNowTerm();

        return $this->render('index',$Tmp_Info);
    }

    public function actionGetClass()
    {
        $m_teach_class = new Teachingclassmannage();

        $Term = Yii::$app->request->get('term');
        $List = $m_teach_class->find()->where([
            'Term' => $Term,
            'CourseID' => Yii::$app->session->get('courseCode'),
            'Type' => '1',
            'TeacherName'=>Yii::$app->session->get('UserName')
        ])->asArray()->all();
        echo json_encode($List);
    }


    public function actionGetExcel()
    {
        $PHPExcel = new \PHPExcel();

        $Info = Yii::$app->request->get();
        $Where['DealState'] = '1';
        if (isset($Info['classID']))
        {
            $Where['TeachingClassID'] = $Info['classID'];
            $courseCode = Yii::$app->session->get('courseCode');
            $exam = Examplan::find()->where([
                'and',
                "CourseID='$courseCode'",
                "Type='2'",
                ['like','TeachingClassID',$Info['classID']]
            ])->orderBy('StarTime')->asArray()->all();
            $ClassName = Teachingclassmannage::findOne(['TeachingClassID' => $Info['classID']])
            ->TeachingName;

            $PHPExcel->getProperties()->setTitle($ClassName.'--成绩汇总');
            $PHPExcel->setActiveSheetIndex(0);
            $str = [];
            foreach(range('C','Z') as $v)
            {
                $str[] = $v;
            }
            $PHPExcel->getActiveSheet()->setCellValue('A1','学号');
            $PHPExcel->getActiveSheet()->setCellValue('B1','姓名');
            foreach ($exam as $key => $value) {

                $PHPExcel->getActiveSheet()->setCellValue($str[$key].'1',$value['ExamPlanName']);
            }
            $student = Teachingclassdetails::find()->where([
                'TeachingClassID' => $Info['classID']
            ])->orderBy("StuNumber ASC")->asArray()->all();
            $i = 1;
            foreach ($student as $key => $value)
            {
                $i++;
                $name = Studentinfo::find()->where(['StuNumber'=>$value['StuNumber']])->asArray()->one()['Name'];
                $PHPExcel->getActiveSheet()->setCellValue('A'.$i,$value['StuNumber']);
                $PHPExcel->getActiveSheet()->setCellValue('B'.$i,$name);
                foreach ($exam as $key1 => $value1)
                {
                    
                    $score = Exampaper::find()->where(['StudentID' => $value['StuNumber'],
                        'ExamPlanBh' => $value1['ExamPlanBh']])->asArray()->one()['Score'];
                    $PHPExcel->getActiveSheet()->setCellValue($str[$key1].$i,$score);
                }
            }

        // foreach ($Grade as $item) {
        //     $Tmp = $item->student;
        //     $PHPExcel->getActiveSheet()->setCellValue("A".$i,$item->StuNumber);
        //     $PHPExcel->getActiveSheet()->setCellValue("B".$i,$Tmp->Name);
        //     $PHPExcel->getActiveSheet()->setCellValue("C".$i,$item->ExamScore);
        //     $PHPExcel->getActiveSheet()->setCellValue("D".$i,$TeachingPlanName);
        //     $PHPExcel->getActiveSheet()->setCellValue("E".$i,$item->StarTime);
        //     $PHPExcel->getActiveSheet()->setCellValue("F".$i,$item->EndTime);
        //     $i++;
        // }

            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition:attachment;filename="'.$ClassName.'.xls"');
            $objWriter= \PHPExcel_IOFactory::createWriter($PHPExcel,'Excel5');
            $objWriter->save('php://output');
        }
    }
}