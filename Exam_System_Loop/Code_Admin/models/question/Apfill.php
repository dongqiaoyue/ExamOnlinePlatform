<?php

namespace app\models\question;

use Yii;

/**
 * This is the model class for table "apfill".
 *
 * @property string $ApfillPosition
 * @property string $QuestionBh
 * @property integer $ReadType
 * @property string $Answer
 * @property double $Proportion
 * @property string $Memo
 * @property integer $answertype
 */
class Apfill extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'apfill';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ApfillPosition', 'QuestionBh'], 'required'],
            [['ReadType', 'answertype'], 'integer'],
            [['Proportion'], 'number'],
            [['ApfillPosition', 'QuestionBh'], 'string', 'max' => 32],
            [['Answer', 'Memo'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ApfillPosition' => 'Apfill Position',
            'QuestionBh' => 'Question Bh',
            'ReadType' => 'Read Type',
            'Answer' => 'Answer',
            'Proportion' => 'Proportion',
            'Memo' => 'Memo',
            'answertype' => 'Answertype',
        ];
    }
}
