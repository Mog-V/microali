<?php
ini_set("display_errors", "On");
require_once("./config.php");

mysql_connect($db_url, $db_user, $db_pas);
mysql_select_db($db_name);
mysql_query("set names 'utf8'");
$tine = strtotime(date('Y-m-d'));
$arr=array();
$list = mysql_query("select pho,num from card_bind where num not in (select num from card_wait) and pho not in (select pho from card_wait where time>'$tine' group by pho having count(pho)>='$maxbind')");
while ($list_row = mysql_fetch_row($list)) {
    $pho = $list_row[0];
    $num = (int)$list_row[1];
    array_push($arr,array($pho,$num));
}

shuffle($arr);


foreach($arr as $val){
    $pho=$val[0];
    $num=$val[1];
    echo "pho:".$pho."<br>";
    echo "num:".$num."<br>";
    $sql_a = "select num from card_wait where pho='$pho' and num in (select num from card_bus where bus = (select bus from card_bus where card_bus.cardid='$num'))";
    $sql_b = "select pho from card_wait where time>'$tine' and pho = '$pho' and num not in (select num from card_ed)";
    if (mysql_num_rows(mysql_query($sql_a)) < $maxwait && mysql_num_rows(mysql_query($sql_b)) < $maxbind) {
        echo "提现人电话:" . $pho . "________________卡券编号：" . $num;
        echo "<br>";
    if (mysql_query("insert into card_wait(num,pho,time) values('$num','$pho','$time')")) {
        echo "insert into card_wait(num,pho,time) values('$num','$pho','$time')" . "<br>";
        echo "提现成功";
    }
    echo mysql_error();
    echo "<br>";
    $minid = mysql_num_rows(mysql_query("select * from card_ed"));
    $rows = mysql_num_rows(mysql_query("select * from card_wait"));
    $maxid = floor($rows / 25) - $minid;
    $result = mysql_query("select * from card_wait where num not in (select num from card_ed) limit $maxid");
    while ($rown = mysql_fetch_row($result)) {
        $rnum = $rown[1];
        $rpho = $rown[2];
        mysql_query("insert into card_ed(num,pho,time) values('$rnum','$rpho','$time')");
        mysql_query("update user set exp=exp+100 where pho='$pho'");
    }
    mysql_query("update user set exp=exp+10 where pho='$pho'");
    }
}


