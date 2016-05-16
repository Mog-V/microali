<?php
require_once("./config.php");
mysql_connect($db_url,$db_user,$db_pas);
mysql_select_db($db_name);
mysql_query("set names 'utf8'");

$sql="select num,pho,time from card_bind order by num";
$result=mysql_query($sql);
$str = "编号\t电话\t时间\t\n"; 
//$str = iconv('utf-8','gb2312',$str); 

while($row=mysql_fetch_array($result)){ 
    $id = $row[0]; 
    $pho = $row[1]."_"; 
    $time=date("Y年m月d日 H:i:s",$row[2]);
    $str .= $id."\t".$pho."\t".$time."\t\n"; 
} 
$filename = date('Y年m月d日 H:i:s')."导出".'.xls'; 
exportExcel($filename,$str); 
function exportExcel($filename,$content){ 
     header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
    header("Content-Type: application/vnd.ms-execl"); 
    header("Content-Type: application/force-download"); 
    header("Content-Type: application/download"); 
    header("Content-Disposition: attachment; filename=".$filename); 
    header("Content-Transfer-Encoding: binary"); 
    header("Pragma: no-cache"); 
    header("Expires: 0"); 
 
    echo $content; 
} 