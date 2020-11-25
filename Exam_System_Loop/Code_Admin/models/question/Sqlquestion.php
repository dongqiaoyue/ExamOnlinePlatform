<?php

namespace app\models\question;

use Yii;

/**
 * This is the model class for table "sqlquestion".
 *
 * @property string $sql_question_id
 * @property string $question_bh
 * @property string $init_sql
 * @property string $answer_sql
 * @property string $answer_result
 * @property string $judge_sql
 * @property string $judge_result
 * @property string $score
 * @property string $sql_type
 * @property string $remark
 */
class Sqlquestion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sqlquestion';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sql_question_id'], 'required'],
            [['init_sql', 'answer_sql', 'answer_result', 'judge_sql', 'judge_result', 'score'], 'string'],
            [['sql_question_id', 'question_bh'], 'string', 'max' => 32],
            [['sql_type'], 'string', 'max' => 50],
            [['remark'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'sql_question_id' => 'Sql Question ID',
            'question_bh' => 'Question Bh',
            'init_sql' => 'Init Sql',
            'answer_sql' => 'Answer Sql',
            'answer_result' => 'Answer Result',
            'judge_sql' => 'Judge Sql',
            'judge_result' => 'Judge Result',
            'score' => 'Sconnnre',
            'sql_type' => 'Sql Type',
            'remark' => 'Remark',
        ];
    }

    public static function editAll($attributes, $condition = '', $params = [])
    {
        try{

            $node = self::findOne(['question_bh' => $condition['QuestionBh']]);
            $node->attributes = $attributes;

            if(false === $node->save()){
                return false;
            }
        }catch (\Exception $e){

            return false;
        }

        return true;

    }
}
