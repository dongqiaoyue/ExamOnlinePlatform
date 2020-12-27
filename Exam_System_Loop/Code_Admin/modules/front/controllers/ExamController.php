<?php

namespace app\modules\front\controllers;

use app\models\aid\Question;
use app\models\exam\Createpaper;
use app\models\exam\Exampaper;
use app\models\exam\Examprocess;
use yii\helpers\Url;
use app\models\exam\Paper;
use app\models\question\Questions;
use app\models\systembase\Studentinfo;
use app\models\teachplan\Examplan;
use app\models\teachplan\Teachingclassdetails;
use common\commonFuc;
use app\models\system\TbcuitmoonDictionary;
use Yii;

class ExamController extends BaseController
{

    /**
     * @return string
     */
    public function actionIndex()
    {
        $m_teaching = new Teachingclassdetails();
        $m_exam_plan = new Examplan();
        $com = new commonFuc();
        $StudentNum = Yii::$app->session->get('StudentNum');
        $TeachingClass = $m_teaching->find()->select(['TeachingClassID'])
            ->where(['StuNumber' => $StudentNum])->asArray()->all();
        $Where = [];
        foreach ($TeachingClass as $key=>$value) {
            $Where[$key] = $value['TeachingClassID'];
        }

        $Query = $m_exam_plan->find()->where(['or like','TeachingClassID',$Where]);
        $QueryCourse = clone $Query;
        $CourseID = $QueryCourse->select(['CourseID'])->groupBy('CourseID')->all();
        $Data = [];
        foreach ($CourseID as $key=>$value){
            $Data[$com->codeTranName($value->CourseID)] = $Query
                ->where(['and',"IsFixedPlace='1'",'CourseID = '.$value->CourseID.'',['or like','TeachingClassID',$Where]])
                ->orderBy('StarTime')->all();
        }
        return $this->render('index',[
            'ExamList' => $Data,
        ]);
    }


