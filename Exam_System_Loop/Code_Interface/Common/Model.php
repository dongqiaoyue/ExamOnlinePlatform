<?php
require_once 'sql.connect.php';
error_reporting(7);

class Model{

    protected $sql = array(
        'field' => '',
        'where' => '',
        'order' => '',
        'limit' => '',
        'table' => '',
    );

    function field($info){
        $this->sql['field']=$info;
        return $this;
    }

    function where($info){
        $this->sql['where']=' where '.$info;
        return $this;
    }

    function table($info){
        $this->sql['table']=$info;
        return $this;
    }

    function order($info){
        $this->sql['order']='order by '.$info;
        return $this;
    }

    function limit($info){
        $this->sql['limit']='limit '.$info;
        return $this;
    }

    /*
     * sql语句直接查询
     * @sql 查询语句
     * 成功 查询类 返回二维关联数组
     *    非查询类 返回 1
     * 失败 返回错误信息
     */
    function query($sql){
        $connect=new connect();
        $con=$connect->connect();
        if($re=$con->query($sql)){
                $result = array();
                while ($row = $re->fetch_assoc()) {
                    $result[] = $row;
                }
                $connect->close($con);
                self::clear();
                return $result;
        }else{
            $connect->close($con);
            self::clear();
            return $con->error;
        }
    }

    /*
     * return 返回二维关联数组。
     * 失败 返回错误信息
     */
    function select(){
        $connect=new connect();
        $con=$connect->connect();
        if($this->sql['field']==null){
            $this->sql['field']='*';
        }
        $query="select ".$this->sql['field']." from ".$this->sql['table']." ".$this->sql['where']." ".$this->sql['order']." ".$this->sql['limit'];
        if($re=$con->query($query)) {
            $result = array();
            while ($row = $re->fetch_assoc()) {
                $result[] = $row;
            }
            $connect->close($con);
            self::clear();
            return $result;
        }else{
            $con->error;
            self::clear();
            $connect->close($con);
        }
    }

    /*
     * @filed 字段名称,多个用逗号隔开
     * return 返回字段的值,单个字段直接返回一个字符串,多个字段返回一个一维关联数组。
     * 注:只返回一条记录,如果查出有多条记录也只返回一条记录。
     */
    function getField($field){
        $connect=new connect();
        $con=$connect->connect();
        $query="select ".$field." from ".$this->sql['table']." ".$this->sql['where']." ".$this->sql['order']." ".$this->sql['limit'];
        if($re=$con->query($query)) {
            $connect->close($con);
            $result = $re->fetch_assoc();
            $field = explode(',', $field);
            if (count($field) == 1) {
                $field = $field[0];
                return $result[$field];
            } else {
                $arr = array();
                foreach ($field as $k => $vo) {
                    $arr[$vo] = $result[$vo];
                }
                self::clear();
                return $arr;
            }
        }else{
            self::clear();
            $connect->close($con);
        }
    }

    /*
     * 插入新记录
     * @data 数据类型 数据 格式如下
     * 只允许一条记录,不能二维数组
     * array(
     *  'CommodityID' => '值',
     *  'CommodityName' => '值',
     * );
     * return 成功 返回 1 失败 返回错误信息
     */
    function add($data){
        $filed=array();
        $i=0;
        foreach ($data as $k=>$vo){
            $filed[]=$k;
            if($i==0){
                $value="'$vo'";
            }else {
                $value = $value . ',' . "'$vo'";
            }
            $i++;
        }
        $filed=implode(',',$filed);
        $query="insert into ".$this->sql['table']." (".$filed.") values (".$value.")";
        $connect=new connect();
        $con=$connect->connect();
        if($con->query($query)){
            $connect->close($con);
            self::clear();
            return 1;
        }else{
            $connect->close($con);
            self::clear();
            return $con->error;
        }
    }

    /*
     * 更新字段
     * @data 需要更新的数据 格式如下
     * array(
     *  'CommodityID' => 'xxx',
     *  'CommodityName' => 'xxx',
     * )
     * return 成功返回 1 失败返回 0
     */
    function update($data){
        $Tmp=null;
        foreach ($data as $k=>$vo){
            $Tmp.="$k='$vo',";
        }
        $Tmp=substr($Tmp,0,-1);
        $query="update ".$this->sql['table']." set ".$Tmp." ".$this->sql['where']." ".$this->sql['limit']." ".$this->sql['order'];
        $connect=new connect();
        $con=$connect->connect();
        $con->query($query);
        if(($re=$con->affected_rows)>0){
            $connect->close($con);
            self::clear();
            return 1;
        }else{
            $connect->close($con);
            self::clear();
            return 0;
        }
    }

    /*
     * 更新单个字段
     * @data 字符串形式 char CommodityID='xxx'
     * return 成功返回 1 失败返回 0
     */
    function setField($data){
        $query="update ".$this->sql['table']." set ".$data." ".$this->sql['where']." ".$this->sql['limit']." ".$this->sql['order'];
        $connect=new connect();
        $con=$connect->connect();
        $con->query($query);
        if(($re=$con->affected_rows)>0){
            $connect->close($con);
            self::clear();
            return 1;
        }else{
            $connect->close($con);
            self::clear();
            return 0;
        }
    }

    /*
     * 删除记录
     * 成功返回 1 失败返回 0
     */
    function delete(){
        $query="delete from ".$this->sql['table']." ".$this->sql['where'];
        $connect=new connect();
        $con=$connect->connect();
        $con->query($query);
        if(($re=$con->affected_rows)>0){
            $connect->close($con);
            self::clear();
            return 1;
        }else{
            $connect->close($con);
            self::clear();
            return 0;
        }
    }

    function clear(){
        $this->sql=null;
    }
}