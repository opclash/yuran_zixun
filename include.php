<?php
include_once __DIR__.'/database/index.php';
#注册插件

RegisterPlugin("yuranapp","ActivePlugin_yuranapp");

function ActivePlugin_yuranapp() {
    Add_Filter_Plugin('Filter_Plugin_PostArticle_Core', 'yuranapp_PostArticle_Core');
    Add_Filter_Plugin('Filter_Plugin_API_Get_Object_Array', 'yuranapp_API_Get_Object_Array');
    Add_Filter_Plugin('Filter_Plugin_Edit_Response3','yuranapp_Edit_Response3');
    Add_Filter_Plugin('Filter_Plugin_PostArticle_Succeed','yuranapp_PostArticle_Succeed');
    Add_Filter_Plugin('Filter_Plugin_API_Extend_Mods', 'yuranapp_API');
    Add_Filter_Plugin('Filter_Plugin_Admin_TopMenu', 'yuranapp_Admin_SiteInfo_SubMenu');
}

function InstallPlugin_yuranapp() {
    baiduapp_CreateTable();
}

function UninstallPlugin_yuranapp() {}

function yuranapp_API() {
	return array('yuran' => __DIR__ . '/myapi.php');
}

function yuranapp_Admin_SiteInfo_SubMenu(&$m)
{
  global $zbp;
  $m[] = MakeTopMenu("root", '百度小程序设置', $zbp->host . "zb_users/plugin/yuranapp/show.php", "", "topmenu_metro",'icon-zblog-appcenter');
}

function yuranapp_SubMenu($id){
	$arySubMenu = array(
		0 => array('插件说明', 'show', 'left', false),
        1 => array('小程序配置', 'set', 'left', false),
		2 => array('Swiper设置', 'main', 'left', false),
        3 => array('功能配置', 'tool', 'left', false),
        4 => array('首页导航配置', 'home', 'left', false),
        5 => array('链接说明', 'url', 'left', false),
	);
	foreach($arySubMenu as $k => $v){
		echo '<a href="./'.$v[1].'.php" '.($v[3]==true?'target="_blank"':'').'><span class="m-'.$v[2].' '.($id==$k?'m-now':'').'">'.$v[0].'</span></a>';
	}
}

function yuranapp_PostArticle_Succeed($article){
    global $zbp;
    if($article->Status)  return ;
    if((int) $article->Metas->search1==1){
        yuranapp_baiduapp_Post($article->ID,1);
    }
    if((int) $article->Metas->search0==1){
        yuranapp_baiduapp_Post($article->ID,0);
    }
    if((int) $article->Metas->search2==1){
        yuranapp_baiduapp_Post($article->ID,2);
    }
}


function yuranapp_baiduapp_spost($id,$title,$intro){
    global $zbp;
    $client_id=$zbp->Config('yuranapp')->appkey;
    $client_secret=$zbp->Config('yuranapp')->appsecret;
    $url="https://openapi.baidu.com/oauth/2.0/token?grant_type=client_credentials&client_id=".$client_id."&client_secret=".$client_secret."&scope=smartapp_snsapi_base";
    $ajax = Network::Create();
    $ajax->open('GET', $url);
    $ajax->enableGzip();
    $ajax->setTimeOuts(60, 60, 0, 0);
    $ajax->send();
    $response = json_decode($ajax->responseText, true);
    if (empty($response['access_token'])){
        $zbp->SetHint('good','推送搜索失败');
    }else{
        $access_token=$response['access_token'];
        
        $post='[{
            "path":"/pages/article/index?id='.$id.'",
            "jump_app_key":"'.$client_id.'",      
            "title":"'.$title.'",   
            "mapp_type":2001,              
            "schema":"{\"datatype\":2,\"desc\":\"'.$intro.'\",\"detail\":{\"params\":{\"title\":\"'.$client_id.'\",\"desc\":\"'.$intro.'\",\"app_key\":\"'.$client_id.'\",\"jump_url\":\"/pages/article/index?id='.$id.'\",\"jump_type\":0}}}"
        }]';
    
        $header = array("Content-Type:application/json");
        $api = "https://openapi.baidu.com/rest/2.0/smartapp/search/submit/schema?access_token=".$access_token;
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $api);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
        $result = curl_exec($curl);
        $zbp->SetHint('good','推送成功');
    }
}


