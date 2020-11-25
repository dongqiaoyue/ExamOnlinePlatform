<?php

namespace app\models\question;

use Yii;

/**
 * This is the model class for table "solution".
 *
 * @property integer $solution_id
 * @property integer $problem_id
 * @property string $user_id
 * @property integer $time
 * @property integer $memory
 * @property string $in_date
 * @property integer $result
 * @property integer $language
 * @property string $ip
 * @property integer $contest_id
 * @property integer $valid
 * @property integer $num
 * @property integer $code_length
 * @property string $judgetime
 * @property string $pass_rate
 * @property integer $lint_error
 * @property string $judger
 */
class Solution extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'solution';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['problem_id', 'time', 'memory', 'result', 'language', 'contest_id', 'valid', 'num', 'code_length', 'lint_error'], 'integer'],
            [['user_id', 'ip'], 'required'],
            [['in_date', 'judgetime'], 'safe'],
            [['pass_rate'], 'number'],
            [['user_id'], 'string', 'max' => 48],
            [['ip'], 'string', 'max' => 15],
            [['judger'], 'string', 'max' => 16],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'solution_id' => 'Solution ID',
            'problem_id' => 'Problem ID',
            'user_id' => 'User ID',
            'time' => 'Time',
            'memory' => 'Memory',
            'in_date' => 'In Date',
            'result' => 'Result',
            'language' => 'Language',
            'ip' => 'Ip',
            'contest_id' => 'Contest ID',
            'valid' => 'Valid',
            'num' => 'Num',
            'code_length' => 'Code Length',
            'judgetime' => 'Judgetime',
            'pass_rate' => 'Pass Rate',
            'lint_error' => 'Lint Error',
            'judger' => 'Judger',
        ];
    }
}
