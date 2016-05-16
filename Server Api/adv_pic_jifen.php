<?php
require_once("./config.php");

if(isset($_POST['pho'])&&isset($_POST['acs'])&&isset($_POST['advid'])){
	$pho=$_POST['pho'];
	$acs=$_POST['acs'];
        $advid=$_POST['advid'];
	mysql_connect($db_url,$db_user,$db_pas);
	mysql_select_db($db_name);
	mysql_query("set names 'utf8'");
	mysql_query("update adv set ci=ci+1 where id='$advid'");
	mysql_query("BEGIN");
	if(mysql_num_rows(mysql_query("select * from user where pho='$pho' and acs='$acs'"))>0){
            if(mysql_num_rows(mysql_query("select * from adv_ed where pho='$pho' and advid='$advid'"))==0){
                $num=rand(40,80);
                mysql_query("insert into adv_ed(advid,pho,num,time) values('$advid','$pho','$num','$time')");
                $return['status']=0;
                $return['val']=$num;
                mysql_query("COMMIT");
            }

	}else{
		$return['status']=2;$return['msg']="认证码过期！";
	}
	mysql_query("ROLLBACK");
}

echo json_encode($return);
