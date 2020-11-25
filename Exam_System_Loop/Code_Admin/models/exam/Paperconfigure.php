<?php

namespace app\models\exam;

use Yii;
use app\models\exam\Examconfigrecord;

/**
 * This is the model class for table "paperconfigure".
 *
 * @property string $PaperConfigureID
 * @property string $QuestionType
 * @property integer $QuestionTypeNumber
 * @property string $EveryQuestionSocre
 * @property string $difficulty
 * @property string $stage
 * @property string $Memo
 * @property string $ExamPlanBh
 * @property string $ExamConfigRecordID
 */
class Paperconfigure extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'paperconfigure';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['PaperConfigureID'], 'required'],
            [['QuestionTypeNumber'], 'integer'],
            [['PaperConfigureID', 'ExamPlanBh', 'ExamConfigRecordID'], 'string', 'max' => 32],
            [['QuestionType'], 'string', 'max' => 20],
            [['EveryQuestionSocre', 'difficulty'], 'string', 'max' => 10],
            [['stage'], 'string', 'max' => 100],
            [['Memo'], 'string', 'max' => 500],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'PaperConfigureID' => 'Paper Configure ID',
            'QuestionType' => 'Question Type',
            'QuestionTypeNumber' => 'Question Type Number',
            'EveryQuestionSocre' => 'Every Question Socre',
            'difficulty' => 'Difficulty',
            'stage' => 'Stage',
            'Memo' => 'Memo',
            'ExamPlanBh' => 'Exam Plan Bh',
            'ExamConfigRecordID' => 'Exam Config Record ID',
        ];
    }


    /**
     * 判断计划是否已经配置考试模块,如果已经配置返回模块名称
     * @param $ExamPlanBh
     * @return bool
     */
    public function isExamModule($ExamPlanBh){
        $Tmp = self::findOne([
            'ExamPlanBh' => $ExamPlanBh,
        ]);
        if(isset($Tmp)){
            $m_examModule = new Examconfigrecord();
            $Tmp_One = $m_examModule->findOne([
                'ExamConfigRecordID' => $Tmp['ExamConfigRecordID'],
            ]);
            return $Tmp_One;
        }else{
            return false;
        }
    }
}
