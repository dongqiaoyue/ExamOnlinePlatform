<?php
namespace app\modules\question\controllers;
use app\modules\question\controllers\QuestionbaseController;
use app\models\question\Knowledgepoint;
use app\models\question\Questions;
use app\models\system\TbcuitmoonDictionary;
use common\commonFuc;
use Yii;

class KnowledgeController extends QuestionbaseController{


    /**
     * 渲染知识点主页
     * @return string
     */
    public function actionIndex(){
        $m_dic = new TbcuitmoonDictionary();
        $m_know = new Knowledgepoint();
        $com = new commonFuc();
        $session = Yii::$app->session;
        $session->open();

        $info = $m_know->find()->where([
            'CourseID' => $session->get('courseCode'),
        ]);
        $countInfo = clone $info;
        $pages = $com->Tab($countInfo);
        return $this->render('index',[
            'stage' => $m_dic->getDictionaryList('题目阶段'),
            'chapter' => $m_dic->getDictionaryList('章节'),
            'list' => $info->offset($pages->offset)->limit($pages->limit)->orderBy(['Stage' => SORT_ASC])->all(),
            'pages' => $pages,
        ]);
    }
    // public function actionAdd(){
    //     $m_know = new Knowledgepoint();
    //     $m_dic = new TbcuitmoonDictionary();

    //     return $this->render('add',[
    //         //默认显示第一阶段知识点
    //         'defaultKnow' => $m_know->getByStage(1000301),
    //         'stage' => $m_dic->getDictionaryList('题目阶段'),
    //         'diff' => $m_dic->getDictionaryList('题目难度')
    //     ]);
    // }


    /**
     * 添加知识点
     * @return json
     */
    public function actionCreate(){
        $m_know = new Knowledgepoint();
        $com = new commonFuc();
        $session = Yii::$app->session;
        $session->open();

        if($m_know->load(Yii::$app->request->post())){
            $m_know->KnowledgeBh = $com->create_id();
            $m_know->CourseID = $session->get('courseCode');
            if($m_know->validate() && $m_know->save()){
                $com->JsonSuccess('添加成功');
            }else{
                $com->JsonFail($m_know->getErrors());
            }
        }else{
            $com->JsonFail('数据错误');
        }
    }

    //删除知识点

    public function actionDelete(){
        $m_know = new Knowledgepoint();
        $m_ques = new Questions();

        $ids = Yii::$app->request->get('ids');
        if(count($ids)>0){
            foreach($ids as $id) {
                $dataQ = $m_ques->find()->where(['knowledgeBh' => $id])->one();
                if(isset($dataQ)){
                    continue;
                }
                $m_know->deleteAll(['knowledgeBh'=>$id]);
            }

        }

        echo json_encode($ids);
    }

    /**
     * 返回某阶段知识点
     * @return json
     */
    public function actionKnowledgeList(){
        $m_know = new Knowledgepoint();

        $stageCode = Yii::$app->request->get('stageId');
        echo json_encode($m_know->getByStage($stageCode));
    }

    //根据id获取知识点信息
    public function actionGetKnowledgeById()
    {
        $post = Yii::$app->request->post();
        if(isset($post['id']) && $post['id'])
        {
            $res = Knowledgepoint::find()->where(['KnowledgeBh'=>$post['id']])->asArray()->one();
            echo json_encode($res);
        }
    }
    public function actionUpdateKnowledge()
    {
        $post = Yii::$app->request->post();
        if(isset($post['Knowledgepoint']['KnowledgeBh']))
        {
            $aim = Knowledgepoint::find()
            ->where(['KnowledgeBh'=>$post['Knowledgepoint']['KnowledgeBh']])->one();
            if($aim && $aim->load($post) && $aim->save())
            {
                $stage = $aim->Stage;
                Questions::updateAll(['Stage'=>$stage],['KnowledgeBh'=>$aim->KnowledgeBh]);
                echo json_encode("修改成功");
            }else
            {
                echo json_encode("修改失败");
            }
            return $this->redirect(['index']);
        }
    }
}
