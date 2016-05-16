<?php
/**
 * Created by PhpStorm.
 * User: liurong
 * Date: 15/7/22
 * Time: 16:10
 */
ini_set("display_errors", "On");
require_once("./config.php");
if (isset($_GET['bus'])) {
    $bus = $_GET['bus'];
    mysql_connect($db_url, $db_user, $db_pas);
    mysql_select_db($db_name);
    mysql_query("set names 'utf8'");

    if ($result = mysql_query("select pho,dsc,lev from bus where id='$bus' and sta=1")) {
        $row = mysql_fetch_array($result);
        $arr = json_encode(array('pho' => $row[0],
            'dsc' =>(String)$row[1],'lev'=>(int)$row[2]));
        $return['status'] = 0;
        $return['msg'] = "信息获取成功";
        $return['val'] = $arr;
    }
    echo mysql_error();
}
echo json_encode($return);