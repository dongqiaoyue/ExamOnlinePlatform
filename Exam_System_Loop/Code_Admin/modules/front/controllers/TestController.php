<?php
namespace app\modules\front\controllers;

use app\models\question\Knowledgepoint;
use app\models\question\Questions;
use app\models\question\FindError;
use app\models\system\TbcuitmoonDictionary;
use app\models\exam\Stutestrecorddetails;
use app\models\exam\Stutest;
use app\models\systembase\Studentinfo;
use common\commonFuc;
use app\models\question\Solution;
use app\models\question\SourceCode;
use app\models\question\SourceCodeUser;
use app\models\question\Runtimeinfo;
use app\models\question\Compileinfo;
use app\models\question\Problem;
use app\models\teachplan\Teachingclassdetails;
use app\models\teachplan\Teachingclassmannage;
use app\models\question\Apfill;
use Yii;
use yii\helpers\Url;
use yii\rbac\Item;

class TestController extends BaselimitController
{
    public $enableCsrfValidation=false;
    public function actionIndex()
    {
        return $this->render('index');
    }


    public function actionLeft()
    {
        $this->layout = "//paper";
        $m_dic = new TbcuitmoonDictionary();
        $m_know = new Knowledgepoint();
        // TbcuitmoonDictionary::find()->select('CuitMoon_DictionaryName','CuitMoon_DictionaryName')
        // ->where()
        $course = [];
        $Info = [];
        $Tmp = [];
        $allTeach = Teachingclassdetails::find()->select('TeachingClassID')->where(['StuNumber'=>\Yii::$app->session->get('StudentNum')])->asArray()->all();
        foreach ($allTeach as $key => $value) {
            $course[] = Teachingclassmannage::find()->where(['TeachingClassID'=>$value['TeachingClassID']])->asArray()->one()['CourseID'];
        }
        $course = array_unique($course);

        foreach($course as $key => $value){
            $Info[] = TbcuitmoonDictionary::find()->where(['CuitMoon_DictionaryCode'=>$value,'CuitMoon_DictionaryRemarks'=>'10005001'])->one();
        }

        $Stage = $m_dic->getDictionaryList('题目阶段');
        foreach ($Info as $item) {
            foreach ($Stage as $va) {
                $Tmp[$item["CuitMoon_DictionaryName"]][$va["CuitMoon_DictionaryName"]] =
                    $m_know->find()->where([
                        'Stage' => $va["CuitMoon_DictionaryCode"],
                        'CourseID' => $item["CuitMoon_DictionaryCode"]
                    ])->asArray()->all();
            }
        }
        return $this->render('left',[
            'list' => $Tmp
        ]);
    }

