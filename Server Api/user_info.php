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
            
            //判断用户是否实名认证
            if(mysql_num_rows($result=mysql_query("select * from user_info where pho='$pho'"))>0){
                //如果用户已实名认证，则返回认证信息
                $row=  mysql_fetch_row($result);
                $return['status']=0;
                $return['val']=array('name' => getName($row[2]),
                                        'idcard' => getIdCard($row[3]),
                                        'time' => date("Y年m月d日", $row[4]));
            }

		mysql_query("COMMIT");

	}else{
		$return['status']=2;$return['msg']="认证码过期！";
	}
	mysql_query("ROLLBACK");
}

echo json_encode($return);

function getIdCard($idcard){
    $re1= substr($idcard,0,4);
    $re2= substr($idcard,-6);
    $re=$re1."********".$re2;
    return $re;
}
function getName($name){
    $re=mb_substr($name, 1,5,"utf-8");
    return "*".$re;
}