<?php

namespace app\models\exam;

use Yii;

/**
 * This is the model class for table "examconfigrecord".
 *
 * @property string $ExamConfigRecordID
 * @property string $ExamPaperName
 * @property string $ConfigTeacherName
 * @property string $ConfigMemo
 * @property string $Academy
 * @property string $ConfigTime
 * @property string $CourseID
 */
class Examconfigrecord extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'examconfigrecord';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ExamConfigRecordID'], 'required'],
            [['ConfigTime'], 'safe'],
            [['ExamConfigRecordID', 'CourseID'], 'string', 'max' => 32],
            [['ExamPaperName', 'ConfigMemo', 'Academy'], 'string', 'max' => 200],
            [['ConfigTeacherName'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ExamConfigRecordID' => 'Exam Config Record ID',
            'ExamPaperName' => 'Exam Paper Name',
            'ConfigTeacherName' => 'Config Teacher Name',
            'ConfigMemo' => 'Config Memo',
            'Academy' => 'Academy',
            'ConfigTime' => 'Config Time',
            'CourseID' => 'Course ID',
        ];
    }


    public function getExamConfigRecord(){
        return self::find()
            ->select([
                'ExamConfigRecordID',
                'ExamPaperName',
                'ConfigTeacherName',
                'Academy',
                'ConfigTime'
            ])
            ->orderBy("ConfigTeacherName ASC")
            ->where([
                'CourseID' => Yii::$app->session->get('courseCode')
            ])->all();
    }
}
