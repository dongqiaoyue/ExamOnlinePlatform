<?php

namespace app\models\question;

use Yii;

/**
 * This is the model class for table "knowledgepoint".
 *
 * @property string $KnowledgeBh
 * @property integer $Bh
 * @property string $Description
 * @property string $KnowledgeName
 * @property integer $Chapter
 * @property integer $Stage
 * @property string $Memo
 * @property string $CourseID
 */
class Knowledgepoint extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'knowledgepoint';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['KnowledgeBh'], 'required'],
            [['Bh', 'Chapter', 'Stage'], 'integer'],
            [['KnowledgeBh', 'CourseID'], 'string', 'max' => 32],
            [['Description'], 'string', 'max' => 1000],
            [['KnowledgeName'], 'string', 'max' => 50],
            [['Memo'], 'string', 'max' => 500],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'KnowledgeBh' => 'Knowledge Bh',
            'Bh' => 'Bh',
            'Description' => 'Description',
            'KnowledgeName' => 'Knowledge Name',
            'Chapter' => 'Chapter',
            'Stage' => 'Stage',
            'Memo' => 'Memo',
            'CourseID' => 'Course ID',
        ];
    }


    /**
     * 返回所属阶段知识点
     * @param $stage
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getByStage($stage){
        return self::find()
            ->select([
                'KnowledgeBh',
                'KnowledgeName',
            ])->where([
                'Stage' => $stage,
                'CourseID' => Yii::$app->session->get('courseCode'),
            ])->asArray()->all();
    }


    public function idTranName($id){
        $Tmp = self::find()->select(['KnowledgeName'])
            ->where(['KnowledgeBh' => $id])->asArray()->one();
        return $Tmp['KnowledgeName'];
    }
}
