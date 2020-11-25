<?php

namespace app\models\exam;

use Yii;

/**
 * This is the model class for table "stutest".
 *
 * @property string $StuNumber
 * @property string $QuestionBh
 * @property string $StuName
 * @property string $StuAnswer
 * @property string $SubmitTime
 * @property string $Memo
 * @property string $Score
 * @property string $DetailsID
 */
class Stutest extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'stutest';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['StuNumber', 'QuestionBh'], 'required'],
            [['StuNumber', 'QuestionBh', 'DetailsID'], 'string', 'max' => 32],
            [['StuName'], 'string', 'max' => 200],
            [['StuAnswer'], 'string', 'max' => 8000],
            [['Score'], 'string', 'max' => 100],
            [['Memo'], 'string', 'max' => 500],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'StuNumber' => 'Stu Number',
            'QuestionBh' => 'Question Bh',
            'StuName' => 'Stu Name',
            'StuAnswer' => 'Stu Answer',
            'SubmitTime' => 'Submit Time',
            'Memo' => 'Memo',
            'Score' => 'Score',
            'DetailsID' => 'Details ID',
        ];
    }
}
