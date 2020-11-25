<?php
namespace common;

use app\models\question\Problem;
use app\models\question\Questions;
use app\models\question\Solution;
use app\models\question\Testcase;
use app\models\redismod\SolutionRedis;
use app\models\redismod\ProblemRedis;

use Yii;

class redisFunc {

    function saveSolutionToRedis($code, $ProblemId) {
        $redis = \Yii::$app->redis;
        $com = new CommonFuc();

        // 获得solutionId 并自增
        $redis->setnx("solutionCounter", 1);
        // $solution_id = (int)$redis->get('solutionCounter');
        $solution_id = (int)$redis->incr('solutionCounter');

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
        // $ProblemId = (int)$redis->get('problemCounter');
        $ProblemId = (int)$redis->incr('problemCounter');

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
