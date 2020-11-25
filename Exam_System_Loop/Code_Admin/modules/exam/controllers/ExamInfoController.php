<?php

namespace app\modules\exam\controllers;

use app\models\exam\Examprocess;
use app\models\question\Knowledgepoint;
use app\models\system\TbcuitmoonDictionary;
use app\modules\front\controllers\ExamController;
use common\commonFuc;
use app\models\exam\Exampaper;
use app\models\teachplan\Examplan;
use app\models\teachplan\Teachingclassmannage;
use app\models\question\Questions;
use app\models\system\AdminLog;
use app\models\teachplan\Teachingclassdetails;
use app\models\systembase\Studentinfo;
use Yii;

require_once __DIR__.'/../../../web/component/excel/PHPExcel/IOFactory.php';

class ExamInfoController extends \app\controllers\BaseController
{
    /**
     * 渲染搜首页
     * @return string
     */
    public function actionIndex()
    {
        $m_dic = new TbcuitmoonDictionary();
        $com = new commonFuc();
        $m_exam_paper = new Exampaper();

        $Info = Yii::$app->request->get();
        $Where = [];
        if (isset($Info['classID'])) {
            $Where['ExamPlanBh'] = $Info['examPlan'];
            $Where[Exampaper::tableName().'.TeachingClassID'] = $Info['classID'];
            $Data['ExamPlan_Choice'] = $Info['examPlan'];
            $Data['ClassID_Choice'] = $Info['classID'];
            $Data['Term_Choice'] = $Info['term'];
        } else {
            $Data['Term_Choice'] = false;
            $Data['ExamPlan_Choice'] = false;
            $Data['ClassID_Choice'] = false;
            $Data['Term_Choice'] = false;
        }
        // $Where['TeacherName'] = Yii::$app->session->get('UserName');
        $Tmp = $m_exam_paper->find()->leftJoin(Teachingclassmannage::tableName(),
                    Teachingclassmannage::tableName().'.TeachingClassID='.
                    Exampaper::tableName().'.TeachingClassID')->where($Where);
        $Tmp_One = clone $Tmp;
        $Pages = $com->Tab($Tmp_One);

        return $this->render('index',[
            'term' => $m_dic->getDictionaryList('学期'),
            'pages' => $Pages,
            'list' => $Tmp->all(),
            'choice' => $Data,
            'now_term' => $com->getNowTerm(),
        ]);
    }

    /**
     * 查看试卷详情
     */
     // public function actionView()
     // {
     //    $m_exam_paper = new Exampaper();

     //    $Tmp = $m_exam_paper->find()->where([
     //        'PaperID' => Yii::$app->request->get('id'),
     //    ])->asArray()->one();

