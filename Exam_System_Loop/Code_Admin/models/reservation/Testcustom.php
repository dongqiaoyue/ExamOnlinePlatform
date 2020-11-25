<?php

namespace app\models\reservation;

use Yii;

/**
 * This is the model class for table "testcustom".
 *
 * @property string $TestCustomBh
 * @property string $TestCustomName
 * @property string $BeginTime
 * @property string $EndTime
 * @property string $Memo
 */
class Testcustom extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'testcustom';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['TestCustomBh'], 'required'],
            [['TestCustomBh'], 'string', 'max' => 32],
            [['TestCustomName', 'BeginTime', 'EndTime'], 'string', 'max' => 50],
            [['Memo'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'TestCustomBh' => 'Test Custom Bh',
            'TestCustomName' => 'Test Custom Name',
            'BeginTime' => 'Begin Time',
            'EndTime' => 'End Time',
            'Memo' => 'Memo',
        ];
    }

    public function getTestCustom(){
        return self::find()
            ->select([
                'TestCustomBh',
                'TestCustomName',
                'BeginTime',
                'EndTime',
                'Memo'
            ])->orderBy("TestCustomName ASC")->all();
    }
}
