<?php
namespace app\modules\phone\controllers;

use \app\controllers\BaseController;
use app\models\question\Knowledgepoint;
use app\models\phone\Tresources;
use app\models\system\TbcuitmoonDictionary;
use common\commonFuc;
use app\models\phone\UploadFile;
use Yii;
use yii\data\Pagination;
use yii\helpers\Url;use yii\web\UploadedFile;

class VideoController extends BaseController{


    /**
     * 渲染视频添加首页
     * @return string
     */
    public $enableCsrfValidation=false;
    public function actionIndex(){
        $m_dic = new TbcuitmoonDictionary();
        $m_know = new Knowledgepoint();
        $m_vid = new Tresources();
        $com = new commonFuc();
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
        $whereL['Type'] = ['1000803'];
        $list = $m_vid->find()->select(['ID', 'Name', 'KnowledgeBh', 'IsPublish','AddAt','AddBy','CustomBh','IsExam'])
            ->where(['and',$whereL,$w])->orderBy("AddAt ASC");
        $pr = $m_vid->find()->select(['ID', 'Name', 'KnowledgeBh', 'IsPublish','AddAt','AddBy','CustomBh','IsExam'])
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
        ]);
    }


    /**
     * 添加视频地址
     * @return json
     */
    public function actionCreate()
    {
        $m_vid = new Tresources();
        $com = new commonFuc();
        if($m_vid->load(Yii::$app->request->post())){
            $m_vid->ID = $com->create_id();
            $m_vid->AddAt = date('Y-m-d H:i:s');
            $m_vid->AddBy = Yii::$app->session->get('UserName');
            $m_vid->CourseID = Yii::$app->session->get('courseCode');
            $m_vid->IsPublish = '0';
            $m_vid->KnowledgeBh =  implode("||",$_POST['KnowledgeBhCode']);
            $m_vid->ResourcesURL = Yii::$app->request->get('up');

            $m_vid->Type = '1000803';
            if($m_vid->validate() && $m_vid->save()){
                $com->JsonSuccess('添加成功');

            }else{
                $com->JsonFail($m_vid->getErrors());
            }
        }else{
            $com->JsonFail('数据出错');
        }
        unset($_SESSION['upVideo']);
    }

    public function actionView()
    {
        $m_vid = new Tresources();

        $id = Yii::$app->request->get('id');
        if ($id) {
            $data = $m_vid->find()->where([
                'ID' => $id,
            ])->asArray()->one();
            return json_encode($data);
        }

    }
    public function actionUpdate()
    {
        $com = new commonFuc();
        $m_vid = new Tresources();
        $id = Yii::$app->request->post('id');
        $update = $m_vid->findOne($id);
        $update->KnowledgeBh =  implode("||",$_POST['KnowledgeBhCode']);
        if ($update->load(Yii::$app->request->post())) {
            if ($update->validate() && $update->save()) {
                $com->JsonSuccess('更新成功');
            } else {
                $com->JsonFail($m_vid->getErrors());
            }
        } else {
            $com->JsonFail('更新失败');
        }
    }

    public function actionAdd(){
        $m_know = new Knowledgepoint();
        $m_dic = new TbcuitmoonDictionary();

        $data = $m_know->find()->all();
        $up = Yii::$app->session->get('upVideo');
        return $this->render('add',[
            //默认显示第一阶段知识点
            'stage' => $m_dic->getDictionaryList('题目阶段'),
            'defaultKnow' => $m_know->getByStage(1000301),
            'data' => $data,
            'up' => $up
        ]);
    }


    //删除
    public function actionDelete()
    {
        $com = new commonFuc();
        $m_vid = new Tresources();

        $ids = Yii::$app->request->get('ids');



        if (count($ids) > 0) {
            foreach ($ids as $item) {
                $up = $m_vid->find()->where(['ID' => $item])->asArray()->one();
                $up = iconv("UTF-8", "gbk",$up['ResourcesURL']);
                if (file_exists($up)) {
                    unlink($up);
                    $up = preg_replace("~\/[^/]*.mp4~",'',$up);
                    rmdir($up);
                }

                $m_vid->deleteAll(['ID' => $item]);
                $com->JsonSuccess('删除成功');

            }
        }
    }


    //搜索视频信息
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
                        ':Type' => '1000803',
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
        $m_vid = new Tresources();
        $com = new commonFuc();
        $id = Yii::$app->request->get();
        $data = $m_vid->find()->where(["ID" => $id])->one();
        if (isset($id)) {
            $data = $m_vid->find()->where(["ID" => $id])->one();
            if ($data->IsPublish == '1') {
                $data->IsPublish = '0';
            } else {
                $data->IsPublish = '1';
            }
            $data->save();
        }
        echo json_encode($data);
    }



}
