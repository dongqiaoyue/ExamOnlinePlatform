<?php

namespace app\models\teachplan;

use Yii;

/**
 * This is the model class for table "ac".
 *
 * @property string $TeachingClassID
 * @property string $StuNumber
 */
class Ac extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ac';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['TeachingClassID', 'StuNumber'], 'string', 'max' => 32],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'TeachingClassID' => 'Teaching Class ID',
            'StuNumber' => 'Stu Number',
        ];
    }
}
