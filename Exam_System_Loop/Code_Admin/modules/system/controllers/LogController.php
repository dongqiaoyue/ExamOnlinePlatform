<?php
namespace  app\modules\system\controllers;

use app\controllers\BaseController;
use Yii;
use app\models\system\AdminLog;
use app\models\system\AuthItem;
use app\models\TbcuitmoonUser;
use app\models\systembase\Studentinfo;


class LogController extends  BaseController{


    public function actionIndex(){
        return $this->render('index');
    }


    public function actionGetLog()
    {

    	$pagesize = 20;
    	if(\Yii::$app->request->isPost)
    	{
    		$post = \Yii::$app->request->post();
    		if(isset($post['time']))
    		{
    			$info = AdminLog::find()->select("id,route,user_agent,admin_id,ip,user,created_at")->where("from_unixtime(created_at,'%Y-%m-%d') = :time",[':time'=>$post['time']])->orderBy("created_at DESC")->offset($pagesize*(int)$post['PageNum'])
                ->limit($pagesize)->asArray()->all();

                 $count = ceil((new \yii\db\Query())
                ->select('count(*)')
                ->from(AdminLog::tableName())

                ->where("from_unixtime(created_at,'%Y-%m-%d') = :time",[':time'=>$post['time']])
                ->All()[0]['count(*)']*1.0/$pagesize);


    			foreach ($info as $key => $value) {
    				$info[$key]['routeName'] = AuthItem::find()->where(['name'=>'/'.$value['route']])->asArray()->one()['description'];
                    $info[$key]['created_at'] =  date("Y-m-d H:i:s", $info[$key]['created_at']);
    				if($value['admin_id'] == 1)
    					$info[$key]['userName'] = TbcuitmoonUser::find()->where(['CuitMoon_UserName'=>$value['user']])->asArray()->one()['CuitMoon_UserRealName'];
    				else
    					$info[$key]['userName'] = Studentinfo::find()->where(['StuNumber'=>$value['user']])->asArray()->one()['Name'];
    				// $info[$key]['gets'] = json_decode($info[$key]['gets'],true);

    				// $info[$key]['posts'] = json_decode($info[$key]['posts'],true);


    			}
    			$info[0]['count'] = $count;
                $info[0]['i'] = $pagesize*(int)$post['PageNum'];
    			echo json_encode($info);
    		}
    	}
    }
    public function actionGetDetails()
    {
    	if(\Yii::$app->request->isPost)
    	{
    		$post = \Yii::$app->request->post();
    		if(isset($post['id']))
    		{
    			$aim = AdminLog::find()->select("gets,posts")->where(['id'=>$post['id']])->asArray()->one();

    			$aim['gets'] = json_decode($aim['gets'],true);
    			$aim['posts'] = json_decode($aim['posts'],true);
    			echo json_encode($aim);
    		}


    	}
    }

    public function actionSearchLog()
    {

        $pagesize = 20;
        if(\Yii::$app->request->isPost)
        {
            $post = \Yii::$app->request->post();
            if(isset($post['key']))
            {
                $info = AdminLog::find()->select("id,route,user_agent,admin_id,ip,user,created_at")->where("route like :key or ip like :key or user like :key or user_agent like :key",[':key'=>'%'.$post['key'].'%'])->orderBy("created_at DESC")->offset($pagesize*(int)$post['PageNum'])
                ->limit($pagesize)->asArray()->all();

                 $count = ceil((new \yii\db\Query())
                ->select('count(*)')
                ->from(AdminLog::tableName())

                ->where("route like :key or ip like :key or user like :key",[':key'=>'%'.$post['key'].'%'])
                ->All()[0]['count(*)']*1.0/$pagesize);


                foreach ($info as $key => $value) {
                    $info[$key]['created_at'] =  date("Y-m-d H:i:s", $info[$key]['created_at']);
                    $info[$key]['routeName'] = AuthItem::find()->where(['name'=>'/'.$value['route']])->asArray()->one()['description'];
                    if($value['admin_id'] == 1)
                        $info[$key]['userName'] = TbcuitmoonUser::find()->where(['CuitMoon_UserName'=>$value['user']])->asArray()->one()['CuitMoon_UserRealName'];
                    else
                        $info[$key]['userName'] = Studentinfo::find()->where(['StuNumber'=>$value['user']])->asArray()->one()['Name'];
                    // $info[$key]['gets'] = json_decode($info[$key]['gets'],true);

                    // $info[$key]['posts'] = json_decode($info[$key]['posts'],true);


                }
                $info[0]['count'] = $count;
                $info[0]['i'] = $pagesize*(int)$post['PageNum'];
                echo json_encode($info);
            }
        }
    }



}
