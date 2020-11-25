<?php

namespace app\models\reservation;

use Yii;

/**
 * This is the model class for table "testroom".
 *
 * @property string $TestRoomBh
 * @property string $TestRoomname
 * @property string $BeginIP
 * @property string $EndIP
 * @property string $SeatTotal
 * @property string $Memo
 */
class Testroom extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'testroom';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['TestRoomBh'], 'required'],
            [['TestRoomBh'], 'string', 'max' => 32],
            [['TestRoomname', 'BeginIP', 'EndIP', 'SeatTotal', 'Memo'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'TestRoomBh' => 'Test Room Bh',
            'TestRoomname' => 'Test Roomname',
            'BeginIP' => 'Begin Ip',
            'EndIP' => 'End Ip',
            'SeatTotal' => 'Seat Total',
            'Memo' => 'Memo',
        ];
    }
}
