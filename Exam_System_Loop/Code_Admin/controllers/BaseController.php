<?php
namespace app\controllers;

use yii\helpers\Url;
use yii\web\Controller;
use Yii;
use app\models\system\AdminLog;
use common\commonFuc;

class BaseController extends Controller{

   public $enableCsrfValidation=false;
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

       if(!$log->save())
        var_dump($log->getErrors());



       //$allow_url = ['site/login','site/index','site/logout'];
       $nodeName = $controllerId.'/'.$actionId;
       
       if (parent::beforeAction($action)) {
           //print_r($action); // 权限名字传递过去（CreatePost）
        // $action->controller->module->module->requestedRoute
        // if(in_array($route,$allow_url))
        //   return true;
        if (Yii::$app->user->isGuest) {
          $this->redirect(Url::toRoute("/site/index",true));
          return false;
        }
            $isIE = Yii::$app->request->headers->get('User-Agent');
            if(strpos($isIE,"MSIE") || strpos($isIE,"rv:11.0"))
            {
              $this->redirect(Url::toRoute("/not/noie"));
              return false;
            }
           if (!Yii::$app->user->can('/'.$route)) {
               //throw new \Yii\web\UnauthorizedHttpException(Yii::t('yii', '对不起，您现在还没获此操作的权限'));
             $this->redirect(Url::toRoute("/not/index"));
            // die;

               return false;
           }
           else
           {
              return true;
           }
           
       } else {
           return false;
       }
   }


    // public function beforeAction($action)
    // {
    //     // Yii::app()->cache->flush();
    //     $route = $this->route;
    //     $allow_url = ['site/login','site/index'];
    //     if (in_array($route,$allow_url)) {
    //         return true;
    //     } else {
    //         if (Yii::$app->user->isGuest) {
    //             $this->redirect(Url::toRoute("/site/index",true));
    //             return false;
    //         } else {
    //             return true;
    //         }
    //     }
    // }


}