<?php

namespace app\models\phone;

use Yii;

/**
 * This is the model class for table "tresourcesreplyqa".
 *
 * @property string $ID
 * @property string $QaID
 * @property string $content
 * @property string $AttchaURL
 * @property string $AddAgent
 * @property string $AddAt
 * @property string $AddBy
 * @property string $AddIP
 */
class Tresourcesreplyqa extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tresourcesreplyqa';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID'], 'required'],
            [['AddAt'], 'safe'],
            [['ID', 'QaID'], 'string', 'max' => 32],
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
            'QaID' => 'Qa ID',
            'content' => 'Content',
            'AttchaURL' => 'Attcha Url',
            'AddAgent' => 'Add Agent',
            'AddAt' => 'Add At',
            'AddBy' => 'Add By',
            'AddIP' => 'Add Ip',
        ];
    }
}
