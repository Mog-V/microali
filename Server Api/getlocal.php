<?php
require_once("./config.php");
header("Content-Type: text/html; charset=UTF-8");

if(isset($_POST['pho'])&&isset($_POST['lat'])&&isset($_POST['lng'])){
    $pho=$_POST['pho'];
    $lat=$_POST['lat'];
    $lng=$_POST['lng'];
    mysql_connect($db_url,$db_user,$db_pas);
    mysql_select_db($db_name);
    mysql_query("set names 'utf8'");
    $time=time();
    //mysql_query("insert into user_local(pho,time,lat,lng) values['$pho','$time','$lat','$lng']");

    $ln=$lng.",".$lat;
    $url="http://yuntuapi.amap.com/datasearch/around?tableid={$amap_tab}&radius=50000&center=$ln&key={$amap_key}";

    $arr=get($url);

    if($arr->status==1){
        if($arr->count==0){
            //没有店铺信息
            $return['status']=3;$return['msg']="没有店铺信息";
        }else{
            $arrData=(array) $arr->datas;
            $reaArr="(";
            for($i=0;$i<count($arrData);$i++){
                if($i==(count($arrData)-1)){
                    $reaArr.=$arrData[$i]->bus;
                }else{
                    $reaArr.=$arrData[$i]->bus.",";
                }
            }
            $reaArr.=")";

            $sql="select * from bus where sta=1 and id in {$reaArr}";
            if($result=mysql_query($sql)){
                $arr=array();
                while($row = mysql_fetch_array($result)){
                    $arr2=array('id'=>$row[0],
                        'name'=>$row[4],
                        'img'=>$row[9],
                        'local'=>$row[8],
                        'trade'=>"暂无分类",
                        'call'=>$row[1]);
                    array_push($arr,$arr2);
                }
                $return['status']=0;$return['msg']="信息获取成功";$return['val']=$arr;
            }else{
                $return['status']=1;$return['msg']="信息获取失败";
            }
        }
    }else{
        //获取失败
        $return['status']=1;$return['msg']="信息获取失败";
    }
}

function get($url)
{
    $result=file_get_contents($url);
    return json_decode($result);
}

echo json_encode($return);