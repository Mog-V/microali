<?php
require_once("./config.php");

if(isset($_POST['pho'])&&isset($_POST['acs'])&&isset($_POST['msg'])){
	$pho=$_POST['pho'];
	$acs=$_POST['acs'];
        $msg=$_POST['msg'];
	mysql_connect($db_url,$db_user,$db_pas);
	mysql_select_db($db_name);
	mysql_query("set names 'utf8'");
	mysql_query("BEGIN");
	if(mysql_num_rows(mysql_query("select * from user where pho='$pho' and acs='$acs'"))>0){
            
            mysql_query("insert into feedback(pho,msg,time,ip) values('$pho','$msg','$time','$ip')");
            $return['status']=0;
            mysql_query("COMMIT");

	}else{
		$return['status']=2;$return['msg']="认证码过期！";
	}
	mysql_query("ROLLBACK");
}

echo json_encode($return);
