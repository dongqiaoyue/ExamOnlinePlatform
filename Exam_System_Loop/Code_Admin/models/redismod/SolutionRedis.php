<?php
namespace app\models\redismod;

use Yii;


class SolutionRedis extends \yii\redis\ActiveRecord {

    public static function primaryKey() {
        return ['solution_id'];
    }

    public function attributes() {
        return ['solution_id',
                'time',
                'judger',
                'pass_rate',
                'language',
                'result',
                'memory',
                'user_id',
                'problem_id',
                'source_code',
                'runtime_info',
                'compile_info'
            ];
    }

}
