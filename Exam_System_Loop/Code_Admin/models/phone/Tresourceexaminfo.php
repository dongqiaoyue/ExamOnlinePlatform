<?php

namespace app\models\phone;

use Yii;

/**
 * This is the model class for table "tresourceexaminfo".
 *
 * @property string $BH
 * @property string $PaperName
 * @property string $ResourcesID
 * @property string $AddAgent
 * @property string $AddAt
 * @property string $AddBy
 * @property string $AddIP
 * @property string $CourseID
 */
class Tresourceexaminfo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tresourceexaminfo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['BH'], 'required'],
            [['AddAt'], 'safe'],
            [['BH', 'ResourcesID', 'CourseID'], 'string', 'max' => 32],
            [['PaperName', 'AddBy'], 'string', 'max' => 200],
            [['AddAgent'], 'string', 'max' => 300],
            [['AddIP'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'BH' => 'Bh',
            'PaperName' => 'Paper Name',
            'ResourcesID' => 'Resources ID',
            'AddAgent' => 'Add Agent',
            'AddAt' => 'Add At',
            'AddBy' => 'Add By',
            'AddIP' => 'Add Ip',
            'CourseID' => 'Course ID',
        ];
    }

    public function Check($id){
        $data = self::find()->where(['ResourcesID' => $id])->asArray()->one();
        return $data;
    }
}
