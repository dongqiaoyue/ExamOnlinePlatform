<?php

namespace app\models\phone;

use Yii;

/**
 * This is the model class for table "tresources".
 *
 * @property string $ID
 * @property string $Name
 * @property string $Type
 * @property string $Description
 * @property string $ResourcesURL
 * @property string $ResourcesContent
 * @property integer $IsExam
 * @property string $CourseID
 * @property string $KnowledgeBh
 * @property string $BeforeID
 * @property integer $IsDeleted
 * @property integer $IsPublish
 * @property string $AddAgent
 * @property string $AddAt
 * @property string $AddBy
 * @property string $AddIP
 * @property string $CustomBh
 * @property string $Stage
 * @property string $Term
 */
class Tresources extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tresources';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID'], 'required'],
            [['ResourcesContent'], 'string'],
            [['IsExam', 'IsDeleted', 'IsPublish'], 'integer'],
            [['AddAt'], 'safe'],
            [['ID', 'Type', 'CourseID', 'BeforeID'], 'string', 'max' => 32],
            [['Name', 'AddBy', 'AddIP'], 'string', 'max' => 100],
            [['Description', 'ResourcesURL', 'AddAgent'], 'string', 'max' => 300],
            [['KnowledgeBh'], 'string', 'max' => 500],
            [['CustomBh'], 'string', 'max' => 50],
            [['Stage', 'Term'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'Name' => 'Name',
            'Type' => 'Type',
            'Description' => 'Description',
            'ResourcesURL' => 'Resources Url',
            'ResourcesContent' => 'Resources Content',
            'IsExam' => 'Is Exam',
            'CourseID' => 'Course ID',
            'KnowledgeBh' => 'Knowledge Bh',
            'BeforeID' => 'Before ID',
            'IsDeleted' => 'Is Deleted',
            'IsPublish' => 'Is Publish',
            'AddAgent' => 'Add Agent',
            'AddAt' => 'Add At',
            'AddBy' => 'Add By',
            'AddIP' => 'Add Ip',
            'CustomBh' => 'Custom Bh',
            'Stage' => 'Stage',
            'Term' => 'Term',
        ];
    }
    public function aaa(){
        $where['CourseID'] = Yii::$app->session->get('courseCode');
        $where['IsPublish'] = '1';
        $data = self::find()->where($where)->all();
        return $data;
    }
    //资源id转资源名
    public function Resources($id){
        $data = self::find()->where(['ID' => $id])->asArray()->one();
        return $data['Name'];
    }
}
