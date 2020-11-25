<?php

namespace app\models\reservation;

use Yii;

/**
 * This is the model class for table "appointment".
 *
 * @property string $AppointmentBh
 * @property string $beginTime
 * @property string $EndTime
 * @property string $TestDate
 * @property string $SubmitTime
 * @property string $CurrentState
 * @property string $TestRoomBh
 * @property string $StuNumber
 * @property string $ExamPlanBh
 * @property string $Memo
 * @property string $ConfigureBh
 */
class Appointment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'appointment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['AppointmentBh'], 'required'],
            [['AppointmentBh', 'TestRoomBh', 'ExamPlanBh', 'ConfigureBh'], 'string', 'max' => 32],
            [['beginTime', 'EndTime', 'TestDate', 'SubmitTime', 'CurrentState', 'StuNumber'], 'string', 'max' => 50],
            [['Memo'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'AppointmentBh' => 'Appointment Bh',
            'beginTime' => 'Begin Time',
            'EndTime' => 'End Time',
            'TestDate' => 'Test Date',
            'SubmitTime' => 'Submit Time',
            'CurrentState' => 'Current State',
            'TestRoomBh' => 'Test Room Bh',
            'StuNumber' => 'Stu Number',
            'ExamPlanBh' => 'Exam Plan Bh',
            'Memo' => 'Memo',
            'ConfigureBh' => 'Configure Bh',
        ];
    }
}
