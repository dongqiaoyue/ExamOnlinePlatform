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
//        $Courses = Stuscore::find()->where(['StuNumber' => $StudentNum])
//            ->groupBy('CourseID')->all();
        $Scores = Stuscore::find()->where(['StuNumber' => $StudentNum])->all();
        foreach($Scores as $score){
            $Terms[] = Examplan::find()->where(['ExamPlanBh' => $score->ExamPlanBh])->all()['Term'];
        }
        $Terms = array_unique($Terms);
        $Info = [];

        foreach ($Terms as $term) {
            foreach ($Scores as $score){
                // $finalExam = Exampaper::find()->where(['CourseID'=>$CourseID->CourseID,'Type'=>'1'])->asArray()->all();
                if($term == Examplan::find()->where(['ExamPlanBh' => $score->ExamPlanBh])->all()['Term']){
                    $CourseName = $m_dic->codeTranName($score->CourseID);
                    $Info[$term][$CourseName] = Stuscore::find()->where([
                        'StuNumber' => $StudentNum,
                        'CourseID' => $score->CourseID,
                    ])->andWhere("ExamPlanBh NOT IN (select ExamPlanBh from examplan where CourseID=:course and Type=:type)",[':course'=>$score->CourseID,':type'=>'1'])->orderBy('StarTime')->all();
                }
            }
        }
        return $this->render('index',[
            'info' => $Info,
        ]);
    }
}