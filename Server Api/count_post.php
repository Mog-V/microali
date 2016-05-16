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

		$num1=mysql_num_rows(mysql_query("select * from card_bind where pho='$pho'"));//总绑定
		$num2=mysql_num_rows(mysql_query("select * from card_wait where pho='$pho'"));//总排队
		$num3=mysql_num_rows(mysql_query("select * from card_ed where pho='$pho'"));//总提现
		
		
		$r=mysql_query("select sum(num) as money from money_out where pho='$pho' and sta<5");//总提现
		$rr=mysql_fetch_row($r);
		$num4=$rr[0]/100;

		//可用余额等于  总提现-出账
		//将要入账      总排队-总提现
		//将要排队      总绑定-已绑定
		//返现总额      总提现
		//消费金额      总绑定

		//当前排名 group by pho and not in 第一位ID；再计算到此数目的数量

		$row=mysql_fetch_row(mysql_query("select * from card_wait where num not in (select num from card_ed) and pho='$pho' limit 1"));
		$maxid=$row[0];


        $sql1=mysql_query("select id from card_wait where num not in (select num from card_ed) and pho='$pho' order by id limit 1");
        if(mysql_num_rows($sql1)==0){
            $num5=mysql_num_rows(mysql_query("select * from card_wait where num not in (select num from card_ed)"));//总排名
        }else{
            $sql_id=mysql_fetch_row($sql1)[0];
            $num5=mysql_num_rows(mysql_query("select * from card_wait where num not in (select num from card_ed) and id<$sql_id"));//总排名
        }



		$return['status']=0;

		$return['val']=array('v1' => ($num3-$num4)*100,
								'v2' => $num2-$num3,
								'v3' => $num1-$num2,
								'v4' => $num3, 
								'v5' => $num1,
								'v0'=> $num5);



		mysql_query("COMMIT");

	}else{
		$return['status']=2;$return['msg']="认证码过期！";
	}
	mysql_query("ROLLBACK");
}

echo json_encode($return);