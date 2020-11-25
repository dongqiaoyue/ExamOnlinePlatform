<?php

namespace app\models\aid;

use Yii;

/**
 * This is the model class for table "commonhomework".
 *
 * @property string $HomeworkID
 * @property string $TeacherName
 * @property string $TeachClass
 * @property string $HomeworkName
 * @property string $WorkDesc
 * @property string $WorkURL
 * @property integer $WorkScore
 * @property string $DeadTime
 * @property string $IsStuSee
 * @property string $Memo
 */
class Commonhomework extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'commonhomework';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['HomeworkID'], 'required'],
            [['WorkScore'], 'integer'],
            [['DeadTime'], 'safe'],
            [['HomeworkID', 'TeachClass'], 'string', 'max' => 32],
            [['TeacherName'], 'string', 'max' => 20],
            [['HomeworkName'], 'string', 'max' => 50],
            [['WorkDesc'], 'string', 'max' => 2000],
            [['WorkURL'], 'string', 'max' => 500],
            [['IsStuSee'], 'string', 'max' => 10],
            [['Memo'], 'string', 'max' => 300],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'HomeworkID' => 'Homework ID',
            'TeacherName' => 'Teacher Name',
            'TeachClass' => 'Teach Class',
            'HomeworkName' => 'Homework Name',
            'WorkDesc' => 'Work Desc',
            'WorkURL' => 'Work Url',
            'WorkScore' => 'Work Score',
            'DeadTime' => 'Dead Time',
            'IsStuSee' => 'Is Stu See',
            'Memo' => 'Memo',
        ];
    }
}
