<?php
require_once("./config.php");

function userInfoValid($pho,$acs){
	global $db_url,$db_user,$db_pas,$db_name;
	mysql_connect($db_url,$db_user,$db_pas);
	mysql_select_db($db_name);
	mysql_query("set names 'utf8'");
	if(mysql_num_rows(mysql_query("select * from user where pho='$pho' and acs='$acs'"))>0){

		mysql_close();
		return true;
	}
	mysql_close();
	return false;
}
?>