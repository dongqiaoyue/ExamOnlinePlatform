<?php
namespace app\modules\exam\controllers;


use yii\web\Controller;
use app\controllers\BaseController;
use app\controllers\CommonController;
use app\models\exam\Createpaper;
use app\models\exam\Exampaper;
use app\models\exam\Examprocess;
use app\models\grade\Stuscore;
use app\models\question\FindError;
use app\models\question\Questions;
use app\models\system\TbcuitmoonDictionary;
use app\models\teachplan\Examplan;
use app\models\teachplan\Teachingclassdetails;
use app\models\question\Testcase;
use app\models\question\Problem;
use app\models\question\Solution;
use app\models\question\SourceCode;
use app\models\question\SourceCodeUser;
use common\commonFuc;
use app\models\question\Apfill;
use Yii;
use yii\base\Exception;
use yii\data\Pagination;
use app\modules\front\controllers\ExamController;



use app\models\teachplan\Teachingclassmannage;


class PythonController extends Controller
{
    public function beforeAction($action) {
        if(Yii::$app->request->userIp != '127.0.0.1') {
            return false;
        }

        return true;
    }

    public function actionIndex()
    {

           $m_dic = new TbcuitmoonDictionary();
            $com = new commonFuc();

        $Info = Yii::$app->request->get();
        if (isset($Info['classID']) && $Info['classID'] != 'null') {

                $Data['ExamPlan_Choice'] = $Info['examPlan'];
                $Data['ClassID_Choice'] = $Info['classID'];
                $Data['Term_Choice'] = $Info['term'];
                $Tmp = self::GetList($Info['examPlan'], $Info['classID'], 'SubmitStage', '1');
        }
        else {
            $Tmp = Exampaper::find();
            $Data['Term_Choice'] = false;
            $Data['ExamPlan_Choice'] = false;
            $Data['ClassID_Choice'] = false;
            $Data['Term_Choice'] = false;
        }
        //$Tmp_One = clone $Tmp;
       // $Pages = $com->Tab($Tmp_One);

        return $this->render('index', [
            'term' => $m_dic->getDictionaryList('学期'),
           // 'pages' => $Pages,
            'list' => $Tmp->all(),
            'choice' => $Data,
        ]);
    }



  public function actionCorrect()
    {
        $com = new commonFuc();
        $m_tb = new TbcuitmoonDictionary();
        $PaperID = Yii::$app->request->get();
        $PaperBh = Exampaper::findOne(['PaperID' => $PaperID['id']])->PaperBh;
        $course = (string)Yii::$app->session->get('courseCode');
        $courseId = $m_tb->find()->select('CuitMoon_DictionaryName')->where(['CuitMoon_DictionaryCode'=>$course])->asArray()->one();
        $Data = $com->GetPaper($PaperBh);
        $Answer = Examprocess::find()->where(['PaperID' => $PaperID])->asArray()->all();
        $score = Exampaper::find()->where(['PaperID'=>$PaperID['id']])->asArray()->one()['Score'];

        foreach ($Data as $key => $value) {
            foreach ($value as $key1 => $value1) {
                $Data[$key][$key1]['get_score'] = Examprocess::find()->where(['PaperID' => $PaperID,'QuestionBh'=>$value1['QuestionBh']])->asArray()->one()['Score'];
                // $Data[$key][$key1]['get_answer'] = Examprocess::find()->where(['PaperID' => $PaperID,'QuestionBh'=>$value1['QuestionBh']])->asArray()->one()['Answer'];
            }
        }
        $PaperID[0] = 'mark/index';
        return $this->render('papers',[
            'score'=>$score,
            'info' => $Data,
            'paperID' => $PaperID['id'],
            'param' => $PaperID,
            'answer' => json_encode($Answer),
            'type'=>$courseId
        ]);
    }

    // /**
    //  * 手动阅卷
    //  * @return json
    //  */
    // public function actionManualMark()
    // {
    //     $com = new commonFuc();

