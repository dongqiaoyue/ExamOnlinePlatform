<?php

class sql_server{

    //连接sqlServer
    public function connect(){
        $serverName = "222.18.158.220"; //serverName\instanceName
        $connectionInfo = array( "Database"=>"C_CourseSystem", "UID"=>"sa", "PWD"=>"admin_@_cuitmoon_220");
        $conn = sqlsrv_connect( $serverName, $connectionInfo);
        return $conn;
    }

    /**
     *  查询测试用例和分值
     * @questionId
     * 返回二位数组
     */
    public function selectTestCase($questionId){
        $con = self::connect();
        $sql = "select ScoreWeight,TestCaseInput,TestCaseOutput from TestCase where QuestionId='$questionId'";
        $stmt = sqlsrv_query($con,$sql);
        while ($row = sqlsrv_fetch_array($stmt,SQLSRV_FETCH_ASSOC)){
            $info[] = $row;
        }
        sqlsrv_close($con);
        return $info;
    }
}
