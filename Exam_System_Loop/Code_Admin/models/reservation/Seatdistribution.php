<?php

namespace app\models\reservation;

use Yii;

/**
 * This is the model class for table "seatdistribution".
 *
 * @property string $DistributionBh
 * @property string $TestRoomName
 * @property string $SeatName
 * @property string $PersonalPhotos
 * @property string $TestTime
 * @property string $beginTime
 * @property string $EndTime
 * @property string $ICNumber
 * @property string $Memo
 * @property string $SeatBh
 */
class Seatdistribution extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'seatdistribution';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['DistributionBh'], 'required'],
            [['DistributionBh', 'SeatBh'], 'string', 'max' => 32],
            [['TestRoomName', 'SeatName', 'beginTime', 'EndTime'], 'string', 'max' => 50],
            [['PersonalPhotos', 'Memo'], 'string', 'max' => 200],
            [['TestTime'], 'string', 'max' => 100],
            [['ICNumber'], 'string', 'max' => 18],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'DistributionBh' => 'Distribution Bh',
            'TestRoomName' => 'Test Room Name',
            'SeatName' => 'Seat Name',
            'PersonalPhotos' => 'Personal Photos',
            'TestTime' => 'Test Time',
            'beginTime' => 'Begin Time',
            'EndTime' => 'End Time',
            'ICNumber' => 'Icnumber',
            'Memo' => 'Memo',
            'SeatBh' => 'Seat Bh',
        ];
    }
}
