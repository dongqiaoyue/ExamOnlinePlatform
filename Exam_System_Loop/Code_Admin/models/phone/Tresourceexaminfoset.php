<?php

namespace app\models\phone;

use Yii;

/**
 * This is the model class for table "tresourceexaminfoset".
 *
 * @property string $XH
 * @property string $BH
 * @property string $QuestionType
 * @property integer $QuestionTypeNumber
 * @property double $EveryQuestionScore
 * @property string $difficulty
 * @property string $KonwledgeBh
 * @property string $AddAt
 * @property string $AddBy
 * @property string $AddAgent
 * @property string $AddIP
 */
class Tresourceexaminfoset extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tresourceexaminfoset';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['XH'], 'required'],
            [['QuestionTypeNumber'], 'integer'],
            [['EveryQuestionScore'], 'number'],
            [['AddAt'], 'safe'],
            [['XH', 'BH', 'QuestionType', 'difficulty'], 'string', 'max' => 32],
            [['KnowledgeBh'], 'string', 'max' => 500],
            [['AddBy'], 'string', 'max' => 255],
            [['AddAgent'], 'string', 'max' => 300],
            [['AddIP'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'XH' => 'Xh',
            'BH' => 'Bh',
            'QuestionType' => 'Question Type',
            'QuestionTypeNumber' => 'Question Type Number',
            'EveryQuestionScore' => 'Every Question Score',
            'difficulty' => 'Difficulty',
            'KnowledgeBh' => 'Knowledge Bh',
            'AddAt' => 'Add At',
            'AddBy' => 'Add By',
            'AddAgent' => 'Add Agent',
            'AddIP' => 'Add Ip',
        ];
    }
}
