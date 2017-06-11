<?php
header('Content-type:text/html; charset=utf-8');
require_once 'class/Mysql.class.php';
$mysqlobj = new Mysql("localhost","root","123456","ceshi");
// $db_arr = $mysqlobj->Dblist();
// print_r($db_arr);

//插入数据用法
// $data['name'] = "name";
// $data['xingbie'] = "nan";
// if($mysqlobj->addone($data,"webappsceshi")){
// 	echo "插入成功";
// }else{
// 	echo "插入失败";
// }


//查询一条数据
// if($result = $mysqlobj->queryone("webappsceshi","xingbie='男'")){
// 	print_r($result);
// }else{
// 	echo "查询失败！";
// }

//查询所有数据
// if($result = $mysqlobj->queryall("webappsceshi","xingbie='男'")){
// 	print_r($result);
// }else{
// 	echo "查询失败";
// }

//更新数据
// if($mysqlobj->dataupdate("webappsceshi",array("xingbie"=>"男"),"id=3")){
// 	echo "数据更新成功！";
// }else{
// 	echo "更新失败！";
// }

//删除数据
// if($mysqlobj->datadelete("webappsceshi","id=4")){
// 	echo "数据删除成功！";
// }else{
// 	echo "删除失败";
// }

//列出数据库中的表
// $result = $mysqlobj->tableList("gzyycx");
// if($result != "error" && $result != "empty") {
// 	print_r($result);
// } else {
// 	echo "错误或者为空";
// }
?>