<?php

namespace app\controllers;

use Yii;
use yii\helpers\Url;
use app\models\systembase\Studentinfo;

class NotController extends \yii\web\Controller
{
	public $enableCsrfValidation=false;

    public function actionIndex()
    {
        $this->layout = 'lte_main';
        return $this->render('not');
    }
    public function actionReset()
    {
    	$this->layout = "/front_login";

    	
        return $this->render('reset');
    }
    public function actionResetpasswd()
    {
    	if(\Yii::$app->request->isPost)
    	{
    		$post = \Yii::$app->request->post();
    		if(isset($post['StuNum']) && $post['StuNum'] && isset($post['IC']) && $post['IC'])
    		{
    			$aim = Studentinfo::find()->where(['StuNumber'=>$post['StuNum'],'ICNumber'=>$post['IC']])->one();
    			if($aim)
    			{
    				$aim['Password'] = md5($post['StuNum']);
    				if($aim->save())
    					echo "密码已初始化为学号！";
    				else
    					echo "输入有误";
    			}
    			else
    				echo "重置失败，输入有误，请联系管理员或老师进行重置密码！";
    		}
    		else
    			echo "参数错误";
    	}
    }
   
    public function actionAddic()
    {
        // var_dump(\Yii::$app->stu->isGuest) ;
        // var_dump(\Yii::$app->session->get('StudentNum'));
        if (\Yii::$app->session->get('StudentNum')==null) {
            \Yii::$app->stu->logout();
            $this->redirect(Url::toRoute('/front/site/index'));
        }
    	$this->layout = "/front_login";
        $aim = Studentinfo::find()->where(['StuNumber'=>\Yii::$app->session->get('StudentNum')])->asArray()->one()['ICNumber'];

        if(strlen(trim($aim))==18)
        {
            $this->redirect(Url::toRoute('/front/site/index'));
        }
        return $this->render("addic");
    }
    public function actionSaveic()
    {
        $this->layout = '/lte_main_login';
        if (Yii::$app->stu->isGuest) {
            $this->redirect(Url::toRoute('/front/site/index'));  
        }
        if (!Yii::$app->stu->isGuest && \Yii::$app->request->isPost)
        {
            $post = \Yii::$app->request->post();
            if(isset($post['IC']))
            {
                Studentinfo::updateAll(['ICNumber'=>$post['IC']],['StuNumber'=>\Yii::$app->session->get('StudentNum')]);
                echo "ok";
            }
        }
    }


    public function actionNoie()
    {
    	$this->layout = "/lte_main_login";
    	return $this->render("noie");
    }

    public function actionNoexam()
    {
        $this->layout = '/lte_main_login';
        return $this->render("noexam");
    }
}
