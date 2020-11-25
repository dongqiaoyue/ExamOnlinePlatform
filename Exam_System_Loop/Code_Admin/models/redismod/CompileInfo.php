<?php
namespace app\models\redismod;

use Yii;


class CompileInfo extends \yii\redis\ActiveRecord {

    public static function primaryKey() {
        return ['solution_id'];
    }

    public function attributes() {
        return ['solution_id',
                'error',
            ];
    }

}