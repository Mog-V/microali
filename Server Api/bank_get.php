<?php
require_once("./config.php");

if(isset($_POST['pho'])&&isset($_POST['acs'])){
    $pho=$_POST['pho'];
    $acs=$_POST['acs'];
    mysql_connect($db_url,$db_user,$db_pas);
    mysql_select_db($db_name);
    mysql_query("set names 'utf8'");
    if(mysql_num_rows(mysql_query("select * from user where pho='$pho' and acs='$acs'"))>0){
        $return['status']=0;
        if(mysql_num_rows($re=mysql_query("select tp,num from bank where pho='$pho'"))>0){
            $arr = array();
            while ($row = mysql_fetch_array($re)) {
                if($row[0]==1){
                    $arr2 = array('tp' => 1,
                        'num' => $row[1]);
                }else{
                    $arr2 = array('tp' => 2,
                        'num' => substr($row[1],-4));
                }

                array_push($arr, $arr2);
            }
            $return['val'] = $arr;
            $return['status']=3;
        }
    }
}

echo json_encode($return);