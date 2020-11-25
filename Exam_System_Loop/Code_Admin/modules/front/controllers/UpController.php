<?php

namespace app\modules\front\controllers;
use app\models\teachplan\Teachingclassmannage;
//教学学生
use app\models\teachplan\Teachingclassdetails;
//homework 模块
use app\models\aid\Commonhomework;

use app\models\systembase\Studentinfo;
use common\commonFuc;
use app\models\aid\Studentswork;
class UpController extends \app\modules\front\controllers\BaseController
{
    public $enableCsrfValidation=false;
    public function actionIndex()
    {
        return $this->render('index');
    }
    //前台获取作业接口
    public function actionGetHomeworks()
    {
    	// 
    	$studentNum = \Yii::$app->session->get('StudentNum');

    	if(\Yii::$app->request->isGet)
    	{
    		$get = \Yii::$app->request->get();
    		$array['StuNumber'] = $studentNum;
    		$array['IsStuSee'] = '1';
    		if(isset($get['HomeworkID']))
    			$array['HomeworkID'] = $get['HomeworkID'];
    			
			$all_homework = (new \yii\db\Query())
	        ->select('HomeworkID,'.Teachingclassmannage::tableName().'.TeacherName,HomeworkName,WorkDesc,WorkURL,WorkScore,DeadTime,IsStuSee,'.Commonhomework::tableName().'.Memo,TeachingName')
	        ->from(Commonhomework::tableName())
	        ->leftJoin(Teachingclassdetails::tableName(),
	            Teachingclassdetails::tableName().'.TeachingClassID='.Commonhomework::tableName().'.Teachclass')
	        ->leftJoin(Teachingclassmannage::tableName(),
	            Teachingclassmannage::tableName().'.TeachingClassID='.Commonhomework::tableName().'.Teachclass')
	        ->where($array)
	        ->orderBy('DeadTime ASC')
	        ->All();
            for($i=0; $i<count($all_homework); $i++)
                $all_homework[$i]['isUpload'] = count(Studentswork::find()->where(['HomeworkID'=>$all_homework[$i]['HomeworkID'],'StudentNum'=>$studentNum])->asArray()->all()) > 0 ? '已上传' : '未上传';
	        echo json_encode($all_homework,JSON_UNESCAPED_UNICODE);
    	}
    }
    //前台获取上传作业情况
    public function actionGetUploadHomework()
    {
    	$studentNum = \Yii::$app->session->get('StudentNum');

    	if(\Yii::$app->request->isGet)
    	{
    		$get = \Yii::$app->request->get();

    		$array['StudentNum'] = $studentNum;
    		$array['HomeworkID'] = $get['HomeworkID'];

    		$all = Studentswork::find()->where($array)->asArray()->one();
            //$all['uploadTime'] = $all['uploadTime'] ? '已上传' : '未上传';
            $all['TeachClass'] = isset($all['TeachClass']) ? Teachingclassmannage::find()->where(['TeachingClassID'=>$all['TeachClass']])->asArray()->one()['TeachingName'] : 'NULL';
    		echo json_encode($all,JSON_UNESCAPED_UNICODE);
    	}
    }

    public function actionUploadHomework()
    {
        $com = new commonFuc();
        if(\Yii::$app->request->isPost)
        {
            $post = \Yii::$app->request->post();
            if(isset($post['HomeworkID']) && isset($post['WorkContent']))
            {
                $aim_homework = Commonhomework::find()->where(['HomeworkID'=>$post['HomeworkID']])->asArray()->one();
                $dead_time = $aim_homework['DeadTime'];
                if(strtotime($dead_time) < strtotime (date("y-m-d h:i:s")))
                {
                    $com->JsonFail('作业时间已过期，上传失败');
                }
                else 
                {
                    $user = \Yii::$app->session->get('StudentNum');
                    $count = count(Studentswork::find()->where(['HomeworkID'=>$post['HomeworkID'],'StudentNum'=>$user])->asArray()->all());
                    if($count > 0)
                    {
                        $array['WorkContent'] = $post['WorkContent'];
                        $array['uploadTime'] = date("y-m-d h:i:s");
                        $array['MarkDate'] = '';
                        Studentswork::updateAll($array,['HomeworkID'=>$post['HomeworkID'],'StudentNum'=>$user]);
                        $com->JsonSuccess('上传成功');
                    }
                    else
                    {
                        $new = new Studentswork();
                        $new['StudentWorkID'] = $com->create_id();
                        $new['HomeworkID'] = $post['HomeworkID'];
                        $new['StudentNum'] = $user;
                        $new['StudentName'] = Studentinfo::find()->where(['StuNumber'=>$user])->asArray()->one()['Name'];
                        $new['TeacherName'] = $aim_homework['TeacherName'];
                        $new['WorkContent'] = $post['WorkContent'];
                        $new['uploadTime'] = date("y-m-d h:i:s");
                        $new['TeachClass'] = $aim_homework['TeachClass'];
                        if($new->validate() && $new->save())
                            $com->JsonSuccess('上传成功');
                        else
                            $com->JsonFail('上传失败');
                    }
                }
            }
            else 
                $com->JsonFail('参数不正确');
        }
        else
            $com->JsonFail('请以post提交');

    }
}