    /**
     * @return string
     * enter exam
     * 检查是否已经进入考试了 如果已经进入则查询已保存的答案
     * 最开始进入考试时,设置事件,在考试时间结束时未交卷则自动提交试卷
     */
    public function actionEnterExam()
    {
        $this->layout = '//paper';
        $m_paper = new Paper();
        $m_create_paper = new Createpaper();
        $m_exam_paper = new Exampaper();
        $m_teach_details = new Teachingclassdetails();
        $m_exam_process = new Examprocess();
        $m_exam_plan = new Examplan();
        $m_student = new Studentinfo();
        $com = new commonFuc();
        $m_tb = new TbcuitmoonDictionary();
//        $Data = [];

        $Id = Yii::$app->request->get('ExamPlanBh');
        $Paper = Exampaper::find()->where([
            'ExamPlanBh' => $Id,
            'StudentID' => Yii::$app->session->get('StudentNum')
        ])->orderBy("ExamBeginTime DESC")->one();
        $StuName = $m_student->findOne(
                ['StuNumber' => Yii::$app->session->get('StudentNum')]
            )->Name;
        $course = Examplan::find()->where(['ExamPlanBh'=>$Id])->asArray()->one()['CourseID'];
        $courseId = TbcuitmoonDictionary::find()->where(['CuitMoon_DictionaryCode'=>$course])->asArray()->one()['CuitMoon_DictionaryName'];
        \Yii::$app->session->set('courseCode',$course);
        if (!$Paper) {//第一次进入考试
            $id = $m_paper->find()->where(['ExamPlanBh' => $Id ])
                ->orderBy('rand()')
                ->asArray()
                ->one()['PaperBh'];//随机获取试卷
            if(!$id){
                echo 'no exampaper';
                die;
            }
            //get TeachingClassID
            $examplan = $m_exam_plan->findOne([
                'ExamPlanBh' => $Id,
            ]);
            //            $courseId = $m_tb->find()->select('CuitMoon_DictionaryName')->where(['CuitMoon_DictionaryCode'=>$examplan['CourseID']])->asArray()->one();
            $TeachingClassID=$examplan['TeachingClassID'];
            $TeachingClassID = explode('|',$TeachingClassID);
            foreach ($TeachingClassID as $item) {
                if ($ClassID = $m_teach_details->find()->where([
                    'StuNumber' => Yii::$app->session->get('StudentNum'),
                    'TeachingClassID' => $item,
                ])->asArray()->one()["TeachingClassID"]) {
                    $m_exam_paper->TeachingClassID = $ClassID;
                    break;
                }
            }

            $PaperId = $com->create_id();
            $m_exam_paper->Memo = (string)1;
            $m_exam_paper->DealState = '0';
            $m_exam_paper->PaperID = $PaperId;
            $m_exam_paper->PaperBh = $id;
            $m_exam_paper->StudentID = Yii::$app->session->get('StudentNum');
            $m_exam_paper->ExamBeginTime = date('Y-m-d H:i:s');
            $m_exam_paper->ExamPlanBh = $Id;
            $m_exam_paper->MachineIP = $com->getClientIp();
            $m_exam_paper->StuName = $StuName;
            $m_exam_paper->SubmitStage = '0';
            if (!$m_exam_paper->save()) {
                print_r($m_exam_paper->getErrors());
            }
            $Answer = '';

        } else {
            $isOver = Examplan::find()->where(['ExamPlanBh'=>$Paper->ExamPlanBh])->asArray()->one()['EndTime'];

            if($Paper->SubmitStage == 1 || strtotime(date('Y-m-d H:i:s'))>strtotime($isOver))
                $this->redirect(Url::toRoute('//not/noexam'));
            $PaperId = $Paper->PaperID;
            $Answer = $m_exam_process->find()->where([
                'PaperID' => $PaperId,
            ])->asArray()->all();//如果是第二次进入则查询以保存的答案
            $id = $Paper->PaperBh;
            $Paper->Memo = (string)(((int)$Paper->Memo)+1);
            //如果第二次ip不同就记录下来
            if(strpos($Paper->MachineIP,$com->getClientIp())===false){
                $Paper->MachineIP = $Paper->MachineIP.",".$com->getClientIp();
            }
            $Paper->update();
        }


//        $QuestionTypes = $m_create_paper->find()->select(['Memo'])
//            ->where([
//                'PaperBh' => $id,
//            ])->groupBy(['Memo'])->asArray()->all();//查找试卷所有类型
        $QuestionTypes = $m_create_paper->find()->select(['Memo'])
            ->where([
                'PaperBh' => $id,
            ])->asArray()->all();//查找试卷所有类型

        foreach ($QuestionTypes as $value){
            $Data[$value['Memo']] = $m_create_paper->find()->where([
                'PaperBh' => $id,
                'Memo' => $value['Memo'],
            ])->all();
        }

//        foreach ($QuestionTypes as $item) {
//            $Tmp = $m_create_paper->find()->where([
//                'PaperBh' => $id,
//                'Memo' => $item['Memo'],
//            ])->all();
//            foreach ($Tmp as $value) {
//                $TmpData = $value->question;
//                $TmpData['Score'] = $value->TotalScore;
//                $Tmp_Data[] = $TmpData;
//            }
//            $Data[$item['Memo']] = $Tmp_Data;
//
//
//            unset($Tmp_Data);
//        }
//        //获取文件
//        foreach ($Data as $key1 => $value1) {
//            foreach ($value1 as $key => $value) {
//                $Data[$key1][$key]['file'] = [];
//                $path = $_SERVER['DOCUMENT_ROOT'].'/QuestionFile/'.$value['QuestionBh'].'/';
//                if(is_dir($path))
//                {
//                    $handler = opendir($path);
//                    $url_path = Url::to("@web/QuestionFile/".$value['QuestionBh'].'/', true);
//                    $i = 0;
//                    while( ($filename = readdir($handler)) !== false )
//                    {
//                        if($filename != "." && $filename != "..")
//                        {
//                            $Data[$key1][$key]['file'][$filename] = $url_path.$filename;
//                        }
//                    }
//                    closedir($handler);
//                }
//            }
//        }
        $StarTime = Examplan::findOne(['ExamPlanBh' => $Id])->StarTime;
        $EndTime = Examplan::findOne(['ExamPlanBh' => $Id])->EndTime;
        $ExamTime = Examplan::find()->where(['ExamPlanBh' => $Id])->asArray()->one()['ExamTime'];
        $d = strtotime($EndTime);
        $EndTime = date('H:i',$d);

        $info = Exampaper::find()->select("ExamBeginTime,PaperID")->where([
            'ExamPlanBh' => $Id,
            'StudentID' => Yii::$app->session->get('StudentNum')
        ])->orderBy("ExamBeginTime DESC")->asArray()->one();
        $PassTime = (int)((int)(strtotime(date('Y-m-d H:i:s'))-strtotime($info['ExamBeginTime']))/60);

//        var_dump($Data);
//        exit();

        return $this->render('paper',[
            'info' => $Data,
            'examPlanBh' => $Id,
            'paperID' => $PaperId,
            'paperBh' => $id,
            'answer' => json_encode($Answer),
            'endTime' => $EndTime,
            'StuNumber' => Yii::$app->session->get('StudentNum'),
            'StuName' => $StuName,
            'ExamTime'=>$ExamTime,
            'PassTime'=>$PassTime,
            'now'=> date('Y-m-d H:i:s'),
            'type' => $courseId,
        ]);
    }


