<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\systemdata\Developerinfo;
use app\models\systemdata\Newsinfo;
use app\models\system\TbcuitmoonDictionary;
use yii\helpers\Url;

use app\models\question\Knowledgepoint;
use app\models\question\Questions;
use app\models\question\FindError;
use app\models\exam\Stutestrecorddetails;
use app\models\exam\Stutest;
use app\models\systembase\Studentinfo;
use common\commonFuc;
use app\models\system\AdminLog;
use app\models\teachplan\Teachingclassdetails;
use app\models\teachplan\Teachingclassmannage;

class IndexController extends Controller
{
    public $layout = 'index';
    public function beforeAction($action)
    {
        $controllerId=$action->controller->id;
        $actionId=$action->id;
        $route = $this->route;
        $log = new AdminLog();

        $com = new commonFuc();

        $log['route'] = $route;
        $log['url'] = Url::toRoute($route);
        $log['user_agent'] = Yii::$app->request->headers->get('User-Agent');
        // if(\Yii::$app->request->isGet)
        $log['gets'] = json_encode(\Yii::$app->request->get());
        // if(\Yii::$app->request->isPost)
        $log['posts'] = json_encode(\Yii::$app->request->post());
        $log['ip'] = $com->getClientIp();
        $time = time();
        $log['created_at'] = $time;
        $log['updated_at'] = $time;
        $log['admin_email'] = "admin@email.com";
        $log['admin_id'] = 1;
        $user = "";
        if(\Yii::$app->session->get('UserName')!=null)
            $user = \Yii::$app->session->get('UserName');
        else if(\Yii::$app->session->get('StudentNum')!=null)
            $user = \Yii::$app->session->get('StudentNum');
        else
            $user = "guest";
        $log['user'] =  $user;
        $log->save();
        return true;

    }

    public function actionIndex()
    {


        $news = new Newsinfo();
        $info = $news->find()->orderBy("releasetime DESC")->all();
        $m_deve = new Developerinfo();
        $deve = $m_deve->find()->asArray()->all();
        $where = '';
        $month = (int)date("m",time());
        $year = (int)date("Y",time());
        if($month >= 9)
            $where = "SubmitTime > '".($year)."-9-1 00:00:00'"." and SubmitTime < '".date("Y-m-d H:i:s",time())."'";
        else {
            $where = "SubmitTime < '".date("Y-m-d H:i:s",time())."' and SubmitTime > '".($year-1)."-9-1 00:00:00'";
        }

        $stuTest = (new \yii\db\Query())
        ->select("count(*)as sum,StuNumber,StuName")
        ->from(Stutest::tableName())
        ->where($where)
        ->limit(10)
        ->groupBy("StuNumber")
        ->orderBy("count(*) DESC")
        ->All();
        return $this->render('//index/index', [
            'info' => $info,
            'deve' => $deve,
            'stuTest' => $stuTest
        ]);
    }

    public function actionAboutUs()
    {
        return $this->render('//index/about-us');
    }

    public function actionNews()
    {
        $news = new Newsinfo();
        $m_n = Yii::$app->request->get();
        $m_news = $news->find()->where(['newsBh'=>$m_n])->all();

      //echo json_encode($m_news);
       return $this->render('//index/news',[
          'm_news'=>$m_news,
        ]);
    }

    public function actionDeveloper()
    {
        $m_deve = new Developerinfo();
        $deve = $m_deve->find()->all();

        return $this->render('//index/developer', [
            'deve' => $deve,
        ]);
    }

    public function actionNewsList()
    {
        $m_dic = new TbcuitmoonDictionary();
        $news = new Newsinfo();
        $m_news = $news->find()->all();
        return $this->render('//index/NewsList', [
            'type' => $m_dic->getDictionaryList('新闻类型'),
            'm_news'=>$m_news,
        ]);

    }

    public function actionNewsType(){
        $news = new Newsinfo();
        $m_d = Yii::$app->request->get();
        $m_news = $news->find()->where(['newstype'=>$m_d])->asArray()->all();

        echo json_encode($m_news);
    }

    // public function actionClear()
    // {
    //     $allDetail = Stutestrecorddetails::find()->select("DetailsID")->asArray()->all();
    //     foreach ($allDetail as $key => $value) {
    //         $sum = Stutest::find()->where(['DetailsID'=>$value['DetailsID']])->count();
    //         $allDetail[$key]['sum'] = $sum;
    //         if($sum==0)
    //         {
    //             Stutestrecorddetails::deleteAll(['DetailsID'=>$value['DetailsID']]);
    //         }
    //     }
    //     echo json_encode($allDetail);
    // }
    // public function actionSendmail()
    // {
    //     $mail= \Yii::$app->mailer->compose();
    //     $mail->setTo('626973633@qq.com');
    //     $mail->setSubject("ubuntu当前登录用户");
    //     $mail->setHtmlBody(\Yii::$app->request->get("id"));    //发布可以带html标签的文本
    //     $mail->send();
    // }
}
?>
