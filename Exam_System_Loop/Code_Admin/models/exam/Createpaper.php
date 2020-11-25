<?php

namespace app\models\exam;

use app\models\question\Questions;
use Yii;

/**
 * This is the model class for table "createpaper".
 *
 * @property string $PaperBh
 * @property string $QuestionBh
 * @property string $TotalScore
 * @property string $Memo
 */
class Createpaper extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'createpaper';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['PaperBh', 'QuestionBh'], 'required'],
            [['Memo'], 'string'],
            [['PaperBh', 'QuestionBh', 'TotalScore'], 'string', 'max' => 32],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'PaperBh' => 'Paper Bh',
            'QuestionBh' => 'Question Bh',
            'TotalScore' => 'Total Score',
            'Memo' => 'Memo',
        ];
    }


    public function getQuestion()
    {
        return $this->hasOne(Questions::className(),['QuestionBh'=>'QuestionBh'])
            ->asArray();
    }
}
