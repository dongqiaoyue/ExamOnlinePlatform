<?php
error_reporting(7);
class connect{

    protected $db_name;
    protected $db_type;
    protected $db_user;
    protected $db_pass;
    protected $db_port;
    protected $db_host;
    protected $db_charset;

    function __construct()
    {
        $info=include './Config/db.config.php';
        $this->db_host=$info['db_host'];
        $this->db_name=$info['db_name'];
        $this->db_charset=$info['db_charset'];
        $this->db_pass=$info['db_pass'];
        $this->db_port=$info['db_port'];
        $this->db_user=$info['db_user'];
        $this->db_type=$info['db_type'];
        date_default_timezone_set('Asia/Shanghai');
    }

    public function connect(){
        $con=new mysqli($this->db_host,$this->db_user,$this->db_pass,$this->db_name);
        if ($con->connect_error) {
            die('Connect Error (' . $con->connect_errno . ') '
                . $con->connect_error);
        }
        $con->set_charset($this->db_charset);
        return $con;
    }

    public function close($con){
        mysqli_close($con);
    }
}