function yuranapp_baiduapp_Post($id,$type){
    global $zbp;
    $client_id=$zbp->Config('yuranapp')->appkey;
    $client_secret=$zbp->Config('yuranapp')->appsecret;
    $url="https://openapi.baidu.com/oauth/2.0/token?grant_type=client_credentials&client_id=".$client_id."&client_secret=".$client_secret."&scope=smartapp_snsapi_base";
    $ajax = Network::Create();
    $ajax->open('GET', $url);
    $ajax->enableGzip();
    $ajax->setTimeOuts(60, 60, 0, 0);
    $ajax->send();
    $response = json_decode($ajax->responseText, true);
    if (empty($response['access_token'])){
        $zbp->SetHint('good','百度小程序收录推送失败');
    }else{
        $access_token=$response['access_token'];
        $api = 'https://openapi.baidu.com/rest/2.0/smartapp/access/submitsitemap/api?access_token='.$access_token;
        $ajaxa = Network::Create();
        $ajaxa->open('POST', $api);
        $ajaxa->enableGzip();
        $ajaxa->setTimeOuts(120, 120, 0, 0);
        $posturl='/pages/article/index?id='.$id;
        $urls = array(
            $posturl
        );
        $data['type'] = $type;
        $data['url_list'] = implode(",", $urls);
        $ajaxa->send($data);
        if($ajaxa->status == 200){
            $response = json_decode($ajaxa->responseText, true);
            if($response['errno']==0){
                $zbp->SetHint('good','百度小程序收录推送成功');
            }else{
                $zbp->SetHint('good','百度小程序收录推送失败：'.$response['msg']);
            }
        }else{
            $zbp->SetHint('good','百度小程序快收推送失败');
        }
    }
}

function yuranapp_Edit_Response3(){
    global $zbp,$article;
    echo '<div id="original" class="editmod">
    <label for="edtoriginal" class="editinputname">小程序天级收录</label>
    <input id="edtoriginal" name="meta_search1" style="" type="text" value="0" class="checkbox"/>
    </div>';
    echo '<div id="original" class="editmod">
    <label for="edtoriginal" class="editinputname">小程序搜索提交</label>
    <input id="edtoriginal" name="meta_search2" style="" type="text" value="0" class="checkbox"/>
    </div>';
    $videoon=(int)$zbp->Config('yuranapp')->videoon;
    if($videoon==1){
    echo '<div id="original" class="editmod">
    <label for="edtoriginal" class="editinputname">开启视频展示</label>
    <input id="edtoriginal" name="meta_videoon" style="" type="text" value="'.(int) $article->Metas->videoon.'" class="checkbox"/>
    </div>';
    }
    echo '<div id="original" class="editmod">
    <label for="edtoriginal" class="editinputname">开启大图展示</label>
    <input id="edtoriginal" name="meta_datuad" style="" type="text" value="'.(int) $article->Metas->datuad.'" class="checkbox"/>
    </div>';
}

function yuranapp_PostArticle_Core(&$article) {
    global $zbp;
    $on=(int)$zbp->Config('yuranapp')->newintro;
    if($on==0){
        $intro=preg_replace('/[\r\n\s]+/', '', trim((TransferHTML($article->Content,'[nohtml]'))));
        $intro=str_replace("&nbsp;","",$intro);
        $intro=str_replace('style=""',"",$intro);
        $intro=SubStrUTF8($intro,45)."...";
        $article->Intro=$intro;
    }
}

function yuranapp_API_Get_Object_Array(&$object, &$array) {
    global $zbp,$mod,$act;
    switch (get_class($object)) {
        case 'Post':
            $array['CateName'] = $zbp->GetCategoryByID($object->CateID)->Name;
            $array['Thumb'] = GetImagesFromHtml($object->Content);
            $array['Thumb'] = Thumb::Thumbs($array['Thumb'], 350, 240,3);
            $array['Tagn'] = explode(',', $object->TagsName);
            $on=(int)$zbp->Config('yuranapp')->oldintro;
            $array['TagsNames']=$object->TagsName;
            if($object->TagsCount==0){
                $array['TagsNames']=$array['CateName'];
            }
            if($on==1){
                $intro=preg_replace('/[\r\n\s]+/', '', trim((TransferHTML($object->Content,'[nohtml]'))));
                $intro=str_replace("&nbsp;","",$intro);
                $intro=str_replace('style=""',"",$intro);
                $intro=SubStrUTF8($intro,45)."...";
                $array['Intro'] =$intro;
            }
            $array['videoon'] = (int)$object->Metas->videoon;
			$array['datuad'] = (int)$object->Metas->datuad;
            if($act != "list"){
                $array['AuthorName'] = $zbp->GetMemberByID($object->AuthorID)->StaticName;
                $array['AuthorAvatar'] = $zbp->GetMemberByID($object->AuthorID)->Avatar;
                $getlist=GetList(4, $object->CateID);
                $datelist=array();
                foreach ($getlist as $key=>$article) {
                    $datelist[$key]['title']=$article->Title;
                    $datelist[$key]['id']=$article->ID;
                    $datelist[$key]['intro']=$article->Intro;
                }
                $array['RelatedList'] = $datelist;
            }
            break;
        default:
            # code...
            break;
    }
}

function yuranapp_JSON_SwiperToJson($item)
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
        case 'category':
            $data->route = "/pages/list/index?id=".$item->Related;
        break;
        case 'about':
            $data->route = "/pages/about/index";
        break;
        case 'yewu':
            $data->route = "/pages/yewu/index";
        break;
    }
    return $data;
}