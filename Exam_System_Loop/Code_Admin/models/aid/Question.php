<?php

namespace app\models\aid;

use Yii;

/**
 * This is the model class for table "question".
 *
 * @property string $QuestionID
 * @property string $StudentName
 * @property string $StudentNum
 * @property string $QuestionDate
 * @property integer $Score
 * @property string $ScoreGrade
 * @property string $QuestionState
 * @property string $TeachClass
 */
class Question extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'question';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['QuestionID'], 'required'],
            [['QuestionDate'], 'safe'],
            [['Score'], 'integer'],
            [['QuestionID', 'TeachClass'], 'string', 'max' => 32],
            [['StudentName'], 'string', 'max' => 20],
            [['StudentNum', 'QuestionState'], 'string', 'max' => 50],
            [['ScoreGrade'], 'string', 'max' => 5],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'QuestionID' => 'Question ID',
            'StudentName' => 'Student Name',
            'StudentNum' => 'Student Num',
            'QuestionDate' => 'Question Date',
            'Score' => 'Score',
            'ScoreGrade' => 'Score Grade',
            'QuestionState' => 'Question State',
            'TeachClass' => 'Teach Class',
        ];
    }
}
