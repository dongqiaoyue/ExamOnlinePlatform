<?php

namespace app\models\exam;

use Yii;

/**
 * This is the model class for table "paper".
 *
 * @property string $PaperBh
 * @property string $CreateTime
 * @property integer $PaperName
 * @property string $Memo
 * @property string $ExamPlanBh
 */
class Paper extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'paper';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['CreateTime'], 'safe'],
            // [['PaperName'], 'integer'],
            [['PaperBh', 'ExamPlanBh'], 'string', 'max' => 32],
            [['Memo'], 'string', 'max' => 200],
            [['PaperName'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'PaperBh' => 'Paper Bh',
            'CreateTime' => 'Create Time',
            'PaperName' => 'Paper Name',
            'Memo' => 'Memo',
            'ExamPlanBh' => 'Exam Plan Bh',
        ];
    }
}
