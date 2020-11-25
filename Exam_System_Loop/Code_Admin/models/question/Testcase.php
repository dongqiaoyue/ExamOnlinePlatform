<?php

namespace app\models\question;

use Yii;

/**
 * This is the model class for table "testcase".
 *
 * @property string $TestCaseBh
 * @property double $ScoreWeight
 * @property string $TestCaseInput
 * @property string $TestCaseOutput
 * @property string $TestCaseTips
 * @property string $QuestionId
 * @property string $Memo
 */
class Testcase extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'testcase';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['TestCaseBh'], 'required'],
            [['ScoreWeight'], 'number'],
            [['TestCaseBh', 'QuestionId'], 'string', 'max' => 32],
            [['TestCaseInput', 'TestCaseOutput', 'Memo'], 'string', 'max' => 3000],
            [['TestCaseTips'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'TestCaseBh' => 'Test Case Bh',
            'ScoreWeight' => 'Score Weight',
            'TestCaseInput' => 'Test Case Input',
            'TestCaseOutput' => 'Test Case Output',
            'TestCaseTips' => 'Test Case Tips',
            'QuestionId' => 'Question ID',
            'Memo' => 'Memo',
        ];
    }
}

