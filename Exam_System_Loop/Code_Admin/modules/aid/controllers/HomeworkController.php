<?php

namespace app\modules\aid\controllers;

//homework 模块
use app\models\aid\Commonhomework;
//公共函数
use common\commonFuc;
//教学班级
use app\models\teachplan\Teachingclassmannage;
//教学学生
use app\models\teachplan\Teachingclassdetails;
//学生信息获取
use app\models\systembase\Studentinfo;

use yii\web\UploadedFile;
use app\models\UploadForm;

use yii\helpers\Url;

use app\models\aid\Studentswork;
use app\models\aid\Gradescoreset;


//平时作业
class HomeworkController extends \app\controllers\BaseController
{
    public $enableCsrfValidation=false;
    public function actionIndex()
    {
        return $this->render('index');
    }
    //获取当前老师所有课班级信息
    public function actionGetClassAll()
    {
    	if(\Yii::$app->request->isPost)
    	{
    		$post = \Yii::$app->request->post();
    		$allclass = Teachingclassmannage::find()->where(['TeacherName'=>\Yii::$app->session->get('UserName'),'CourseID'=>\Yii::$app->session->get('courseCode')])->asArray()->all();
    		echo json_encode($allclass, JSON_UNESCAPED_UNICODE);
    	}
    }
    //新增homework保存
    public function actionSaveHomework()
    {
    	$user = \Yii::$app->session->get('UserName');
    	$com = new commonFuc();
    	if(\Yii::$app->request->isPost)
    	{
    		$post = \Yii::$app->request->post();
    		if(isset($post['HomeworkName']) && $post['HomeworkName'] && isset($post['DeadTime']) && $post['DeadTime'] && isset($post['TeachClass']) && $post['TeachClass'])
    		{
                    $newHomework = new Commonhomework();
                    $newHomework['HomeworkID'] = $com->create_id();
                    $newHomework['TeachClass'] = $post['TeachClass'];
                    $newHomework['TeacherName'] = $user;
                    $newHomework['HomeworkName'] = $post['HomeworkName'];
                    if(isset($_FILES['WorkURL']))
                    {
                        $type = explode("/",$_FILES['WorkURL']['type']);
                        if($type[0]!='image')
                        {
                            echo "请上传图片";
                            die;
                        }
                        $url = \Yii::$app->basePath.'/upload/'.$user.'/homework';
                        $save_url = \Yii::$app->request->baseUrl.'/../upload/'.$user.'/homework';
                        if (!file_exists($url))
                            mkdir($url);
                        // echo $url;
                        $urlAll = $url.'/'.$newHomework['HomeworkID'].'.'.$type[1];
                        $save_url = $save_url.'/'.$newHomework['HomeworkID'].'.'.$type[1];
                        move_uploaded_file($_FILES["WorkURL"]["tmp_name"], $urlAll);
                        // echo $urlAll;
                        $newHomework['WorkURL'] = $save_url;
                    }
                    $newHomework['WorkDesc'] = $post['WorkDesc'];
                    $newHomework['WorkScore'] = -1;
                    $newHomework['DeadTime'] = $post['DeadTime'];
                    $newHomework['IsStuSee'] = $post['IsStuSee'];
                    $newHomework['Memo'] = $post['Memo'];
                    if($newHomework->validate() && $newHomework->save())
                        echo '添加成功';
                    else
                        echo '添加失败';    			
    		}
    		else
    			echo '参数不完整';

    	}
    }
    //获取所有homework
    public function actionGetAllHomework()
    {
    	if(\Yii::$app->request->isPost)
    	{
    		$post = \Yii::$app->request->post();
    		if(isset($post['TeachClass']))
    		{
    			$username = \Yii::$app->session->get('UserName');
    			$all = Commonhomework::find()->where(['Teachclass'=>$post['TeachClass'],'TeacherName'=>$username])->orderBy('DeadTime')->asArray()->all();
                $all[0]['now'] = date('Y-m-d H:i:s');
    			echo json_encode($all,JSON_UNESCAPED_UNICODE);
    		}
    	}
    }
    //改变可见
    public function actionChangeIsSee()
    {
    	if(\Yii::$app->request->isPost)
    	{
    		$post = \Yii::$app->request->post();
    		if(isset($post['HomeworkID']))
    		{
    			$value = Commonhomework::find()->where(['HomeworkID'=>$post['HomeworkID']])->asArray()->one()['IsStuSee'];
    			$value = ($value+1)%2;
    			Commonhomework::updateAll(['IsStuSee'=>$value],['HomeworkID'=>$post['HomeworkID']]);
    		}
    	}
    }
    //获取指定honework
    public function actionGetOneHomework()
    {
    	if(\Yii::$app->request->isPost)
    	{
    		$post = \Yii::$app->request->post();
    		if(isset($post['HomeworkID']))
    		{
    			$one = Commonhomework::find()->where(['HomeworkID'=>$post['HomeworkID'],'TeacherName'=>\Yii::$app->session->get('UserName')])->asArray()->one();
    			echo json_encode($one,JSON_UNESCAPED_UNICODE);
    		}
    	}
    }
    //删除作业
    public function actionDeleteHomework()
    {
    	if(\Yii::$app->request->isPost)
    	{
    		$post = \Yii::$app->request->post();
    		if(isset($post['HomeworkID']))
    		{
    			if(count(Commonhomework::find()->where(['HomeworkID'=>$post['HomeworkID'],'TeacherName'=>\Yii::$app->session->get('UserName')])->asArray()->all()) ==1)
    			{
                    Studentswork::deleteAll(['HomeworkID'=>$post['HomeworkID']]);
    				Commonhomework::deleteAll(['HomeworkID'=>$post['HomeworkID']]);
    				echo "删除成功";
    			}
    			else
    				echo "删除失败";
    		}
    	}
    }
    //更新作业
    public function actionUpdateHomework()
    {
        $array = [];
        $user = \Yii::$app->session->get('UserName');
        if(\Yii::$app->request->isPost)
        {
            $post = \Yii::$app->request->post();
            if(isset($post['HomeworkID']) && $post['HomeworkID'])
            {
                foreach ($post as $key => $value)
                {
                    if($value)
                        $array[$key] = $value;
                }
                if(isset($_FILES['WorkURL']))
                    {
                        $type = explode("/",$_FILES['WorkURL']['type']);
                        if($type[0]!='image')
                        {
                            echo "请上传图片";
                            die;
                        }
                        $url = \Yii::$app->basePath.'/upload/'.$user.'/homework';
                        $save_url = \Yii::$app->request->baseUrl.'/../upload/'.$user.'/homework';
                        if (!file_exists($url))
                            mkdir($url);
                        $urlAll = $url.'/'.$post['HomeworkID'].'.'.$type[1];
                        $save_url = $save_url.'/'.$post['HomeworkID'].'.'.$type[1];
                        move_uploaded_file($_FILES["WorkURL"]["tmp_name"], $urlAll);
                        // echo $urlAll;
                        $array['WorkURL'] = $save_url;
                    }
                Commonhomework::updateAll($array,['HomeworkID'=>$post['HomeworkID']]);
                echo "修改成功";
            }
            
        }
    }

