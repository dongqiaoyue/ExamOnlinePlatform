<?php
error_reporting(7);

require_once './Common/Model.php';

class exam extends Model{


    /**
     * 更新问题,并返回问题id
     */
    public function insertProblem($Tmp){
        if(parent::table("problem")->add($Tmp)){
            return parent::table("problem")->order('problem_id desc')->limit(1)->getField('problem_id');
        }else{
            return false;
        }
    }

    /**
     * 更新编译记录，并返回id
     */
    public function insertSolution($Tmp){
        if(parent::table("solution")->add($Tmp)){
            return parent::table("solution")->order('solution_id desc')->limit(1)->getField('solution_id');
        }else{
            return false;
        }
    }

    /**
     * 插入代码
     */
    public function insertCode($Tmp){
        if(parent::table("source_code")->add($Tmp)&&parent::table('source_code_user')->add($Tmp)){
            return true;
        }else{
            return false;
        }
    }

    /**
     * 查询编译结果
     */
    public function selectResult($id){
        return parent::table('solution')->where("solution_id = '$id'")->getField('result');
    }

}