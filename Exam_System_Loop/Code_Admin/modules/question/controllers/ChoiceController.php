<?php
namespace app\modules\question\controllers;

use app\modules\question\controllers\QuestionbaseController;
use app\models\question\Knowledgepoint;
use app\models\question\Questions;
use app\models\system\TbcuitmoonDictionary;
use common\commonFuc;
use Yii;
use yii\data\Pagination;

class ChoiceController extends QuestionbaseController{


    /**
     * 渲染选择题首页
     * @return string
     */
    public function actionIndex(){
        $m_dic = new TbcuitmoonDictionary();
        $m_know = new Knowledgepoint();
        $m_ques = new Questions();
        $com = new commonFuc();

        //是否选择阶段
        $stage  = Yii::$app->request->get();
        $whereKnow = [];
        $where = [];
        if(isset($stage['stage'])){
            $where = [
                'Stage' => $stage['stage'],
            ];
            $whereKnow['Stage'] = $stage['stage'];
        }
        //是否选择知识点
        if(isset($stage['knowledgeBh'])){
            $where['KnowledgeBh'] = $stage['knowledgeBh'];
        }

        $where['CourseID'] = Yii::$app->session->get('courseCode');
        $whereKnow['CourseID'] = Yii::$app->session->get('courseCode');
        $where['QuestionType'] = ['100020101','100020102'];
        $knowledgepoint = knowledgepoint::find()->where($whereKnow)->asArray()->all();
        $list = $m_ques->find()->select(['QuestionBh','name','KnowledgeBh','CustomBh','Stage','Checked','Score','AddTime','UpdateTime'])
            ->where($where)->orderBy("AddTime ASC, UpdateTime DESC");

        //Tab
        $countList = clone $list;
        $pages = $com->Tab($countList);

        return $this->render('index',[
            'list' => $list->offset($pages->offset)->limit($pages->limit)->orderBy(['Stage' => SORT_ASC])->all(),
            'pages' => $pages,
            'stageChoice' => $stage,
            'stage' => $m_dic->getDictionaryList('题目阶段'),
            'dif' => $m_dic->getDictionaryList('题目难度'),
            //默认显示第一阶段知识点
            'defaultKnow' => $m_know->find()->all(),
            'knowledgepoint'=>$knowledgepoint,



               ]);
    }



    public function actionAdd(){
        $m_know = new Knowledgepoint();
        $m_dic = new TbcuitmoonDictionary();

        return $this->render('add',[
            //默认显示第一阶段知识点
            'defaultKnow' => $m_know->getByStage(1000301),
            'stage' => $m_dic->getDictionaryList('题目阶段'),
            'diff' => $m_dic->getDictionaryList('题目难度')
        ]);
    }


    /**
     * 添加选择题
     * @return json
     */
    public function actionCreate(){
        $m_ques = new Questions();
        $com = new commonFuc();

        if($m_ques->load(Yii::$app->request->post())){
            $m_ques->QuestionBh = $com->create_id();
            $m_ques->AddTime = date('Y-m-d H:i:s');
            $m_ques->UpdateTime = date('Y-m-d H:i:s');

            $m_ques->CourseID = Yii::$app->session->get('courseCode');
            // $answer = Yii::$app->request->post('Answer');

            //判断多选题 还是单选题
            // if(count($answer) == 1){
                $m_ques->QuestionType = '100020101';
            // }else{
                // $m_ques->QuestionType = '100020102';

            // }
            if($m_ques->validate() && $m_ques->save()){
                $com->JsonSuccess('添加成功');
            }else{
                $com->JsonFail($m_ques->getErrors());
            }
        }else{
            $com->JsonFail('数据出错');
        }
    }

    public function actionView()
    {
        $m_ques = new Questions();

        $id = Yii::$app->request->get('id');
        if ($id) {
            $ques = $m_ques->find()->where([
                'QuestionBh' => $id,
            ])->asArray()->one();
            return json_encode($ques);
        }

    }
    public function actionUpdate()
    {
        $com = new commonFuc();
        $m_ques = new Questions();
        $id = Yii::$app->request->post('id');
        $update = $m_ques->findOne($id);
        if ($update->load(Yii::$app->request->post())) {
            $update->UpdateTime = date('Y-m-d H:i:s');

            if ($update->validate() && $update->save()) {
                $com->JsonSuccess('更新成功');
            } else {
                $com->JsonFail($m_ques->getErrors());
            }
        } else {
            $com->JsonFail('更新失败');
        }
    }

    //删除
    public function actionDelete()
    {
        $com = new commonFuc();
        $m_ques = new Questions();

        $ids = Yii::$app->request->get('ids');
        if (count($ids) > 0) {
            foreach ($ids as $item) {

                $m_ques->deleteAll(['QuestionBh' => $item]);

                $com->JsonSuccess('删除成功');

            }
        }
    }


    //搜索选择题信息
    public function actionSearchChoice()
    {
        if(\Yii::$app->request->isPost)
        {
            $post = \Yii::$app->request->post();
            if(isset($post['key']))
            {
                $aim = Questions::find()
                ->where("(QuestionType=:QuestionType  or QuestionType=:QuestionType1) and CourseID=:CourseID and CustomBh like :CustomBh or (QuestionType=:QuestionType or QuestionType=:QuestionType1) and CourseID=:CourseID  and name like :name ", [
                    ':QuestionType' => '100020101',
                    ':QuestionType1' => '100020102',
                    ':CourseID' => \Yii::$app->session->get('courseCode'),
                    ':CustomBh' => '%'.$post['key'].'%',
                    ':name' => '%'.$post['key'].'%'
                ])
                ->limit(10)
                ->asArray()->all();
                foreach ($aim as $key => $value) {
                    $aim[$key]['DifficultyCode'] = $aim[$key]['Difficulty'];
                    $aim[$key]['Difficulty'] = TbcuitmoonDictionary::find()->where(['CuitMoon_DictionaryCode'=>$aim[$key]['Difficulty']])->asArray()->one()['CuitMoon_DictionaryName'];
                    $aim[$key]['StageCode'] = $aim[$key]['Stage'];
                    $aim[$key]['SourceCode'] = json_decode($aim[$key]['SourceCode'],true)['key']['0']['code'];
                    $aim[$key]['Stage'] = TbcuitmoonDictionary::find()->where(['CuitMoon_DictionaryCode'=>$aim[$key]['Stage']])->asArray()->one()['CuitMoon_DictionaryName'];
                    $aim[$key]['KnowledgeBhCode'] = $aim[$key]['KnowledgeBh'];
                    $aim[$key]['KnowledgeBh'] = (new Knowledgepoint())->idTranName($aim[$key]['KnowledgeBh']);

                }


                echo json_encode($aim);
            }
        }
    }



}
