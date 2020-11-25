<?php

namespace app\models\aid;

use Yii;

/**
 * This is the model class for table "studentswork".
 *
 * @property string $StudentWorkID
 * @property string $HomeworkID
 * @property string $StudentName
 * @property string $StudentNum
 * @property string $TeacherName
 * @property string $WorkContent
 * @property integer $GetScore
 * @property string $ScoreGrade
 * @property string $AnswerURL
 * @property string $uploadTime
 * @property string $MarkDate
 * @property string $TeachClass
 * @property string $Memo
 */
class Studentswork extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'studentswork';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['StudentWorkID'], 'required'],
            [['WorkContent'], 'string'],
            [['GetScore'], 'integer'],
            [['uploadTime', 'MarkDate'], 'safe'],
            [['StudentWorkID', 'HomeworkID', 'TeachClass'], 'string', 'max' => 32],
            [['StudentName', 'TeacherName'], 'string', 'max' => 20],
            [['StudentNum'], 'string', 'max' => 50],
            [['ScoreGrade'], 'string', 'max' => 5],
            [['AnswerURL'], 'string', 'max' => 500],
            [['Memo'], 'string', 'max' => 300],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'StudentWorkID' => 'Student Work ID',
            'HomeworkID' => 'Homework ID',
            'StudentName' => 'Student Name',
            'StudentNum' => 'Student Num',
            'TeacherName' => 'Teacher Name',
            'WorkContent' => 'Work Content',
            'GetScore' => 'Get Score',
            'ScoreGrade' => 'Score Grade',
            'AnswerURL' => 'Answer Url',
            'uploadTime' => 'Upload Time',
            'MarkDate' => 'Mark Date',
            'TeachClass' => 'Teach Class',
            'Memo' => 'Memo',
        ];
    }
}
