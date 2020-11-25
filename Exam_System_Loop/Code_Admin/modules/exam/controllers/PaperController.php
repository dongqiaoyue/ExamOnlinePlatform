<?php
namespace app\modules\exam\controllers;


use app\models\aid\Question;
use app\models\exam\Createpaper;
use app\models\exam\Paper;
use app\models\exam\Paperconfigure;
use app\models\question\Questions;
use common\commonFuc;
use Yii;
use app\models\question\Knowledgepoint;
use app\controllers\BaseController;
use app\models\system\TbcuitmoonDictionary;
use app\models\teachplan\Examplan;
use app\models\teachplan\Teachingclassmannage;
use yii\base\Exception;
use app\models\TbcuitmoonUser;

class PaperController extends BaseController
{

    /**
     * Rending Paper index
     * @return string
     */
    public function actionIndex()
    {
        $m_dic = new TbcuitmoonDictionary();
        $m_paper = new Paper();
        $com = new commonFuc();
        $Data = [];
        $Param = Yii::$app->request->get();
        $Data['term'] = $m_dic->getDictionaryList('学期');
        $Data['now_term'] = $com->getNowTerm();
        $Data['ExamPlan'] = 0;
        $Data['TermChoice'] = 0;
        if (isset($Param['examPlan'])) {
            $Data['TermChoice'] = $Param['term'];
            $Data['ExamPlan'] = $Param['examPlan'];
            $Where[Paper::tableName().'.ExamPlanBh'] = $Param['examPlan'];
            // $Where['CreateUser'] = TbcuitmoonUser::find()->where(['CuitMoon_UserName'=>Yii::$app->session->get('UserName')])->asArray()->one()['CuitMoon_UserID'];
            $List = $m_paper->find()
            ->leftJoin(Examplan::tableName(),
                    Examplan::tableName().'.ExamPlanBh='.
                    Paper::tableName().'.ExamPlanBh')
            ->orderBy("CreateTime DESC")
            ->where($Where);
            $CloneList = clone $List;
            $Pages = $com->Tab($CloneList);

            $Data['pages'] = $Pages;
            $Data['list'] = $List->limit($Pages->limit)->offset($Pages->offset)->all();
        }
        // } else {
        //     $Data['TermChoice'] = 0;
        //     $Data['ExamPlan'] = 0;
        //     $Where['CreateUser'] = TbcuitmoonUser::find()->where(['CuitMoon_UserName'=>Yii::$app->session->get('UserName')])->asArray()->one()['CuitMoon_UserID'];
        //     $List = $m_paper->find()->leftJoin(Examplan::tableName(),
        //             Examplan::tableName().'.ExamPlanBh='.
        //             Paper::tableName().'.ExamPlanBh')
        //     ->orderBy("CreateTime DESC")
        //     ->where($Where);
        // }
        return $this->render('index',$Data);
    }


    /**
     * Get the current term exam plan(ajax)
     * @return json
     */
    public function actionGetTeachPlan()
    {
        $m_teachPlan = new Examplan();

        $Tmp = $m_teachPlan->find()->select(['ExamPlanBh','ExamPlanName'])
            ->where([
                'Term' => Yii::$app->request->get('term'),
                'CourseID' => Yii::$app->session->get('courseCode'),
            ])->asArray()->all();
        echo json_encode($Tmp);
    }


    public function actionCreatePaper()
    {
        $com = new commonFuc();
        $m_exam_plan = new Examplan();

        $Id = Yii::$app->request->post('id');
        $num = Yii::$app->request->post('Number');
        $ExamPlanName = Examplan::find()
        ->where([
            'ExamPlanBh' => $Id
        ])->asArray()->one()['ExamPlanName'];
        for($i=0; $i<$num; $i++){
            self::createPaper($Id, $ExamPlanName);
        }
        $com->JsonSuccess('生成成功');
    }


