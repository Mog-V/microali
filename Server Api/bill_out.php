<?php
require_once("./config.php");

if(isset($_POST['pho'])&&isset($_POST['acs'])&&isset($_POST['num'])&&isset($_POST['count'])){
	$pho=$_POST['pho'];
	$acs=$_POST['acs'];
	$num=$_POST['num'];
    $count=$_POST['count'];
	mysql_connect($db_url,$db_user,$db_pas);
	mysql_select_db($db_name);
	mysql_query("set names 'utf8'");
	mysql_query("BEGIN");
	if(mysql_num_rows(mysql_query("select * from user where pho='$pho' and acs='$acs'"))>0){
		$num1=mysql_num_rows(mysql_query("select * from card_ed where pho='$pho'"));//总提现
		
		$r=mysql_query("select sum(num) as money from money_out where pho='$pho' and sta<5");//总提现
		$rr=mysql_fetch_row($r);
		$num2=$rr[0];
		
		$all=$num1*100-$num2*1;
		
		if($all>=$num && $num>0){
		
			mysql_query("insert into money_out(pho,num,count,time,ip,sta) values('$pho','$num','$count','$time','$ip',0)");
			$return['status']=0;
		
		}else{
			$return['status']=3;
		}
		mysql_query("COMMIT");

	}else{
		$return['status']=2;$return['msg']="认证码过期！";
	}
	mysql_query("ROLLBACK");
}

echo json_encode($return);
