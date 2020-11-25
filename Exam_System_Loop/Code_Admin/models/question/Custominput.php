<?php

namespace app\models\question;

use Yii;

/**
 * This is the model class for table "custominput".
 *
 * @property integer $solution_id
 * @property string $input_text
 */
class Custominput extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'custominput';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['solution_id'], 'required'],
            [['solution_id'], 'integer'],
            [['input_text'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'solution_id' => 'Solution ID',
            'input_text' => 'Input Text',
        ];
    }
}
