<?php
namespace app\modules\front\controllers;

use app\models\systembase\Studentinfo;
use common\commonFuc;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;



class SiteController extends BaseController
{

    public $enableCsrfValidation=false;




    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }


    public function actionIndex()
    {
        if (Yii::$app->stu->isGuest) {
            $this->layout = "//front_login";
            return $this->render('login');
        } else {
//            Yii::$app->stu->identity->clearUserSession();
//            Yii::$app->stu->logout();
            return $this->render('index');

        }
    }
    public function actionLogin()
    {
        $com = new commonFuc();
        $Username = Yii::$app->request->post('StuNumber');
        $Password = Yii::$app->request->post('password');
        if(Studentinfo::login($Username, $Password, true) == true){
            Yii::$app->session->set('StudentNum',$Username);

//            Studentinfo::updateAll(
//                ['CuitMoon_UserRemarks' => $com->getClientIp()],
//                ['CuitMoon_UserName' => $username]
//            );
//            Yii::$app->session->set('UserName',$username);
            $com->JsonSuccess('登录成功');
        }
        else{
            echo json_encode(['error'=>2]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->stu->logout();
        $this->redirect(Url::toRoute('/front/site/index'));
    }

    public function actionChangePassword()
    {
        return $this->render('changePW');
    }

    public function actionChange() {
        $com = new commonFuc();
        $info = Yii::$app->request->post();
        $Student = Studentinfo::findOne(['StuNumber' => \Yii::$app->session->get('StudentNum')]);
        if (md5($info['oldpassword']) == $Student->Password) {
            $Student->Password = md5($info['newpassword']);
            if ($Student->save()) $com->JsonSuccess('修改成功');
        } else {
            $com->JsonFail('密码错误');
        }
    }

    public function actionPersonInfo() {
        $my = Studentinfo::find()->where(['StuNumber'=>\Yii::$app->session->get('StudentNum')])->asArray()->one();
        return $this->render('person-info',['student_info'=>$my]);
    }
    //修改个人信息
    public function actionChangeInfo() {
        if(\Yii::$app->request->isPost)
        {
            $post = \Yii::$app->request->post();
            Studentinfo::updateAll(['ICNumber'=>$post['newID']],['StuNumber'=>\Yii::$app->session->get('StudentNum')]);
            (new commonFuc())->JsonSuccess('修改成功');
        }
    }

}
