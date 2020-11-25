<?php

namespace app\models\exam;

use Yii;

/**
 * This is the model class for table "stutestrecorddetails".
 *
 * @property string $DetailsID
 * @property string $InTestTime
 * @property string $OutTestTime
 * @property string $TestTimeSpan
 * @property string $Accuracy
 * @property string $Memo
 * @property string $TestRecordID
 * @property string $StuNumber
 * @property string $IPAddress
 * @property string $MacAddress
 * @property string $CourseID
 */
class Stutestrecorddetails extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'stutestrecorddetails';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['DetailsID'], 'required'],
            [['InTestTime', 'OutTestTime'], 'safe'],
            [['DetailsID', 'TestRecordID', 'StuNumber', 'CourseID'], 'string', 'max' => 32],
            [['TestTimeSpan'], 'string', 'max' => 20],
            [['Accuracy'], 'string', 'max' => 5],
            [['Memo'], 'string', 'max' => 100],
            [['IPAddress', 'MacAddress'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'DetailsID' => 'Details ID',
            'InTestTime' => 'In Test Time',
            'OutTestTime' => 'Out Test Time',
            'TestTimeSpan' => 'Test Time Span',
            'Accuracy' => 'Accuracy',
            'Memo' => 'Memo',
            'TestRecordID' => 'Test Record ID',
            'StuNumber' => 'Stu Number',
            'IPAddress' => 'Ipaddress',
            'MacAddress' => 'Mac Address',
            'CourseID' => 'Course ID',
        ];
    }
}
