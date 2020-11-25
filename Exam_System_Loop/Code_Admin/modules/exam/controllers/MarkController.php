<?php
namespace app\modules\exam\controllers;

use app\common\HttpClient;
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

use common\redisFunc;
use app\models\teachplan\Teachingclassmannage;
use app\models\redismod\SolutionRedis;
use app\models\redismod\ProblemRedis;

use app\modules\front\controllers\ExamController;
use yii\db\Query;
use yii\web\Response;


class MarkController extends BaseController
{
    public function actionIndex()
    {
           $m_dic = new TbcuitmoonDictionary();
            $com = new commonFuc();

        $Info = Yii::$app->request->get();
        if (isset($Info['classID']) && $Info['classID'] != 'null') {

                $Data['ExamPlan_Choice'] = $Info['examPlan'];
                $Data['ClassID_Choice'] = $Info['classID'];
                $Data['Term_Choice'] = $Info['term'];
                $Data['Deal_State'] = $Info['dealState'];
                $Tmp = self::GetList($Info['examPlan'], $Info['classID'], 'SubmitStage', '1');
        }
        else {
            $Tmp = Exampaper::find();
            $Data['Term_Choice'] = false;
            $Data['ExamPlan_Choice'] = false;
            $Data['ClassID_Choice'] = false;
            $Data['Term_Choice'] = false;
            $Data['Deal_State'] = false;
        }

        $list = null;
        //筛选 阅卷情况
        if (isset($Info['dealState']) && $Info['dealState'] != 'null') {
            foreach ($Tmp->all() as $model){
                if($Info['dealState'] == $model['DealState']){
                    $list[] = $model;
                }
            }
        }
        //如果
        if (!isset($Info['dealState']) || $Info['dealState'] == '6' ){
            $list = $Tmp->all();
        }

        //$Tmp_One = clone $Tmp;
       // $Pages = $com->Tab($Tmp_One);

        return $this->render('index', [
            'term' => $m_dic->getDictionaryList('学期'),
           // 'pages' => $Pages,
            'list' => $list,
            'choice' => $Data,
            'now_term' => $com->getNowTerm(),
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

    /**
     * 修正成绩,如果已经上报则还要修改上报的成绩
     * @return json
     */

    public function actionSavePaper()
    {
        $com = new commonFuc();
        $Ans = Yii::$app->request->post();
        $PaperID = Yii::$app->request->post('PaperID');
        $score = Yii::$app->request->post('score');
        $Paper = Exampaper::findOne(['PaperID' => $PaperID]);
        Exampaper::updateAll(['Score' => $score],['PaperID'=>$PaperID]);
        unset($Ans['_csrf']);
        unset($Ans['PaperID']);
        $com->SavePaper($Ans,$PaperID);

        //$ExamPlanBh = Exampaper::findOne(['PaperID' => $PaperID])['ExamPlanBh'];
        $ExamPaper = Exampaper::findOne(['PaperID' => $PaperID]);
        $ExamPlanBh = $ExamPaper['ExamPlanBh'];
        $StuID = $ExamPaper['StudentID'];

        $stuScore = new Stuscore();
        $res = $stuScore->updateScore($score,$StuID,$ExamPlanBh);
        if($res['code'] == -1)
        {
            $com->JsonFail($res['msg']);
        }elseif($res['code'] == 2){
            $com->JsonSuccess('成绩修改成功');//没有上报则找不到记录,直接返回成功
        }else{
            $com->JsonSuccess('成绩修改成功,成绩上报成功!');
        }

    }
    
    /**
     * 手动阅卷中，保存每道题目打分分数
     * @return json
     */
    public function actionSaveScore()
    {
        $com = new commonFuc();
        $PaperID = Yii::$app->request->post('PaperID');
        $score = Yii::$app->request->post('score');
        $QuestionBh = Yii::$app->request->post('QuestionBh');
        $PaperBh = Exampaper::findOne(['PaperID' => $PaperID])->PaperBh;

        if($PaperID == NULL){
            $com->JsonFail('打分失败');
        }else{
            $max = Createpaper::find()->where(['PaperBh'=> $PaperBh,'QuestionBh'=> $QuestionBh])->asArray()->one()['TotalScore'];
            if($score > $max){
                $com->JsonFail('打分失败，分数超过上限');
            }else{
                Examprocess::updateAll(['Score' => $score],['PaperID'=>$PaperID,'QuestionBh'=>$QuestionBh]);
                $com->JsonSuccess($score);
            }
        }
    }

    public function actionMark()
    {
        $com = new commonFuc();
        $m_exam_paper = new Exampaper();

        $ids = Yii::$app->request->get('ids');

        //获取课程编号
        $courseID = Yii::$app->session->get('courseCode');

        if($ids){
//             $Score = ($courseID == '2000303')?$this->MarkF($ids):$this->Mark($ids);
             $Score = $this->Mark($ids);
             //在Exampaper中查出待批阅试卷
             $Paper = Exampaper::find()->where([
                 'PaperID' => $ids,
             ])->one();

             if($Paper){
               //dealstate = 1 已批阅 5 手工批阅
                $Paper['Score'] = (string)$Score;
                if($Paper['DealState'] != '5'){
                    $Paper['DealState'] = '1';
                }
                $Paper->ExamException = (string)($this->IsException($Paper));

                try {
                 $Paper->save();
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


/**此为通过读取数据库数据来判断批阅进度的方法（已被抛弃使用）**/
    // public function actionCount()
    // {
    //     $PaperID = yii::$app->request->post('ids');
    //     $ExamPlanBh = Exampaper::find()->where([
    //             'PaperID' => $PaperID,
    //         ])->asArray()->one()['ExamPlanBh'];
    //      // $TotalNum = Exampaper::find()->andWhere([
    //      //    'PaperBh' => $PaperBh,
    //      //    ])->count();
    //      $FinishNum = count(Exampaper::find()->where([
    //         'ExamPlanBh' => $ExamPlanBh,
    //         'DealState' => '1',
    //         ])->asArray()->all());
    //      //$resCount['sum'] = $TotalNum;
    //      $resCount['count'] = $FinishNum;
    //      echo json_encode($resCount);
    // }


    /**
     * 判断学生试卷是否异常,
     * 异常情况如下:
     *      1,同一场考试,有多个学生试卷ip相同
     * @param [model] $Paper [试卷模型]
     * return 1 有异常, 0 无异常
     */
    public function IsException($Paper)
    {
        $ExamPlanBh = $Paper->ExamPlanBh;
        $StudentNum = $Paper->StudentID;
        $AllIp = explode(',',$Paper->MachineIP);
        $sum = 0;
        foreach ($AllIp as $key => $value) {
            $OtherIpNum = Exampaper::find()
            ->where(['ExamPlanBh'=>$Paper->ExamPlanBh])
            ->andWhere('MachineIP like :key ',[':key'=>'%'.$value.'%'])
            ->andWhere(['not in', 'StudentID', $Paper->StudentID])
            ->count();
            $sum += $OtherIpNum;
        }
        if($sum > 0){
            return 1;
        }
        if(count($AllIp) > 1){
            return 1;
        }
        return 0;
    }

    public function Mark($PaperID)
    {

        $m_question = new Questions();
        $m_exam_process = new Examprocess();
        $m_exam_paper = new Exampaper();
        $m_create_paper = new Createpaper();
        $m_exam_plan = new Examplan();
        $com = new commonFuc();

        //找出学生试卷答案
        $Paper = $m_exam_paper->find()->where([
            'PaperID' => $PaperID,
        ])->asArray()->one();
        //试卷编号
        $PaperBh = $Paper['PaperBh'];
        //考试计划
        $ExamPlanBh = $Paper['ExamPlanBh'];
        //试卷--题对应表
        $Questions = $m_create_paper->find()->where([
            'PaperBh' => $PaperBh,
        ])->all();
        //课程ID
        $CourseID = $m_exam_plan->find()->where([
            'ExamPlanBh' => $ExamPlanBh,
        ])->asArray()->one()['CourseID'];
        //学生试题答案
        $Answers = $m_exam_process->find()->where([
            'PaperID' => $PaperID,
        ])->asArray()->all();
      //遍历每一道题
        foreach ($Questions as $item) {
            $FinalScore = 0.0;
            $Answer = '';

            foreach ($Answers as $key){
                if($key['QuestionBh'] == $item->QuestionBh)
                    $Answer = $key;
            }
            //学生试题状态
            //$status = $Answer['Status'];  update by lgc 2020/6/3
            $status = isset($Answer['Status']) ? $Answer['Status'] : '';
            //正确答案
            $RightAnswer = $m_question->find()->where([
                'QuestionBh' => $item->QuestionBh
            ])->asArray()->one()['Answer'];
            //题的得分
            $RightScore = $item->TotalScore;

            switch ($item->Memo) {
                //选择,判断
                case 100020102 :
                case 1000203:
                //选择题
                case 100020101 :
                    if(isset($Answer['Answer']))
                    {
                        $FinalScore = trim($Answer['Answer']) == trim($RightAnswer) ?  (double)$RightScore : 0;
                    }else{
                        $FinalScore = 0;
                    }
                    //$FinalScore = trim($Answer['Answer']) == trim($RightAnswer) ?  (double)$RightScore : 0; update by lgc 2020/6/3

                    Examprocess::updateAll(['Score'=>$FinalScore],['QuestionBh' =>$item->QuestionBh,'PaperID' => $PaperID]);
                    break;
                //下列分别为填空、改错题、简答、综合题~均为主观题
                case 1000204:
                //查出填空题的分值比例作为数组存储索引为填空题位置-1
                $apfillrows = Apfill::find()->where(['QuestionBh' => $item->QuestionBh])->asArray()->all();
                $scoreproportion = self::turnto1darray($apfillrows,'Proportion');
                $apfillanswerarray = self::turnto1darray($apfillrows,'Answer');

                //学生填空题答案作为数组存储索引为填空位置-1
                $apfilexamanwser = self::getapfillfromexam($Answer['Answer']);
                $FinalScore=0;
                // 判断
                for($i = 0;$i < count($apfillanswerarray);$i++)
                {
                    if(strcmp(strtolower($apfillanswerarray[$i]), strtolower(trim($apfilexamanwser[$i]))) == 0) {
                        $oneapfillscore = ($scoreproportion[$i]/100.0)*$RightScore;

                        $FinalScore += $oneapfillscore;
                    }else{
                        $FinalScore += 0;
                    }
                }
                //修改学生试卷该题得分
                Examprocess::updateAll(['Score'=>$FinalScore],['QuestionBh'=>$item->QuestionBh,'PaperID' => $PaperID]);
                Exampaper::updateAll(['DealState'=>'5'],['PaperID'=>$PaperID]);
                break;
                case 1000205:

                case 1000207:
                    Exampaper::updateAll(['DealState'=>'5'],['PaperID'=>$PaperID]);
                    break;
                //编程
                case 1000206:
                    //jsp课程
                    if($CourseID == 2000304) {
                        Exampaper::updateAll(['DealState'=>'5'],['PaperID'=>$PaperID]);
                        break;
                    }
                    //如果当前学生答案不为空 且不是 数据库原理及应用 课程
                    if (strlen($Answer['Answer']) != 0 && $CourseID != 2000313) {
                        //判断该学生该编程题是否已经满分 若满分则不再重新编译
                        //哪个分数高选哪个
                        $Tmp = $this->GetProgramScore($item->QuestionBh, $Answer['Answer'], 3);
                        if($Tmp >= $Answer['Score']){
                            $Fscore = $Tmp;
                        }else{
                            $Fscore = $Answer['Score'];
                        }
                        $FinalScore =($RightScore*$Fscore)/100;

                        Examprocess::updateAll(['Score'=>$FinalScore],['QuestionBh' =>$item->QuestionBh,'PaperID' => $PaperID]);

                        //如果是 数据库原理及应用 课程
                    }else if($CourseID == 2000313){
                        //对于编程题得分不为 100 的，重新调取一次接口
                        if($Answer['Score'] != '100'){
                            //试卷号，题号，答案
                            $params =[
                                'questionBh' => $Answer['QuestionBh'],
                                'paperID' => $Answer['PaperID'],
                                'answerSql' => $Answer['Answer']
                            ];
                            $params = json_encode($params, 320);
                            $res = HttpClient::post("http://222.18.158.42:8801/producer/compile/autoTeacher", $params);
                            $res = json_decode($res);
                            //更新成绩
                            if(isset($res->data->msg) && $res->data->msg == 100){
                                $score = $RightScore;
                            }else{
                                $score = 0;
                            }
                            Examprocess::updateAll(['Score' => $score], ['QuestionBh' => $Answer['QuestionBh'], 'PaperID' => $Answer['PaperID']]);
                            sleep(1);
                        }
                    }
                    break;

                //改错
                case 1000208:
                    $m_find_error = new FindError();
                    $Answer = explode('@', $Answer['Answer']);
                    $AnswerNum = 1;
                    $score = $m_exam_process->find()
                    ->where([
                       'QuestionBh' =>$item->QuestionBh,
                       'PaperID' => $PaperID
                    ])->One();
                    $tmpscore = 0;
                    for ($i = 0; $i < count($Answer) - 1; $i++) {
                        //查找对应的答案
                        $Tmp = FindError::find()
                        ->select(['Answer', 'Proportion'])
                        ->where([
                            'QuestionBh' => $item->QuestionBh,
                            'ErrorCount' => $AnswerNum
                        ])
                        ->asArray()
                        ->one();

                        if($Tmp){
                            $Tmp_Answer = json_decode($Tmp['Answer']);
                            if (count($Tmp_Answer->key) == 1) {
                                $Tmp_RightAnswer = $Tmp_Answer->key[0]->Answer;
                                str_replace(' ', '', $Answer[$i]) == stripslashes(str_replace(' ', '', $Tmp_RightAnswer)) ?
                                    $FinalScore =  ($RightScore * $Tmp['Proportion'] / 100) :
                                    true;
                                    $tmpscore += $FinalScore;
                            } else {
                                foreach ($Tmp_Answer->key as $k => $va) {
                                    if (str_replace(' ', '', $Answer[$i]) == stripslashes(str_replace(' ', '', $va->Answer))) {
                                        $FinalScore = ($RightScore * $Tmp['Proportion'] / 100);
                                        $tmpscore += $FinalScore;
                                        break;
                                    }
                                }
                            }
                        }
                        $AnswerNum++;
                    }
                    $score['Score'] = (string)$tmpscore;
                    $score->save();
                    break;
            }
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
        if($score == null)
            $score = 0;
        $PaperID[0] = 'mark/index';
        //处理数据
//        $i = 0;
//        foreach($Answer as $key){
//            if ($key['Memo'] == '1000204'){
//               $Answer[$i]['Answer'] = explode($key['Answer'], '@');
//            }
//            $i++;
//        }
//        $Answer = json_encode($Answer);
        // print(json_encode($Answer));
        // die;
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
        $score = round($Info['score']);
        $Paper->Score = (string)$score;
        $Paper->DealState = '1';
        // Exampaper::updateAll(['DealState'=>'1'],['PaperID'=>$Info['id']]);
        if ($Paper->save()) {
            $com->JsonSuccess('批阅成功');
        } else {
            $com->JsonFail('批阅失败');
        }
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

        $paper = Exampaper::find()
        ->where(['PaperID' => Yii::$app->request->get('id'),])
        ->asArray()
        ->one();

        $ExamPlanBh = $paper['ExamPlanBh'];
        $StudentNum = $paper['StudentID'];
        $AllIp = explode(',',$paper['MachineIP']);
        $sum = 0;
        $Exception = [];
        foreach ($AllIp as $key => $value) {
            $OtherStu = Exampaper::find()
            ->select("StudentID,StuName")
            ->where(['ExamPlanBh'=>$ExamPlanBh])
            ->andWhere('MachineIP like :key ',[':key'=>'%'.$value.'%'])
            ->andWhere(['not in', 'StudentID', $StudentNum])
            ->asArray()
            ->all();
            foreach ($OtherStu as $key1 => $value1) {
                $Exception['students'][] = $value1;
            }
        }
        $Exception['ips'] = $AllIp;
        $Exception['paper'] = $paper;
        echo json_encode($Exception);
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
        $redisFun = new redisFunc();
        $redis = \Yii::$app->redis;
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

                // //新建一个problem
                // $m_problem = new Problem();
                // $m_problem->title = $ID;
                // $m_problem->in_date = date("Y-m-d H:i:s");
                // $m_problem->time_limit = 1;
                // $m_problem->memory_limit = 128;
                // $m_problem->defunct = 'N';
                // $m_problem->save();
                // //获取对应的problem id
                // $ProblemId = $m_problem->attributes['problem_id'];

                // 新建一个problem 保存到redis
                $ProblemId = $redisFun->saveProblemToRedis($ID);

                $path =  "/home/judge/data";
                $this->mkData($ProblemId, 'test.in', $value->TestCaseInput, $path);
                $this->mkData($ProblemId, 'test.out', $value->TestCaseOutput, $path);
                $x = shell_exec("cp ".$_SERVER['DOCUMENT_ROOT']."/QuestionFile/".$ID."/* /home/judge/data/".$ProblemId);
                $value->Memo = (string)$ProblemId;
                $value->save();

                $Problems[$ProblemId] = $value->ScoreWeight;
            }

            $Question->ProblemID = 0;
            $Question->update();


        $Solutions = [];

        if (count($Problems) > 0) {
            foreach ($Problems as $key=>$item) {
                if(strlen(trim($Code)) > 0){
                    $m_solution = new Solution();
                    $m_source = new SourceCode();
                    $m_source_user = new SourceCodeUser();

                    $m_solution->problem_id = $key;
                    $m_solution->user_id = 'admin';
                    $m_solution->in_date = date("Y-m-d H:i:s");
                    $m_solution->language = $com->nameTranCode(\Yii::$app->session->get('courseCode'));
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

                    // 新建与problem一一对应的solution 保存redis
                    $SolutionID = $redisFun->saveSolutionToRedis($Code, $key);

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
                //$Result = $m_solution->findOne(['solution_id'=> $key]);
                $Result = SolutionRedis::findOne($key);
                $res = (int)$Result->result;
                unset($Result);
                if($res == 4)
                {
                    $Score = $Score + $item;
                    break;
                }
                usleep(500000);

            }

        }
        return $Score;


    }
// /*
// **下列三个函数本为commonFuc.php中的函数。
// **原函数名为Compile()，因为此控制器中需要返回$Score值，而不是echo。
// **考虑到前台有多出调用Compile()函数，若更改会引起连锁反应
// */
//
//     public function GetProgramScore($ID,$Code,$Time)
//     {
//         $com = new commonFuc();
//         $m_test_case = new Testcase();
//         $m_question = new Questions();
//         //查找当前编译的题目
//         $Question = $m_question->findOne([
//             'QuestionBh' => $ID
//         ]);
//         //查找所有测试用例
//         $TestCase = $m_test_case->find()->select(['TestCaseBh','ScoreWeight','TestCaseInput','TestCaseOutput','Memo'])
//             ->where(['QuestionId' => $ID])->all();
//         $Problems = [];
//         // if ($Question->ProblemID == null) {
//             //遍历测试用例
//             foreach ($TestCase as $value) {
//
//                 //新建一个problem
//                 $m_problem = new Problem();
//                 $m_problem->title = $ID;
//                 $m_problem->in_date = date("Y-m-d H:i:s");
//                 $m_problem->time_limit = 1;
//                 $m_problem->memory_limit = 128;
//                 $m_problem->defunct = 'N';
//                 $m_problem->save();
//                 //获取对应的problem id
//                 $ProblemId = $m_problem->attributes['problem_id'];
//
//                 $path =  "/home/judge/data";
// //                $path = __DIR__ . '/../../../Question_TestCase';
//                 $this->mkData($ProblemId, 'test.in', $value->TestCaseInput, $path);
//                 $this->mkData($ProblemId, 'test.out', $value->TestCaseOutput, $path);
//
//                 $x = shell_exec("cp ".$_SERVER['DOCUMENT_ROOT']."/QuestionFile/".$ID."/* /home/judge/data/".$ProblemId);
//                 $value->Memo = (string)$ProblemId;
//                 $value->save();
//
//                 $Problems[$ProblemId] = $value->ScoreWeight;
//             }
//
//             $Question->ProblemID = 0;
//             $Question->update();
//
//         // } else {
//         //     foreach ($TestCase as $value) {
//         //         $Problems[$value->Memo] = $value->ScoreWeight;
//         //     }
//         // }
//         $Solutions = [];
//         // echo json_encode($Problems);
//         if (count($Problems) > 0) {
//             foreach ($Problems as $key=>$item) {
//                 if(strlen(trim($Code)) > 0){
//                     $m_solution = new Solution();
//                     $m_source = new SourceCode();
//                     $m_source_user = new SourceCodeUser();
//
//                     $m_solution->problem_id = $key;
//                     $m_solution->user_id = 'admin';
//                     $m_solution->in_date = date("Y-m-d H:i:s");
//                     $m_solution->language = $com->nameTranCode(\Yii::$app->session->get('courseCode'));
//                     $m_solution->code_length = strlen($Code);
//                     $m_solution->ip = $this->getClientIp();
//                     $m_solution->save();
//                     $SolutionID = $m_solution['solution_id'];
//
//                     $m_source->solution_id = $SolutionID;
//                     $m_source->source = $Code;
//                     $m_source_user->solution_id = $SolutionID;
//                     $m_source_user->source = $Code;
//
//                     $m_source->save();
//                     $m_source_user->save();
//
//                     $Solutions[$SolutionID] = $item;
//                 }
//             }
//         }
//
//
//         // sleep($Time);
//         $Score = 0;
//         foreach ($Solutions as $key=>$item) {
//             $res = 0;
//             while($res == 0 || $res == 2 || $res == 3)
//             {
//                 $Result = $m_solution->findOne(['solution_id'=> $key]);
//                 $res = $Result->result;
//                 unset($Result);
//                 if($res == 4)
//                 {
//                     $Score = $Score + $item;
//                     break;
//                 }
//                 usleep(500000);
//                 // else if($res == 11)
//                 // {
//                 //     return 0;
//                 // }
//                 // else if($res == 0 || $res == 2)
//                 // {
//                 //     sleep(1);
//                 // }
//                 // else
//                 // {
//                 //     // $Score = $Score + 0;
//                 //     break;
//                 // }
//                 // switch ($res) {
//                 //     case 4:
//                 //         $Score = $Score + $item;
//                 //         break;
//                 //     case 11:
//                 //         return 0;
//                 //     case 0:
//
//                 //     default:
//                 //         # code...
//                 //         break;
//                 // }
//             }
//
// // //                sleep(1);
// //             $Result = $m_solution->findOne(['solution_id'=> $key]);
// // //            sleep(1);
// //             switch ($Result->result) {
// //                 case 4:
// //                     $Score = $Score + $item;
// //                     break;
// //                 case 11:
// //                     return 0;
//
// //                     break;
// //                 default:
// //                     $Score = $Score + 0;
// //                     break;
//             // }
//         }
//         // $Solutions[] = $Score;
//         // echo json_encode($Solutions);
//         return $Score;
//
//
//     }


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