    public function actionQuestions()
    {
        $this->layout = "//paper";
        $Tmp = [];
        $m_question = new Questions();
        $m_dic = new TbcuitmoonDictionary();

        $Data = Yii::$app->request->get();
        $couresname = $Data['course'];

        $courseCode = TbcuitmoonDictionary::find()->where([
            'CuitMoon_DictionaryName' => $Data['course'],
        ])->asArray()->one()['CuitMoon_DictionaryCode'];
        \Yii::$app->session->set('courseCode',$courseCode);
        $stageCode = $m_dic->find()->where([
            'CuitMoon_DictionaryName' => $Data['stage'],
        ])->asArray()->one()['CuitMoon_DictionaryCode'];
        $where = [
            'CourseID' => $courseCode,
            'KnowledgeBh' => $Data['know'],
            'Stage' => $stageCode,
            'Checked' => '100001',
            'Score'=>'1'
        ];
        $StuNumber = \Yii::$app->session->get('StudentNum');
        $Type = $m_question->find()->select(['QuestionType'])->where($where)->groupBy('QuestionType')->asArray()->all();
        foreach ($Type as $item) {
            $m_question = new Questions();
            $where['QuestionType'] = $item['QuestionType'];
            $Tmp[$item['QuestionType']] = $m_question->find()->where($where)->asArray()->all();
            foreach ($Tmp[$item['QuestionType']] as $key => $value) {
                $answer = Stutest::find()->select(['StuAnswer','Score'])->where(['StuNumber'=>$StuNumber,'QuestionBh'=>$value['QuestionBh']])->asArray()->one();
                $Tmp[$item['QuestionType']][$key]['StuAnswer'] = $answer['StuAnswer'];
                $Tmp[$item['QuestionType']][$key]['AnswerScore'] = $answer['Score'];
            }

            foreach ($Tmp[$item['QuestionType']] as $key => $value) {
                $Tmp[$item['QuestionType']][$key]['SourceCode'] = json_decode($value['SourceCode'],true);
                $Tmp[$item['QuestionType']][$key]['file'] = [];
                $path = $_SERVER['DOCUMENT_ROOT'].'/QuestionFile/'.$value['QuestionBh'].'/';
                if(is_dir($path))
                {
                    $handler = opendir($path);
                    $url_path = Url::to("@web/QuestionFile/".$value['QuestionBh'].'/', true);
                    $i = 0;
                    while( ($filename = readdir($handler)) !== false )
                    {
                        if($filename != "." && $filename != "..")
                        {
                            $Tmp[$item['QuestionType']][$key]['file'][$filename] = $url_path.$filename;
                            // $Tmp[$item['QuestionType']][$key]['file'][$i]['file_url'] = ;F
                        }
                    }
                    closedir($handler);
                }



            }
        }
        // print_r($Tmp);
        return $this->render('question.php',[
            'info' => $Tmp,
            'type' => $where,
            'couresname'=>$couresname,
        ]);
    }
    //填空题答案
    public function actionGetFillAnswer()
    {
        if(\Yii::$app->request->isPost)
        {
            $post = \Yii::$app->request->post();
            if(isset($post['QuestionBh']) && $post['QuestionBh'])
                echo json_encode(Apfill::find()->select(['Answer'])->where(['QuestionBh'=>$post['QuestionBh']])->asArray()->all());
        }
    }
    //改错题答案
    public function actionGetCorrectAnswer()
    {
         if(\Yii::$app->request->isPost)
        {
            $post = \Yii::$app->request->post();
            if(isset($post['QuestionBh']) && $post['QuestionBh'])
            {

                $res = FindError::find()->select(['ErrorCount','Content','Answer'])->where(['QuestionBh'=>$post['QuestionBh']])->asArray()->all();
                foreach ($res as $key => $value) {
                    $res[$key]['Answer'] = json_decode($res[$key]['Answer'],true)['key'];
                }
                echo json_encode($res);
            }

        }
    }
    //添加练习信息
    public function actionAddTestInfo()
    {
        if(\Yii::$app->request->isPost)
        {
            $post = \Yii::$app->request->post();
            $StuNumber = \Yii::$app->session->get('StudentNum');
            $aim = '';
            $StuDetailHis = '';
            if(isset($post['QuestionBh']) && $post['QuestionBh'])
            {
                $CourseID = Questions::find()->where(['QuestionBh'=>$post['QuestionBh']])->asArray()->one()['CourseID'];
                $com = new commonFuc();
                $StuDetailHis = Stutestrecorddetails::find()->where(['StuNumber'=>$StuNumber,'CourseID'=>$CourseID])->orderBy('InTestTime DESC')->asArray()->one();

                if($StuDetailHis == null || (strtotime(date('Y-m-d H:i:s')) - strtotime($StuDetailHis['InTestTime'])) >= 60*20)
                {
                    $isExist = Stutest::find()->where(['StuNumber'=>$StuNumber,'QuestionBh'=>$post['QuestionBh']])->one();
                    if($isExist)
                    {
                        $isExist['StuAnswer'] = $post['StuAnswer'];
                        $isExist['Score'] = $post['Score'];
                        $isExist['SubmitTime'] = date('Y-m-d H:i:s');
                        $isExist->save();
                    }
                    else
                    {
                        $NewDetail = new Stutestrecorddetails();
                        $NewDetail['DetailsID'] = $com->create_id();
                        $NewDetail['InTestTime'] = date('Y-m-d H:i:s');
                        $NewDetail['StuNumber'] = $StuNumber;
                        $NewDetail['IPAddress'] = $com->getClientIp();

                        $NewDetail['CourseID'] = $CourseID;
                        if($NewDetail->save())
                        {
                            $new = new Stutest();
                            $new['StuNumber'] = $StuNumber;
                            $new['QuestionBh'] = $post['QuestionBh'];
                            $new['StuName'] = Studentinfo::find()->where(['StuNumber'=>$StuNumber])->asArray()->one()['Name'];
                            $new['StuAnswer'] = $post['StuAnswer'];
                            $new['SubmitTime'] = date('Y-m-d H:i:s');
                            $new['Score'] = $post['Score'];
                            $new['DetailsID'] = $NewDetail['DetailsID'];
                            $new->save();
                        }
                    }
                }
                else if($StuDetailHis && (strtotime(date('Y-m-d H:i:s')) - strtotime($StuDetailHis['InTestTime'])) < 60*20)
                {
                    $aim = Stutest::find()->where(['QuestionBh'=>$post['QuestionBh'],'StuNumber'=>$StuNumber])->one();

                    if($aim)
                    {
                       $aim['StuAnswer'] = $post['StuAnswer'];
                       $aim['SubmitTime'] = date('Y-m-d H:i:s');
                       $aim['Score'] = $post['Score'];
                       $aim->save();
                       echo "has";

                    }
                    else
                    {

                        $detail = new Stutest();
                        $detail['DetailsID'] = $StuDetailHis['DetailsID'];
                        $detail['StuNumber'] = $StuNumber;
                        $detail['QuestionBh'] = $post['QuestionBh'];
                        $detail['StuName'] = Studentinfo::find()->where(['StuNumber'=>$StuNumber])->asArray()->one()['Name'];
                        $detail['Score'] = $post['Score'];
                        $detail['StuAnswer'] = $post['StuAnswer'];
                        $detail['SubmitTime'] = date('Y-m-d H:i:s');
                        $detail->save();
                    }
                }
            }

        }
    }

