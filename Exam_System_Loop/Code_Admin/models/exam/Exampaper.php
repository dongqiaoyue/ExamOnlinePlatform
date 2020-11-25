<?php

namespace app\models\exam;

use Yii;

/**
 * This is the model class for table "exampaper".
 *
 * @property string $PaperID
 * @property string $StuName
 * @property string $StudentID
 * @property string $Score
 * @property string $GeneralTime
 * @property string $PaperName
 * @property string $EXamPaperAddType
 * @property string $ExamBeginTime
 * @property string $ExamEndTime
 * @property string $DealState
 * @property string $MachineIP
 * @property string $BrowserVision
 * @property string $MACAddress
 * @property string $Memo
 * @property string $ExamPlanBh
 * @property string $SetPaperName
 * @property string $SubmitStage
 * @property string $TeachingClassID
 * @property string $ExamException
 * @property string $PaperBh
 */
class Exampaper extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'exampaper';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['PaperID'], 'required'],
            [['ExamBeginTime'], 'safe'],
            [['PaperID', 'PaperName', 'ExamPlanBh', 'TeachingClassID', 'PaperBh'], 'string', 'max' => 32],
            [['StuName', 'GeneralTime', 'ExamEndTime', 'BrowserVision', 'SetPaperName'], 'string', 'max' => 100],
            [['StudentID', 'DealState', 'MachineIP', 'MACAddress', 'ExamException'], 'string', 'max' => 50],
            [['Score', 'SubmitStage'], 'string', 'max' => 10],
            [['EXamPaperAddType'], 'string', 'max' => 20],
            [['Memo'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'PaperID' => 'Paper ID',
            'StuName' => 'Stu Name',
            'StudentID' => 'Student ID',
            'Score' => 'Score',
            'GeneralTime' => 'General Time',
            'PaperName' => 'Paper Name',
            'EXamPaperAddType' => 'Exam Paper Add Type',
            'ExamBeginTime' => 'Exam Begin Time',
            'ExamEndTime' => 'Exam End Time',
            'DealState' => 'Deal State',
            'MachineIP' => 'Machine Ip',
            'BrowserVision' => 'Browser Vision',
            'MACAddress' => 'Macaddress',
            'Memo' => 'Memo',
            'ExamPlanBh' => 'Exam Plan Bh',
            'SetPaperName' => 'Set Paper Name',
            'SubmitStage' => 'Submit Stage',
            'TeachingClassID' => 'Teaching Class ID',
            'ExamException' => 'Exam Exception',
            'PaperBh' => 'Paper Bh',
        ];
    }
}
