<?php

namespace app\models\phone;

use Yii;

/**
 * This is the model class for table "tresourcesqa".
 *
 * @property string $ID
 * @property string $StuID
 * @property string $ResourcesID
 * @property string $content
 * @property string $AttchaURL
 * @property string $Status
 * @property integer $IsPublish
 * @property integer $IsTOP
 * @property string $AddAgent
 * @property string $AddAt
 * @property string $AddBy
 * @property string $AddIP
 */
class Tresourcesqa extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tresourcesqa';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID'], 'required'],
            [['IsPublish', 'IsTOP'], 'integer'],
            [['AddAt'], 'safe'],
            [['ID', 'ResourcesID', 'Status'], 'string', 'max' => 32],
            [['StuID'], 'string', 'max' => 50],
            [['content', 'AttchaURL'], 'string', 'max' => 1000],
            [['AddAgent'], 'string', 'max' => 300],
            [['AddBy', 'AddIP'], 'string', 'max' => 100],
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
            'content' => 'Content',
            'AttchaURL' => 'Attcha Url',
            'Status' => 'Status',
            'IsPublish' => 'Is Publish',
            'IsTOP' => 'Is Top',
            'AddAgent' => 'Add Agent',
            'AddAt' => 'Add At',
            'AddBy' => 'Add By',
            'AddIP' => 'Add Ip',
        ];
    }

    public function Change($id){
        $data = self::find()->where(['ID' => $id])->one();
        $data->Status = '1000805';
        $data->save();
    }

}
