<?php
require '../../../zb_system/function/c_system_base.php';
require '../../../zb_system/function/c_system_admin.php';
$zbp->Load();

$json['code'] = 200;
$json['message'] = "成功";

$baiduapp = new Baiduapp;
$swipers = $baiduapp->GetSwiperList(null, array(
    array("=", "baiduapp_swiper_Status", "1"),
), array("baiduapp_swiper_Order" => "DESC"));
if (count($swipers) > 0) {
    foreach ($swipers as $item) {
        $json['swiper'][] = baiduapp_JSON_SwiperToJson($item);
    }
}

echo json_encode($json);

function baiduapp_JSON_SwiperToJson($item)
{
    $data = json_decode($item->__toString());
    unset($data->Meta);
    switch ($item->Type) {
        case 'normal':
            $data->route = null;
        break;
        case 'article':
            $data->route = "/pages/article/index?id=".$item->Related;
        break;
        case 'page':
            $data->route = "/pages/page/index?id=".$item->Related;
        break;
        case 'search':
            $data->route = "/pages/search/index?word=".$item->Related;
        break;
    }

    return $data;
}