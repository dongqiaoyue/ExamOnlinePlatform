<?php
namespace app\modules\front\controllers;

use app\models\grade\Stuscore;
use common\commonFuc;
use app\models\teachplan\Examplan;
use Yii;

class GradeController extends BaseController
{
    public function actionIndex()
    {
        $m_dic = new commonFuc();
        $StudentNum = Yii::$app->session->get('StudentNum');
        $Courses = Stuscore::find()->where(['StuNumber' => $StudentNum])
            ->groupBy('CourseID')->all();
        $Info = [];

        foreach ($Courses as $CourseID) {
            // $finalExam = Exampaper::find()->where(['CourseID'=>$CourseID->CourseID,'Type'=>'1'])->asArray()->all();

            $CourseName = $m_dic->codeTranName($CourseID->CourseID);
            $Info[$CourseName] = Stuscore::find()->where([
                'StuNumber' => $StudentNum,
                'CourseID' => $CourseID->CourseID,
            ])->andWhere("ExamPlanBh NOT IN (select ExamPlanBh from examplan where CourseID=:course and Type=:type)",[':course'=>$CourseID->CourseID,':type'=>'1'])->orderBy('StarTime')->all();
        }
        return $this->render('index',[
            'info' => $Info,
        ]);
    }
}