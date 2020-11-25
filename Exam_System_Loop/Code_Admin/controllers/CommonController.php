<?php
namespace app\controllers;

use app\models\question\Problem;
use app\models\question\Questions;
use app\models\question\Solution;
use app\models\question\SourceCode;
use app\models\question\SourceCodeUser;
use app\models\question\Testcase;
use app\models\teachplan\Examplan;
use app\models\teachplan\Teachingclassmannage;
use common\commonFuc;
use yii\web\Controller;
use Yii;

class CommonController extends Controller
{

    public $enableCsrfValidation=false;


    public function actionIndex()
    {

    }

    public function Compile($ID,$Code,$Time)
    {
        $m_test_case = new Testcase();
        $m_question = new Questions();
        $com = new commonFuc();

        $Question = $m_question->findOne([
            'QuestionBh' => $ID
        ]);

        $TestCase = $m_test_case->find()->select(['TestCaseBh','ScoreWeight','TestCaseInput','TestCaseOutput','Memo'])
            ->where(['QuestionId' => $ID])->all();

        if ($Question->ProblemID == null) {

            foreach ($TestCase as $value) {
                $m_problem = new Problem();
                $m_problem->title = $ID;
                $m_problem->in_date = date("Y-m-d H:i:s");
                $m_problem->time_limit = 1;
                $m_problem->memory_limit = 128;
                $m_problem->defunct = 'N';
                $m_problem->save();
                $ProblemId = $m_problem->attributes['problem_id'];

                $path =  "/home/judge/data";
//                $path = __DIR__ . '/../../../Question_TestCase';
                $com->mkData($ProblemId, 'test.in', $value->TestCaseInput, $path);
                $com->mkData($ProblemId, 'test.out', $value->TestCaseOutput, $path);


                $value->Memo = (string)$ProblemId;
                $value->save();

                $Problems[$ProblemId] = $value->ScoreWeight;
            }

            $Question->ProblemID = 1;
            $Question->update();

        } else {
            foreach ($TestCase as $value) {
                $Problems[$value->Memo] = $value->ScoreWeight;
            }
        }

        if (count($Problems) > 0) {
            foreach ($Problems as $key=>$item) {
                $m_solution = new Solution();
                $m_source = new SourceCode();
                $m_source_user = new SourceCodeUser();

                $m_solution->problem_id = $key;
                $m_solution->user_id = 'admin';
                $m_solution->in_date = date("Y-m-d H:i:s");
                $m_solution->language = 0;
                $m_solution->code_length = strlen($Code);
                $m_solution->ip = $com->getClientIp();
                $m_solution->save();
                $SolutionID = $m_solution->attributes['solution_id'];

                $Solutions[$SolutionID] = $item;

                $m_source->solution_id = $SolutionID;
                $m_source->source = $Code;
                $m_source_user->solution_id = $SolutionID;
                $m_source_user->source = $Code;

                $m_source->save();
                $m_source_user->save();
            }
        }



        sleep($Time);
        $Score = 0;
        foreach ($Solutions as $key=>$item) {
//                sleep(1);
            $Result = $m_solution->findOne(['solution_id'=> $key]);
//            sleep(1);
            switch ($Result->result) {
                case 4:
                    $Score = $Score + $item;
                    break;
                case 11:
                    echo json_encode('编译失败');
                    exit();
                    break;
                default:
                    $Score = $Score + 0;
                    break;
            }
        }
        return $Score;
    }

    /**
     * 在线编译 返回百分比分数
     * 已post方式提交   需要提交参数格式
     * id = 题号ID
//     * Bh = PaperID
     * code = 需要编译的代码
     */
    public function actionCompile()
    {
        $com = new commonFuc();

        $Info = Yii::$app->request->post();
//        if(isset($Info['Bh']))
//            $Bh = $Info['Bh'];
//        else
//            $Bh = '';

        echo $com->Compile($Info['id'],$Info['code'],5);
    }


    /**
     * 根据学期获取考试计划
     * get请求  参数
     * term = 学期
     * type = 0或者1  (0代表返回每场期末考试,1代表返回期末考试总计划)
     * 返回Json格式
     */
    public function actionGetExamPlan()
    {
        $m_exam_plan = new Examplan();

        $Term = Yii::$app->request->get('term');
        $Type = Yii::$app->request->get('type');
        $UserID = Yii::$app->user->getId();
        $courseCode = Yii::$app->session->get('courseCode');

        $List_One = $m_exam_plan->find()->where([
            'and',
            "CourseID='$courseCode'","Term='$Term'","Type!='1'","CreateUser='$UserID'"
        ])->orderBy("StarTime DESC")->asArray()->all();
        if ($Type == 0) {
            $List_Two = $m_exam_plan->find()->where([
                'and',
                "Type='1'","TeachingClassID!=''","Term='$Term'","CreateUser='$UserID'",
            ])->orWhere("CreateUser in (select ExamPlanBh from `examplan` where CourseID='$courseCode' and Term='$Term')")->orderBy("StarTime DESC") ->asArray()->all();
        } else {
            $List_Two = $m_exam_plan->find()->where([
                'and',
                "Type='1'","TeachingClassID=''","Term='$Term'",
            ])->andWhere(['CourseID'=>$courseCode])->orderBy("StarTime DESC") ->asArray()->all();
        }

        $List = array_merge($List_One, $List_Two);
        echo json_encode($List);
    }


    /**
     * 根据考试计划获取考试班级
     * 检测是否期末考试
     * get请求  需要提交的参数
     * teach = 考试计划ID
     * 返回Json格式
     */
    public function actionGetClass()
    {
        $m_exam_plan = new Examplan();
        $com = new commonFuc();
        $m_teaching_class = new Teachingclassmannage();

        $Tmp = $m_exam_plan->findOne([
            'ExamPlanBh' => Yii::$app->request->get('teach'),
        ]);
        if ($Tmp->TeachingClassID) {
            $Data = [];
            $Tmp = explode('|',$Tmp->TeachingClassID);
        } else {
            $Tmp = explode('|',$Tmp->Memo);
        }
        foreach ($Tmp as $key=>$value) {
            $Data[$key]['ID'] = $value;
            $Tmp_Name = $m_teaching_class->findOne([
                'TeachingClassID' => $value,
            ]);
            $Data[$key]['ClassName'] = $Tmp_Name->TeachingName;
        }
        $com->JsonSuccess($Data);
    }
}