    /**
     * @return JSON
     * submit paper
     */
    public function actionSubmit()
    {
        $m_exam_paper = new Exampaper();
        $com = new commonFuc();

        $Ans = Yii::$app->request->post();
        $PaperID = Yii::$app->request->post('PaperID');
        unset($Ans['_csrf']);
        unset($Ans['PaperID']);

        if((Exampaper::find()->where([
            'StudentID' => Yii::$app->session->get('StudentNum'),
            'PaperID' => $PaperID,
        ])->asArray()->one()['SubmitStage']) == '1')
        {
            $com->JsonSuccess('试卷已提交，请勿重复提交！');
            die;
        }

        $Tmp = $m_exam_paper->findOne([
            'StudentID' => Yii::$app->session->get('StudentNum'),
            'PaperID' => $PaperID,
        ]);
        $Tmp->ExamEndTime = date('Y-m-d H:i:s');
        $Tmp->SubmitStage = '1';
        // $Tmp->MachineIP = (string)$com->getClientIp();
        $Tmp->update();
        $this->SavePaper($Ans,$PaperID);
        $com->JsonSuccess('已交卷');
    }


    /**
     * 定时保存试卷
     */
    public function actionSave()
    {
        $com = new commonFuc();
        if (\Yii::$app->session->get('StudentNum')==null) {
            \Yii::$app->stu->logout();
            echo json_encode(['erro'=>1]);
            die;
        }
        $Ans = Yii::$app->request->post();
        $ExamPlanBh = Yii::$app->request->post('PaperID');
        unset($Ans['_csrf']);
        unset($Ans['PaperID']);
        $com->SavePaper($Ans,$ExamPlanBh);
        //以下代码是把提交的编程题不是满分的进行编译，目的是减少老师批阅时的时间花费
        // $program = Examprocess::find()->select("PaperID,QuestionBh,Answer")->where(['PaperID'=>$ExamPlanBh,'Memo'=>'1000206','Status'=>''])->asArray()->all();


        // foreach ($program as $key => $value) {
        //     $score = $com->Compilex($value['QuestionBh'],$value['Answer'],3);
        //     if((int)$score==100)
        //     {
        //         $PaperBh = Exampaper::find()->where(['PaperID'=>$value['PaperID']])->asArray
        //         ()->one()['PaperBh'];
        //         $realScore = Createpaper::find()->where([
        //                 'PaperBh' => $PaperBh, 'QuestionBh' => $value['QuestionBh']
        //                 ])->asArray()->one()['TotalScore'];
        //         Examprocess::updateAll(['Status'=>'1','Score'=>$realScore],['PaperID'=>$value['PaperID'],'QuestionBh'=>$value['QuestionBh']]);
        //     }

        // }

        // echo json_encode($program);
    }


    /**
     * @param $Data
     * @param $ExamPlanBh
     * function Save Paper Answer
     */
    public function SavePaper($Data,$ExamPlanBh)
    {
        foreach ($Data as $key=>$item) {
            $m_exam_process = new Examprocess();
            $m_question = new Questions();

            $Tmp = $m_exam_process->findOne([
                'PaperID' => $ExamPlanBh,
                'QuestionBh' => $key,
            ]);
            $QuestionType = $m_question->findOne([
                'QuestionBh' => $key,
            ])->QuestionType;
            switch ($QuestionType) {
                case 100020102:
                    $item = implode("|",$item);
                    break;
                case 1000204:
                case 1000208:
                    $Tmp_Data = null;
                    foreach ($item as $value) {
                        $Tmp_Data = $Tmp_Data.$value.'@';
                    }
                    $item = $Tmp_Data;
                    break;
                default:
                    break;
            }

            if ($Tmp) {
                $Tmp->PaperID = $ExamPlanBh;
                $Tmp->QuestionBh = $key;
                $Tmp->Answer = $item;
                $Tmp->SubmitTime = date('Y-m-d H:i:s');
                $Tmp->Memo = $QuestionType;
                $Tmp->update();
            }else{
                $m_exam_process->PaperID = $ExamPlanBh;
                $m_exam_process->QuestionBh = $key;
                $m_exam_process->Answer = $item;
                $m_exam_process->SubmitTime = date('Y-m-d H:i:s');
                $m_exam_process->Memo = $QuestionType;
                $m_exam_process->save();
            }
        }
    }

