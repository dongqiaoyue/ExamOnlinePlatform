<?php

namespace app\models\reservation;

use Yii;

/**
 * This is the model class for table "openconfigure".
 *
 * @property string $ConfigureBh
 * @property string $TestDate
 * @property string $TestCustomBh
 * @property string $TestRoomBh
 * @property string $Memo
 */
class Openconfigure extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'openconfigure';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ConfigureBh'], 'required'],
            [['ConfigureBh', 'TestCustomBh', 'TestRoomBh'], 'string', 'max' => 32],
            [['TestDate'], 'string', 'max' => 50],
            [['Memo'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ConfigureBh' => 'Configure Bh',
            'TestDate' => 'Test Date',
            'TestCustomBh' => 'Test Custom Bh',
            'TestRoomBh' => 'Test Room Bh',
            'Memo' => 'Memo',
        ];
    }
}
