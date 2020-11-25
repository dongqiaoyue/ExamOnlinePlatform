<?php
namespace app\modules\systemdata\controllers;

use app\controllers\BaseController;
use app\models\systemdata\AboutUs;
use common\commonFuc;
use Yii;


class AboutUsController extends BaseController{
    /**
     * @return array
     */
    public function actionIndex()
    {
        $m_ab = new AboutUs();
        $com = new commonFuc();
        $where = ['and'];
        $ab=$m_ab->find()->all();
        return $this->render('index',[
            'ab'=>$ab,
        ]);
    }


    public function actionCreate(){
        $com = new commonFuc();
        $m_ab = new AboutUs();
        if ($m_ab->load(Yii::$app->request->post())) {
            $m_ab->aboutUsID = $com->create_id();
            if ($m_ab->validate() && $m_ab->save()) {
                $com->JsonSuccess('添加成功');
            } else {
                $com->JsonFail($m_ab->getErrors());
            }
        } else {
            $com->JsonFail('添加失败');
        }

    }
}
