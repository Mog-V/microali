<?php
require_once("./config.php");

$pho=isset($_GET['pho'])?$_GET['pho']:0;

mysql_connect($db_url,$db_user,$db_pas);
mysql_select_db($db_name);
mysql_query("set names 'utf8'");
$time=time();
$sql="select * from adv";
if($result=mysql_query($sql)){
	$arr=array();
		while($row = mysql_fetch_array($result)){
			$arr2=array('id'=>$row[0],
						'title'=>$row[1],
						'value'=>$row[2],
						'type'=>$row[3],
						'admin'=>$row[4],
						'cot'=>$row[5],
						'start'=>$row[6],
						'end'=>$row[7]);
			array_push($arr,$arr2);
			array_push($arr,$arr2);
			array_push($arr,$arr2);
			array_push($arr,$arr2);
			array_push($arr,$arr2);
			array_push($arr,$arr2);
			array_push($arr,$arr2);
		}
		$return['status']=0;$return['msg']="信息获取成功";$return['val']=$arr;
}else{
	$return['status']=1;$return['msg']="信息获取失败";
}
echo json_encode($return);