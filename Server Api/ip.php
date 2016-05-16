<?php
require_once("./config.php");
echo "您当前的IP地址：".$ip."<br>";
$bl=true;
if(in_array($ip, $iparr)){ 
	$bl=false;
}
if($bl){ 
	var_dump($iparr);
	echo "<br>";
	echo "您的IP不在安全范围里，拒绝访问！";
}else{ 
	var_dump($iparr);
	echo "<br>";
	echo "您的IP属于安全IP，欢迎访问！";
}
