<?php

namespace app\models\teachplan;

use Yii;

/**
 * This is the model class for table "teachingclassmannage".
 *
 * @property string $TeachingClassID
 * @property string $TeacherName
 * @property string $TeachingName
 * @property string $Term
 * @property string $CourseID
 * @property string $Memo
 * @property string $Department
 * @property string $Type
 */
class Teachingclassmannage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'teachingclassmannage';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['TeachingClassID'], 'required'],
            [['TeachingClassID', 'CourseID'], 'string', 'max' => 32],
            [['TeacherName', 'Type'], 'string', 'max' => 50],
            [['TeachingName', 'Department'], 'string', 'max' => 100],
            [['Term'], 'string', 'max' => 20],
            [['Memo'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'TeachingClassID' => 'Teaching Class ID',
            'TeacherName' => 'Teacher Name',
            'TeachingName' => 'Teaching Name',
            'Term' => 'Term',
            'CourseID' => 'Course ID',
            'Memo' => 'Memo',
            'Department' => 'Department',
            'Type' => 'Type',
        ];
    }

    /**
     * 一对多关联Teachingclassdetails
     * @return \yii\db\ActiveQuery
     */
    public function getTeachingcalssdetails(){
        return $this->hasMany(Teachingclassdetails::className(),['TeachingClassID' => 'TeachingClassID']);
    }

}
