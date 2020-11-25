<?php

namespace app\models\question;

use Yii;

/**
 * This is the model class for table "source_code_user".
 *
 * @property integer $solution_id
 * @property string $source
 */
class SourceCodeUser extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'source_code_user';
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
