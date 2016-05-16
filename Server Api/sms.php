<?php
require_once("./config.php");
require_once("./config_sms.php");//短信发送

if(isset($_POST['pho'])&&isset($_POST['imei'])){
	$pho=$_POST['pho'];
	$imei=$_POST['imei'];
	mysql_connect($db_url,$db_user,$db_pas);
	mysql_select_db($db_name);
	mysql_query("set names 'utf8'");
	$time=time();
	$acs=md5($pho.$imei.$time);
	$sns=rand(1000,9999);

	if(mysql_num_rows(mysql_query("select * from user where pho='$pho'"))>0){
		if(mysql_query("insert into user_log(pho,imei,acs,ver,time,ip,num) values('$pho','$imei','$acs','$sns','$time','$ip',0)")&&mysql_query("update user set acs='$acs' where pho='$pho'")){
			//...
			sms($pho,array("$sns"));
			$return['status']=0;$return['msg']="验证码获取成功";
		}else{ 
			$return['msg']=mysql_error();
		}
		//直接发送短信
	}else{
		if(mysql_query("insert into user(pho,acs) values('$pho','$acs')")&&mysql_query("insert into user_log(pho,imei,acs,ver,time,ip,num) values('$pho','$imei','$acs','$sns','$time','$ip',0)")){
			//发送短信
			sms($pho,array("$sns"));
			$return['status']=0;$return['msg']="注册成功，验证码已发出";
		}else{ 
			$return['msg']=mysql_error();
		}
	}
}

echo json_encode($return);