<?php

namespace app\modules\aid\controllers;


//字典
use app\models\system\TbcuitmoonDictionary;
//公共函数
use common\commonFuc;
//
use app\models\teachplan\Teachingclassmannage;
//教学学生
use app\models\teachplan\Teachingclassdetails;
//学生信息获取
use app\models\systembase\Studentinfo;
//提问
use app\models\aid\Question;

use app\models\aid\Gradescoreset;

//课堂提问
class ClassQuestionController extends \app\controllers\BaseController
{
    public $enableCsrfValidation=false;
    public function actionIndex()
    {
        return $this->render('index');
    }
//获取学期
    public function actionGetTerm()
    {
    	$m_Dic = new TbcuitmoonDictionary();
    	$term = $m_Dic->getDictionaryListAsArray('学期');
    	// print_r($term);
    	 echo json_encode($term, JSON_UNESCAPED_UNICODE);
    }
//获取班级
    public function actionGetClass()
    {
    	if(\Yii::$app->request->isPost)
    	{
    		$post=\Yii::$app->request->post();
    		if(isset($post['Term']))
    		{
    			$classAll=Teachingclassmannage::find()->where(
                ['Term'=>$post['Term'],
                'TeacherName'=>\Yii::$app->session->get('UserName'),
                'CourseID'=>\Yii::$app->session->get('courseCode')
                ])->asArray()->all();
                echo json_encode($classAll,JSON_UNESCAPED_UNICODE);
    		}
    	}
    }
//获取学生信息
    public function actionGetStudent()
    {
    	if(\Yii::$app->request->isPost)
    	{
    		$post=\Yii::$app->request->post();
    		if(isset($post['TeachingClassID']))
    		{
    			$stu_info = (new \yii\db\Query())
	            ->select(Studentinfo::tableName().'.StuNumber,Name,Sex,ClassName')
	            ->from(Studentinfo::tableName())
	            ->leftJoin(Teachingclassdetails::tableName(),
                    Teachingclassdetails::tableName().'.StuNumber='.Studentinfo::tableName().'.StuNumber')
	            ->where(['TeachingClassID'=>$post['TeachingClassID']])
	            ->orderBy('StuNumber ASC')
	            ->All();
    			echo json_encode($stu_info,JSON_UNESCAPED_UNICODE);
    		}
    	}
    }
//获取次数
    public function actionGetClassQuestionTime()
    {
    	if(\Yii::$app->request->isPost)
    	{
    		$post=\Yii::$app->request->post();
    		if(isset($post['TeachingClassID']))
    		{
    			$time = (new \yii\db\Query())
	            ->select('studentNum,count(*) as time')
	            ->from(Question::tableName())
	            ->where(['TeachClass'=>$post['TeachingClassID']])
	            ->groupBy('studentNum')
	            ->All();
    			echo json_encode($time,JSON_UNESCAPED_UNICODE);
    		}
    	}
    }
//获取详情
    public function actionGetDetails()
    {
    	if(\Yii::$app->request->isPost)
    	{
    		$post=\Yii::$app->request->post();
    		if(isset($post['StuNumber']) && isset($post['TeachingClassID']))
    		{
    			$details = (new \yii\db\Query())
	            ->select('*')
	            ->from(Question::tableName())
	            ->leftJoin(Gradescoreset::tableName(),
	            	Gradescoreset::tableName().'.TeachingClassID='.Question::tableName().'.TeachClass AND '.Gradescoreset::tableName().'.GradeName='.Question::tableName().'.ScoreGrade')
	            ->where(['TeachClass'=>$post['TeachingClassID'],'studentNum'=>$post['StuNumber']])
                ->orderBy('QuestionDate DESC')
	            ->All();
    			echo json_encode($details,JSON_UNESCAPED_UNICODE);
    		}
    	}
    }
//新增提问
    public function actionAddQuestion()
    {
        $com = new commonFuc();
        $new_question = new Question();
        //create_id
        if(\Yii::$app->request->isPost)
        {
            $post=\Yii::$app->request->post();
            if(isset($post['StuNumber']) && isset($post['TeachingClassID']) && isset($post['score']))
            {
                if($post['score']=='0')
                    echo "打分失败，分数未选择";
                else
                {
                    
                    $new_question['QuestionID'] = $com->create_id();
                    $new_question['StudentNum'] = $post['StuNumber'];
                    $new_question['StudentName'] = Studentinfo::find()->where(['StuNumber'=>$post['StuNumber']])->asArray()->one()['Name'];
                    $new_question['QuestionDate'] = date('Y-m-d H:i:s');
                    $new_question['ScoreGrade'] = $post['score'];
                    // $new_question['Score'] = Gradescoreset::find()->where(['TeachingClassID'=>$post['TeachingClassID'],'GradeName'=>$post['score']])->asArray()->one()['Score'];
                    $new_question['TeachClass'] = $post['TeachingClassID'];
                    if($new_question->validate() && $new_question->save())
                        echo "打分成功";
                    else
                        echo "打分失败";
                }      
            }
            else 
                echo "打分失败";
        }
    }
//获取及天点到信息
    public function actionGetTodayTime()
    {
        if(\Yii::$app->request->isPost)
        {
            $post=\Yii::$app->request->post();
            if(isset($post['TeachingClassID']))
            {
                $time = (new \yii\db\Query())
                ->select('studentNum,count(*) as time')
                ->from(Question::tableName())
                // ->from(Question::tableName())['and', 'type=1', ['or', 'id=1', 'id=2']]
                ->where(['TeachClass'=>$post['TeachingClassID']])
                ->andWhere('DATE_FORMAT(QuestionDate,\'%Y-%m-%d\') = CURDATE()')
                ->groupBy('studentNum')
                ->All();
                echo json_encode($time,JSON_UNESCAPED_UNICODE);
            }
        }
    }
}
