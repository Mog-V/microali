<?php
require_once("./config.php");

if(//判断开始
	){
	mysql_connect($db_url,$db_user,$db_pas);
	mysql_select_db($db_name);
	mysql_query("set names 'utf8'");
	mysql_query("BEGIN");
				$tine=strtotime(date('Y-m-d'));
				if(($nums=mysql_num_rows(mysql_query("select * from card_wait where pho='$pho' and time>'$tine'")))<$maxbind){
					$maxnums=$maxbind-$nums;
					$query=mysql_query("select * from card_bind where pho='$pho' and time>'$tine' and num not in (select num from card_wait where pho='$pho') limit $maxnums");
					while ($row=mysql_fetch_row($query)) {
						$rom=$row[1];
						$tell=$row[2];
						mysql_query("insert into card_wait(num,pho,time) values('$rom','$tell','$time')");
						mysql_query("update user set exp=exp+10 where pho='$pho'");
					}
					//TO DO....
					//提现
						$minid=mysql_num_rows(mysql_query("select * from card_ed"));
						$rows=mysql_num_rows(mysql_query("select * from card_wait"));
						$maxid=floor($rows/25)-$minid;
						$result=mysql_query("select * from card_wait where num not in (select num from card_ed) limit $maxid");
						while ($row=mysql_fetch_row($result)) {
							$rnum=$row[1];
							$rpho=$row[2];
							mysql_query("insert into card_ed(num,pho,time) values('$rnum','$rpho','$time')");
							mysql_query("update user set exp=exp+100 where pho='$pho'");
						}

					}
	}else{
		$return['status']=2;$return['msg']="认证码过期！";
	}
	mysql_query("ROLLBACK");
}

echo json_encode($return);