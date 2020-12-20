<?php

namespace app\modules\phone\controllers;

use app\controllers\BaseController;
use app\models\phone\Tresourceexaminfo;
use app\models\phone\Tresourceexaminfoset;
use app\models\phone\Tresources;
use app\models\question\Knowledgepoint;
use app\models\system\TbcuitmoonDictionary;
use common\commonFuc;
use Yii;
use yii\bootstrap\Alert;

class DocumentController extends BaseController
{
    public $enableCsrfValidation=false;
    public function actionIndex()
    {
        $m_dic = new TbcuitmoonDictionary();
        $m_know = new Knowledgepoint();
        $m_doc = new Tresources();
        $com = new commonFuc();


        $CourseID = Yii::$app->session->get('courseCode');
        $Info = Yii::$app->request->get();

        $pr = $m_doc->find()->select(['ID', 'Name', 'KnowledgeBh', 'IsPublish','AddAt','AddBy','CustomBh','IsExam'])
            ->where(['and',['CourseID' => $CourseID],'IsPublish = 1'])->orderBy("AddAt ASC")->all();

        $mod = Tresourceexaminfo::find()->select(['BH','PaperName'])->where(['CourseID'=>$CourseID])->groupBy(['BH'])->orderBy('BH DESC')->all();

        $list = $m_doc->find()
            ->where(['Type' => 1000801]);


        if (isset($Info['term'])) {
            $list = $list->andWhere([
                'like',
                'Term',
                $Info['term']]);
        }
        if (isset($Info['stage'])) {
            $knowledgepoint = $m_know->find()
                ->where(['Stage' => $Info['stage'], 'CourseID' => $CourseID])
                ->all();
        }else{
            $knowledgepoint = $m_know->find()
                ->where(['CourseID' => $CourseID])
                ->all();
        }
        if (isset($Info['knowledgeBh'])) {
            $list = $list->andWhere([
                'like',
                'knowledgeBh',$Info['knowledgeBh']
            ]);
        }

        $list = $list->orderBy("AddAt DESC");


        //Tab
        $countList = clone $list;
        $pages = $com->Tab($countList);

        return $this->render('index', [
            'list' => $list->offset($pages->offset)->limit($pages->limit)->all(),
            'pages' => $pages,
            //默认显示第一阶段知识点
            'defaultKnow' => $m_know->getByStage('1000301'),
            'term' => $m_dic->getDictionaryList('学期'),
            'stage' => $m_dic->getDictionaryList('题目阶段'),
            'knowledgepoint' => $knowledgepoint,
            'pr' => $pr, //前置资源
            'mod'=>$mod,
        ]);
    }

    public function actionCreate()
    {
        $m_doc = new Tresources();
        $m_mod = new Tresourceexaminfo();
        $com = new commonFuc();
        $post = Yii::$app->request->post();
        
        if ($m_doc->load($post)) {
            $m_doc->ID= $com->create_id();
            if (isset($post['BH']))
            {
                $PaperName = Tresourceexaminfo::find()->select(['PaperName'])->where(['BH'=>$post['BH']])->one();
                $m_mod->AddBy = Yii::$app->session->get('UserName');
                $m_mod->AddAt = date('Y-m-d H:i:s');
                $m_mod->CourseID = Yii::$app->session->get('courseCode');
                $m_mod->BH = $post['BH'];
                $m_mod->PaperName = $PaperName['PaperName'];
                $m_mod->ResourcesID = $m_doc->ID;
                $m_mod->save();
            }
            $m_doc->CourseID = Yii::$app->session->get('courseCode');
            $m_doc->Type = '1000801';
            $m_doc->IsPublish = '0';
            $m_doc->KnowledgeBh =  implode("||",$post['KnowledgeBhCode']);
            $m_doc->AddAt = date('Y-m-d H:i:s');
            $m_doc->AddBy = Yii::$app->session->get('UserName');

            if ($m_doc->validate() && $m_doc->save()) {
                $com->JsonSuccess('添加成功');
            } else {
                $com->JsonFail($m_doc->getErrors());
            }
        } else {
            /*$com->JsonFail('数据出错');*/
        }

    }


    public function actionDelete()
    {
        $com = new commonFuc();
        $m_doc = new Tresources();

        $ids = \Yii::$app->request->get('ids');
        if (count($ids) > 0) {
            foreach ($ids as $item) {
                $m_doc->deleteAll(['ID' => $item]);
            }
            $com->JsonSuccess('删除成功');

        }
    }

