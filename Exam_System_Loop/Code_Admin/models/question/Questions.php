<?php

namespace app\models\question;

use Yii;

/**
 * This is the model class for table "questions".
 *
 * @property string $QuestionBh
 * @property string $CustomBh
 * @property integer $IsProgramming
 * @property double $Score
 * @property integer $Difficulty
 * @property integer $Chapter
 * @property integer $Stage
 * @property string $Description
 * @property string $QuestionType
 * @property string $name
 * @property string $SourceCode
 * @property string $StartTag
 * @property string $EndTag
 * @property string $AnswerDescript
 * @property string $Answer
 * @property string $KnowledgeBh
 * @property string $Memo
 * @property string $IsProgramBlank
 * @property string $Checked
 * @property string $AddTime
 * @property string $CourseID
 * @property integer $ProblemID
 * @property string $UpdateTime
 */
class Questions extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'questions';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['QuestionBh'], 'required'],
            [['IsProgramming', 'Difficulty', 'Chapter', 'Stage', 'ProblemID'], 'integer'],
            [['Score'], 'number'],
            [['Description', 'SourceCode', 'Answer'], 'string'],
            [['AddTime', 'UpdateTime'], 'safe'],
            [['QuestionBh', 'KnowledgeBh', 'CourseID'], 'string', 'max' => 32],
            [['CustomBh', 'QuestionType', 'StartTag', 'EndTag', 'IsProgramBlank', 'Checked'], 'string', 'max' => 50],
            [['name', 'AnswerDescript'], 'string', 'max' => 1000],
            [['Memo'], 'string', 'max' => 8000],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'QuestionBh' => 'Question Bh',
            'CustomBh' => 'Custom Bh',
            'IsProgramming' => 'Is Programming',
            'Score' => 'Score',
            'Difficulty' => 'Difficulty',
            'Chapter' => 'Chapter',
            'Stage' => 'Stage',
            'Description' => 'Description',
            'QuestionType' => 'Question Type',
            'name' => 'Name',
            'SourceCode' => 'Source Code',
            'StartTag' => 'Start Tag',
            'EndTag' => 'End Tag',
            'AnswerDescript' => 'Answer Descript',
            'Answer' => 'Answer',
            'KnowledgeBh' => 'Knowledge Bh',
            'Memo' => 'Memo',
            'IsProgramBlank' => 'Is Program Blank',
            'Checked' => 'Checked',
            'AddTime' => 'Add Time',
            'CourseID' => 'Course ID',
            'ProblemID' => 'Problem ID',
            'UpdateTime' => 'Update Time',
        ];
    }

    public static function editAll($attributes, $condition = '', $params = [])
    {
        try{

            $node = self::findOne($condition['QuestionBh']);
            unset($attributes['SqlType']);
            unset($attributes['initScript']);
            unset($attributes['JudgeSql']);
            unset($attributes['AnswerResult']);
            unset($attributes['JudgeResult']);
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
