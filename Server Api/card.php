<?php
require_once("./config.php");
echo "您当前的IP地址：".$ip."<br>";
$bl=true;
foreach ($iparr as $key => $value) {
	if($ip==$value){
		$bl=false;
	}
}
if($bl){ 
	echo $iparr[0]."<br>";
	echo "您的IP不在安全范围里，拒绝访问！";
	exit();
}


mysql_connect($db_url,$db_user,$db_pas);
mysql_select_db($db_name);
mysql_query("set names 'utf8'");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$card=$_POST['def'];
	if($card=='card'){
		$psd=getpsd(6);
		$sql="insert into card(psd,time,user,ip) values('$psd','$time',0,'$ip')";
		mysql_query($sql);
	}
}
$sql="select * from card order by id desc limit 1";
$row=mysql_fetch_row(mysql_query($sql));
mysql_close($con);
function getpsd($len){
	$chars = 'ABCDEFGHIJKLMNPQRSTUVWXYZ23456789';
		$randpwd = "";
	for ($i=0;$i<$len;$i++)  
		{
			$randpwd.= $chars[mt_rand(0,strlen($chars)-1)];
		}
		return $randpwd;
}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title></title>
		<style type="text/css">
			*{color: #666;font-weight: 400;}
		</style>
	</head>
	<body style="background-color: #E6FFCC;">
		<a href="dao.php" target="_blank" style="position: absolute;right: 10px;top: 10px;color: #d34;">导出EXCEL</a>
		<h1 style="color: #FF3333;text-align: center;margin-top: 100px;font-family: '楷体';">卡券生成中心</h1>
		<div style="margin: 30px auto;padding: 30px 10px;box-shadow: 0 0 5px 0 rgba(0,0,0,.3);width: 300px;border-radius: 10px;">
			<div style="clear: all;width: 100%;height: 32px;">
				<span style="display: inline-block;width: 100px;text-align: right;float: left;">卡券总数：</span>
				<span style="display: inline-block;width: 150px;text-align: right;float: left;"><?php echo (int) $row[0]; ?></span>
			</div>
			<div style="clear: all;width: 100%;height: 32px;">
				<span style="display: inline-block;width: 100px;text-align: right;float: left;">最后日期：</span>
				<span style="display: inline-block;width: 150px;text-align: right;float: left;"><?php echo date("Y年m月d H:i:s",$row[2]); ?></span>
			</div>
			<div style="clear: all;width: 100%;height: 32px;">
				<span style="display: inline-block;width: 100px;text-align: right;float: left;">工号：</span>
				<span style="display: inline-block;width: 150px;text-align: right;float: left;"><?php echo (int) $row[3]; ?></span>
			</div>
			<div style="clear: all;width: 100%;height: 32px;">
				<span style="display: inline-block;width: 100px;text-align: right;float: left;">IP地址：</span>
				<span style="display: inline-block;width: 150px;text-align: right;float: left;"><?php echo $row[4]; ?></span>
			</div>
		</div>
		<form action="card.php" method="post" style="width: 100%;text-align: center;margin-top: 50px;">
			<input type="hidden" name="def" value="card" />
			<input type="submit" value="生成" style="font-size: 28px;font-family: '楷体';padding: 10px 50px;color: #fff;border: none;outline: none;background-color: #52FF52;box-shadow: 0 0 5px 0 #52FF52;"/>
		</form>
	</body>
</html>