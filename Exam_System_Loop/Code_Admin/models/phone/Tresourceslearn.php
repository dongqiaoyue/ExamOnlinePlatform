<?php

namespace app\models\phone;

use Yii;

/**
 * This is the model class for table "tresourceslearn".
 *
 * @property string $ID
 * @property string $StuID
 * @property string $ResourcesID
 * @property string $StTime
 * @property string $EdTime
 * @property double $Score
 * @property string $ScoreTime
 * @property string $ResourcesStatus
 * @property integer $ScoreCount
 * @property string $AddAgent
 * @property string $AddAt
 * @property string $AddBy
 * @property string $AddIP
 */
class Tresourceslearn extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tresourceslearn';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID'], 'required'],
            [['StTime', 'EdTime', 'ScoreTime', 'ScoreCount', 'AddAt', 'AddBy'], 'integer'],
            [['Score'], 'number'],
            [['ID', 'ResourcesID', 'ResourcesStatus'], 'string', 'max' => 32],
            [['StuID'], 'string', 'max' => 50],
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
            'ID' => 'ID',
            'StuID' => 'Stu ID',
            'ResourcesID' => 'Resources ID',
            'StTime' => 'St Time',
            'EdTime' => 'Ed Time',
            'Score' => 'Score',
            'ScoreTime' => 'Score Time',
            'ResourcesStatus' => 'Resources Status',
            'ScoreCount' => 'Score Count',
            'AddAgent' => 'Add Agent',
            'AddAt' => 'Add At',
            'AddBy' => 'Add By',
            'AddIP' => 'Add Ip',
        ];
    }

    public function findScore($StuNumber,$list)
    {
        $a = [];
        foreach ($list as $key => $value){
            $data = self::find()->select(['Score', 'ResourcesStatus'])->where(['ResourcesID' => $value['ID'],'StuID' => $StuNumber])->asArray()->orderBy('ResourcesID DESC')->one();
            $a[] = $data;
        };
        return $a;
    }

    public function findByID($ID,$id)
    {
        $data = [];
        $data = self::find()->where(['ResourcesID' => $ID,'StuID' => $id])->asArray()->one();
        return $data;
    }
}
