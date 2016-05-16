<?php
date_default_timezone_set('PRC');
$db_url = "rdsp73269sp1ugfprer0q.mysql.rds.aliyuncs.com";
$db_user = "vali";
$db_pas = "zyj123456";
$db_name = "dundun";
$return = array('status' => 1,
    'val' => '0',
    'msg' => "执行错误");


$amap_key = "affd1be7948e7676eec3081f9a47c422";
$amap_tab = "55a68c73e4b0a76fce235dab";


$maxbind = 2;
$maxwait = 10;

$time = time();

$iparr = array('111.9.35.215', '119.116.83.52', '42.87.231.180', '0.0.0.0');
$ip = getip();

/*  返回值说明
 *  1---默认返回错误
 *  0---请求成功
 *
 *
 *
 *
 *
 *
 *
 *
 *
 */
function getip()
{
    $onlineip = '';
    if (getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')) {
        $onlineip = getenv('HTTP_CLIENT_IP');
    } elseif (getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')) {
        $onlineip = getenv('HTTP_X_FORWARDED_FOR');
    } elseif (getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')) {
        $onlineip = getenv('REMOTE_ADDR');
    } elseif (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
        $onlineip = $_SERVER['REMOTE_ADDR'];
    }
    return $onlineip;
}

?>