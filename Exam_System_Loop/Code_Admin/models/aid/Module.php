<?php

namespace app\models\aid;

use Yii;

/**
 * This is the model class for table "module".
 *
 * @property string $ModuleID
 * @property string $ModuleName
 * @property integer $ModulePercent
 * @property string $TeachingClassID
 */
class Module extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'module';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ModuleID'], 'required'],
            [['ModulePercent'], 'integer'],
            [['ModuleID', 'TeachingClassID'], 'string', 'max' => 32],
            [['ModuleName'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ModuleID' => 'Module ID',
            'ModuleName' => 'Module Name',
            'ModulePercent' => 'Module Percent',
            'TeachingClassID' => 'Teaching Class ID',
        ];
    }
}
