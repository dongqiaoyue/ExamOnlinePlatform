<?php

namespace app\models\question;

use Yii;

/**
 * This is the model class for table "problem".
 *
 * @property integer $problem_id
 * @property string $title
 * @property string $description
 * @property string $input
 * @property string $output
 * @property string $sample_input
 * @property string $sample_output
 * @property string $spj
 * @property string $hint
 * @property string $source
 * @property string $in_date
 * @property integer $time_limit
 * @property integer $memory_limit
 * @property string $defunct
 * @property integer $accepted
 * @property integer $submit
 * @property integer $solved
 */
class Problem extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'problem';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['description', 'input', 'output', 'sample_input', 'sample_output', 'hint'], 'string'],
            [['in_date'], 'safe'],
            [['time_limit', 'memory_limit', 'accepted', 'submit', 'solved'], 'integer'],
            [['title'], 'string', 'max' => 200],
            [['spj', 'defunct'], 'string', 'max' => 1],
            [['source'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'problem_id' => 'Problem ID',
            'title' => 'Title',
            'description' => 'Description',
            'input' => 'Input',
            'output' => 'Output',
            'sample_input' => 'Sample Input',
            'sample_output' => 'Sample Output',
            'spj' => 'Spj',
            'hint' => 'Hint',
            'source' => 'Source',
            'in_date' => 'In Date',
            'time_limit' => 'Time Limit',
            'memory_limit' => 'Memory Limit',
            'defunct' => 'Defunct',
            'accepted' => 'Accepted',
            'submit' => 'Submit',
            'solved' => 'Solved',
        ];
    }
}
