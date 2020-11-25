<?php

namespace app\models\question;

use Yii;

/**
 * This is the model class for table "runtimeinfo".
 *
 * @property integer $solution_id
 * @property string $error
 */
class Runtimeinfo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'runtimeinfo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['solution_id'], 'required'],
            [['solution_id'], 'integer'],
            [['error'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'solution_id' => 'Solution ID',
            'error' => 'Error',
        ];
    }
}
