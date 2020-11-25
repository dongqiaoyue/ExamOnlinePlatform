<?php

namespace app\models\question;

use Yii;

/**
 * This is the model class for table "compileinfo".
 *
 * @property integer $solution_id
 * @property string $error
 */
class Compileinfo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'compileinfo';
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
