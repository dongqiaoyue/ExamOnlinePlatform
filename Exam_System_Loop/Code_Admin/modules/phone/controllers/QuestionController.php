<?php

namespace app\modules\phone\controllers;

use app\controllers\BaseController;
use app\models\phone\Tresources;
use app\models\phone\Tresourcesqa;
use app\models\phone\Tresourcesreplyqa;
use app\models\question\Knowledgepoint;
use app\models\system\TbcuitmoonDictionary;
use app\models\systembase\Studentinfo;
use app\models\teachplan\Teachingclassdetails;
use app\models\teachplan\Teachingclassmannage;
use common\commonFuc;
use Yii;

class QuestionController extends BaseController
{
    public $enableCsrfValidation=false;
    public function actionIndex()
    {
        $m_tec = new Teachingclassmannage();
        $m_tecd = new Teachingclassdetails();
        $m_dic = new TbcuitmoonDictionary();
        $m_student = new Studentinfo();
        $m_know = new Knowledgepoint();
        $m_qa = new Tresourcesqa();
        $m_sou = new Tresources();
        $com = new commonFuc();
        $whereKnow = [];
        $where = [];
        $aaa = [];
        $aa = [];


        $name = Yii::$app->session->get('UserName');
        $myClass = $m_tec->find()->where(['TeacherName' => $name])->all();
        //是否选择知识点
        $Info = Yii::$app->request->get();


        $whereKnow['CourseID'] = Yii::$app->session->get('courseCode');
        $where['CourseID'] = Yii::$app->session->get('courseCode');

        $scope = $m_sou->find()->where($where)->asArray()->all();
        foreach ($scope as $key => $value){
          $aa[] = $value['ID'];
        };


        if(isset($Info['TeachingClassID'])) {
            $StuN = $m_tecd->find()->where(['TeachingClassID' => $Info['TeachingClassID']])->asArray()->all();
            foreach ($StuN as $key => $value){
                $aaa[] = $value['StuNumber'];
            };
            $list = $m_qa->find()->select(['ID', 'StuID', 'content', 'IsPublish', 'IsTOP', 'Status', 'AddAt', 'AddBy', 'ResourcesID'])
                ->where(['in', 'StuID', $aaa])->orderBy("AddAt DESC");
        }else{
            $list = $m_qa->find()->select(['ID', 'StuID', 'content', 'IsPublish', 'IsTOP', 'Status', 'AddAt', 'AddBy', 'ResourcesID'])
                ->where(['in', 'ResourcesID', $aa])->orderBy("AddAt DESC");
        }
        $knowledgepoint = knowledgepoint::find()->where($whereKnow)->asArray()->all();


        //Tab
        $countList = clone $list;
        $pages = $com->Tab($countList);

        return $this->render('index', [
            'list' => $list->offset($pages->offset)->limit($pages->limit)->all(),
            'pages' => $pages,
            'myClass' => $myClass
        ]);
    }

    public function actionCreate(){
        $m_rep = new Tresourcesreplyqa();
        $com = new commonFuc();

        if($m_rep->load(Yii::$app->request->post())){
            $m_rep->ID = $com->create_id();
            $m_rep->QaID = Yii::$app->request->post('id');
            $m_rep->AddAt = date('Y-m-d H:i:s');
            $m_rep->AddBy = Yii::$app->session->get('UserName');

            if($m_rep->validate() && $m_rep->save()){
                $com->JsonSuccess('添加成功');
            }else{
                $com->JsonFail($m_rep->getErrors());
            }
        }else{
            $com->JsonFail('数据出错');
        }
    }

    public function actionDelete()
    {
        $com = new commonFuc();
        $m_doc = new Tresourcesqa();

        $ids = \Yii::$app->request->get('ids');
        if (count($ids) > 0) {
            foreach ($ids as $item) {
                $m_doc->deleteAll(['ID' => $item]);
            }
            $com->JsonSuccess('删除成功');

        }
    }


    public function actionView()
    {
        $id = Yii::$app->request->get('id');
        $list = (new Tresourcesqa())->find()->where(['ID' => $id])->asArray()->one();
        $class = (new Studentinfo())->find()->where(['StuNumber' => $list['StuID']])->asArray()->one();
        $reply =(new Tresourcesreplyqa())->find()->where(['QaID' => $id])->orderBy('AddAt ASC')->all();
        return $this->render('view', [
                'list' => $list,
                'class' => $class['ClassName'],
                'reply' => $reply,
            ]);
    }

    public function actionChange()
    {
        $id = Yii::$app->request->post('id');
        $data = (new \app\models\phone\Tresourcesqa())->Change($id);
        echo json_encode($data);
    }


    public function actionPublish()
    {
        $m_doc = new Tresourcesqa();
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

    public function actionTop()
    {
        $m_doc = new Tresourcesqa();
        $com = new commonFuc();
        $id = Yii::$app->request->get();
        $data = $m_doc->find()->where(["ID" => $id])->one();
        if (isset($id)) {
            $data = $m_doc->find()->where(["ID" => $id])->one();
            if ($data->IsTOP == '1') {
                $data->IsTOP = '0';
            } else {
                $data->IsTOP = '1';
            }
            $data->save();
        }
        echo json_encode($data);
    }

}