    public function actionCode()
    {
        $temp= TbcuitmoonDictionary::find()->select("CuitMoon_DictionaryID")->where(['CuitMoon_DictionaryCode'=>'1000700'])->asArray()->one()['CuitMoon_DictionaryID'];
        $compiler = TbcuitmoonDictionary::find()->select("CuitMoon_DictionaryCode,CuitMoon_DictionaryName")->where(['CuitMoon_ParentDictionaryID'=>$temp])
        /*->andWhere("CuitMoon_DictionaryName not in (8,11,12,15,16,17)")*/->asArray()->all();
        return $this->render('code',['compiler'=>$compiler]);
    }
    public function actionRun()
    {
    //   $not = [8,11,12,15,16,17];
    //   if(in_array(\Yii::$app->session->get('compiler'),$not))
    //   {
    //     echo "暂不支持该编译器";
    //     die;
    //   }

      $com = new commonFuc();
      $input_text = stripcslashes(Yii::$app->request->post('input_text'));
      $code = Yii::$app->request->post('code');
      $input_text = preg_replace("(\r\n)","\n",$input_text);
      $ID = $com->create_id();
      $m_problem = new Problem();


      $m_problem->title = $ID;
      $m_problem->in_date = date("Y-m-d H:i:s");
      $m_problem->time_limit = 10;
      $m_problem->memory_limit = 512;
      $m_problem->defunct = 'N';


      $m_problem->save();
      //获取对应的problem id
      $ProblemId = $m_problem->attributes['problem_id'];


      $path =  "/home/judge/data";
//                $path = __DIR__ . '/../../../Question_TestCase';
      $com->mkData($ProblemId, 'test.in', $input_text, $path);
      // $this->mkData($ProblemId, 'test.out', $value->TestCaseOutput, $path);
    //  $x = shell_exec("cp ".$_SERVER['DOCUMENT_ROOT']."/QuestionFile/".$ID."/* /home/judge/data/".$ProblemId);

      // var_dump($x);
      // $value->Memo = (string)$ProblemId;
      // $value->save();


      $m_solution = new Solution();
      $m_source = new SourceCode();
      $m_source_user = new SourceCodeUser();
      $m_run_info = new Runtimeinfo();
      $m_compile = new Compileinfo();

      $m_solution->problem_id = $ProblemId;
      $m_solution->user_id = \Yii::$app->session->get('StudentNum');
      $m_solution->judger = 'admin';
      $m_solution->in_date = date("Y-m-d H:i:s");
      $m_solution->language = \Yii::$app->session->get('compiler');
      $m_solution->code_length = strlen($code);
      $m_solution->ip = $com->getClientIp();
      $m_solution->save();
      $SolutionID = $m_solution->attributes['solution_id'];


      $m_source->solution_id = $SolutionID;
      $m_source->source = $code;
      $m_source_user->solution_id = $SolutionID;
      $m_source_user->source = $code;

      $m_source->save();
      $m_source_user->save();





      //sleep($Time);
      $result = 0;
      $time = 0;
      //Poll Table solution until compilation is complete
      while($result != 11 && $result != 13){
          if( $result == 7 || $time > 10)
          {
            echo "编译超时";
            die;
          }
          $result = $m_solution->find()->select(['result'])
              ->where([
                  'solution_id' => $SolutionID,
              ])->asArray()->one();
          $result = $result['result'];
          //Compile successful
          if($result ==  13 || $result ==  10 || $result == 9) {
              $Tmp = $m_run_info->find()->select(['error'])
                  ->where([
                      'solution_id' => $SolutionID,
                  ])->asArray()->one();
              echo $Tmp['error'];
              die;
          }
          //Compile failed
          if($result == 11){
              $Tmp = $m_compile->find()->select(['error'])
                  ->where([
                      'solution_id' => $SolutionID,
                  ])->asArray()->one();
              echo $Tmp['error'];
              die;
          }
          sleep(1);
          $time++;
      }
    }
    public function actionChangeCompiler()
    {
      if(\Yii::$app->request->isPost)
      {
          $post = \Yii::$app->request->post();
          if(isset($post['compiler']))
          {
              \Yii::$app->session->set('compiler',$post['compiler']);
              echo "设置成功";
          }
      }
    }
}
