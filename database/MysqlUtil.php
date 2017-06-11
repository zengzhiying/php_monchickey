<?php
class MysqlUtil {
	
	private $host;	//数据库服务器地址
	private $username; //数据库用户名
	private $password; //数据密码
	private $conn;	//连接句柄
	private $dbname;	//选择的数据库

	function __construct($host,$username,$password,$dbname,$charset = 'utf8') {
		//初始化构造方法，实例化类的时候即连接数据库
		$this->host = $host;
		$this->username = $username;
		$this->password = $password;
		$this->dbname = $dbname;
		$this->conn = mysql_connect($this->host,$this->username,$this->password) or die ("连接数据库服务器失败！".mysql_error());

		if(mysql_select_db($this->dbname)){
			//
		}else{
			exit("数据库选择失败！");
		}

		//设置数据库字符集
		mysql_query("set names '".$charset."'");
	}


	/**
	 * 列出所有数据库
	 */
	public function Dblist(){
		$db_list = mysql_list_dbs($this->conn);
		$db_arr = array();
		while($db = mysql_fetch_object($db_list)) {
			$db_arr[] = $db->Database;
		}
		return $db_arr;
	}

	/**
	 * 列出数据库中所有的数据表
	 */
	public function tableList($dbname) {
		if(mysql_select_db($dbname)) {
			if($result = mysql_query("SHOW TABLES")) {
				while($row = mysql_fetch_array($result)) {
					$tableArray[] = $row[0];
				}
				return $tableArray;
			} else {
				return "error";
			}
		} else {
			return "empty";
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

		if(mysql_query($sql,$this->conn)){
			//数据插入成功返回索引id
			return mysql_insert_id();
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
		if($sel = mysql_query($sql,$this->conn)){
			$row = mysql_fetch_assoc($sel);
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
		if($result = mysql_query($sql,$this->conn)){
			while ($row[] = mysql_fetch_assoc($result)) {
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
			if(mysql_query($sql,$this->conn)){
				//更新成功，值加一，否则不增加
				$i += mysql_affected_rows();
			}
		}
		return $i;
	}


	/**
	 * 数据删除
	 */
	public function datadelete($table,$where){
		$sql = "DELETE FROM ".$table." WHERE ".$where;
		if(mysql_query($sql,$this->conn)){
			//删除成功
			return mysql_affected_rows();
		}else{
			return false;
		}
	}







	/**
	 * 析构函数自动关闭数据库连接
	 */
	function __destruct() {
       mysql_close($this->conn);
    }
}
?>