    public function actionView()
    {
        $m_create_paper = new Createpaper();
        $m_dic = new TbcuitmoonDictionary();

        $id = Yii::$app->request->get('id');
        $course = (string)Yii::$app->session->get('courseCode');
        $courseId = $m_dic->find()->select('CuitMoon_DictionaryName')->where(['CuitMoon_DictionaryCode'=>$course])->asArray()->one();
        if ($id) {
            $QuestionTypes = $m_create_paper->find()
                ->select(['createpaper.QuestionBh', 'createpaper.TotalScore', 'questions.CustomBh', 'createpaper.Memo' ,'questions.name', 'questions.Description'])
                ->join('LEFT JOIN', Questions::tableName(), 'createpaper.QuestionBh = questions.QuestionBh')
                ->where([
                    'createpaper.PaperBh' => $id,
                ])->asArray()->all();

            foreach ($QuestionTypes as $key => $val) {    //数据根据日期分组
                $Tmp[$val['Memo']][] = $val;
            }

            foreach ($Tmp as $key => $value) {
                foreach ($value as $val){
                    $TmpData = $val;
                    $TmpData['Score'] = $val['TotalScore'];
                    $Tmp_Data[] = $TmpData;
                }
                $Data[$key] = $Tmp_Data;
                unset($Tmp_Data);
            }

            return $this->render('paper',[
                'info' => $Data,
                'type' => $courseId,
            ]);
        }
    }


    /**
     * Paper generation
     * @param $ExamPlanBh
     * @return array
     */
    public function createPaper($ExamPlanBh,$ExamPlanName)
    {
        $m_paperConfig = new Paperconfigure();
        $m_question = new Questions();
        $com = new commonFuc();
        //读取试卷配置，题型，数量，每道题的数量，难度，阶段
        $paperConfig = $m_paperConfig->find()->where([
            'ExamPlanBh' => $ExamPlanBh,
        ])->all();

        //配置了模块
        if(count($paperConfig) != 0){
            $paperId = $com->create_id();
            $Data = Array();
            foreach ($paperConfig as $value){

                //找出所有阶段
                $stages = explode('|',$value->stage);
                $or[] = 'or';
                foreach ($stages as $Tmp){
                    $or[] = "Stage=$Tmp";
                }
                //Random access to questions
                $question = $m_question->find()->select(['QuestionBh','KnowledgeBh'])
                    ->where(['and',
                        'Checked = 100001',
                        'Difficulty ='.$value->difficulty.'',
                        'QuestionType ='.$value->QuestionType.'',
                        'CourseID ='.\Yii::$app->session->get('courseCode').'',
                        $or
                ])->orderBy('RAND()')
                // ->limit($value->QuestionTypeNumber)
                ->all();
                //按照知识点来进行筛选，保证出题的知识点的均匀分配
                //已经选择知识点
                $KnowledgeBhs = [];
                //题目数量
                $num = $value->QuestionTypeNumber;
                //已经选择额的题目，防止重复题目出现
                $hasQuestions = [];
                // while($num != 0){
                foreach ($question as $Tmp){
                    //不重复选择题目
                    if(!in_array($Tmp->QuestionBh, $hasQuestions)){
                        if($num <= 0)
                            break;
                        //不重复知识点
                        if(!in_array($Tmp->KnowledgeBh,$KnowledgeBhs)){
                            $Data[] = [$paperId,$Tmp->QuestionBh,$value->EveryQuestionSocre,$value->QuestionType];
                            $KnowledgeBhs[] = $Tmp->KnowledgeBh;
                            $hasQuestions[] = $Tmp->QuestionBh;
                            $num--;
                        }
                    }
                }
                // print_r($KnowledgeBhs);
                // print_r($hasQuestions);
                // echo $num;
                // die;
                foreach ($question as $Tmp){
                    if($num > 0){
                        if(!in_array($Tmp->QuestionBh, $hasQuestions)){
                            $Data[] = [$paperId,$Tmp->QuestionBh,$value->EveryQuestionSocre,$value->QuestionType];
                            $hasQuestions[] = $Tmp->QuestionBh;
                            $num--;
                        }

                    }
                }
                unset($or);
            }
            $db = Yii::$app->db;
            $transaction = $db->beginTransaction();
            try{
                $db->createCommand()
                    ->batchInsert('createpaper',['PaperBh','QuestionBh','TotalScore','Memo'],$Data)
                    ->execute();
                $db->createCommand()
                    ->batchInsert('paper',['PaperBh','CreateTime','PaperName','Memo','ExamPlanBh'],[[
                        $paperId,date('Y-m-d H:i:s'),$ExamPlanName.'-'.rand(10000,99999),'',$ExamPlanBh
                    ]])
                    ->execute();
                $transaction->commit();
                return ['error' => '0'];
            }catch (Exception $e){
                $transaction->rollBack();
                return ['error' =>1 , 'msg' => '添加试卷失败'];
            }
        }else{
            return [
                'error' => '1',
                'mad'  => '此考试计划未配置模板'
            ];
        }
    }