    public function actionGetQuestionDetail()
    {
        $post = Yii::$app->request->post();
        $QuestionType = $post['QuestionType'];
        $paperBh = $post['paperBh'];
        $Data = [];
        if (!is_null($QuestionType) and !is_null($paperBh)){

            $Tmp = Createpaper::find()->where([
                'PaperBh' => $paperBh,
                'Memo' => $QuestionType,
            ])->all();

            foreach ($Tmp as $value) {
                $TmpData = Questions::find()->where(['QuestionBh'=>$value->QuestionBh])->asArray()->one();
                $TmpData['Score'] = $value->TotalScore;
                if($QuestionType == '1000208'){
                    $m_find_error = new \app\models\question\FindError();
                    $TmpData['Errors'] = $m_find_error->find()->where([
                        'QuestionBh' => $value->QuestionBh
                    ]);
                }
                $Tmp_Data[] = $TmpData;
            }
            $Data[$QuestionType] = $Tmp_Data;
            unset($Tmp_Data);

            //获取文件
            foreach ($Data as $key1 => $value1) {
                foreach ($value1 as $key => $value) {
                    $Data[$key1][$key]['file'] = [];
                    $path = $_SERVER['DOCUMENT_ROOT'].'/QuestionFile/'.$value['QuestionBh'].'/';
                    if(is_dir($path))
                    {
                        $handler = opendir($path);
                        $url_path = Url::to("@web/QuestionFile/".$value['QuestionBh'].'/', true);
                        $i = 0;
                        while( ($filename = readdir($handler)) !== false )
                        {
                            if($filename != "." && $filename != "..")
                            {
                                $Data[$key1][$key]['file'][$filename] = $url_path.$filename;
                            }
                        }
                        closedir($handler);
                    }
                }
            }

            echo json_encode($Data);

        }else{
            echo "获取失败";
        }



    }

    public function actionGetSourceCode()
    {
        $Question = Questions::findOne([
           'QuestionBh' => Yii::$app->request->get('id')
       ]);
        if($Question->IsProgramBlank == '100001')
        {
            $start = $Question->StartTag;
            // $end  = addcslashes($Question->EndTag,'*');
            $end = $Question->EndTag;
            $code = json_decode($Question->SourceCode,true)['key']['0']['code'];
            $tmpCode = $code;
            $code = str_replace($start,'`',$code);
            $code = str_replace($end,'`',$code);
            $explode = explode('`',$code);
            foreach ($explode as $key => $value) {
                if($key%2 == 1)
                    $tmpCode = str_replace($value,"\r\n\r\n",$tmpCode);
            }
            $res['key']['0']['code'] = $tmpCode;
            echo json_encode($res);
            // $ansArr =  explode('`',$tmp);
            // $codeArr = explode('`',$code);
            // $i = 0;
            // foreach ($ansArr as $key => $value) {
            //     $check = explode('^',$value);
            //     $check1 = explode('^',$codeArr[$key]);
            //     if($check1[0] != $check[0])
            //     {
            //         $i = 1;
            //         break;
            //     }
            // }
            // if($i == 1)
            // {
            //     echo json_encode("请勿修改start--end之外的代码");
            //     die;
            // }

        }else{
            echo "获取失败";
        }
        // echo->SourceCode;
    }

    public function actionSaveScore(){

        //$data = \Yii::$app->request->post();
        $PaperID = \Yii::$app->request->post('paperID');
        $QuestionBh = \Yii::$app->request->post('QuestionBh');
        // $tSocre = \Yii::$app->request->post('tSocre');
        // $exam = Examprocess::find()
        // ->where([
        //     'QuestionBh'=> $QuestionBh ,
        //     'PaperID' => $PaperID,
        //     ])->one();
        $PaperBh = Exampaper::find()->where(['PaperID'=>$PaperID])
                    ->asArray()->one()['PaperBh'];
        $realScore = Createpaper::find()->where([
                    'PaperBh' => $PaperBh,
                    'QuestionBh' => $QuestionBh,
                    ])->asArray()->one()['TotalScore'];
        Examprocess::updateAll(['Score'=>$realScore,'Status'=>'1'],['QuestionBh' =>$QuestionBh,'PaperID' => $PaperID]);
    }
}
