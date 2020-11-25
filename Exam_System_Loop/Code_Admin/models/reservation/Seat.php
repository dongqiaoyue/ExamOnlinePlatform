<?php

namespace app\models\reservation;

use Yii;

/**
 * This is the model class for table "seat".
 *
 * @property string $SeatBh
 * @property string $SeatIP
 * @property string $SeatMAC
 * @property string $SeatAlias
 * @property string $Memo
 * @property string $TestRoomBh
 */
class Seat extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'seat';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['SeatBh'], 'required'],
            [['SeatBh', 'SeatAlias', 'TestRoomBh'], 'string', 'max' => 32],
            [['SeatIP', 'SeatMAC'], 'string', 'max' => 50],
            [['Memo'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'SeatBh' => 'Seat Bh',
            'SeatIP' => 'Seat Ip',
            'SeatMAC' => 'Seat Mac',
            'SeatAlias' => 'Seat Alias',
            'Memo' => 'Memo',
            'TestRoomBh' => 'Test Room Bh',
        ];
    }
}