    public function actionCopy(){
        $paper = new Paper();
        $com = new commonFuc();
        $ids = Yii::$app->request->get('ids');
       // $flag=0;
        foreach($ids as $id){
            $data = $paper->find()->where(['PaperBh'=>$id])->asArray()->one();
            $cre_paper = new createpaper();
            $paperid=$com->create_id();
            $dataT[] = [$paperid,date('Y-m-d H:i:s'),$data['PaperName'],$data['Memo'],$data['ExamPlanBh']];
            $db = Yii::$app->db;
            $Cid = $cre_paper->find()->where(['PaperBh'=>$id])->asArray()->all();
            if(isset($Cid)){
                foreach($Cid as $c_paperid){
                        $Cdata = $cre_paper->find()->where(['Id' => $c_paperid['Id']])->asArray()->one();
                        $c_data[] = [$paperid,$Cdata['QuestionBh'],$Cdata['TotalScore'],$Cdata['Memo']];
                }
            }
            //echo json_encode($paperN);
        }

        $db->createCommand()
            ->batchInsert('paper',['PaperBh','CreateTime','PaperName','Memo','ExamplanBh'],$dataT)->execute();
        $db->createCommand()
            ->batchInsert('createpaper',['PaperBh','QuestionBh','TotalScore','Memo'],$c_data)->execute();

        echo json_encode("复制试卷成功");
    }

    /**
     * 删除模板
     * @return json
     */
    public function actionDelete()
    {
        $com = new commonFuc();
        $m_paper = new Paper();

        $ids = Yii::$app->request->get('ids');
        json_encode($ids);
        if (count($ids) > 0) {
            foreach ($ids as $item) {
                Paper::deleteAll(['PaperBh' => $item]);
                createpaper::deleteAll(['PaperBh' => $item]);
                // $Transaction = Yii::$app->db->beginTransaction();
                // try {
                    // $m_paper->deleteAll([
                    //     'PaperBh' => $item
                    //     'ExamPlanBh' => ''
                    // ]);
                    // $m_paper->deleteAll(['PaperBh' => $item]);
                    // $Transaction->commit();

                // } catch (Exception $e) {
                    // $Transaction->rollBack();
                    // $com->JsonFail('删除失败');
                // }
            }
            $com->JsonSuccess('删除成功');
        }
    }
//输出试卷详情

    public function actionOutput(){
        $com = new commonFuc();
        $tb = new TbcuitmoonDictionary();
        $paper = new Paper();
        $question = new Questions();
        $cre_paper = new Createpaper();
        $id = Yii::$app->request->get('id');
        $cre_paperdata = $cre_paper->find()->where(['paperBh'=>$id])->asArray()->all();
        foreach($cre_paperdata as $data1){
            $data[]=$question->find()->where(['QuestionBh'=>$data1['QuestionBh']])->asArray()->one();
        }

        return $this->render('paperdetail',[
            'ids'=>$id,
            'question'=>$data,
            'typeS'=>$tb->getDictionaryList("题目阶段"),
            'typeQ'=>$tb->getDictionaryList("题目类型"),

        ]);
    }
//查看题目详情
    public function actionViewq(){
    $que = new Questions();
    $tb = new TbcuitmoonDictionary();
    $id = Yii::$app->request->get('id');
    $data = $que->find()->where(['QuestionBh'=>$id])->asArray()->one();
    $stage= $tb->find()->select(['CuitMoon_DictionaryName'])->where(['CuitMoon_DictionaryCode'=>$data['Stage']])->asArray()->one();
    $data['Stage']=$stage['CuitMoon_DictionaryName'];
    $type = $tb->find()->select("CuitMoon_DictionaryName")->where(["CuitMoon_DictionaryCode"=>$data['QuestionType']])->asArray()->one();
    $data['QuestionType']=$type['CuitMoon_DictionaryName'];
    echo json_encode($data);
    }

