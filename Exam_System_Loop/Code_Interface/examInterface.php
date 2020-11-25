<?php
require_once 'Common/function.php';
require_once 'Model/examModel.php';
//require_once 'sql_server.php';
$basic_path = "/home/judge/data";
$common = new common();
$examModel = new exam();
//$sqlServer = new sql_server();
$data = $_POST['info'];
$data = json_decode($data,true);

//有几个测试用例创建几个问题
//$Tmp_Test = $sqlServer->selectTestCase($data['id']);
$Tmp_Test = $data['test'];
foreach ($Tmp_Test as $key=>$value){
    //创建Problem
    $Problem = array(
        'title' => $data['id'],
        'in_date' => date('Y-m-d H:i:s'),
        'time_limit' => 1,
        'memory_limit' => 128,
        'defunct' => 'N',
    );
//    print_r($Problem);
    if($problem_id = $examModel->insertProblem($Problem)){
        $common->mkData($problem_id,'test.in',$value['TestCaseInput'],$basic_path);
        $common->mkData($problem_id,'test.out',$value['TestCaseOutput'],$basic_path);

        //创建编译记录
        $solution = array(
            'problem_id' => $problem_id,
            'user_id' => 'admin',
            'in_date' => date('Y-m-d H:i:s'),
            'language' => 0,
            'code_length' => strlen($data['code'])
        );
        if($solution_id = $examModel->insertSolution($solution)){
            $source = array(
                'solution_id' => $solution_id,
                'source' => addslashes($data['code']),
            );
            $solution_score[$key]['solution_id'] = $solution_id;
            $solution_score[$key]['score'] = $value['ScoreWeight'];
            //插入代码
            if(!$examModel->insertCode($source)){
                echo '更新代码'.$solution_id.'失败';
            }
        }else{
            echo '创建编译记录'.$solution_id.'失败';
        }
    }else{
        echo  '创建问题'.$problem_id.'失败';
    }
}

//10秒后查询是否编译完成
//sleep(10);
//sleep(2);
$Tmp = 0;
while ($Tmp<5){
    foreach ($solution_score as $key => $value){
        $Score = 0;
        $Tmp_score = $examModel->selectResult($value['solution_id']);
        switch ($Tmp_score){
            case 0:
                $Tmp = 0;
                //sleep(3);
                break;
            case 4:
                $Tmp = 6;
                $Score = $Score + $value['score'];
                break;
            case 11:
                $Tmp = 6;
                echo '编译失败';
                exit();
                break;
            case 6:
                $Tmp = 6;
                $Score = $Score + 0;
                break;
            default:
                $Tmp = 0;
                break;
        }

        if($Tmp == 0){
            break;
        }
    }
}

echo $Score;
