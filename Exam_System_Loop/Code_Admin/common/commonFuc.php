<?php
namespace common;

use app\models\exam\Createpaper;
use app\models\exam\Examprocess;
use app\models\exam\Exampaper;
use app\models\question\Problem;
use app\models\question\Questions;
use app\models\question\Solution;
use app\models\question\SourceCode;
use app\models\question\SourceCodeUser;
use app\models\question\Testcase;
use app\models\system\TbcuitmoonDictionary;
use app\models\teachplan\Examplan;
use yii\data\Pagination;
use app\models\redismod\SolutionRedis;
use app\models\redismod\ProblemRedis;
// use redisFunc;

use yii\helpers\Url;

class commonFuc{


    /**
     * 生成32位guid唯一标识
     * 所有id都用这个生成
     * @return string
     */
    function create_id() {
        $charid = strtoupper(md5(uniqid(mt_rand(), true)));
        $hyphen = chr(45);
        $uuid =
            substr($charid, 0, 8)
            .substr($charid, 8, 4)
            .substr($charid,12, 4)
            .substr($charid,16, 4)
            .substr($charid,20,12)
        ;
        return $uuid;
    }

    /**
     * 操作成功
     * 返回常规msg Josn格式
     * @param $msg 需要返回的信息
     */
    function JsonSuccess($msg){
        $msg = array('error' => 0,'msg' => $msg);
        echo json_encode($msg);
    }

    /**
     * @param $msg
     * 失败时返回
     */
    function JsonFail($msg){
        $msg = array('error' => 2,'msg' => $msg);
        echo json_encode($msg);
    }



