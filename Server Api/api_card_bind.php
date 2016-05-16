<?php
require_once("./config.php");

if(isset($_POST['pho'])&&isset($_POST['acs'])&&isset($_POST['num'])){
    $pho=$_POST['pho'];
    $acs=$_POST['acs'];
    $qd=$_POST['num'];
    mysql_connect($db_url,$db_user,$db_pas);
    mysql_select_db($db_name);
    mysql_query("set names 'utf8'");
    mysql_query("BEGIN");
    if(mysql_num_rows(mysql_query("select * from user where pho='$pho' and acs='$acs'"))>0){
        $bsql="select * from card where qdcode='$qd'";
        $bresult=mysql_query($bsql);
        $brow=  mysql_fetch_row($bresult);
        $num=$brow[0];
        if(//卡卷有效性的判断
            mysql_num_rows(mysql_query("select * from card_bus where cardid='$num'"))>0&&//卡卷已经绑定到商家账户（可以激活）
            mysql_num_rows(mysql_query("select * from card_bind where num='$num'"))==0//卡卷未绑定
        ){
            //绑定卡卷
            if(mysql_query("insert into card_bind(num,pho,time) values('$num','$pho','$time')")){
                $return['status']=0;
                mysql_query("update user set exp=exp+1 where pho='$pho'");
                mysql_query("COMMIT");
                //TO DO....
                //判断是否可排队
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

            }

        }else{
            $return['msg']=mysql_error();}



    }else{
        $return['status']=2;$return['msg']="认证码过期！";
    }
    mysql_query("ROLLBACK");
}

echo json_encode($return);

