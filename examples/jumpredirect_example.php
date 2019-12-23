<?php
namespace examples;
require_once "../autoload.php";
use jumpredirect\JumpRedirect;
// require_once 'JumpRedirect.class.php';
$jr = new JumpRedirect();
//$jr->redirect("2.php",0,"正在跳转...");
$jr->jump("jumpredirect_example2.php",0);
//$jr->redirect301("2.php");
?>