<?php

namespace app\modules\system\controllers;

use app\controllers\BaseController;
use common\commonFuc;
use app\models\TbcuitmoonUser;

class ChangeuserController extends BaseController{
	public function actionIndex()
	{

		$user = TbcuitmoonUser::find()->select("CuitMoon_UserName,CuitMoon_UserRealName")->asArray()->all();

		return $this->render("index",[
			'user'=>$user]);
	}


	public function actionLogin()
	{
		$username = \Yii::$app->request->post('user');
		if($username)
		{
			$com = new commonFuc();
	        $m_user = new TbcuitmoonUser();
	        $user = tbCuitMoonUser::findByUsername($username);
	        if(\Yii::$app->user->login($user, 3600 * 24 * 30 ))
	        {
	        	\Yii::$app->session->set('UserName',$username);
	        	$Tmp = '';
		        $Roles = \Yii::$app->authManager->getRolesByUser($username);
		        foreach ($Roles as $item) {
		            $Tmp = $item->name;
		        }
		        if ($Tmp == '教师') {
		            \Yii::$app->session->set('courseCode',$m_user->findOne([
		                'CuitMoon_UserID' => \Yii::$app->user->getId()
		            ])->CuitMoon_AreaCode);
		        }
	        }
	        
	        // \Yii::$app->user->setId($username);
	        //检测角色
	        
		}
		


	}
}