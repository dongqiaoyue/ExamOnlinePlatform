<?php

namespace app\models\reservation;

use Yii;

/**
 * This is the model class for table "classroomdetails".
 *
 * @property string $ClassRoomDetailsID
 * @property string $IPAddress
 * @property string $MACAddress
 * @property integer $ClassRoomID
 */
class Classroomdetails extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'classroomdetails';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ClassRoomDetailsID'], 'required'],
            [['ClassRoomID'], 'integer'],
            [['ClassRoomDetailsID'], 'string', 'max' => 32],
            [['IPAddress'], 'string', 'max' => 20],
            [['MACAddress'], 'string', 'max' => 30],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ClassRoomDetailsID' => 'Class Room Details ID',
            'IPAddress' => 'Ipaddress',
            'MACAddress' => 'Macaddress',
            'ClassRoomID' => 'Class Room ID',
        ];
    }
}
