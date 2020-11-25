<?php

namespace app\models\question;

use Yii;

/**
 * This is the model class for table "source_code".
 *
 * @property integer $solution_id
 * @property string $source
 */
class SourceCode extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'source_code';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['solution_id', 'source'], 'required'],
            [['solution_id'], 'integer'],
            [['source'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'solution_id' => 'Solution ID',
            'source' => 'Source',
        ];
    }
}
