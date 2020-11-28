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
        $whereC = [];
        $whereL = [];
        $whereK = [];
        $w =[];

        //是否选择知识点
        $stage = Yii::$app->request->get();

        if (isset($stage['knowledgeBh'])) {
            $w = [
                'like',
                'knowledgeBh',$stage['knowledgeBh'],
            ];
        }
        if (isset($stage['stage'])) {
            $whereK['Stage'] = $stage['stage'];
        }

        $whereC['CourseID'] = Yii::$app->session->get('courseCode');


        $whereL['CourseID'] = Yii::$app->session->get('courseCode');
        $whereL['Type'] = ['1000802'];
        $list = $m_ppt->find()->select(['ID', 'Name', 'KnowledgeBh', 'IsPublish','AddAt','AddBy','CustomBh','IsExam'])
            ->where(['and',$whereL,$w])->orderBy("AddAt ASC");
        $pr = $m_ppt->find()->select(['ID', 'Name', 'KnowledgeBh', 'IsPublish','AddAt','AddBy','CustomBh','IsExam'])
            ->where(['and',$whereC,'IsPublish = 1'])->orderBy("AddAt ASC")->all();
        $knowledgepoint = knowledgepoint::find()->where($whereK)->asArray()->all();
        $knowledge = knowledgepoint::find()->asArray()->all();


        //Tab
        $countList = clone $list;
        $pages = $com->Tab($countList);

        return $this->render('index', [
            'list' => $list->offset($pages->offset)->limit($pages->limit)->all(),
            'pages' => $pages,
            'Choice' => $stage,
            'stage' => $m_dic->getDictionaryList('题目阶段'),
            //默认显示第一阶段知识点
            'defaultKnow' => $m_know->getByStage('1000301'),
            'knowledgepoint'=>$knowledgepoint,
            'knowledge'=>$knowledge,
            'pr' => $pr,//前置资源好像是
            'm' => $m
        ]);
    }

    public function actionCreate()
    {
        $m_ppt = new Tresources();
        $com = new commonFuc();
        $m = new UploadFile();
        if ($m_ppt->load(Yii::$app->request->post())) {
            $m_ppt->ID= $com->create_id();
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
        $id = Yii::$app->request->post('id');
        $update = $m_ppt->findOne($id);
        $update->KnowledgeBh =  implode("||",$_POST['KnowledgeBhCode']);
        if ($update->load(Yii::$app->request->post())) {
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
                'KnowledgeName','KnowledgeBh'
            ])->where(['Stage' => $stage])->asArray()->all();
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