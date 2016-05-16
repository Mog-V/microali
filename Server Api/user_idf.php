<?php
require_once("./config.php");

if(isset($_POST['pho'])&&isset($_POST['acs'])&&isset($_POST['name'])&&isset($_POST['idcard'])){
	$pho=$_POST['pho'];
	$acs=$_POST['acs'];
        $name=$_POST['name'];
        $idcard=$_POST['idcard'];
	mysql_connect($db_url,$db_user,$db_pas);
	mysql_select_db($db_name);
	mysql_query("set names 'utf8'");
	mysql_query("BEGIN");
	if(mysql_num_rows(mysql_query("select * from user where pho='$pho' and acs='$acs'"))>0){
            
            //判断用户是否实名认证
            $return['status']=0;
            if(mysql_num_rows($result=mysql_query("select * from user_info where pho='$pho'"))>0){
                //如果用户已实名认证，则返回认证信息
                $row=  mysql_fetch_row($result);
                $return['val']=array('name' => $row[2],
                                        'idcard' => $row[3],
                                        'time' => date("Y年m月d日", $row[4]));
            }else{
                mysql_query("insert into user_info(pho,name,idcard,time,ip) values('$pho','$name','$idcard','$time','$ip')");
                $return['val']=array('name' => $name,
                                        'idcard' => $idcard,
                                        'time' => date("Y年m月d日", $time));
            }
            
            mysql_query("COMMIT");

	}else{
		$return['status']=2;$return['msg']="认证码过期！";
	}
	mysql_query("ROLLBACK");
}

echo json_encode($return);