    //删除该题
    public function actionDeleteq(){
        $cre_paper = new Createpaper();
        $ids = Yii::$app->request->get('ids');
        foreach($ids as $id){
            $data = $cre_paper->find()->where(['QuestionBh'=>$id])->asArray()->one();
            if(isset($data)){
                $cre_paper->deleteAll(["QuestionBh"=>$data['QuestionBh']]);
            }else{
                echo json_encode("不存在该题");
            }
        }
    }

    //显示添加题目
    public function actionAddquestion(){
        $paper_c = new Paperconfigure();
        $tb = new TbcuitmoonDictionary();
        $paper = new Paper();
        $que = new Questions();
        $paperid = Yii::$app->request->get('id');
        $examid = $paper->find()->where(['PaperBh'=>$paperid])->asArray()->one();
        $paper_c_id = $paper_c->find()->where(['ExamPlanBh'=>$examid['ExamPlanBh']])->asArray()->one();
        $str = explode('|',$paper_c_id['stage']);
        $dataO = $que->find()->where(['Stage'=>$str])->asArray()->all();
        foreach($dataO as $data) {
            $stage= $tb->find()->select(['CuitMoon_DictionaryName'])->where(['CuitMoon_DictionaryCode'=>$data['Stage']])->asArray()->one();
            $data['Stage']=$stage['CuitMoon_DictionaryName'];
            $diff= $tb->find()->select(['CuitMoon_DictionaryName'])->where(['CuitMoon_DictionaryCode'=>$data['Difficulty']])->asArray()->one();
            $data['Difficulty']=$diff['CuitMoon_DictionaryName'];
            $type= $tb->find()->select(['CuitMoon_DictionaryName'])->where(['CuitMoon_DictionaryCode'=>$data['QuestionType']])->asArray()->one();
            $data['QuestionType']=$type['CuitMoon_DictionaryName'];
            $dataT[]=$data;
        }
        return $this->render('question',[
            'question'=>$dataT,
            'idr'=>$paperid,
        ]);
    }
    //添加到试卷
    public function actionAddq()
    {
        $que = new Questions();
        $paper = new Paper();
        $pap_c = new Paperconfigure();
        $paperid = Yii::$app->request->get("paperid");
        $ids = Yii::$app->request->get("ids");
        if (isset($ids)) {
            foreach ($ids as $id) {
                $p_exam = $paper->find()->where(['PaperBh' => $paperid])->asArray()->one();
                $pc_exam = $pap_c->find()->where(['ExamPlanBh' => $p_exam['ExamPlanBh']])->asArray()->one();
                if (isset($pc_exam)) {
                    $data = $que->find()->where(['QuestionBh' => $id])->asArray()->one();
                    $allData[] = [$paperid, $data['QuestionBh'], $pc_exam['EveryQuestionSocre'], $data['QuestionType']];
                }
                $db = Yii::$app->db;
                $db->createCommand()->batchInsert('createpaper', ['PaperBh', 'QuestionBh', 'TotalScore', 'Memo'], $allData)->execute();
            }
            echo json_encode($allData);
        }
    }

    public function actionGetCanChoiceQuestion()
    {
        $post = \Yii::$app->request->post();
        if(isset($post['id'])){
            $config = Paperconfigure::find()->where(['ExamPlanBh'=>$post['id']])->orderBy("QuestionType")->asArray()->all();
            if($config)
            {
                foreach ($config as $key => $value) {
                    $config[$key]['difficultyName'] = TbcuitmoonDictionary::find()
                    ->where(['CuitMoon_DictionaryCode'=>$value['difficulty']])
                    ->asArray()->one()['CuitMoon_DictionaryName'];

                    $config[$key]['QuestionTypeName'] = TbcuitmoonDictionary::find()
                    ->where(['CuitMoon_DictionaryCode'=>$value['QuestionType']])
                    ->asArray()->one()['CuitMoon_DictionaryName'];

                    $stage = explode('|',$value['stage']);
                    foreach ($stage as $key1 => $value1) {
                        $name = TbcuitmoonDictionary::find()->where(['CuitMoon_DictionaryCode'=>$value1])->asArray()->one()['CuitMoon_DictionaryName'];
                        $config[$key]['choice'][$name] = Questions::find()
                        ->leftJoin(Knowledgepoint::tableName(),Knowledgepoint::tableName().".KnowledgeBh=".Questions::tableName().'.KnowledgeBh')
                        ->select("QuestionBh,CustomBh,name,KnowledgeName")
                        ->where(['Checked'=>'100001',
                        'QuestionType'=>$value['QuestionType'],
                        Questions::tableName().'.Stage'=>$value1,
                        'Difficulty'=>$value['difficulty'],
                        Questions::tableName().'.CourseID'=>\Yii::$app->session->get('courseCode')])
                        ->asArray()
                        ->all();
                    }
                    // $config[$key]['question'] =
                }
                echo json_encode(['code'=>200,'data'=>$config]);
            }else {
                echo json_encode(['code'=>404,'msg'=>'请先配置模板']);
            }

        }else {
            echo json_encode(['code'=>404,'msg'=>'参数错误']);
        }
    }

