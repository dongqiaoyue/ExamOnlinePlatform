<?php
require_once 'Model.php';

class common{

    /*
     * 返回通用成功json
     * @value  成功后返回的键名
     */
    public function successJson($value){
        $Value['success']=true;
        $Value['code']=1000;
        $Value['data'][$value]=true;
        return json_encode($Value);
    }

    /*
     * 返回通用成功为空Json
     * $Value
     */
    public function failedJson($msg){
        $Value['success']=true;
        $Value['code']=1000;
        $Value['msg']=$msg;
        $Value['data']=null;
        return json_encode($Value);
    }

    /*
     * 返回通用失败json
     * @msg  返回的错误信息
     */
    public function Error($msg){
        $Value['success']=false;
        $Value['code']=1001;
        $Value['msg']=$msg;
        $Value['data']=null;
        return json_encode($Value);
    }


    /*
     * 生成32位唯一ID
     */
    public function create_id(){
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

    /*
     * md5加盐
     */
    public function encodeWithSalt($str){
        $salt="4ed204ddf323fd398256970cc";
        return md5($salt.$str.$salt);
    }


    /*
     * 写入测试用例
     */
    function mkData($pid,$filename,$input,$OJ_DATA){

        $basedir = "$OJ_DATA/$pid";
        mkdir($basedir);

        $fp = @fopen ( $basedir . "/$filename", "w" );
        if($fp){
            fputs ( $fp, preg_replace ( "(\r\n)", "\n", $input ) );
            fclose ( $fp );
        }else{
            echo "Error while opening".$basedir . "/$filename ,try [chgrp -R www-data $OJ_DATA] and [chmod -R 771 $OJ_DATA ] ";

        }
    }

}