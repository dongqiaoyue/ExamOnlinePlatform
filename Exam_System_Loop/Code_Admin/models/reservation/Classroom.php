<?php

namespace app\models\reservation;

use Yii;

/**
 * This is the model class for table "classroom".
 *
 * @property integer $ClassRoomID
 * @property string $IsUsable
 * @property string $ClassName
 * @property string $StartIp
 * @property string $EndIp
 * @property string $Memo
 */
class Classroom extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'classroom';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ClassRoomID'], 'required'],
            [['ClassRoomID'], 'integer'],
            [['IsUsable'], 'string', 'max' => 5],
            [['ClassName', 'StartIp', 'EndIp'], 'string', 'max' => 50],
            [['Memo'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ClassRoomID' => 'Class Room ID',
            'IsUsable' => 'Is Usable',
            'ClassName' => 'Class Name',
            'StartIp' => 'Start Ip',
            'EndIp' => 'End Ip',
            'Memo' => 'Memo',
        ];
    }
}