    //     $PaperID = Yii::$app->request->get();
    //     $PaperBh = Exampaper::findOne(['PaperID' => $PaperID['id']])->PaperBh;
    //     $Data = $com->GetPaper($PaperBh);
    //     $Answer = Examprocess::find()->where(['PaperID' => $PaperID])->asArray()->all();
    //     $PaperID[0] = 'mark/index';
    //     return $this->render('paper', [
    //         'info' => $Data,
    //         'paperID' => $PaperID['id'],
    //         'param' => $PaperID,
    //         'answer' => json_encode($Answer),
    //     ]);
    // }



    //     public function actionSavePaper()
    // {
    //     $com = new commonFuc();

    //     $Ans = Yii::$app->request->post();
    //     $ExamPlanBh = Yii::$app->request->post('PaperID');
    //     unset($Ans['_csrf']);
    //     unset($Ans['PaperID']);
    //     $com->SavePaper($Ans,$ExamPlanBh);
    //     $com->JsonSuccess('修正成功');
    // }

     public function actionSavePaper()
    {
        $com = new commonFuc();
        $Ans = Yii::$app->request->post();
        $ExamPlanBh = Yii::$app->request->post('PaperID');
        $score = Yii::$app->request->post('score');
        $Paper = Exampaper::findOne(['PaperID' => $ExamPlanBh]);
        Exampaper::updateAll(['Score' => $score],['PaperID'=>$ExamPlanBh]);
        unset($Ans['_csrf']);
        unset($Ans['PaperID']);
        $com->SavePaper($Ans,$ExamPlanBh);
        $com->JsonSuccess('修正成功');
    }


    //
    //Judgment function
    //
    //
    public function actionMark()
    {
        $com = new commonFuc();
        $m_exam_paper = new Exampaper();

        $ids = Yii::$app->request->get('ids');//  exampaperIds

        if($ids){
            //Realize the judgment function
             $Score = $this->Mark($ids);
             $Paper = Exampaper::find()->where([
                 'PaperID' => $ids,
             ])->one();

             if($Paper)
             {
                $Paper['Score'] = (string)$Score;
                if($Paper['DealState']=='5')
                {

                }else{
                    $Paper['DealState'] = '1';
                }
                try {
                 $Paper->save();
                 // $Tmp['error'] = 0;
                 // $Tmp['msg'] = $Score;
                 // echo json_encode($Tmp);
                // $com->JsonSuccess($Score);
                 echo (string)$Score;
                 } catch (Exception $e) {
                     echo 'error';
                 }
             }
         }
         /*进行自动批阅进度的查询*/
         //$result = $this->Count($ids);
         //return $result;
     }




