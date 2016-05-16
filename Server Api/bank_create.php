<?php
require_once("./config.php");

if(isset($_POST['pho'])&&isset($_POST['acs'])&&isset($_POST['tp'])&&isset($_POST['num'])){
    $pho=$_POST['pho'];
    $acs=$_POST['acs'];
    $tp=$_POST['tp'];
    $num=$_POST['num'];
    $time=time();
    mysql_connect($db_url,$db_user,$db_pas);
    mysql_select_db($db_name);
    mysql_query("set names 'utf8'");
    mysql_query("BEGIN");
    if(mysql_num_rows(mysql_query("select * from user where pho='$pho' and acs='$acs'"))>0){
        if(mysql_num_rows(mysql_query("select * from bank where pho='$pho' and tp='$tp' and num='$num'"))>0){
            $return['status']=3;
            mysql_query("COMMIT");
        }else{
            if(mysql_query("insert into bank(pho,tp,num,time) values('$pho','$tp','$num','$time')")){
                $return['status']=0;
                mysql_query("COMMIT");
            }
        }
    }
    mysql_query("ROLLBACK");
}

echo json_encode($return);