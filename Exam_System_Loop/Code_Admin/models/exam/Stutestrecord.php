<?php

namespace app\models\exam;

use Yii;

/**
 * This is the model class for table "stutestrecord".
 *
 * @property string $TestRecordID
 * @property string $StuNumber
 * @property string $StuName
 * @property string $TeachingClassID
 * @property string $Memo
 */
class Stutestrecord extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'stutestrecord';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['TestRecordID', 'StuNumber'], 'required'],
            [['TestRecordID', 'StuNumber', 'TeachingClassID'], 'string', 'max' => 32],
            [['StuName', 'Memo'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'TestRecordID' => 'Test Record ID',
            'StuNumber' => 'Stu Number',
            'StuName' => 'Stu Name',
            'TeachingClassID' => 'Teaching Class ID',
            'Memo' => 'Memo',
        ];
    }
}
