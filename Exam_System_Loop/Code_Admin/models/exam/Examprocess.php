<?php

namespace app\models\exam;

use Yii;

/**
 * This is the model class for table "examprocess".
 *
 * @property string $PaperID
 * @property string $QuestionBh
 * @property string $Answer
 * @property string $SubmitTime
 * @property string $Memo
 * @property string $Score
 * @property string $Status
 */
class Examprocess extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'examprocess';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['PaperID', 'QuestionBh'], 'required'],
            [['Answer', 'Memo'], 'string'],
            [['SubmitTime'], 'safe'],
            [['PaperID', 'QuestionBh'], 'string', 'max' => 32],
            [['Score'], 'string', 'max' => 10],
            [['Status'], 'string', 'max' => 2],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'PaperID' => 'Paper ID',
            'QuestionBh' => 'Question Bh',
            'Answer' => 'Answer',
            'SubmitTime' => 'Submit Time',
            'Memo' => 'Memo',
            'Score' => 'Score',
            'Status' => 'Status',
        ];
    }
}
