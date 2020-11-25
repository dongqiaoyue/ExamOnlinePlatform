<?php
namespace app\modules\systemdata\controllers;


use app\controllers\BaseController;
use app\models\system\TbcuitmoonDictionary;
use app\models\systemdata\Newsinfo;
use common\commonFuc;
use Yii;

class NewsController extends BaseController
{
    public function actionIndex()
    {
        $m_new = new Newsinfo();
        $com = new commonFuc();
        $m_dic = new TbcuitmoonDictionary();
        $res = Yii::$app->request->get();
        //$id = isset($id['newsBh']) ? $id['newsBh'] : null;
       // $news = $m_new->find()->all();
        $where = ['and'];
       if(isset($res['search'])){
           $sear = $res['search'];
           $where= ["like","newstitle","$sear"];
       }
       if(isset($res['type'])){
           if($res['type']!='all'){
               $Type=$res['type'];
               $where[]= "newstype='$Type'";

           }
           $Type_Choice = $res['type'];
       }
       else{
           $Type_Choice=null;
       }

        $Info = $m_new->find()->where($where);
        $CountInfo = clone $Info;
        $pages = $com->Tab($CountInfo);
        return $this->render('index', [
//            'news' => $news,
            'news' => $Info->limit($pages->limit)->offset($pages->offset)->all(),
            'pages' => $pages,
            'type' => $m_dic->getDictionaryList('新闻类型'),
            'type_choice'=>$Type_Choice,

        ]);
        //print_r($info);

    }

    public function actionAdd(){
        $m_dic = new TbcuitmoonDictionary();

        return $this->render('add',[
            'type' => $m_dic->getDictionaryList('新闻类型'),
        ]);
    }

    //查看新闻
    public function actionView()
    {
        $m_news = new newsinfo();

        $id = Yii::$app->request->get('id');
        if ($id) {
            $news = $m_news->find()->where([
                'newsBh' => $id,
            ])->asArray()->one();
            echo json_encode($news);
        }

    }

    //添加新闻数据
    public function actionCreate()
    {
        $com = new commonFuc();
        $m_news = new newsinfo();
        if ($m_news->load(Yii::$app->request->post())) {
            $m_news->newsBh = $com->create_id();
            $m_news->releasetime=date("Y-m-d");
            $m_news->State=0;
            if ($m_news->validate() && $m_news->save()) {
                $com->JsonSuccess('添加成功');
            } else {
                $com->JsonFail($m_news->getErrors());
            }
        } else {
            $com->JsonFail('添加失败');
        }
    }


    //更新新闻
    public function actionUpdate()
    {
        $com = new commonFuc();
        $m_news = new newsinfo();

        $id = Yii::$app->request->post('id');
        $update = $m_news->findOne($id);
        if ($update->load(Yii::$app->request->post())) {
            if ($update->validate() && $update->save()) {
                $com->JsonSuccess('更新成功');
            } else {
                $com->JsonFail($m_news->getErrors());
            }
        } else {
            $com->JsonFail('更新失败');
        }
    }

    //删除新闻数据
    public function actionDelete()
    {
        $com = new commonFuc();
        $m_news = new newsinfo();

        $ids = Yii::$app->request->get('ids');
        if (count($ids) > 0) {
            foreach ($ids as $item) {

                $m_news->deleteAll(['newsBh' => $item]);

                $com->JsonSuccess('删除成功');

            }
        }
    }



    //是否公布新闻
    public function actionRelease()
    {
        $m_news = new Newsinfo();
        $com = new commonFuc();
        $id = Yii::$app->request->get();
        if ($id) {
            $news = $m_news->findOne([
                'newsBh'=>$id,
            ]);
            if ($news->State== '1') {
                $news->State= '0';
            } else {
                $news->State= '1';
            }
            if ($news->validate() && $news->save()) {
                $com->JsonSuccess('操作成功');
            } else {
                $com->JsonFail($m_news->getErrors());
            }
        } else {
            $com->JsonFail('操作失败');
        }

    }
}


?>