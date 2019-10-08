<?php
require_once 'JumpRedirect.class.php';
$jr = new JumpRedirect();
//$jr->redirect("2.php",0,"正在跳转...");
$jr->jump("2.php",0);
//$jr->redirect301("2.php");
?>