<?php
require '../../../zb_system/function/c_system_base.php';
require '../../../zb_system/function/c_system_admin.php';
$zbp->Load();
$action='root';
if (!$zbp->CheckRights($action)) {$zbp->ShowError(6);die();}
if (!$zbp->CheckPlugin('yuran_zixun')) {$zbp->ShowError(48);die();}

$type = GetVars("type", "GET");
switch ($type) {
    case "swiper":
        $id = GetVars("id", "GET");
        $save_param = array(
            "Imgurl",
            "Type",
            "Related",
            "Order",
            "Status"
        );
        $swiper = new BaiduappSwiper;
        if (!empty($id)) {
            $swiper->LoadInfoByID((int) $id);
        }
        $imgurl = GetVars("Imgurl", "POST");
        if (empty($imgurl)) {
            $zbp->SetHint('bad', "请输入图片地址");
            Redirect("./main.php");
            break;
        }
        foreach ($save_param as $v) {
            $swiper->$v = GetVars($v, "POST");
        }
        $swiper->Class = 0;
        FilterMeta($swiper);
        $swiper->Save();

        $zbp->SetHint('good', "保存成功");
        Redirect("./main.php");
    break;
    case "swiper_del":
        $id = GetVars("id", "GET");
        $swiper = new BaiduappSwiper;
        if (!empty($id)) {
            $swiper->LoadInfoByID((int) $id);
        }
        $swiper->Del();

        $zbp->SetHint('good', "删除成功");
        Redirect("./main.php");
    break;
    default:
        Redirect("./main.php");
    break;
}
