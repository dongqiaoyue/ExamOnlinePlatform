<?php

namespace app\models\phone;

use Yii;

/**
 * This is the model class for table "tresourceexamrecord".
 *
 * @property string $PaperBH
 * @property string $StuID
 * @property string $StuName
 * @property string $ResourcesID
 * @property string $StTime
 * @property string $EndTime
 * @property string $PZXH
 * @property double $score
 * @property integer $status
 * @property string $AddAgent
 * @property string $AddAt
 * @property string $AddBy
 * @property string $AddIP
 */
class Tresourceexamrecord extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tresourceexamrecord';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['PaperBH'], 'required'],
            [['StTime', 'EndTime', 'AddAt'], 'safe'],
            [['score'], 'number'],
            [['status'], 'integer'],
            [['PaperBH', 'ResourcesID', 'PZXH'], 'string', 'max' => 32],
            [['StuID', 'StuName'], 'string', 'max' => 50],
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
            'PaperBH' => 'Paper Bh',
            'StuID' => 'Stu ID',
            'StuName' => 'Stu Name',
            'ResourcesID' => 'Resources ID',
            'StTime' => 'St Time',
            'EndTime' => 'End Time',
            'PZXH' => 'Pzxh',
            'score' => 'Score',
            'status' => 'Status',
            'AddAgent' => 'Add Agent',
            'AddAt' => 'Add At',
            'AddBy' => 'Add By',
            'AddIP' => 'Add Ip',
        ];
    }
}
