<?php
/*  
  Copyright (c) 2010-02 Game
  Game All Rights Reserved. 
  QQ:503064228
  Author: Version:1.0
  Date:2011-12-18
*/
define('Copyright', '作者QQ:503064228');
define('ROOT_PATH', $_SERVER["DOCUMENT_ROOT"].'/');
include_once ROOT_PATH.'function/global.php';
$dateTime = date('Y-m-d H:i:s');
global $stratGamek3, $endGamek3;
if ( $dateTime < $stratGamek3 || $dateTime > $endGamek3)
{markPos("前台-快3封盘页");
	header("Location: ./right.php"); exit;
}
?>