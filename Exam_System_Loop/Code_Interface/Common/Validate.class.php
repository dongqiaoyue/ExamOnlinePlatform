<?php
require_once 'Model.php';
class Validate extends Model{

    //验证例子
    protected $_validate=array(
        'xxx' => array(
            'table' => 'xxx',//表名
            'filed' => 'xxx',//字段名
            'function' => 'xxx',//调用函数
            'rule' => 'xxx',//验证规则
            'msg' => 'xxx',//错误提示
        )
    );

    public function check($_validate,$value){
        if($_validate['function']!=null){
            return self::checkStep($_validate,$value);
        }else {
            foreach ($_validate as $k => $vo) {
                if(($Tmp=self::checkStep($vo,$value[$vo['filed']]))==true){
                    $msg[$k]=true;
                }else{
                    $msg[$k]=$Tmp;
                }
            }
        }
    }

    public function checkStep($_validate,$value){
        switch ($_validate['function']) {
            case 'regex':
                return (self::regex($_validate['rule'], $value) ? true : $_validate['msg']);
                break;
            case 'required':
                return (self::required($value) ? true : $_validate['msg']);
                break;
            case 'unique':
                return (self::unique($_validate['table'],$_validate['filed'],$value) ? true : $_validate['msg']);
                break;
        }
    }

    public function regex($rule,$value){
        $validate = array(
            'require'   =>  '/\S+/',
            'email'     =>  '/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/',
            'url'       =>  '/^http(s?):\/\/(?:[A-za-z0-9-]+\.)+[A-za-z]{2,4}(:\d+)?(?:[\/\?#][\/=\?%\-&~`@[\]\':+!\.#\w]*)?$/',
            'currency'  =>  '/^\d+(\.\d+)?$/',
            'number'    =>  '/^\d+$/',
            'zip'       =>  '/^\d{6}$/',
            'integer'   =>  '/^[-\+]?\d+$/',
            'double'    =>  '/^[-\+]?\d+(\.\d+)?$/',
            'english'   =>  '/^[A-Za-z]+$/',
        );
        if(isset($validate[strtolower($rule)]))
            $rule       =   $validate[strtolower($rule)];
        return preg_match($rule,$value)===1;

    }

    public function required($value){
        return (strlen($value)==0 ? false : true);
    }

    public function unique($table,$filed,$value){
        return (parent::table($table)->where("$filed='$value'")->getField($filed) ? false : true);

    }


}