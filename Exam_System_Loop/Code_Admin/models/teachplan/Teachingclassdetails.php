<?php

namespace app\models\teachplan;

use app\models\systembase\Studentinfo;
use Yii;

/**
 * This is the model class for table "teachingclassdetails".
 *
 * @property string $TeachingClassDetailsID
 * @property string $TeachingClassID
 * @property string $StuNumber
 */
class Teachingclassdetails extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'teachingclassdetails';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['TeachingClassDetailsID'], 'required'],
            [['TeachingClassDetailsID', 'TeachingClassID'], 'string', 'max' => 32],
            [['StuNumber'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'TeachingClassDetailsID' => 'Teaching Class Details ID',
            'TeachingClassID' => 'Teaching Class ID',
            'StuNumber' => 'Stu Number',
        ];
    }


    /**
     * 与学生信息表建立一对一关联
     * @return \yii\db\ActiveQuery
     */
    public function getStudent(){
        return $this->hasOne(Studentinfo::className(),['StuNumber' => 'StuNumber']);
    }
}
