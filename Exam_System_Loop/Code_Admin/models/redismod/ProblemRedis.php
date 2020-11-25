<?php
namespace app\models\redismod;

use Yii;


class ProblemRedis extends \yii\redis\ActiveRecord {

    public static function primaryKey() {
        return ['problem_id'];
    }

    public function attributes() {
        return ['problem_id',
                'title',
                'spj',
                'time_limit',
                'memory_limit'
            ];
    }

}