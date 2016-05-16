<?php
require_once("./config.php");

if(isset($_POST['pho'])&&isset($_POST['ver'])&&isset($_POST['imei'])){
	$pho=$_POST['pho'];
	$ver=is_numeric($_POST['ver'])?$_POST['ver']:0;
	$imei=$_POST['imei'];
	mysql_connect($db_url,$db_user,$db_pas);
	mysql_select_db($db_name);
	mysql_query("set names 'utf8'");

	$st=0;

	mysql_query("update user_log set num=num+1 where pho='$pho' order by ID desc limit 1");
	if($result=mysql_query("select * from user_log where pho='$pho' and num<5 order by ID desc limit 1")){
		if(mysql_num_rows($result)==1){ 
			$row=mysql_fetch_row($result);
			if($row[4]==$ver){
				$st=1;
				$return['val']=$row[3];
				$return['status']=0;$return['msg']="登陆成功";
				mysql_query("update user_log set ver='dddd' where pho='$pho'");
			}else{
				$return['status']=2;$return['msg']="验证码过时".mysql_error();
			}
		}else{ 
			$return['msg']=mysql_error();
		}
	}else{ 
		$return['msg']=mysql_error();
	}
	mysql_query("insert into login_log(pho,ver,imei,ip,time,status) values('$pho',$ver,'$imei','$ip','$time','$st')");
}

echo json_encode($return);