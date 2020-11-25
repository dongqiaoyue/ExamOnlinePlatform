<?php

namespace app\models\teachplan;

use Yii;

/**
 * This is the model class for table "examplandetails".
 *
 * @property integer $ExamPlanDetailsBh
 * @property string $ExamPlanBh
 * @property integer $StedentNum
 */
class ExamPlanDetails extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'examplandetails';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['StedentNum'], 'integer'],
            [['ExamPlanBh'], 'string', 'max' => 32],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ExamPlanDetailsBh' => 'Exam Plan Details Bh',
            'ExamPlanBh' => 'Exam Plan Bh',
            'StedentNum' => 'Stedent Num',
        ];
    }
}
