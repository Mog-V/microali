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
            $row1=  mysql_fetch_row(mysql_query("select sum(num) from adv_ed where pho='$pho'"));
            $all== ($row1[0]!=null)?$row1[0]:0;
            $row2=  mysql_fetch_row(mysql_query("select sum(num) from adv_share_ed where pho='$pho'"));
            $all+= ($row2[0]!=null)?$row2[0]:0;
            $return['val']= $all;
            $return['status']=0;
            mysql_query("COMMIT");

	}else{
		$return['status']=2;$return['msg']="认证码过期！";
	}
	mysql_query("ROLLBACK");
}

echo json_encode($return);