     //     echo json_encode($Tmp);
     // }
    public function actionView()
    {

                $paper_info = (new \yii\db\Query())
                ->select(Exampaper::tableName().'.Memo,StuName,StudentID,ExamBeginTime,
                    ExamEndTime,MachineIP,MACAddress,' .Examplan::tableName().'.ExamPlanName')
                ->from(Exampaper::tableName())
                ->leftJoin(Examplan::tableName(),
                    Examplan::tableName().'.ExamPlanBh='.
                    Exampaper::tableName().'.ExamPlanBh')
                ->where(['PaperID' => Yii::$app->request->get('id')])
                ->one();
                echo json_encode($paper_info,JSON_UNESCAPED_UNICODE);

    }



    /**
     * 批量提交试卷
     */
    public function actionSubmit()
    {
        $m_exam_paper = new Exampaper();

        $Data = Yii::$app->request->get();
        $Tmp = $m_exam_paper->find()->where([
            'ExamPlanBh' => $Data['examPlan'],
            'TeachingClassID' => $Data['Class'],
        ])->all();
        foreach ($Tmp as $item) {
            $item->ExamEndTime = date('Y-m-d H:i:s');
            $item->SubmitStage = '1';
            $item->save();
        }
        echo json_encode('0');
    }

    public function actionSubmitAlone()
    {
        $m_exam_paper = new Exampaper();
        $com = new commonFuc();

        $get = Yii::$app->request->get();
        if (isset($get['id'])) {
            $Tmp = $m_exam_paper->findOne([
                'PaperID' => $get['id']
            ]);
            if($get['type']){
                $Tmp->SubmitStage = '0';
                $Tmp->ExamEndTime = '';
                if ($Tmp->save()) {
                    $com->JsonSuccess('恢复成功');
                } else {
                    $com->JsonFail('恢复失败');
                }
            }else{
                $Tmp->SubmitStage = '1';
                $Tmp->ExamEndTime = date('Y-m-d H:i:s');
                if ($Tmp->save()) {
                    $com->JsonSuccess('交卷成功');
                } else {
                    $com->JsonFail('交卷失败');
                }
            }
        } else {
            $com->JsonFail('数据错误');
        }
    }

    // public function actionCorrect()
    // {
    //     $com = new commonFuc();

    //     $PaperID = Yii::$app->request->get();
    //     $score = Exampaper::find()->where(['PaperID'=>$PaperID['id']])->asArray()->one()['Score'];
    //     $PaperBh = Exampaper::findOne(['PaperID'=>$PaperID['id']])->PaperBh;
    //     $Data = $com->GetPaper($PaperBh);
    //     $Answer = Examprocess::find()->where(['PaperID' => $PaperID])->asArray()->all();
    //    $PaperID[0] = 'exam-info/index';
    //     return $this->render('paper',[
    //         'score'=>$score,
    //         'info' => $Data,
    //         'paperID' => $PaperID['id'],
    //         'param' => $PaperID,
    //         'answer' => json_encode($Answer),
    //     ]);
    // }

    // public function actionSavePaper()
    // {
    //     $com = new commonFuc();

    //     $Ans = Yii::$app->request->post();
    //     $ExamPlanBh = Yii::$app->request->post('PaperID');
    //     unset($Ans['_csrf']);
    //     unset($Ans['PaperID']);
    //     $com->SavePaper($Ans,$ExamPlanBh);
    //     $com->JsonSuccess('修正成功');
    // }

    public function actionDelete()
    {
        $com = new commonFuc();
        $m_exam_paper = new Exampaper();

        $ids = Yii::$app->request->get('ids');
        if(count($ids) > 0) {
            foreach ($ids as $item){
                Exampaper::deleteAll(['PaperID' => $item]);
            }
            $com->JsonSuccess('删除成功');
        }
    }

    public function actionGetPaperInfo()
    {
        if(\Yii::$app->request->isPost)
    	{
            $com = new commonFuc();
    		$post=\Yii::$app->request->post();
            if(isset($post['paperId']))
            {
                $paper = Examprocess::find()
                ->select("PaperID,".Questions::tableName().".QuestionBh,SubmitTime,"
                .Examprocess::tableName().".Answer as StuAnswer,Description,QuestionType,name")
                ->leftJoin(Questions::tableName(),
                Questions::tableName().".QuestionBh=".Examprocess::tableName().'.QuestionBh')
                ->where(['PaperID'=>$post['paperId']])
                ->orderBy("QuestionType")
                ->asArray()
                ->all();

                $log = AdminLog::find()
                ->select("id,posts,created_at")
                ->where("posts like :key",[':key'=>"%".$post['paperId']."%"])
                ->andWhere(['route'=>"front/exam/save"])
                ->orderBy("created_at ASC")
                ->asArray()
                ->all();
                $logcopy = $log;
                foreach ($log as $key => $value) {
                    $log[$key] = json_decode($log[$key]['posts'],true);
                }
                foreach ($paper as $key => $value) {
                    $i = 0;
                    foreach ($log as $key1 => $value1) {
                        if(isset($log[$key1][$paper[$key]['QuestionBh']]))
                        {
                            $paper[$key]['log'][$logcopy[$key1]['id']]['answer'] = $log[$key1][$paper[$key]['QuestionBh']];
                            $paper[$key]['log'][$logcopy[$key1]['id']]['time'] = date('Y-m-d H:i:s',$logcopy[$key1]['created_at']) ;
                        }


                    }
                }
                echo json_encode($paper);
            }else {
                echo json_encode("参数错误");
            }
        }
    }

    public function actionSave()
    {
        if(\Yii::$app->request->isPost)
    	{
            $com = new commonFuc();
    		$post=\Yii::$app->request->post();
            $paper = $post['PaperID'];
            $question = $post['QuestionBh'];
            $log = $post['LogID'];
            $aimLog = AdminLog::find()
            ->where(['id'=>$log])
            ->asArray()
            ->one();
            $questions = json_decode($aimLog['posts'],true);
            $examProcess = Examprocess::find()
            ->where(['PaperID'=>$paper,'QuestionBh'=>$question])
            ->one();
            $updateAnswer  = '';
            if($examProcess->Memo == '1000204')
            {
                foreach ($questions[$question] as $value) {
                    $updateAnswer = $updateAnswer.$value.'@';
                }
                // $updateAnswer = implode('@',$questions[$question]);
                // $updateAnswer += "@";
                // echo json_encode($questions[$question]);
            }else {
                $updateAnswer = $questions[$question];
            }
            // echo $updateAnswer;
            $examProcess->Answer = $updateAnswer;
            if($examProcess->save())
            {
                echo "修改成功";
            } else {
                echo "修改失败";
            }
        }
    }

    public function actionGetExcel()
    {
        $PHPExcel = new \PHPExcel();
        $Info = Yii::$app->request->get();
        $m_tb = new TbcuitmoonDictionary();

        if (isset($Info['classID']) and $Info['classID']!='null' and ($Info['examPlan']!='null')) {

            $courseCode = (string)Yii::$app->session->get('courseCode');
            $term = $Info['term'];//学期
            $courseId = $m_tb->find()->select('CuitMoon_DictionaryName')->where(['CuitMoon_DictionaryCode'=>$courseCode])->asArray()->one();
            $courseId = $courseId['CuitMoon_DictionaryName'];//课程

            $exam = Examplan::find()->where([
//                'TeachingClassID'=>$Info['classID'],
                'ExamPlanBh'=>$Info['examPlan']
            ])->orderBy('StarTime')->asArray()->all();

            foreach ($exam as $key => $value) {
                $ExamPlanName = $value['ExamPlanName'];
            }

            $PHPExcel->getProperties()->setTitle($ExamPlanName.'--试卷');
            $PHPExcel->setActiveSheetIndex(0);
            $str = [];

            $PHPExcel->getActiveSheet()->setCellValue('A1','考试计划');
            $PHPExcel->getActiveSheet()->setCellValue('B1','学号');
            $PHPExcel->getActiveSheet()->setCellValue('C1','姓名');
            $PHPExcel->getActiveSheet()->setCellValue('D1','学生答案');
            $PHPExcel->getActiveSheet()->setCellValue('E1','该题得分');
            $PHPExcel->getActiveSheet()->setCellValue('F1','考试成绩');
            $PHPExcel->getActiveSheet()->setCellValue('G1','交卷时间');
            $PHPExcel->getActiveSheet()->setCellValue('H1','正确答案');
            $PHPExcel->getActiveSheet()->setCellValue('I1','题目描述');
            $PHPExcel->getActiveSheet()->setCellValue('J1','题目阶段');
            $PHPExcel->getActiveSheet()->setCellValue('K1','知识点');

            $str = [];
            foreach(range('A','Z') as $v)
            {
                $str[] = $v;
            }
            $exampaper = Exampaper::find()->where([
                'ExamPlanBh'=>$Info['examPlan']
            ])->orderBy('StudentID ASC')->asArray()->all();

            $i = 1;
            $j = 0;
            foreach ($exampaper as $key1 => $value1)
            {
                $StuNumber = $value1['StudentID'];
                $Name = $value1['StuName'];
                $TotalScore = $value1['Score'];
                $examprocess = examProcess::find()->where([
                    'PaperID'=>$value1['PaperID']
                ])->asArray()->all();
                foreach ($examprocess as $key2 => $value2)
                {
                    $Answer = $value2['Answer'];
                    $SubmitTime = $value2['SubmitTime'];
                    $Score = $value2['Score'];
                    $questions = questions::find()->where([
                        'QuestionBh'=>$value2['QuestionBh']
                    ])->asArray()->all();
                    //取出所有的题目阶段
                    $stageCode = TbcuitmoonDictionary::find()
                        ->where(['CuitMoon_DictionaryName' => '题目阶段'])
                        ->one();
                    $stages = TbcuitmoonDictionary::find()
                        ->select(['CuitMoon_DictionaryName', 'CuitMoon_DictionaryCode'])
                        ->where(['CuitMoon_ParentDictionaryID' => $stageCode->CuitMoon_DictionaryID])
                        ->asArray()
                        ->all();
                    $j=0;
                    foreach ($questions as $key3 => $value3)
                    {
                        $i++;
                        $Tanswer = $value3['Answer'];
                        $Description = $value3['Description'];
                        $stage = '';
                        //获取阶段信息
                        foreach ($stages as $value){
                            if($value['CuitMoon_DictionaryCode'] == $value3['Stage'])
                                $stage = $value['CuitMoon_DictionaryName'];
                        }
                        //获取知识点信息
                        $knowledgepoint = Knowledgepoint::find()
                            ->select(['Description'])
                            ->where(['KnowledgeBh' => $value3['KnowledgeBh']])
                            ->one();
                        //echo $StuNumber," ",$Name," ",$SubmitTime," ",$Answer," ",$Score," ",$Tanswer,"</br>";
                        $PHPExcel->getActiveSheet()->setCellValue($str[$j++].$i,$ExamPlanName);
                        $PHPExcel->getActiveSheet()->setCellValue($str[$j++].$i,$StuNumber);
                        $PHPExcel->getActiveSheet()->setCellValue($str[$j++].$i,$Name);
                        $PHPExcel->getActiveSheet()->setCellValue($str[$j++].$i,$Answer);
                        $PHPExcel->getActiveSheet()->setCellValue($str[$j++].$i,$Score);
                        $PHPExcel->getActiveSheet()->setCellValue($str[$j++].$i,$TotalScore);
                        $PHPExcel->getActiveSheet()->setCellValue($str[$j++].$i,$SubmitTime);
                        $PHPExcel->getActiveSheet()->setCellValue($str[$j++].$i,$Tanswer);
                        $PHPExcel->getActiveSheet()->setCellValue($str[$j++].$i,$Description);
                        $PHPExcel->getActiveSheet()->setCellValue($str[$j++].$i,$stage);
                        $PHPExcel->getActiveSheet()->setCellValue($str[$j++].$i,$knowledgepoint->Description);
                    }
                }
            }

            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition:attachment;filename="'.$term.'_'.$courseId.'_'.$ExamPlanName.'.xls"');
            $objWriter= \PHPExcel_IOFactory::createWriter($PHPExcel,'Excel5');
            $objWriter->save('php://output');
        } else {
            return $this->render('getexcelerror');

        }
    }

}