    public function Mark($PaperID)
    {

        $m_question = new Questions();

        //the answer of the student
        $m_exam_process = new Examprocess();

        $m_exam_paper = new Exampaper();
        $m_create_paper = new Createpaper();
        $m_exam_plan = new Examplan();
        $com = new commonFuc();
        $m_exam_apfill = new Apfill();

        //The id which descrip the the paper of the student
        $PaperBh = $m_exam_paper->find()->where([
            'PaperID' => $PaperID,
        ])->asArray()->one()['PaperBh'];
        //the paperid descrip the  paper (the diffrent student may use the same paper  but the paper of the student is unique)

        //check out all the QuestionBh to judge;
        $Questions = $m_create_paper->find()->where([
            'PaperBh' => $PaperBh,
        ])->all();

        //?????????
        $ExamPlanBh = $m_exam_paper->find()->where([
            'PaperID' => $PaperID,
            ])->asArray()->one()['ExamPlanBh'];
        $CourseID = $m_exam_plan->find()->where([
            'ExamPlanBh' => $ExamPlanBh,
            ])->asArray()->one()['CourseID'];

//        $AnswerQuestion = $m_exam_process->find()->where(['PaperID' => $PaperID])->all();


        foreach ($Questions as $item) {
             $FinalScore = 0.0;
                //the answer of the student exam
            $Answer = $m_exam_process->find()
                ->where([
                    'QuestionBh' => $item->QuestionBh,
                    'PaperID' => $PaperID
                ])->asArray()->One();
                //
            $status = $m_exam_process->find()
                ->where([
                    'QuestionBh' => $item->QuestionBh,
                    'PaperID' => $PaperID
                ])->asArray()->one()['Status'];
                //
            $RightAnswer = $m_question->find()->where([
                        'QuestionBh' => $item->QuestionBh
                    ])->asArray()->one()['Answer'];

            //the array has two crucial keys (apfllpostion and Answer)
            //the question rows
            $apfillrows =$m_exam_apfill->find()->where([
              'QuestionBh'=>$item->QuestionBh,
          ])->asArray()->all();
          //
          $apfillanswerarray=self::turnto1darray($apfillrows);

          //the Total Score of one question
            $RightScore = $m_create_paper->find()->where([
                        'PaperBh' => $PaperBh, 'QuestionBh' => $item->QuestionBh
                        ])->asArray()->one()['TotalScore'];
        // if($status=='')
        // {
            switch ($item->Memo) {
                //选择,判断
                case 100020102 :
                case 1000203:
                case 100020101 :
                    // $RightAnswer = $m_question->find()->where([
                    //     'QuestionBh' => $item->QuestionBh
                    // ])->asArray()->one()['Answer'];
                    // $RightScore = $m_create_paper->find()->where([
                    //     'PaperBh' => $PaperBh, 'QuestionBh' => $item->QuestionBh
                    //     ])->asArray()->one()['TotalScore'];

                    // $score = $m_exam_process::find()
                    // ->where([
                    //     'QuestionBh' =>$item->QuestionBh,
                    //     'PaperID' => $PaperID
                    //  ])->one();


                    //return $Answer['Score'];
                    // $RightScore =(new\yii\db\Query())
                    // ->select(Createpaper::tableName().'.TotalScore,')
                    // ->from(Createpaper::tableName())
                    // ->where(['PaperBh'=>$PaperBh,'QuestionBh'=>$item->QuestionBh])
                    // ->asArray()->one()['TotalScore'];
                    // echo (double)$RightScore;
                    // var_dump($Answer['Answer'] == $RightAnswer);
                    $FinalScore = trim($Answer['Answer']) == trim($RightAnswer) ?  (double)$RightScore : 0;
                    //var_dump($FinalScore);
                    Examprocess::updateAll(['Score'=>$FinalScore],['QuestionBh' =>$item->QuestionBh,'PaperID' => $PaperID]);
                    // $score['Score'] = (string)$FinalScore;
                    // $score->save();
                    //fuck
                    // echo '$'.(string)$TotalScore;
                    break;
                //下列分别为填空、改错题、简答、综合题~均为主观题


                //filing in the blank
                //1.compare the string
                case 1000204:
                //get the array answer the students do
                  $scoreproportion = self::turnto1darray($apfillrows,'Proportion');
                  $apfilexamanwser = self::getapfillfromexam($Answer['Answer']);
                  $FinalScore=0;
                  // var_dump($apfilexamanwser);
                  // var_dump($apfillanswerarray);
                  // var_dump($item->QuestionBh);
                  // die;
                  // for($key in $apfilexamanwser)
                  var_dump(count($apfillanswerarray));
                  for($i = 0;$i < count($apfillanswerarray);$i++)
                  {
                    // var_dump($apfilexamanwser[$i]);
                    // var_dump($apfillanswerarray[$i]);
                    // die;
                    if($apfilexamanwser[$i]==$apfillanswerarray[$i])
                    {
                      $oneapfillscore = ($scoreproportion[$i]/100.0)*$RightScore;
                      // var_dump($oneapfillscore);
                      $FinalScore+=$oneapfillscore;
                      $position=$i+1;
                      // var_dump($i);
                    }
                    else {
                      $FinalScore+=0;
                    }
                  }
                  // var_dump($FinalScore);

                  Examprocess::updateAll(['Score'=>$FinalScore],['QuestionBh'=>$item->QuestionBh]);
                  Exampaper::updateAll(['DealState'=>'5'],['PaperID'=>$PaperID]);
                  break;
                //2.Enumerated type
                case 10002041:

                case 1000205:

                case 1000207:
                    Exampaper::updateAll(['DealState'=>'5'],['PaperID'=>$PaperID]);
                    break;
                //编程
                case 1000206:
                    if($CourseID == 2000304)
                        {
                            Exampaper::updateAll(['DealState'=>'5'],['PaperID'=>$PaperID]);
                            break;
                        }

                    if (strlen($Answer['Answer']) != 0) {
                        $Tmp = $this->GetProgramScore($item->QuestionBh, $Answer['Answer'], 3);
                        //var_dump($Tmp);
                        // $RightScore = $m_create_paper->find()->where([
                        // 'PaperBh' => $PaperBh, 'QuestionBh' => $item->QuestionBh
                        // ])->asArray()->one()['TotalScore'];
                        //  //var_dump($RightScore);
                        // $score = $m_exam_process->find()
                        // ->where([
                        //     'QuestionBh' =>$item->QuestionBh,
                        //     'PaperID' => $PaperID
                        // ])->one();
                        // if (is_numeric($Tmp)) {
                       // echo '@'.$RightScore.'/';
                       // $Tmp = (int)
                        $FinalScore =($RightScore*$Tmp)/100;
                        // var_dump($FinalScore);
                         Examprocess::updateAll(['Score'=>$FinalScore],['QuestionBh' =>$item->QuestionBh,'PaperID' => $PaperID]);

                          //   $score['Score'] = $FinalScore;
                          // var_dump($score['Score']);
                          //   $score->save();
                           // echo '%'.$TotalScore.'^';
                        // }
                    }
                    break;

                //改错
                case 1000208:
                    $m_find_error = new FindError();
                    $Answer = explode('@', $Answer['Answer']);
                    for ($i = 0; $i < count($Answer) - 1; $i++) {
                        $Tmp = $m_find_error->find()
                            ->select(['Answer', 'Proportion'])->where([
                                'QuestionBh' => $item->QuestionBh,
                            ])->orderBy('ErrorCount')->asArray()->all();

                        //  $RightScore = $m_create_paper->find()->where([
                        //     'PaperBh' => $PaperBh, 'QuestionBh' => $item->QuestionBh
                        //     ])->asArray()->one()['TotalScore'];
                        //  $score = $m_exam_process->find()
                        // ->where([
                        //     'QuestionBh' =>$item->QuestionBh,
                        //     'PaperID' => $PaperID
                        // ])->One();
                        foreach ($Tmp as $key => $value) {
                            $Tmp_Answer = json_decode($value['Answer']);
                            if (count($Tmp_Answer->key) == 1) {
                                $Tmp_RightAnswer = $Tmp_Answer->key[0]->Answer;
                                str_replace(' ', '', $Answer[$i]) == str_replace(' ', '', $Tmp_RightAnswer) ?
                                    $FinalScore =  ($RightScore * $value['Proportion'] / 100) :
                                    true;
                                    $score['Score'] =(string)$FinalScore;
                                    $score->save();
                            } else {
                                foreach ($Tmp_Answer->key as $k => $va) {
                                    if (str_replace(' ', '', $Answer[$i]) == str_replace(' ', '', $va->Answer)) {
                                        $FinalScore = ($RightScore * $value['Proportion'] / 100);
                                        $score['Score'] = (string)$FinalScore;
                                        $score->save();
                                        break;
                                    }
                                }
                            }
                        }
                    }
                    break;
            }
    //    }
       unset($Answer,$status,$RightScore,$RightAnswer);

   }
       $sum = 0.0;
        $TotalScore = Examprocess::find()->select("Score")
            ->where([
                'PaperID' => $PaperID
            ])->asArray()->all();
        foreach ($TotalScore as $key => $value) {
            //var_dump($value['Score']);
            $sum += $value['Score'];
        }
        return $sum;

    }


