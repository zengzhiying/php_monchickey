<?php
/**
 * 新版mysqli连接工具类
 * php7以及以后的版本都用
 */
class MysqliUtil {
    
    private $host;  //数据库服务器地址
    private $username; //数据库用户名
    private $password; //数据密码
    private $conn;  //连接句柄
    private $dbname;    //选择的数据库

    function __construct($host,$username,$password,$dbname,$charset = 'utf8') {
        //初始化构造方法，实例化类的时候即连接数据库
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
        $this->dbname = $dbname;
        $this->conn = mysqli_connect($this->host,$this->username,$this->password, $this->dbname) or die ("连接数据库服务器失败！".mysql_error());

        //设置数据库字符集
        mysql_query($this->conn, "set names '".$charset."'");
    }


    /**
     * 列出数据库中所有的数据表
     */
    public function tableList() {
        if($result = mysqli_query($this->conn, "SHOW TABLES")) {
            while($row = mysqli_fetch_array($result)) {
                $tableArray[] = $row[0];
            }
            return $tableArray;
        } else {
            return "error";
        }
    }



    /**
     * 往表中插入一条数据
     * 以数组的形式插入
     */
    public function addone($dataarr,$table){
        $keys = '';
        $values = '';
        $i = 0;
        foreach ($dataarr as $key => $value) {
            if($i == 0){
                $keys = $key;
                $values = '\''.$value.'\'';
            }else{
                $keys .= ','.$key;
                $values .= ','.'\''.$value.'\'';
            }
            $i++;
        }
        //拼字符串
        $sql = "INSERT into ".$table."(".$keys.") values (".$values.")";

        if(mysqli_query($this->conn, $sql)){
            //数据插入成功返回索引id
            return mysqli_insert_id();
        }else{
            return false;
        }
    }


    /**
     * 查询一条数据
     * 传入条件是字符串
     * 注意字段类型，字符串字段要加引号
     */
    public function queryone($table,$where = ''){
        if(!empty($where)){
            $where = "where ".$where;
        }
        $sql = "SELECT * from ".$table." ".$where." limit 1";
        if($sel = mysqli_query($this->conn, $sql)){
            $row = mysqli_fetch_assoc($sel);
            return $row;
        }else{
            return false;
        }
    }


    /**
     * 查询所有数据
     * 传入条件是字符串
     * 字符串字段要加引号
     */
    public function queryall($table,$where = ''){
        if(!empty($where)){
            $where = "where ".$where;
        }
        $row = array();
        $sql = "SELECT * from ".$table." ".$where;
        if($result = mysqli_query($this->conn, $sql)){
            while ($row[] = mysqli_fetch_assoc($result)) {
                continue;
            }
            //销毁最后一项空项
            unset($row[count($row)-1]);
            return $row;
        }else{
            return false;
        }
    }

    /**
     * 数据更新
     * 更新内容和条件全部需要传入
     */
    public function dataupdate($table,$set_arr,$where){
        $i = 0;
        foreach ($set_arr as $key => $value) {
            $sql = "UPDATE ".$table." SET ".$key."="."'".$value."'"." WHERE ".$where;
            if(mysqli_query($this->conn, $sql)){
                //更新成功，值加一，否则不增加
                $i += mysqli_affected_rows();
            }
        }
        return $i;
    }


    /**
     * 数据删除
     */
    public function datadelete($table,$where){
        $sql = "DELETE FROM ".$table." WHERE ".$where;
        if(mysqli_query($this->conn, $sql)){
            //删除成功
            return mysqli_affected_rows();
        }else{
            return false;
        }
    }

    /**
     * 析构函数自动关闭数据库连接
     */
    function __destruct() {
       mysqli_close($this->conn);
    }
}
?>