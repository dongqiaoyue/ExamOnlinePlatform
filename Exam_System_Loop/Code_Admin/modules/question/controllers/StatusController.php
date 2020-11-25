<?php
namespace app\modules\question\controllers;

use app\controllers\BaseController;
use app\models\system\TbcuitmoonDictionary;
use common\commonFuc;

class StatusController extends BaseController
{
	public function actionIndex()
    {
        $com = new commonFuc();
        $res = \Yii::$app->session->get('courseCode');
        $cour = $com->codeTranName($res);

    	$status = TbcuitmoonDictionary::find()->where(['CuitMoon_DictionaryName'=>$cour])->asArray()->one()['CuitMoon_DictionaryRemarks'];
    	return $this->render('index', ['status'=>$status]);
    }

    public function actionChange()
    {
        $com = new commonFuc();
        $res = \Yii::$app->session->get('courseCode');
        $cour = $com->codeTranName($res);

    	$info = \Yii::$app->request->post();
    	TbcuitmoonDictionary::updateAll(['CuitMoon_DictionaryRemarks'=>$info['status']], ['CuitMoon_DictionaryName'=>$cour]);
    }
}