    /**
     * 手动阅卷
     * @return json
     */
    public function actionManualMark()
    {
        $com = new commonFuc();
        $m_tb = new TbcuitmoonDictionary();

        $course = (string)Yii::$app->session->get('courseCode');
        $courseId = $m_tb->find()->select('CuitMoon_DictionaryName')->where(['CuitMoon_DictionaryCode'=>$course])->asArray()->one();
       // $coursename = $courseId['CuitMoon_DictionaryCode'];
        $PaperID = Yii::$app->request->get();
        $PaperBh = Exampaper::findOne(['PaperID' => $PaperID['id']])->PaperBh;
        $Data = $com->GetPaper($PaperBh);
        foreach ($Data as $key => $value) {
            if($key == "1000204"){
                foreach ($value as $key1 => $value1) {
                    $Data[$key][$key1]['Answer'] = Apfill::find()->select("Answer")->where(['QuestionBh'=>$value1['QuestionBh']])->asArray()->all();
                }
            }
        }
        $Answer = Examprocess::find()->where(['PaperID' => $PaperID])->asArray()->all();
        $score = Exampaper::find()->where(['PaperID'=>$PaperID['id']])->asArray()->one()['Score'];
        $PaperID[0] = 'mark/index';
        return $this->render('paper', [
            'score' => $score,
            'info' => $Data,
            'paperID' => $PaperID['id'],
            'param' => $PaperID,
            'answer' => json_encode($Answer),
            'type' => $courseId
        ]);
    }

