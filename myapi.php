<?php

function api_yuran_info() {
	global $zbp;
	$baiduapp = new Baiduapp;
	$swipers = $baiduapp->GetSwiperList(null, array(
		array("=", "baiduapp_swiper_Status", "1"),
		array("=", "baiduapp_swiper_Class", "0"),
	), array("baiduapp_swiper_Order" => "DESC"));
	if (count($swipers) > 0) {
		foreach ($swipers as $item) {
			$json['swiper'][] = yuranapp_JSON_SwiperToJson($item);
		}
	}

	$swipers = $baiduapp->GetSwiperList(null, array(
		array("=", "baiduapp_swiper_Status", "1"),
		array("=", "baiduapp_swiper_Class", "1"),
	), array("baiduapp_swiper_Order" => "DESC"));
	if (count($swipers) > 0) {
		foreach ($swipers as $item) {
			$json['toolnav'][] = yuranapp_JSON_SwiperToJson($item);
		}
	}

	$json['info']['name']=$zbp->Config('yuranapp')->name;
	$json['info']['title']=$zbp->Config('yuranapp')->title;
	$json['info']['keywords']=$zbp->Config('yuranapp')->keywords;
	$json['info']['description']=$zbp->Config('yuranapp')->description;
	$json['info']['cloudcache']=(int)$zbp->Config('yuranapp')->cloudcache;
	$json['info']['contacton']=(int)$zbp->Config('yuranapp')->contacton;
	$json['info']['mzid']=(int)$zbp->Config('yuranapp')->mzid;
	$json['info']['aboutid']=(int)$zbp->Config('yuranapp')->aboutid;
	$json['info']['aboutimg']=$zbp->host."zb_users/plugin/yuranapp/images/wave.gif";
	return array('data' => $json);
}

function api_yuran_search() {
	global $zbp;
	$red = explode(',', $zbp->Config('yuranapp')->search);
	$json['red']=$red;
	return array('data' => $json);
}