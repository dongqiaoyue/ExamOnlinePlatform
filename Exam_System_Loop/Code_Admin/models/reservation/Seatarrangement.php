<?php

namespace app\models\reservation;

use Yii;

/**
 * This is the model class for table "seatarrangement".
 *
 * @property string $SeatArrangementID
 * @property string $StuNumber
 * @property string $SeatNumber
 * @property string $IPAddress
 * @property string $ICNumber
 * @property string $Memo
 * @property integer $ClassRoomID
 * @property string $ExamPlanBh
 */
class Seatarrangement extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'seatarrangement';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['SeatArrangementID'], 'required'],
            [['ClassRoomID'], 'integer'],
            [['SeatArrangementID'], 'string', 'max' => 15],
            [['StuNumber'], 'string', 'max' => 50],
            [['SeatNumber'], 'string', 'max' => 10],
            [['IPAddress'], 'string', 'max' => 20],
            [['ICNumber'], 'string', 'max' => 18],
            [['Memo'], 'string', 'max' => 200],
            [['ExamPlanBh'], 'string', 'max' => 32],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'SeatArrangementID' => 'Seat Arrangement ID',
            'StuNumber' => 'Stu Number',
            'SeatNumber' => 'Seat Number',
            'IPAddress' => 'Ipaddress',
            'ICNumber' => 'Icnumber',
            'Memo' => 'Memo',
            'ClassRoomID' => 'Class Room ID',
            'ExamPlanBh' => 'Exam Plan Bh',
        ];
    }
}