    public function actionManualMarkDeal()
    {
        $com = new commonFuc();

        $Info = Yii::$app->request->get();
        $Paper = Exampaper::findOne(['PaperID' => $Info['id']]);
        $Paper->Score = (string)$Info['score'];
        $Paper->DealState = '1';
        // Exampaper::updateAll(['DealState'=>'1'],['PaperID'=>$Info['id']]);
        if ($Paper->save()) {
            $com->JsonSuccess('批阅成功');
        } else {
            $com->JsonFail('批阅失败');
        }
    }







    /**
     * 成绩上报
     */
    public function actionUpGrade()
    {
        $com  = new commonFuc();

        $Data = Yii::$app->request->get();
        if ($Data['type'] == '0') {
            $ExamPlan = Examplan::findOne(['ExamPlanBh' => $Data['ExamPlan']]);
            $Tmp = self::GetList($Data['ExamPlan'], $Data['Class'], 'DealState', '1');

            $Tmp  = $Tmp->all();

            foreach ($Tmp as $item) {
                $m_stu_score = new Stuscore();
                $Tmp = $m_stu_score->findOne([
                    'ExamPlanBh' => $Data['ExamPlan'],
                    'TeachingClassID' => $Data['Class'],
                    'StuNumber' => $item->StudentID
                ]);
                if ($Tmp) {
                    $m_stu_score = $Tmp;
                }
                $m_stu_score->OrderNumber = $com->create_id();
                $m_stu_score->StuNumber = (string)$item->StudentID;
                $m_stu_score->CourseID = (string)Yii::$app->session->get('courseCode');
                $m_stu_score->EndTime = $item->ExamEndTime;
                $m_stu_score->ExamPlanBh = $Data['ExamPlan'];
                $m_stu_score->StarTime = $item->ExamBeginTime;
                $m_stu_score->ExamScore = $item->Score;
                $m_stu_score->TeachingClassID = $Data['Class'];
                if ($ExamPlan->Type == '2') {
                    $m_stu_score->NumOfExam = (string)$ExamPlan->NumOfExam;
                    $m_stu_score->Weights = (string)$ExamPlan->Weights;
                }
                $item->DealState = '2';
                $item->save();
                $m_stu_score->save();
            }
            $Tmp2 = self::GetList($Data['ExamPlan'], $Data['Class'], 'DealState', '2');
            $Tmp2  = $Tmp2->all();
            foreach ($Tmp2 as $item2) {
                $m_stu_score = new Stuscore();
                $Tmp2 = $m_stu_score->findOne([
                    'ExamPlanBh' => $Data['ExamPlan'],
                    'TeachingClassID' => $Data['Class'],
                    'StuNumber' => $item2->StudentID
                ]);
                if ($Tmp2) {
                    $m_stu_score = $Tmp2;
                }
                $m_stu_score->OrderNumber = $com->create_id();
                $m_stu_score->StuNumber = (string)$item2->StudentID;
                $m_stu_score->CourseID = (string)Yii::$app->session->get('courseCode');
                $m_stu_score->EndTime = $item2->ExamEndTime;
                $m_stu_score->ExamPlanBh = $Data['ExamPlan'];
                $m_stu_score->StarTime = $item2->ExamBeginTime;
                $m_stu_score->ExamScore = $item2->Score;
                $m_stu_score->TeachingClassID = $Data['Class'];
                if ($ExamPlan->Type == '2') {
                    $m_stu_score->NumOfExam = (string)$ExamPlan->NumOfExam;
                    $m_stu_score->Weights = (string)$ExamPlan->Weights;
                }
                $item2->DealState = '2';
                $item2->save();
                $m_stu_score->save();
            }
            $com->JsonSuccess('上报成功');
        } else {
//            $ExamPaper = Exampaper::findOne(['PaperID' => $Data['id']]);
//            $ExamPlan  = Examplan::findOne(['ExamPlanBh' => $ExamPaper->ExamPlanBh]);
//            if ($ExamPlan->Type == '1') {
//
//            }
        }
    }


