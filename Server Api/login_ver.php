<?php
require_once("./config.php");

if(isset($_POST['pho'])&&isset($_POST['acs'])){
	$pho=$_POST['pho'];
	$acs=$_POST['acs'];
	mysql_connect($db_url,$db_user,$db_pas);
	mysql_select_db($db_name);
	mysql_query("set names 'utf8'");
	mysql_query("BEGIN");
	if(mysql_num_rows(mysql_query("select * from user where pho='$pho' and acs='$acs'"))>0){
            
            if($row=mysql_fetch_row(mysql_query("select * from version order by id desc limit 1"))){
                $return['status']=0;
                $return['val']=$row[1];
            }

	}else{
		$return['status']=2;$return['msg']="用户验证过期，请重新登录！";
	}
	mysql_query("ROLLBACK");
}

echo json_encode($return);