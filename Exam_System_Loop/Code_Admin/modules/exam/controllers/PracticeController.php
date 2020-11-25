<?php
namespace app\modules\exam\controllers;

use app\controllers\BaseController;
use app\models\system\TbcuitmoonDictionary;
use app\models\teachplan\Teachingclassmannage;
// use app\models\teachplan\Teachingclassmannage;
//教学学生
use app\models\teachplan\Teachingclassdetails;
use app\models\systembase\Studentinfo;
use app\models\exam\Stutest;
use app\models\exam\Stutestrecorddetails;
use app\models\question\Questions;
use common\commonFuc;
class PracticeController extends BaseController
{
    public function actionIndex()
    {
        $com = new commonFuc();
        return $this->render('index',['now_term'=>$com->getNowTerm()]);
    }
    //获取班学期
    public function actionGetTerm()
    {
    	echo json_encode(TbcuitmoonDictionary::getDictionaryListAsArray('学期'));
    }
    //获取班级
    public function actionGetClass()
    {
    	if(\Yii::$app->request->isPost)
    	{
    		$post=\Yii::$app->request->post();
    		if(isset($post['Term']))
    		{
    			$classAll=Teachingclassmannage::find()->select(['TeachingName','TeachingClassID'])->where(
                ['Term'=>$post['Term'],
                'TeacherName'=>\Yii::$app->session->get('UserName'),
                'CourseID'=>\Yii::$app->session->get('courseCode')
                ])->asArray()->all();
                echo json_encode($classAll,JSON_UNESCAPED_UNICODE);
    		}
    	}
    }
     public function actionGetStudent()
    {
    	if(\Yii::$app->request->isPost)
    	{
    		$post=\Yii::$app->request->post();
    		if(isset($post['TeachingClassID']))
    		{
                $course = Teachingclassmannage::find()->where(['TeachingClassID'=>$post['TeachingClassID']])->asArray()->one()['CourseID'];
                $stu_info = (new \yii\db\Query())
                ->select('Name,'.Studentinfo::tableName().'.StuNumber,TeachingClassID')
                ->from(Teachingclassdetails::tableName())
                ->leftJoin(Studentinfo::tableName(),
                    Studentinfo::tableName().'.StuNumber='.Teachingclassdetails::tableName().'.StuNumber')
                ->where(['TeachingClassID'=>$post['TeachingClassID']])
                ->All();
                foreach ($stu_info as $key => $value) {
                    $stu_info[$key]['sum'] = count(Stutestrecorddetails::find()->where(['StuNumber'=>$value['StuNumber'],'CourseID'=>$course])->asArray()->all());
                    $stu_info[$key]['questionSum'] = count((new \yii\db\Query())
                    ->select('*')
                    ->from(Stutest::tableName())
                    ->leftJoin(Stutestrecorddetails::tableName(),
                        Stutestrecorddetails::tableName().'.DetailsID='.Stutest::tableName().'.DetailsID')
                    ->where([Stutest::tableName().'.StuNumber'=>$value['StuNumber'],'CourseID'=>$course])
                    ->All());
                }
                echo json_encode($this->list_sort_by($stu_info, 'questionSum', 'desc'),JSON_UNESCAPED_UNICODE);
    		}
    	}
    }
    function list_sort_by($list, $field, $sortby = 'asc')
    {
        if (is_array($list))
        {
            $refer = $resultSet = array();
            foreach ($list as $i => $data)
            {
                $refer[$i] = &$data[$field];
            }
            switch ($sortby)
            {
                case 'asc': // 正向排序
                    asort($refer);
                    break;
                case 'desc': // 逆向排序
                    arsort($refer);
                    break;
                case 'nat': // 自然排序
                    natcasesort($refer);
                    break;
            }
            foreach ($refer as $key => $val)
            {
                $resultSet[] = &$list[$key];
            }
            return $resultSet;
        }
        return false;
    }
    public function actionGetDetaile()
    {
        if(\Yii::$app->request->isPost)
        {
            $post=\Yii::$app->request->post();
            if(isset($post['TeachingClassID']) && isset($post['StuNumber']))
            {
                $course = Teachingclassmannage::find()->where(['TeachingClassID'=>$post['TeachingClassID']])->asArray()->one()['CourseID'];
                $detaile = Stutestrecorddetails::find()->select("DetailsID,IPAddress,InTestTime")->where(['StuNumber'=>$post['StuNumber'],'CourseID'=>$course])->orderBy('InTestTime DESC')->asArray()->all();
                foreach ($detaile as $key => $value) {
                    $detaile[$key]['sum'] = Stutest::find()->where(['DetailsID'=>$value['DetailsID']])->count(); 
                }
                echo json_encode($detaile);
            }
        }
    }
    public function actionGetPracticeQus()
    {
        if(\Yii::$app->request->isPost)
        {
            $com = new commonFuc();
            $post=\Yii::$app->request->post();
            if(isset($post['DetailsID']))
            {
                $AllQuestion = (new \yii\db\Query())
                ->select("CustomBh,name,StuAnswer,".Stutest::tableName().".Score,,SubmitTime,QuestionType,Difficulty")
                ->from(Stutest::tableName())
                ->leftJoin(Questions::tableName(),
                    Questions::tableName().'.QuestionBh='.Stutest::tableName().'.QuestionBh')
                ->orderBy("SubmitTime DESC")
                ->where(['DetailsID'=>$post['DetailsID']])
                ->All();
                foreach ($AllQuestion as $key => $value) {
                    $AllQuestion[$key]['QuestionType'] = $com->codeTranName($AllQuestion[$key]['QuestionType']);
                    $AllQuestion[$key]['Difficulty'] = $com->codeTranName($AllQuestion[$key]['Difficulty']);
                }
                echo json_encode($AllQuestion);

            }
        }
    }
}