    /**
     * 获取客户端IP
     * @return string 返回ip地址,如127.0.0.1
     */
    function getClientIp()
    {
        $onlineip = 'Unknown';
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        {
            $ips = explode(",", $_SERVER['HTTP_X_FORWARDED_FOR']);
            $real_ip = $ips['0'];
            if ($_SERVER['HTTP_X_FORWARDED_FOR'] && preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $real_ip))
            {
                $onlineip = $real_ip;
            }
            elseif ($_SERVER['HTTP_CLIENT_IP'] && preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER['HTTP_CLIENT_IP']))
            {
                $onlineip = $_SERVER['HTTP_CLIENT_IP'];
            }
        }
        if ($onlineip == 'Unknown' && isset($_SERVER['HTTP_CDN_SRC_IP']) && preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER['HTTP_CDN_SRC_IP']))
        {
            $onlineip = $_SERVER['HTTP_CDN_SRC_IP'];
            $c_agentip = 0;
        }
        if ($onlineip == 'Unknown' && isset($_SERVER['HTTP_NS_IP']) && preg_match ( '/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER ['HTTP_NS_IP'] ))
        {
            $onlineip = $_SERVER ['HTTP_NS_IP'];
            $c_agentip = 0;
        }
        if ($onlineip == 'Unknown' && isset($_SERVER['REMOTE_ADDR']) && preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER['REMOTE_ADDR']))
        {
            $onlineip = $_SERVER['REMOTE_ADDR'];
            $c_agentip = 0;
        }
        return $onlineip;
//        return $_SERVER['HTTP_X_REAL_IP'];
    }


    /**
     * 获取当前学期
     * @return string 返回学期,如2018-2019第1学期
     */
    function getNowTerm(){
        $now_term = '';
        $month = date("m");
        if(1<$month && $month<8){
            $now_term=(date("Y") - 1).'-'.date("Y").'第2学期';
        }else if(7 < $month && $month <=12){
            $now_term=date("Y").'-'.(date("Y") + 1).'第1学期';
        }else if(0 < $month && $month <2){
            $now_term=(date("Y") -1).'-'.date("Y").'第1学期';
        }
        return $now_term;
    }


    /**
     * 将字典中的code转换为名字
     * @param $code
     * @return mixed
     */
    public function codeTranName($code){
        $m_dic = new TbcuitmoonDictionary();
        $value = $m_dic->find()->select('CuitMoon_DictionaryName')->where([
            'CuitMoon_DictionaryCode' => $code,
        ])->asArray()->one();
        return $value['CuitMoon_DictionaryName'];
    }


    /**
     * @param $name
     * @return mixed
     */
    public function nameTranCode($name){
        $m_dic = new TbcuitmoonDictionary();
        $value = $m_dic->find()->select('CuitMoon_DictionaryCode')->where([
            'CuitMoon_DictionaryName' => $name,
        ])->asArray()->one();
        return $value['CuitMoon_DictionaryCode'];
    }


    /**
     * 分页插件
     * 参数为一个model对象
     * 返回分页对象,具体查看Yii分页插件
     * @param $model
     * @return Pagination
     */
    public function Tab($model){
        $pages = new Pagination([
            'totalCount' => $model->count(),
            'pageSize' => '15',
            'pageParam' => 'page',
            'pageSizeParam' => 'per-page',

        ]);
        return $pages;
    }


    /*
   * 写入测试用例
   */
    // $ProblemId, 'test.in', $value->TestCaseInput, $path
    function mkData($pid,$filename,$input,$OJ_DATA){

        $basedir = "$OJ_DATA/$pid";

        if(!file_exists($basedir)) {
            mkdir($basedir);
        }

        $fp = @fopen ( $basedir . "/$filename", "w" );
        if($fp){
            fputs ( $fp, preg_replace ( "(\r\n)", "\n", $input ) );
            fclose ( $fp );
        }else{
            echo "Error while opening".$basedir . "/$filename ,try [chgrp -R www-data $OJ_DATA] and [chmod -R 771 $OJ_DATA ] ";

        }
    }


    /**
     * @param $ID       题号
     * @param $Code     代码
     * @param $Time     等待时间 一般为10s
     * @return int|string
     * 在线编译 返回百分比格式
     */
    function Compile($ID,$Code,$Time)
    {
        $m_test_case = new Testcase();
        $m_question = new Questions();
        $redisFun = new redisFunc();
//        $exam_process = new Examprocess();
//        $m_create_paper = new Createpaper();
//        $exam_paper = new Exampaper();
        $redis = \Yii::$app->redis;
        //查找当前编译的题目
        $Question = $m_question->find()->where([
            'QuestionBh' => $ID
        ])->one();
        if($Question->IsProgramBlank == '100001')
        {
            $start = $Question->StartTag;
            // $end  = addcslashes($Question->EndTag,'*');
            $end = $Question->EndTag;
            $code = json_decode($Question->SourceCode,true)['key']['0']['code'];
            $preg = '\''.$start.'[\D]*'.$end.'\'';
            $tmp = $Code;

            $tmp = str_replace($start,'^',$tmp);
            $tmp = str_replace($end,'`',$tmp);
            $code = str_replace($start,'^',$code);
            $code = str_replace($end,'`',$code);
            $ansArr =  explode('`',$tmp);
            $codeArr = explode('`',$code);
            $i = 0;
            $ignore = ["\r\n","\r","\n","\t"];
            foreach ($ansArr as $key => $value) {
                $check = explode('^',$value);
                $check1 = explode('^',$codeArr[$key]);
                if(trim(str_replace($ignore, "", $check1[0])) != trim(str_replace($ignore, "", $check[0])))
                {
                    $i = 1;
                    break;
                }
            }
            if($i == 1)
            {
                echo json_encode("请勿修改start--end之外的代码");
                die;
            }

        }
        //$Bh = PaperID  $ID = QuestionBh
        //查询学生当下的该题成绩
//        $m_score = $exam_process->find()->where([
//            'QuestionBh' => $ID,
//            'PaperID' => $Bh
//        ])->asArray()->one()['Score'];
//        //$PaperBh对应答案内的  $PaperID对应学生内的
//        $PaperBh = $exam_paper->find()->where([
//            'PaperID' => $Bh
//        ])->asArray()->one()['PaperBh'];
//        //通过$paperBh查询该题总分值
//        $realScore = $m_create_paper->find()->where([
//            'QuestionBh' => $ID,
//            'PaperBh' => $PaperBh
//        ])->asArray()->one()['TotalScore'];
//        //通过该题总分值和学生成绩进行比较
//        if(isset($m_score) && $m_score == $realScore) {
//            $Score = $m_score;
//        }else {
            //查找所有测试用例
            $TestCase = $m_test_case->find()->select(['TestCaseBh', 'ScoreWeight', 'TestCaseInput', 'TestCaseOutput', 'Memo'])
                ->where(['QuestionId' => $ID])->all();
            $Problems = [];
            if ($Question->ProblemID == null) {
                //遍历测试用例
                foreach ($TestCase as $value) {
                    // 新建一个problem 保存到redis
                    $ProblemId = $redisFun->saveProblemToRedis($ID);

                    $path = "/home/judge/data";
                    $this->mkData($ProblemId, 'test.in', $value->TestCaseInput, $path);
                    $this->mkData($ProblemId, 'test.out', $value->TestCaseOutput, $path);
                    $x = shell_exec("cp " . $_SERVER['DOCUMENT_ROOT'] . "/QuestionFile/" . $ID . "/* /home/judge/data/" . $ProblemId);
                    $value->save();

                    $Problems[$ProblemId] = $value->ScoreWeight;
                }

                $Question->ProblemID = 0;
                $Question->update();

            } else {
                foreach ($TestCase as $value) {
                    $Problems[$value->Memo] = $value->ScoreWeight;
                }
            }

            if (count($Problems) > 0) {
                foreach ($Problems as $key => $item) {

                    // 新建与problem一一对应的solution 保存redis
                    $SolutionID = $redisFun->saveSolutionToRedis($Code, $key);
                    $Solutions[$SolutionID] = $item;
                }
            }


            sleep($Time);
            $Score = 0;

            foreach ($Solutions as $key => $item) {
                $Result = SolutionRedis::findOne($key);
                switch ((int)$Result->result) {
                    case 4:
                        $Score = $Score + $item;
                        break;
                    case 11:
                        return json_encode('编译失败');
                        exit();
                        // die;
                        break;
                    default:
                        $Score = $Score + 0;
                        break;
                }
            }
//        }
        echo $Score;
    }

    public function Compilex($ID,$Code,$Time)
    {
        $m_test_case = new Testcase();
        $m_question = new Questions();
        //查找当前编译的题目
        $Question = $m_question->findOne([
            'QuestionBh' => $ID
        ]);
        //查找所有测试用例
        $TestCase = $m_test_case->find()->select(['TestCaseBh','ScoreWeight','TestCaseInput','TestCaseOutput','Memo'])
            ->where(['QuestionId' => $ID])->all();
        $Problems = [];
        if ($Question->ProblemID == null) {
            //遍历测试用例
            foreach ($TestCase as $value) {
                //新建一个problem
                $m_problem = new Problem();
                $m_problem->title = $ID;
                $m_problem->in_date = date("Y-m-d H:i:s");
                $m_problem->time_limit = 1;
                $m_problem->memory_limit = 128;
                $m_problem->defunct = 'N';


                $m_problem->save();
                //获取对应的problem id
                $ProblemId = $m_problem->attributes['problem_id'];


                $path =  "/home/judge/data";
//                $path = __DIR__ . '/../../../Question_TestCase';
                $this->mkData($ProblemId, 'test.in', $value->TestCaseInput, $path);
                $this->mkData($ProblemId, 'test.out', $value->TestCaseOutput, $path);
                $x = shell_exec("cp ".$_SERVER['DOCUMENT_ROOT']."/QuestionFile/".$ID."/* /home/judge/data/".$ProblemId);

                // var_dump($x);
                // $value->Memo = (string)$ProblemId;
                $value->save();

                $Problems[$ProblemId] = $value->ScoreWeight;
            }

            $Question->ProblemID = 0;
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
                $m_solution->language = self::nameTranCode(\Yii::$app->session->get('courseCode'));
                $m_solution->code_length = strlen($Code);
                $m_solution->ip = $this->getClientIp();
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
                    return json_encode('编译失败');
                    exit();
                    // die;
                    break;
                default:
                    $Score = $Score + 0;
                    break;
            }
        }
        return $Score;
    }
    /**
     * @param $PaperBh
     * @return mixed
     */
    function GetPaper($PaperBh)
    {
        $m_create_paper = new Createpaper();
        $Data = [];
        $QuestionTypes = $m_create_paper->find()->select(['Memo'])
            ->where([
                'PaperBh' => $PaperBh,
            ])->groupBy(['Memo'])->asArray()->all();//查找试卷所有类型
        foreach ($QuestionTypes as $item) {
            $Tmp = $m_create_paper->find()->where([
                'PaperBh' => $PaperBh,
                'Memo' => $item['Memo'],
            ])->all();
            foreach ($Tmp as $value) {
                $TmpData = $value->question;
                $TmpData['Score'] = $value->TotalScore;
                $Tmp_Data[] = $TmpData;
            }
            $Data[$item['Memo']] = $Tmp_Data;
            unset($Tmp_Data);
        }

        return $Data;

    }


    /**
     * @param $Data
     * @param $ExamPlanBh
     * function Save Paper Answer
     */
    function SavePaper($Data,$ExamPlanBh)
    {
        foreach ($Data as $key=>$item) {
            $m_exam_process = new Examprocess();
            $m_question = new Questions();

            $Tmp = $m_exam_process->findOne([
                'PaperID' => $ExamPlanBh,
                'QuestionBh' => (string)$key,
            ]);
            $QuestionType = Questions::find()->where([
                'QuestionBh' => (string)$key,
            ])->asArray()->one()['QuestionType'];
            switch ($QuestionType) {
                case 100020102:
                    $item = implode("|",$item);
                    break;
                case 1000204:
                case 1000208:
                    $Tmp_Data = null;
                    foreach ($item as $value) {
                        $Tmp_Data = $Tmp_Data.$value.'@';
                    }
                    $item = $Tmp_Data;
                    break;
                default:
                    break;
            }

            if ($Tmp) {
                $Tmp->PaperID = $ExamPlanBh;
                $Tmp->QuestionBh = (string)$key;
                $Tmp->Answer = $item;
                $Tmp->SubmitTime = date('Y-m-d H:i:s');
                $Tmp->Memo = (string)$QuestionType;
                $Tmp->update();
            }else{
                $m_exam_process->PaperID = $ExamPlanBh;
                $m_exam_process->QuestionBh = (string)$key;
                $m_exam_process->Answer = $item;
                $m_exam_process->Memo = (string)$QuestionType;
                $m_exam_process->SubmitTime = date('Y-m-d H:i:s');
                $m_exam_process->save();
            }
        }
    }

}
/*

class redisFunc {

    function saveSolutionToRedis($code, $ProblemId) {
        $redis = \Yii::$app->redis;
        $com = new CommonFuc();

        // 获得solutionId 并自增
        $redis->setnx("solutionCounter", 1);
        $solution_id = (int)$redis->get('solutionCounter');
        $redis->incr('solutionCounter');

        // 维护solutionList列表用于judged获取任务
        $redis->lpush('solutionList', $solution_id);

        // 保存solution
        $solution_redis = new SolutionRedis();
        $solution_redis->solution_id = $solution_id;
        $solution_redis->time = 0;
        $solution_redis->judger = 'admin';
        $solution_redis->pass_rate = 0;
        $solution_redis->language = (int)$com->nameTranCode(\Yii::$app->session->get('courseCode'));
        $solution_redis->result = 0;
        $solution_redis->memory = 0;
        $solution_redis->user_id = 'admin';
        $solution_redis->problem_id = $ProblemId;
        $solution_redis->source_code = $code;
        $solution_redis->runtime_info = '';
        $solution_redis->compile_info = '';
        $solution_redis->save();

        return $solution_id;
    }

    function saveProblemToRedis($ID) {
        $redis = \Yii::$app->redis;
        // 获得ProblemId 并自增
        $redis->setnx("problemCounter", 1);
        $ProblemId = (int)$redis->get('problemCounter');
        $redis->incr('problemCounter');

        // 保存problem
        $problem_redis = new ProblemRedis();
        $problem_redis->problem_id = $ProblemId;
        $problem_redis->title = $ID;
        $problem_redis->spj = '0';
        $problem_redis->time_limit = 10;
        $problem_redis->memory_limit = 512;
        $problem_redis->save();

        return $ProblemId;
    }

}
*/
