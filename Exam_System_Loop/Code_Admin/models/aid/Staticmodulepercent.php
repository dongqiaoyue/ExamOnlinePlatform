<?php

namespace app\models\aid;

use Yii;

/**
 * This is the model class for table "staticmodulepercent".
 *
 * @property string $StaticID
 * @property integer $AttendancePercent
 * @property integer $HomeworkPercent
 * @property integer $QuestionPercent
 * @property integer $OtherPercent
 * @property string $TeachingClassID
 */
class Staticmodulepercent extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'staticmodulepercent';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['StaticID'], 'required'],
            [['AttendancePercent', 'HomeworkPercent', 'QuestionPercent', 'OtherPercent'], 'integer'],
            [['StaticID', 'TeachingClassID'], 'string', 'max' => 32],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'StaticID' => 'Static ID',
            'AttendancePercent' => 'Attendance Percent',
            'HomeworkPercent' => 'Homework Percent',
            'QuestionPercent' => 'Question Percent',
            'OtherPercent' => 'Other Percent',
            'TeachingClassID' => 'Teaching Class ID',
        ];
    }
}
