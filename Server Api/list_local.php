<?php
require_once("./config.php");

if(isset($_POST['pho'])&&isset($_POST['acs'])){
	$pho=$_POST['pho'];
	$acs=$_POST['acs'];
mysql_connect($db_url,$db_user,$db_pas);
mysql_select_db($db_name);
mysql_query("set names 'utf8'");
$time=time();
$sql="select * from bus where sta=1";
if($result=mysql_query($sql)){
	$arr=array();
		while($row = mysql_fetch_array($result)){
			$arr2=array('id'=>$row[0],
						'name'=>$row[4],
						'img'=>$row[9],
						'local'=>$row[8],
						'trade'=>"暂无分类",
						'call'=>$row[1]);
			array_push($arr,$arr2);
		}
		$return['status']=0;$return['msg']="信息获取成功";$return['val']=$arr;
}else{
	$return['status']=1;$return['msg']="信息获取失败";
}
}

echo json_encode($return);