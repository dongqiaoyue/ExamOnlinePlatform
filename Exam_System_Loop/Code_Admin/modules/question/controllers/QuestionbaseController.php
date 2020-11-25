<?php

namespace app\modules\question\controllers;

use app\models\question\Questions;
use app\controllers\BaseController;
use common\commonFuc;


class QuestionbaseController extends BaseController
{
    public $enableCsrfValidation=false;
	public function actionChangeSee()
    {
        if(\Yii::$app->request->isPost)
        {
            $post = \Yii::$app->request->post();
            $aim = Questions::find()->where(['QuestionBh'=>$post['QuestionBh']])->one();
            $aim->Score = (string)((int)$aim->Score+1)%2;
            $aim->save();
            echo $aim->Score;
        }
    }
    public function actionChangeChecked()
    {
        if(\Yii::$app->request->isPost)
        {
            $post = \Yii::$app->request->post();
            $aim = Questions::find()->where(['QuestionBh'=>$post['QuestionBh']])->one();
            // echo $aim->Checked;
            if($aim->Checked == NULL)
                $aim->Checked='100002';
            $aim->Checked = (string)(((int)$aim->Checked+1)%100001%2+100001);
            $aim->save();
            echo $aim->Checked;
        }
    }
    //删除一个编程题
    // public function actionDeleteOne()
    // {
    //     if(\Yii::$app->request->isPost)
    //     {
    //         $post = \Yii::$app->request->post();
    //         if(isset($post['QuestionBh']) && $post['QuestionBh'])
    //         {
    //             Questions::deleteAll(['QuestionBh'=>$post['QuestionBh']]);
    //             echo '删除成功';
    //         }
    //         else
    //             echo '删除失败';
    //     }
    //     else
    //         echo '删除失败';
    // }
      //删除
    public function actionDelete()
    {
        $com = new commonFuc();
        $m_ques = new Questions();

        $ids = \Yii::$app->request->get('ids');
        if (count($ids) > 0) {
            foreach ($ids as $item) {

                $m_ques->deleteAll(['QuestionBh' => $item]);
            }
            $com->JsonSuccess('删除成功');

        }
    }
  
}