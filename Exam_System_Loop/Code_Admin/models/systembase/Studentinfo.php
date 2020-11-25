<?php

namespace app\models\systembase;

use app\models\FrontUser;
use app\models\teachplan\Examplan;
use app\models\exam\Exampaper;
use app\models\teachplan\Teachingclassdetails;
use Yii;

/**
 * This is the model class for table "studentinfo".
 *
 * @property string $StuNumber
 * @property string $ICNumber
 * @property string $Name
 * @property string $Sex
 * @property string $Password
 * @property string $ClassName
 * @property string $DepartmentName
 * @property string $MajorName
 * @property string $Memo
 * @property string $StudentPhoto
 */
class Studentinfo extends FrontUser
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'studentinfo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['StuNumber'], 'required'],
            [['StuNumber', 'ClassName', 'DepartmentName', 'MajorName'], 'string', 'max' => 50],
            [['ICNumber'], 'string', 'max' => 18],
            [['Name'], 'string', 'max' => 30],
            [['Sex'], 'string', 'max' => 5],
            [['Password'], 'string', 'max' => 100],
            [['Memo'], 'string', 'max' => 200],
            [['StudentPhoto'], 'string', 'max' => 500],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'StuNumber' => 'Stu Number',
            'ICNumber' => 'Icnumber',
            'Name' => 'Name',
            'Sex' => 'Sex',
            'Password' => 'Password',
            'ClassName' => 'Class Name',
            'DepartmentName' => 'Department Name',
            'MajorName' => 'Major Name',
            'Memo' => 'Memo',
            'StudentPhoto' => 'Student Photo',
        ];
    }
    //判断当前时间此人是否有考试
    public static function HasExam($StuNumber)
    {
        //获取当前时间存在的考试
        $allExam = Examplan::find()->where('NOW() > StarTime AND NOW() < EndTime and IsFixedPlace="1"')->asArray()->all();
        //记录所有考试班级
        $allTea = [];
        //记录考试班级对应的考试计划
        $allExams = [];
        foreach ($allExam as $key => $value) {
            $aim = explode('|',$value['TeachingClassID']);
            foreach ($aim as $key1 => $value1) {
                $allTea[] = $value1;
                $allExams[] = $value['ExamPlanBh'];
            }
        }
        $flag = 0;
        foreach ($allTea as $key => $value) {
            $has = Teachingclassdetails::find()->where(['TeachingClassID'=>$value,'StuNumber'=>$StuNumber])->asArray()->one();
            if($has)
            {
                $isSub = Exampaper::find()->where(['ExamPlanBh'=>$allExams[$key],'StudentID'=>$StuNumber])->asArray()->one()['SubmitStage'];
                if(!$isSub)
                {
                    $flag = 1;
                    break;
                }
                
            }
        }
        return $flag;
    }
}