    /***/
    // public function actionGetQuestionType(){
    //     $ExamPlanBh = \Yii::$app->request->get('ExamPlanBh');
    //     $PaperBh = Exampaper::find()->where(['ExamPlanBh'=>$ExamPlanBh])->one()['PaperBh'];
    //     $QuestionType =Createpaper::find()->where(['PaperBh'=>$PaperBh])->asArray()->all()['Memo'];
    //     foreach ($QuestionType as $key => $value) {
    //         switch ($value) {

    //             case 1000204:
    //             case 1000205:
    //             case 1000207:
    //                 Exampaper::updateAll(['DealState'=>'5'],['PaperBh'=>$PaperBh]);
    //                 break;

    //             default:

    //                 break;
    //         }
    //     }
    // }

    //考试异常报告

    public function actionException()
    {
        $m_exam_paper = new Exampaper();

        $paper_info = $m_exam_paper->find()->where([
            'PaperID' => Yii::$app->request->get('id'),
            ])->asArray()->one();
        $except = $this->Exception($paper_info);
        $array['except'] = $except;
        $array['paper_info'] = $paper_info;
        //echo json_encode($except);
        echo json_encode($array);

    }

    public function Exception($paper_info)
    {
        $Memo = $paper_info['Memo'];
        if($Memo > 1){
            $otherIP = (new\yii\db\Query())
            ->select(Exampaper::tableName().'.MachineIP,')
            ->from(Exampaper::tableName())
            ->where(['StudentID'=>$paper_info['StudentID']])
            ->All();

            $initIP = '$paper_info[\'MachineIP\']';
            foreach ($otherIP as $Tmp) {
                $count  = array();
                if($initIP == $Tmp)
                {
                    ;
                }
                else{
                    $i=0;
                    $count[$i] = '$Tmp';
                    $i++;
                }
                return $count;
                // echo json_encode($count);
            }
        }
        else{
            $otherStuID = (new\yii\db\Query())
            ->select(Exampaper::tableName().'.StudentID,')
            ->from(Exampaper::tableName())
            ->where(['MachineIP'=>$paper_info['MachineIP'],'ExamPlanBh'=>$paper_info['ExamPlanBh']])
            ->All();
            return $otherStuID;
            // echo json_encode($otherStuID);
        }
    }

    /**
     * 根据考试计划和教学班级得到考试试卷List
     * @param $ExamPlan   考试计划ID
     * @param $ClassID      普通教学班级ID
     * @param $Filed        DealState or SubmitStage
     * @param $SubmitStage      0 or 1
     * @return $this   返回查询model
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
        $Tmp = $m_exam_paper->find()->where($Where)->orderBy('CAST(Score as SIGNED) DESC');
        return $Tmp;
    }
/*
**下列三个函数本为commonFuc.php中的函数。
**原函数名为Compile()，因为此控制器中需要返回$Score值，而不是echo。
**考虑到前台有多出调用Compile()函数，若更改会引起连锁反应
*/

