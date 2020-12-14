<?php

namespace app\modules\phone\controllers;

use app\controllers\BaseController;
use app\models\phone\Tresourceexaminfo;
use app\models\phone\Tresources;
use app\models\phone\UploadFile;
use app\models\question\Knowledgepoint;
use app\models\system\TbcuitmoonDictionary;
use common\commonFuc;
use Yii;
use yii\bootstrap\Alert;
use yii\web\UploadedFile;

class PptController extends BaseController
{
    public $enableCsrfValidation=false;
    public function actionIndex()
    {
        $m_dic = new TbcuitmoonDictionary();
        $m_know = new Knowledgepoint();
        $m_ppt = new Tresources();
        $com = new commonFuc();
        $m = new UploadFile();

        $CourseID = Yii::$app->session->get('courseCode');
        $Info = Yii::$app->request->get();

        $pr = $m_ppt->find()->select(['ID', 'Name', 'KnowledgeBh', 'IsPublish','AddAt','AddBy','CustomBh','IsExam'])
            ->where(['and',['CourseID' => $CourseID],'IsPublish = 1'])->orderBy("AddAt ASC")->all();

        $mod = Tresourceexaminfo::find()->select(['BH','PaperName'])->where(['CourseID'=>$CourseID])->groupBy(['BH'])->orderBy('BH DESC')->all();

        $list = $m_ppt->find()
            ->where(['Type' => 1000802]);

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

        $list = $list->orderBy("Type ASC");


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
            'pr' => $pr,//前置资源
            'mod' => $mod,
            'm' => $m
        ]);
    }

    public function actionCreate()
    {
        $m_ppt = new Tresources();
        $m_mod = new Tresourceexaminfo();
        $com = new commonFuc();
        $m = new UploadFile();
        if ($m_ppt->load(Yii::$app->request->post())) {
            $m_ppt->ID= $com->create_id();
            $PaperName = Tresourceexaminfo::find()->select(['PaperName'])->where(['BH'=>$_POST['BH']])->one();
            $m_mod->AddBy = Yii::$app->session->get('UserName');
            $m_mod->AddAt = date('Y-m-d H:i:s');
            $m_mod->CourseID = Yii::$app->session->get('courseCode');
            $m_mod->BH = $_POST['BH'];
            $m_mod->PaperName = $PaperName['PaperName'];
            $m_mod->ResourcesID = $m_doc->ID;
            $m_mod->save();
            $m_ppt->CourseID = Yii::$app->session->get('courseCode');
            $m_ppt->Type = '1000802';
            $m_ppt->IsPublish = '0';
            $m_ppt->KnowledgeBh =  implode("||",$_POST['KnowledgeBhCode']);
            $m_ppt->AddAt = date('Y-m-d H:i:s');
            $m_ppt->AddBy = Yii::$app->session->get('UserName');
            $m= UploadedFile::getInstance($m, 'file');
            $name= 'file'.time().'_'.rand(1,999).'.'.$m->extension;
            $m->saveAs('uploads/ppt/'.$name);
            $path = 'uploads/ppt/'.$name;
            $m_ppt->ResourcesURL=$path;
            if ($m_ppt->validate() && $m_ppt->save()) {
                $com->JsonSuccess('添加成功');
            } else {
                $com->JsonFail($m_ppt->getErrors());
            }
        } else {
            /*$com->JsonFail('数据出错');*/
        }

//        echo json_encode($m_ppt->load(Yii::$app->request->post()));

    }


    public function actionDelete()
    {
        $com = new commonFuc();
        $m_ppt = new Tresources();

        $ids = Yii::$app->request->get('ids');


        if (count($ids) > 0) {
            foreach ($ids as $item) {
                $path=$m_ppt->find()->select(['ResourcesURL','ID'])->where(['ID'=>$item])->one();
                $t = $path['ResourcesURL'];
                if(is_file($t)){
                    unlink($t);
                    $m_ppt->deleteAll(['ID' => $item]);
                }
            }
            $com->JsonSuccess('删除成功');

        }
    }


    public function actionView()
    {
        $m_ppt = new Tresources();

        $id = Yii::$app->request->get('id');
        if (isset($id)) {
            $data = $m_ppt->find()->where(['ID' => $id])->asArray()->one();
        }

        echo json_encode($data);
    }


    public function actionUpdate()
    {
        $com = new commonFuc();
        $m_ppt = new Tresources();
        $m_mod = new Tresourceexaminfo();
        $post = Yii::$app->request->post();
        $id = $post['id'];
        if ($m_mod->find()->where(['ResourcesID'=>$id])->exists())
        {
            $m_mod = Tresourceexaminfo::findOne($id);
        }
        $update = $m_ppt->findOne($id);
        $update->KnowledgeBh =  implode("||",$_POST['KnowledgeBhCode']);
        if ($update->load($post)) {
            if (isset($post['BH']))
            {
                $PaperName = Tresourceexaminfo::find()->select(['PaperName'])->where(['BH'=>$post['BH']])->one();
                $m_mod->AddBy = Yii::$app->session->get('UserName');
                $m_mod->AddAt = date('Y-m-d H:i:s');
                $m_mod->CourseID = Yii::$app->session->get('courseCode');
                $m_mod->BH = $post['BH'];
                $m_mod->PaperName = $PaperName['PaperName'];
                $m_mod->ResourcesID = $id;
                $m_mod->save();
            }
            if ($update->validate() && $update->save()) {
                $com->JsonSuccess('更新成功');
            } else {
                $com->JsonFail($m_ppt->getErrors());
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
        $m_ppt = new Tresources();
        $com = new commonFuc();
        $id = Yii::$app->request->get();
        $data = $m_ppt->find()->where(["ID" => $id])->one();
        if (isset($id)) {
            $data = $m_ppt->find()->where(["ID" => $id])->one();
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
                        ':Type' => '1000802',
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