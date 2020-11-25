<?php

namespace app\models\grade;

use app\models\systembase\Studentinfo;
use Yii;

/**
 * This is the model class for table "stuscore".
 *
 * @property string $OrderNumber
 * @property string $StuNumber
 * @property string $CourseID
 * @property string $TeachingClassID
 * @property string $NumOfModule
 * @property string $NumOfExam
 * @property string $PlaceOfExam
 * @property string $Weights
 * @property string $StarTime
 * @property string $EndTime
 * @property string $ExamScore
 * @property string $Memo
 * @property string $ExamPlanBh
 */
class Stuscore extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'stuscore';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['OrderNumber', 'StarTime', 'EndTime'], 'required'],
            [['StarTime', 'EndTime'], 'safe'],
            [['OrderNumber', 'CourseID', 'TeachingClassID', 'ExamPlanBh'], 'string', 'max' => 32],
            [['StuNumber'], 'string', 'max' => 50],
            [['NumOfModule'], 'string', 'max' => 100],
            [['NumOfExam', 'Weights'], 'string', 'max' => 10],
            [['PlaceOfExam', 'Memo'], 'string', 'max' => 200],
            [['ExamScore'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'OrderNumber' => 'Order Number',
            'StuNumber' => 'Stu Number',
            'CourseID' => 'Course ID',
            'TeachingClassID' => 'Teaching Class ID',
            'NumOfModule' => 'Num Of Module',
            'NumOfExam' => 'Num Of Exam',
            'PlaceOfExam' => 'Place Of Exam',
            'Weights' => 'Weights',
            'StarTime' => 'Star Time',
            'EndTime' => 'End Time',
            'ExamScore' => 'Exam Score',
            'Memo' => 'Memo',
            'ExamPlanBh' => 'Exam Plan Bh',
        ];
    }

    public function getStudent() {
        return $this->hasOne(Studentinfo::className(),['StuNumber' => 'StuNumber']);
    }

    public function updateScore($score,$StudentID,$ExamPlanBh)
    {
        try{
            //$node = self::findOne(['and','StuNumber' => $StudentID,'ExamPlanBh' => $ExamPlanBh]);
            $node = self::find()->where(['StuNumber' => $StudentID])->andWhere(['ExamPlanBh' => $ExamPlanBh])->one();
            if(empty($node)){
                return ['code' => 2, 'data' => '', 'msg' => '']; //未找到该记录
            }
            $node->ExamScore = $score;
            $node->save();

        }catch (\Exception $e) {

            return ['code' => -1, 'data' => '', 'msg' => $e->getMessage()];
        }
        return ['code' => 1, 'data' => '', 'msg' => '成绩修改成功'];
    }
}
