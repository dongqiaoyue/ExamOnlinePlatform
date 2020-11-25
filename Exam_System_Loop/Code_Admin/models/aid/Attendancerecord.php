<?php

namespace app\models\aid;

use Yii;

/**
 * This is the model class for table "attendancerecord".
 *
 * @property string $AttendaceRecordID
 * @property string $StudentName
 * @property string $StudentNum
 * @property string $AttendanceDate
 * @property integer $Score
 * @property string $AttendanceState
 * @property string $TeachClass
 */
class Attendancerecord extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'attendancerecord';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['AttendaceRecordID'], 'required'],
            [['AttendanceDate'], 'safe'],
            [['Score'], 'integer'],
            [['AttendaceRecordID', 'TeachClass'], 'string', 'max' => 32],
            [['StudentName', 'AttendanceState'], 'string', 'max' => 20],
            [['StudentNum'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'AttendaceRecordID' => 'Attendace Record ID',
            'StudentName' => 'Student Name',
            'StudentNum' => 'Student Num',
            'AttendanceDate' => 'Attendance Date',
            'Score' => 'Score',
            'AttendanceState' => 'Attendance State',
            'TeachClass' => 'Teach Class',
        ];
    }
}