    //获取学生提交作业情况
    public function actionGetUploadHomeworkAll()
    {
        //分页总数
        $count;
        //每页人数
        $pagesize = 10;
        //页数
        $pagenum = 0;
        if(\Yii::$app->request->isPost)
        {
            $post = \Yii::$app->request->post();
            if(isset($post['HomeworkID']) && $post['HomeworkID'] && isset($post['PageNum']))
            {
                // $count = Studentswork::count()->where(['HomeworkID'=>$post['HomeworkID']]);
                $count = ceil((new \yii\db\Query())
                ->select('count(*)')
                ->from(Studentswork::tableName())
                ->where(['HomeworkID'=>$post['HomeworkID']])
                ->All()[0]['count(*)']*1.0/$pagesize);
                
                $all = (new \yii\db\Query())
                ->select('*')
                ->from(Studentswork::tableName())
                ->Where(['HomeworkID'=>$post['HomeworkID']])
                ->offset($pagesize*(int)$post['PageNum'])
                ->limit($pagesize)
                ->orderby('StudentNum ASC')
                ->All();
                $all[0]['count'] = $count;
                $all[0]['i'] = $pagesize*(int)$post['PageNum'];
                echo json_encode($all,JSON_UNESCAPED_UNICODE);
            }
        }
    }

    public function actionGetUploadHomeworkOne()
    {
        if(\Yii::$app->request->isPost)
        {
            $post = \Yii::$app->request->post();
            if(isset($post['StudentWorkID']))
            {
                $all = Studentswork::find()->where(['StudentWorkID'=>$post['StudentWorkID']])->asArray()->one();
                echo json_encode($all,JSON_UNESCAPED_UNICODE);
            }
        }
    }

    public function actionMarkHomework()
    {
         if(\Yii::$app->request->isPost)
        {
            $post = \Yii::$app->request->post();
            if(isset($post['StudentWorkID']) && $post['StudentWorkID'] && isset($post['ScoreGrade']) && $post['ScoreGrade'])
            {
                $TeachClass = Studentswork::find()->where(['StudentWorkID'=>$post['StudentWorkID']])->asArray()->one()['TeachClass'];
                $array['MarkDate'] = date('Y-m-d H:i:s');
                $array['ScoreGrade'] = $post['ScoreGrade'];
                // $array['GetScore'] = Gradescoreset::find()->where(['TeachingClassID'=>$TeachClass,'GradeName'=>$post['ScoreGrade']])->asArray()->one()['Score'];
                Studentswork::updateAll($array,['StudentWorkID'=>$post['StudentWorkID']]);
                echo "打分成功";
            }
            else
                echo "参数不正确";
        }
    }
    //获取学生上传的文件
    public function actionGetUploadFile()
    {
        $fileName = Yii::app()->basePath.'/../download_file/'.'xxx.txt';
        $fp = fopen($fileName,'r');
        $contents = fread($fp,filesize($fileName));
        fclose($fp);

        Yii::$app->request->sendFile($fileName,$contents);
    }
}
