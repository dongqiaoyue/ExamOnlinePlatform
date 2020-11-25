<?php

namespace app\models\teachplan;

use Yii;

/**
 * This is the model class for table "examplan".
 *
 * @property string $ExamPlanBh
 * @property string $ExamPlace
 * @property string $ExamPlanName
 * @property string $ExamTime
 * @property string $Weights
 * @property string $IsFixedPlace
 * @property string $IsProcessExam
 * @property integer $NumOfExam
 * @property string $StarTime
 * @property string $EndTime
 * @property string $CourseID
 * @property string $TeachingClassID
 * @property string $AdjustPlacePassword
 * @property string $Memo
 * @property string $LastPlanBh
 * @property string $Term
 * @property string $Department
 * @property string $Type
 * @property string $CreateUser
 * @property double $PassScore
 */
class Examplan extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'examplan';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ExamPlanBh', 'StarTime', 'EndTime'], 'required'],
            [['NumOfExam'], 'integer'],
            [['StarTime', 'EndTime'], 'safe'],
            [['PassScore'], 'number'],
            [['ExamPlanBh', 'CourseID', 'LastPlanBh', 'Type', 'CreateUser'], 'string', 'max' => 32],
            [['ExamPlace', 'ExamPlanName', 'Department'], 'string', 'max' => 100],
            [['ExamTime', 'Term'], 'string', 'max' => 20],
            [['Weights', 'IsFixedPlace'], 'string', 'max' => 10],
            [['IsProcessExam'], 'string', 'max' => 5],
            [['TeachingClassID'], 'string', 'max' => 8000],
            [['AdjustPlacePassword'], 'string', 'max' => 50],
            [['Memo'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ExamPlanBh' => 'Exam Plan Bh',
            'ExamPlace' => 'Exam Place',
            'ExamPlanName' => 'Exam Plan Name',
            'ExamTime' => 'Exam Time',
            'Weights' => 'Weights',
            'IsFixedPlace' => 'Is Fixed Place',
            'IsProcessExam' => 'Is Process Exam',
            'NumOfExam' => 'Num Of Exam',
            'StarTime' => 'Star Time',
            'EndTime' => 'End Time',
            'CourseID' => 'Course ID',
            'TeachingClassID' => 'Teaching Class ID',
            'AdjustPlacePassword' => 'Adjust Place Password',
            'Memo' => 'Memo',
            'LastPlanBh' => 'Last Plan Bh',
            'Term' => 'Term',
            'Department' => 'Department',
            'Type' => 'Type',
            'CreateUser' => 'Create User',
            'PassScore' => 'Pass Score',
        ];
    }
}
