<?php
require_once("./config.php");

if(isset($_POST['pho'])&&isset($_POST['acs'])&&isset($_POST['num'])){
	$pho=$_POST['pho'];
	$acs=$_POST['acs'];
	$num=$_POST['num'];
        $id=0;
        $st=0;
        $shop='——';
	mysql_connect($db_url,$db_user,$db_pas);
	mysql_select_db($db_name);
	mysql_query("set names 'utf8'");
	if(mysql_num_rows(mysql_query("select * from user where pho='$pho' and acs='$acs'"))>0){
            $sql="select * from card where qdcode='$num'";
		if(mysql_num_rows($result=mysql_query($sql))>0){
                    $row=  mysql_fetch_row($result);
                    $id=$row[0];
                    $st=$row[6];
                    if(mysql_num_rows($result=mysql_query("select bus.shop,sale_list.sum,sale_list.time from bus,sale_list,card_sale where bus.id=sale_list.shop and sale_list.id=card_sale.sale and card_sale.num='$id'"))>0){
                        $row1=  mysql_fetch_row($result);
                        $shop= $row1[0];
                        $sum=$row1[1];
                        $date=  date("Y-m-d",$row1[2]);
                    }
                    $return['status']=0;
                    $return['val']=array("id"=>$id,
                                            "st"=>$st,
                                            "shop"=>$shop,
                                            "sum"=>$sum,
                                            "date"=>$date);
                }else{
			$return['msg']=mysql_error();}
        
	}else{
		$return['status']=2;$return['msg']="认证码过期！";
	}
}

echo json_encode($return);