    public function actionAddModel(){
        $m = new Tresourceexaminfo;
        $com = new commonFuc;
         if($data = Yii::$app->request->post()){
         $BH = $data['BH'];
         $ResourcesID = $data['id'];
         Tresourceexaminfo::deleteAll($ResourcesID);
         $model = $m->find()->where([
            'BH' =>$BH,
            'ResourcesID' => "",
        ])->asArray()->all();
        foreach ($model as $value){
            $m = new Tresourceexaminfo;
            $m->BH = $BH ;
            $m->PaperName = $value['PaperName'];
            $m->ResourcesID = $ResourcesID ;
            $m->AddAt = date('Y-m-d H:i:s');
            $m->AddBy = Yii::$app->session->get('Username');
            $m->CourseID = Yii::$app->session->get('courseCode');
            $m->save();
        }
        $com->JsonSuccess('成功配置');
     }
    }


    public function actionView()
    {
        $m_doc = new Tresources();

        $id = Yii::$app->request->get('id');
        if (isset($id)) {
            $data = $m_doc->find()->where(['ID' => $id])->asArray()->one();
        }

        echo json_encode($data);
    }


    public function actionUpdate()
    {
        $com = new commonFuc();
        $m_doc = new Tresources();
        $m_mod = new Tresourceexaminfo();
        $post = Yii::$app->request->post();
        $id = $post['id'];
        if ($m_mod->find()->where(['ResourcesID'=>$id])->exists())
        {
            $m_mod = Tresourceexaminfo::findOne($id);
        }
        $update = $m_doc->findOne($id);
        $update->KnowledgeBh =  implode("||",$_POST['KnowledgeBhCode']);
        if ($update->load(Yii::$app->request->post())) {
            if (isset($post['BH']))
            {
                $PaperName = Tresourceexaminfo::find()->select(['PaperName'])->where(['BH'=>$_POST['BH']])->one();
                $m_mod->AddBy = Yii::$app->session->get('UserName');
                $m_mod->AddAt = date('Y-m-d H:i:s');
                $m_mod->CourseID = Yii::$app->session->get('courseCode');
                $m_mod->BH = $_POST['BH'];
                $m_mod->PaperName = $PaperName['PaperName'];
                $m_mod->ResourcesID = $id;
                $m_mod->save();
            }

            if ($update->validate() && $update->save()) {
                $com->JsonSuccess('更新成功');
            } else {
                $com->JsonFail($m_doc->getErrors());
            }
        }
    }

    public function actionModel()
    {
        $m_exa =new Tresourceexaminfo();
        $id = Yii::$app->request->get('id');

        $data = $m_exa->find()->where(['ResourcesID' => $id])->asArray()->all();
        if ($data == null)
            echo json_encode(1);
        else
            echo json_encode(0);
    }

    public function actionStage()
    {

        $m_kon = new Knowledgepoint();
        $aa = [];
        $bb = [];

        $knowledge = Yii::$app->request->get('knowledge');
        $bhs = explode("||",$knowledge);
        foreach ($bhs as $key => $value){
            $aa[] = $value;
        };
        $data = $m_kon->find()->select('Stage')->where(['in','KnowledgeBh',$aa])->groupBy('Stage')->asArray()->all();
        foreach ($data as $key => $value){
            $cc =$value['Stage'];
            $bb["$cc"] = (new commonFuc())->codeTranName($value);
        }

        echo json_encode($bb);

    }

    public function actionKnowledge()
    {
        $aa = [];

        $knowledge = Yii::$app->request->get('knowledge');
        $bhs = explode("||",$knowledge);
        foreach ($bhs as $key => $value){
              $aa[] = $value;
        };

        echo json_encode($aa);

    }

    public function actionKnowledgeList(){
        $m_know = new Knowledgepoint();
        $stage = Yii::$app->request->get('stageId');
        $data = $m_know->find()
            ->select([
                'KnowledgeName','KnowledgeBh','CourseID'
            ])->where(['Stage' => $stage,'CourseID'=>Yii::$app->session->get('courseCode')])->asArray()->all();
        echo json_encode($data);
    }

    public function actionPublish()
    {
        $m_doc = new Tresources();
        $com = new commonFuc();
        $id = Yii::$app->request->get();
        $data = $m_doc->find()->where(["ID" => $id])->one();
        if (isset($id)) {
            $data = $m_doc->find()->where(["ID" => $id])->one();
            if ($data->IsPublish == '1') {
                $data->IsPublish = '0';
            } else {
                $data->IsPublish = '1';
            }
            $data->save();
        }
        echo json_encode($data);
    }



    public function actionSearchProgram()
    {
        if(\Yii::$app->request->isPost)
        {
            $post = \Yii::$app->request->post();
            if(isset($post['key']))
            {
                $aim = Tresources::find()
                    // and CourseID=:CourseID
                    ->where("Type=:Type and CourseID=:CourseID and CustomBh like :CustomBh or Type=:Type and CourseID=:CourseID  and Name like :Name ", [
                        ':Type' => '1000801',
                        ':CourseID' => \Yii::$app->session->get('courseCode'),
                        ':CustomBh' => '%'.$post['key'].'%',
                        ':Name' => '%'.$post['key'].'%'
                    ])
                    ->limit(10)
                    ->asArray()->all();

                echo json_encode($aim);
            }
        }
    }

}