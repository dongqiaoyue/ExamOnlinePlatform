<?php
namespace app\controllers;

use yii\helpers\Url;
use yii\web\Controller;
use Yii;
use app\models\system\AdminLog;
use common\commonFuc;


class SitebaseController extends Controller{
	public function beforeAction($action)
    {
        // Yii::app()->cache->flush();
        $route = $this->route;


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
        $isIE = Yii::$app->request->headers->get('User-Agent');
        if(strpos($isIE,"MSIE") || strpos($isIE,"rv:11.0"))
        {
          $this->redirect(Url::toRoute("/not/noie"));
          return false;
        }
        $allow_url = ['site/login','site/index','site/captcha'];
        if (in_array($route,$allow_url)) {
            return true;
        } else {

            if (Yii::$app->user->isGuest) {
                $this->redirect(Url::toRoute("/site/index",true));
                return false;
            } else {


                return true;
            }
        }
    }
}