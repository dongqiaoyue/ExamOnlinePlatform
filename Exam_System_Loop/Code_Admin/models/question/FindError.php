<?php

namespace app\models\question;

use Yii;

/**
 * This is the model class for table "FindError".
 *
 * @property string $QuestionBh
 * @property integer $ErrorCount
 * @property string $ErrorStartTag
 * @property string $ErrorEndTag
 * @property string $Content
 * @property string $Answer
 * @property double $Proportion
 * @property string $Memo
 */
class FindError extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'finderror';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['QuestionBh', 'ErrorCount'], 'required'],
            [['ErrorCount'], 'integer'],
            [['Content'], 'string'],
            [['Proportion'], 'number'],
            [['QuestionBh'], 'string', 'max' => 32],
            [['ErrorStartTag', 'ErrorEndTag'], 'string', 'max' => 50],
            [['Answer'], 'string', 'max' => 8000],
            [['Memo'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'QuestionBh' => 'Question Bh',
            'ErrorCount' => 'Error Count',
            'ErrorStartTag' => 'Error Start Tag',
            'ErrorEndTag' => 'Error End Tag',
            'Content' => 'Content',
            'Answer' => 'Answer',
            'Proportion' => 'Proportion',
            'Memo' => 'Memo',
        ];
    }
}