    public function GetProgramScore($ID,$Code,$Time)
    {
        $com = new commonFuc();
        $m_test_case = new Testcase();
        $m_question = new Questions();
        //查找当前编译的题目
        $Question = $m_question->findOne([
            'QuestionBh' => $ID
        ]);
        //查找所有测试用例
        $TestCase = $m_test_case->find()->select(['TestCaseBh','ScoreWeight','TestCaseInput','TestCaseOutput','Memo'])
            ->where(['QuestionId' => $ID])->all();
        $Problems = [];
        // if ($Question->ProblemID == null) {
            //遍历测试用例
            foreach ($TestCase as $value) {

                //新建一个problem
                $m_problem = new Problem();
                $m_problem->title = $ID;
                $m_problem->in_date = date("Y-m-d H:i:s");
                $m_problem->time_limit = 1;
                $m_problem->memory_limit = 128;
                $m_problem->defunct = 'N';
                $m_problem->save();
                //获取对应的problem id
                $ProblemId = $m_problem->attributes['problem_id'];

                $path =  "/home/judge/data";
//                $path = __DIR__ . '/../../../Question_TestCase';
                $this->mkData($ProblemId, 'test.in', $value->TestCaseInput, $path);
                $this->mkData($ProblemId, 'test.out', $value->TestCaseOutput, $path);

                $x = shell_exec("cp ".$_SERVER['DOCUMENT_ROOT']."/QuestionFile/".$ID."/* /home/judge/data/".$ProblemId);
                $value->Memo = (string)$ProblemId;
                $value->save();

                $Problems[$ProblemId] = $value->ScoreWeight;
            }

            $Question->ProblemID = 0;
            $Question->update();

        // } else {
        //     foreach ($TestCase as $value) {
        //         $Problems[$value->Memo] = $value->ScoreWeight;
        //     }
        // }
        $Solutions = [];
        // echo json_encode($Problems);
        if (count($Problems) > 0) {
            foreach ($Problems as $key=>$item) {
                if(strlen(trim($Code)) > 0){
                    $m_solution = new Solution();
                    $m_source = new SourceCode();
                    $m_source_user = new SourceCodeUser();

                    $m_solution->problem_id = $key;
                    $m_solution->user_id = 'admin';
                    $m_solution->in_date = date("Y-m-d H:i:s");

                    //getCourseCode
                    $courseIds = $m_question->find()->where(['QuestionBh' => $ID])->asArray()->one()['CourseID'];

                    $m_solution->language = $com->nameTranCode($courseIds);
                    $m_solution->code_length = strlen($Code);
                    $m_solution->ip = $this->getClientIp();
                    $m_solution->save();
                    $SolutionID = $m_solution['solution_id'];

                    $m_source->solution_id = $SolutionID;
                    $m_source->source = $Code;
                    $m_source_user->solution_id = $SolutionID;
                    $m_source_user->source = $Code;

                    $m_source->save();
                    $m_source_user->save();

                    $Solutions[$SolutionID] = $item;
                }
            }
        }


        // sleep($Time);
        $Score = 0;
        foreach ($Solutions as $key=>$item) {
            $res = 0;
            while($res == 0 || $res == 2 || $res == 3)
            {
                $Result = $m_solution->findOne(['solution_id'=> $key]);
                $res = $Result->result;
                unset($Result);
                if($res == 4)
                {
                    $Score = $Score + $item;
                    break;
                }
                usleep(500000);
                // else if($res == 11)
                // {
                //     return 0;
                // }
                // else if($res == 0 || $res == 2)
                // {
                //     sleep(1);
                // }
                // else
                // {
                //     // $Score = $Score + 0;
                //     break;
                // }
                // switch ($res) {
                //     case 4:
                //         $Score = $Score + $item;
                //         break;
                //     case 11:
                //         return 0;
                //     case 0:

                //     default:
                //         # code...
                //         break;
                // }
            }

// //                sleep(1);
//             $Result = $m_solution->findOne(['solution_id'=> $key]);
// //            sleep(1);
//             switch ($Result->result) {
//                 case 4:
//                     $Score = $Score + $item;
//                     break;
//                 case 11:
//                     return 0;

//                     break;
//                 default:
//                     $Score = $Score + 0;
//                     break;
            // }
        }
        // $Solutions[] = $Score;
        // echo json_encode($Solutions);
        return $Score;


    }