    public function actionSaveQuestion()
    {
        $post = \Yii::$app->request->post();
        $com = new commonFuc();
        // print_r($post);
        // echo json_encode($post);
        // die;
        if(isset($post['examPlan']) && isset($post['id']) && isset($post['paperNum']))
        {
            $exam = Examplan::find()->where(['ExamPlanBh'=>$post['examPlan']])->asArray()->one();
            //here
            $num = $post['paperNum'] > 0 ? $post['paperNum'] : 1;
            while($num--)
            {
                $paper = new Paper();
                $paper['PaperBh'] = $com->create_id();
                $paper['CreateTime'] = date('Y-m-d H:i:s');
                $paper['PaperName'] = $exam['ExamPlanName'].'-'.rand(10000,99999);
                $paper['ExamPlanBh'] = $post['examPlan'];
                if($paper->save())
                {
                    foreach ($post['id'] as $key => $value) {
                        //所有配置
                        $config = Paperconfigure::find()->where(['PaperConfigureID'=>$value['id']])->asArray()->one();
                        $quesNum = (int)($config['QuestionTypeNumber']);
                        $tmp = [];
                        //生成老师指定了的题目
                        if(isset($value['question']))
                        {
                            $tmp = $value['question'];
                            foreach ($value['question'] as $key1 => $value1) {
                                $qus = Questions::find()->where(['QuestionBh'=>$value1])->asArray()->one();
                                $create = new Createpaper();
                                $create['PaperBh'] = $paper['PaperBh'];
                                $create['QuestionBh'] = $value1;
                                $score = $config['EveryQuestionSocre'];
                                // Paperconfigure::find()->where(['QuestionType'=>$qus['QuestionType'], 'difficulty'=>$qus['Difficulty'], 'ExamPlanBh'=>$post['examPlan']])->asArray()->one()['EveryQuestionSocre'];
                                $create['TotalScore'] = $score;
                                $create['Memo'] = $qus['QuestionType'];
                                if($create->save())
                                {
                                    $quesNum--;
                                }
                            }
                        }
                        // print_r($tmp);
                        // // echo $quesNum;
                        // die;
                        //剩下没指定的题目随机生成
                        if($quesNum > 0){
                            $other = Questions::find()
                            ->select("QuestionBh,QuestionType")
                            ->where([
                                'Checked'=>'100001',
                                'QuestionType'=>$config['QuestionType'],
                                'Difficulty'=>$config['difficulty'],
                                'CourseID'=>\Yii::$app->session->get('courseCode'),
                                'Stage'=>explode('|',$config['stage']),
                            ])
                            ->andWhere(['not in', 'Stage', $tmp])
                            ->orderBy('RAND()')
                            ->limit($quesNum)
                            ->asArray()
                            ->all();
                            // var_dump($other);
                            // die;
                            foreach ($other as $key3 => $value3) {
                                $create = new Createpaper();
                                $create['PaperBh'] = $paper['PaperBh'];
                                $create['QuestionBh'] = $value3['QuestionBh'];
                                $create['TotalScore'] = $config['EveryQuestionSocre'];
                                $create['Memo'] = $value3['QuestionType'];
                                $create->save();
                            }
                        }

                    }
                }
            }
            echo json_encode(['status'=>200,'msg'=>"添加成功"]);
            // else {
            //     echo json_encode(['status'=>404,'msg'=>$paper->getErrors()]);
            // }
        }
    }

}
