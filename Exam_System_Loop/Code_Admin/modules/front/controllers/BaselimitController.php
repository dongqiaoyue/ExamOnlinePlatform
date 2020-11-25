<?php
namespace app\modules\front\controllers;

use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use app\models\system\TbcuitmoonDictionary;
use app\models\system\AdminLog;
use common\commonFuc;
use app\models\systembase\Studentinfo;

class BaselimitController extends Controller{


    public $enableCsrfValidation=false;

    public function beforeAction($action)
    {

        if (parent::beforeAction($action)) {
            $route = $this->route;
            $log = new AdminLog();

            $m_dic = new TbcuitmoonDictionary();
            $course = $m_dic->getDictionaryList('课程');

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

                    foreach ($course as $cour){
                        if(TbcuitmoonDictionary::find()->where(['CuitMoon_DictionaryName'=>$cour])->asArray()->one()['CuitMoon_DictionaryCode'] == '10005002')
                        {
                            // $this->redirect(Url::toRoute('/front/cannot/close'));
                            // return false;
                        }
                    }
                    if(Studentinfo::HasExam(\Yii::$app->session->get('StudentNum')))
                    {
                        $this->redirect(Url::toRoute('/front/cannot/index'));
                        return false;
                    }
                    else
                    {
                        return true;
                    }
                    
                }
            }
        }
        return false;
    }


}