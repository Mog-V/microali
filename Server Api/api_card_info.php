<?php
require_once("./config.php");

if (isset($_GET['num'])) {
    $num = $_GET['num'];
    $id = 0;
    $st = "获取信息失败";
    $shop = '未知';
    mysql_connect($db_url, $db_user, $db_pas);
    mysql_select_db($db_name);
    mysql_query("set names 'utf8'");
    if (mysql_num_rows($res1 = mysql_query("select * from card where qdcode='$num'")) > 0) {
        $row = mysql_fetch_row($res1);
        $id = $row[0];
        $st = "卡卷无效";
        $return['msg'] = "找到卡卷ID！";
        if (mysql_num_rows($res2 = mysql_query("select bus.shop from bus,card_bus where bus.id=card_bus.bus and card_bus.cardid='$id'")) > 0) {
            $row1 = mysql_fetch_row($res2);
            $shop = $row1[0];
            if (mysql_num_rows(mysql_query("select * from card_bind where num='$id'")) > 0) {
                $return['msg'] = "卡卷已激活！";
            } else {
                $st = "可以激活";//卡卷未激活
                $return['msg'] = "卡卷有效！";
            }
        }
    }
    $return['status'] = 0;
    $return['val'] = array("id" => $id,
                            "st" => $st,
                            "shop" => $shop);
}

echo json_encode($return);