    //get the array of apfll answer
   function turnto1darray($array=array(),$para='Answer'){
      $ret_array = array();
      foreach ($array as $oneapfill)
      {
        $ret_array[]=$oneapfill[$para];
      }
      return $ret_array;
    }
    //get the array of student exam anwser
    //Multiple answers to the same question exploded by @
    function getapfillfromexam($string){
      $ret_array = array();
      $ret_array = explode("@",$string);
      return $ret_array;
    }


 function mkData($pid,$filename,$input,$OJ_DATA){

        $basedir = "$OJ_DATA/$pid";

        if(!file_exists($basedir)) {
            mkdir($basedir);
        }

        $fp = @fopen ( $basedir . "/$filename", "w" );
        if($fp){
            fputs ( $fp, preg_replace ( "(\r\n)", "\n", $input ) );
            fclose ( $fp );
        }else{
            echo "Error while opening".$basedir . "/$filename ,try [chgrp -R www-data $OJ_DATA] and [chmod -R 771 $OJ_DATA ] ";

        }
    }
    /**
     * 获取客户端IP
     * @return string 返回ip地址,如127.0.0.1
     */
    function getClientIp()
    {
        $onlineip = 'Unknown';
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        {
            $ips = explode(",", $_SERVER['HTTP_X_FORWARDED_FOR']);
            $real_ip = $ips['0'];
            if ($_SERVER['HTTP_X_FORWARDED_FOR'] && preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $real_ip))
            {
                $onlineip = $real_ip;
            }
            elseif ($_SERVER['HTTP_CLIENT_IP'] && preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER['HTTP_CLIENT_IP']))
            {
                $onlineip = $_SERVER['HTTP_CLIENT_IP'];
            }
        }
        if ($onlineip == 'Unknown' && isset($_SERVER['HTTP_CDN_SRC_IP']) && preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER['HTTP_CDN_SRC_IP']))
        {
            $onlineip = $_SERVER['HTTP_CDN_SRC_IP'];
            $c_agentip = 0;
        }
        if ($onlineip == 'Unknown' && isset($_SERVER['HTTP_NS_IP']) && preg_match ( '/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER ['HTTP_NS_IP'] ))
        {
            $onlineip = $_SERVER ['HTTP_NS_IP'];
            $c_agentip = 0;
        }
        if ($onlineip == 'Unknown' && isset($_SERVER['REMOTE_ADDR']) && preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER['REMOTE_ADDR']))
        {
            $onlineip = $_SERVER['REMOTE_ADDR'];
            $c_agentip = 0;
        }
        return $onlineip;
    }
/**
     * 获取自动批阅的进度数据
     *
     */


     /**
      * 搜索
      * @return json 搜索结果
      */
    function actionSearch()
    {
        if(\Yii::$app->request->isPost)
    	{
    		$post=\Yii::$app->request->post();
            if(isset($post['examId']) && isset($post['classId']))
            {
                $ExamPlan = $post['examId'];
                $ClassID = $post['classId'];
                $Filed = 'SubmitStage';
                $SubmitStage = 1;

                $m_exam_paper = new Exampaper();
                $m_exam_plan = new Examplan();
                $m_teach_class_detail = new Teachingclassdetails();

                $Where = ['and',"$Filed='$SubmitStage'"];
                $Type = $m_exam_plan->find()->where([
                    'ExamPlanBh' => $ExamPlan
                ])->asArray()->one();
                if ($Type['Type'] == '1') {
                    $SonExamPlan = $m_exam_plan->find()->select(['ExamPlanBh'])
                        ->where([
                            'CreateUser' => $Type['ExamPlanBh']
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
                $Tmp = $m_exam_paper->find()->where($Where)
                ->andWhere('StudentID like :key or StuName like :key',[':key'=>'%'.$post['key'].'%'])
                ->orderBy('CAST(Score as SIGNED) DESC')->asArray()->all();
                echo json_encode($Tmp) ;
            }
        }
    }

}
