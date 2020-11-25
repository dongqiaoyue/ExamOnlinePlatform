<?php

namespace app\models\systemdata;

use Yii;

/**
 * This is the model class for table "developerinfo".
 *
 * @property string $DeveloperID
 * @property string $DeveloperName
 * @property string $DeveloperIcon
 * @property string $Sex
 * @property integer $Grade
 * @property string $BetterAspect
 * @property string $DoneProject
 * @property string $QQ
 * @property string $Motto
 * @property string $Memo
 * @property string $BirthDay
 * @property string $ContactTell
 * @property string $Emails
 * @property string $ClassName
 * @property string $StudyOfWork
 * @property string $TheHonour
 */
class Developerinfo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'developerinfo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['DeveloperID'], 'required'],
            [['Grade'], 'integer'],
            [['BirthDay'], 'safe'],
            [['DeveloperID'], 'string', 'max' => 36],
            [['DeveloperName', 'ContactTell', 'Emails'], 'string', 'max' => 50],
            [['DeveloperIcon', 'Motto'], 'string', 'max' => 500],
            [['Sex'], 'string', 'max' => 10],
            [['BetterAspect', 'Memo', 'StudyOfWork', 'TheHonour'], 'string', 'max' => 1000],
            [['DoneProject'], 'string', 'max' => 2000],
            [['QQ'], 'string', 'max' => 20],
            [['ClassName'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'DeveloperID' => 'Developer ID',
            'DeveloperName' => 'Developer Name',
            'DeveloperIcon' => 'Developer Icon',
            'Sex' => 'Sex',
            'Grade' => 'Grade',
            'BetterAspect' => 'Better Aspect',
            'DoneProject' => 'Done Project',
            'QQ' => 'Qq',
            'Motto' => 'Motto',
            'Memo' => 'Memo',
            'BirthDay' => 'Birth Day',
            'ContactTell' => 'Contact Tell',
            'Emails' => 'Emails',
            'ClassName' => 'Class Name',
            'StudyOfWork' => 'Study Of Work',
            'TheHonour' => 'The Honour',
        ];
    }
}
