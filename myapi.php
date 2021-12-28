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
			$json['swiper'][] = yuran_zixun_JSON_SwiperToJson($item);
		}
	}

	$swipers = $baiduapp->GetSwiperList(null, array(
		array("=", "baiduapp_swiper_Status", "1"),
		array("=", "baiduapp_swiper_Class", "1"),
	), array("baiduapp_swiper_Order" => "DESC"));
	if (count($swipers) > 0) {
		foreach ($swipers as $item) {
			$json['toolnav'][] = yuran_zixun_JSON_SwiperToJson($item);
		}
	}

	$json['info']['name']=$zbp->Config('yuran_zixun')->name;
	$json['info']['title']=$zbp->Config('yuran_zixun')->title;
	$json['info']['keywords']=$zbp->Config('yuran_zixun')->keywords;
	$json['info']['description']=$zbp->Config('yuran_zixun')->description;
	$json['info']['cloudcache']=(int)$zbp->Config('yuran_zixun')->cloudcache;
	$json['info']['contacton']=(int)$zbp->Config('yuran_zixun')->contacton;
	$json['info']['appbanner']=(int)$zbp->Config('yuran_zixun')->appbanner;
	$json['info']['comlist']=(int)$zbp->Config('yuran_zixun')->comlist;
	$json['info']['searchqh']=(int)$zbp->Config('yuran_zixun')->searchqh;
	$json['info']['moduleId']=(int)$zbp->Config('yuran_zixun')->moduleId;
	$json['info']['aboutid']=(int)$zbp->Config('yuran_zixun')->aboutid;
	$json['info']['navimg']=$zbp->host."zb_users/plugin/yuran_zixun/images/navimg.png";
	return array('data' => $json);
}

function api_yuran_search() {
	global $zbp;
	$red = explode(',', $zbp->Config('yuran_zixun')->search);
	$json['red']=$red;
	return array('data' => $json);
}