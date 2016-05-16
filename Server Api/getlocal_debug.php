<?php
/**
 * Created by PhpStorm.
 * User: liurong
 * Date: 15/7/16
 * Time: 20:45
 */
ini_set("display_errors", "On");
require_once("./config.php");
header("Content-Type: text/html; charset=UTF-8");
$lat = "103.953667";
$lng = "30.778714";

$ln = $lat . "," . $lng;
$url = "http://yuntuapi.amap.com/datasearch/local?city=全国&keywords= tableid={$amap_tab}&key={$amap_key}";
$arr = get($url);

// if ($arr->status == 1) {
//     if ($arr->count == 0) {
//         //没有店铺信息
//         $return['status'] = 3;
//         $return['msg'] = "没有店铺信息";
//         $return['val'] = $arr;
//     } else {
//         if ($arr->count == 0) {
//             //没有店铺信息
//             $return['status'] = 3;
//             $return['msg'] = "没有店铺信息";
//         } else {
//             $arrData = (array)$arr->datas;
//             $reaArr = "(";
//             for ($i = 0; $i < count($arrData); $i++) {
//                 if ($i == (count($arrData) - 1)) {
//                     $reaArr .= $arrData[$i]->bus;
//                 } else {
//                     $reaArr .= $arrData[$i]->bus . ",";
//                 }
//             }
//             $reaArr .= ")";
//         }
//     }
// } else {
//     //获取失败
//     $return['status'] = 1;
//     $return['msg'] = "信息获取失败";
// }

function get($url)
{
    $result = file_get_contents($url);
    echo($result);
}

// echo json_encode($return);