<?php

namespace app\models\aid;

use Yii;

/**
 * This is the model class for table "gradescoreset".
 *
 * @property string $SetID
 * @property string $GradeName
 * @property integer $Score
 * @property string $TeachingClassID
 */
class Gradescoreset extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'gradescoreset';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['SetID'], 'required'],
            [['Score'], 'integer'],
            [['SetID', 'TeachingClassID'], 'string', 'max' => 32],
            [['GradeName'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'SetID' => 'Set ID',
            'GradeName' => 'Grade Name',
            'Score' => 'Score',
            'TeachingClassID' => 'Teaching Class ID',
        ];
    }
}
