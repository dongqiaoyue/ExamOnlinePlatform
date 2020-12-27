<?php
namespace app\modules\phone\controllers;


use app\controllers\BaseController;
use app\models\phone\Tresourceexamrecord;
use app\models\phone\Tresources;
use app\models\question\Knowledgepoint;
use app\models\system\TbcuitmoonDictionary;
use common\commonFuc;
use Yii;

class LearnallController extends BaseController
{
    public function actionIndex()
    {
        $m_dic = new TbcuitmoonDictionary();
        $m_know = new Knowledgepoint();
        $m_sou = new Tresources();
        $com = new commonFuc();

        $Info = Yii::$app->request->get();
        $CourseID = Yii::$app->session->get('courseCode');

        $list = $m_sou->find()
            ->select(['ID', 'Name', 'Type']);

        if (isset($Info['term'])) {
            $list = $list->andWhere([
                'like',
                'Term',
                $Info['term']]);
        }
        if (isset($Info['type'])) {
            $list = $list->andWhere(['Type'=>$Info['type']]);
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
            'term' => $m_dic->getDictionaryList('学期'),
            'stage' => $m_dic->getDictionaryList('题目阶段'),
            'knowledgepoint' => $knowledgepoint,
        ]);
    }
    public function actionView()
    {
        $com = new commonFuc();
        $tre = new Tresources();
        $m_exa = new Tresourceexamrecord();
        $ID = Yii::$app->request->get('ID');
        $tresources = $tre->find()
            ->select(['Name','Type'])
            ->where(['ID'=>$ID])
            ->asArray()
            ->one();
        $students = $m_exa->find()
            ->where(['ResourcesID'=>$ID])
            ->orderBy('score DESC')
            ->groupBy('StuName');

        //Tab
        $countList = clone $students;
        $pages = $com->Tab($countList);
        return $this->render('view',[
            'list' => $students->offset($pages->offset)->limit($pages->limit)->all(),
            'pages' => $pages,
            'tresources' => $tresources
            ]);
    }
    public function actionScore()
    {
        $m_exa = new Tresourceexamrecord();

        $sou_id = Yii::$app->request->get('id1');
        $stu_id = Yii::$app->request->get('id2');
        $data = $m_exa->find()
            ->where(['ResourcesID' => $sou_id,'StuID' => $stu_id])
            ->orderBy('AddAt DESC')
            ->asArray()->all();
        echo json_encode($data);
    }
}