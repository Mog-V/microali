<?php

$return = array('status' => 0,
    'val' => '0',
    'msg' => "执行成功");

$return['val'] = array(
    't1'=>1,//   0--未获得；1--使用中；2--已使用；3--已失效
    't2'=>1
);

echo json_encode($return);