<?php
namespace app\modules\front\controllers;

use Yii;
use yii\helpers\Url;
use app\models\system\AdminLog;
use common\commonFuc;
use yii\web\Controller;
use app\models\systembase\Studentinfo;
class BaseController extends Controller{


    public $enableCsrfValidation=false;
    public function beforeAction($action)
    {
       

        if (parent::beforeAction($action)) {
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
            $log['admin_id'] = 0;
            $user = "";
            if(\Yii::$app->session->get('UserName')!=null)
                $user = \Yii::$app->session->get('UserName');
            else if(\Yii::$app->session->get('StudentNum')!=null)
                $user = \Yii::$app->session->get('StudentNum');
            else
                $user = "guest";
            $log['user'] =  $user;
            $log->save();
            $allowUrl = [
                'front/site/index', 'front/site/login'
            ];
            if (in_array($route, $allowUrl)) {
                return true;
            } else {
                if (Yii::$app->stu->isGuest) {
                    $this->redirect(Url::toRoute('/front/site/index'));
                    return false;
                } else {
                    $isIE = Yii::$app->request->headers->get('User-Agent');
                    if(strpos($isIE,"MSIE") || strpos($isIE,"rv:11.0"))
                    {
                      $this->redirect(Url::toRoute("/not/noie"));
                      return false;
                    }
                    $aim = Studentinfo::find()->where(['StuNumber'=>\Yii::$app->session->get('StudentNum')])->asArray()->one()['ICNumber'];
                    // echo $aim;
                    if($aim=='' || strlen(trim($aim)) != 18)
                    {
                        $this->redirect(Url::toRoute('/not/addic'));
                        return false;
                    }
                    else
                        return true;
                }
            }
        }
        return false;
    }

    public function actionIndex(){
        echo '1';
    }
}