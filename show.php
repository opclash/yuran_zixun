<?php
require '../../../zb_system/function/c_system_base.php';
require '../../../zb_system/function/c_system_admin.php';
$zbp->Load();
$action='root';
if (!$zbp->CheckRights($action)) {$zbp->ShowError(6);die();}
if (!$zbp->CheckPlugin('yuran_zixun')) {$zbp->ShowError(48);die();}

if (count($_POST) > 0) {
    CheckIsRefererValid();
}

$sql = $zbp->db->sql->get()->ALTER("%pre%baiduapp_swiper")
->ADDCOLUMN('baiduapp_swiper_Class integer NOT NULL DEFAULT \'0\'')
->sql;
$zbp->db->QueryMulit($sql);

$blogtitle='百度智能小程序';
require $blogpath . 'zb_system/admin/admin_header.php';
require $blogpath . 'zb_system/admin/admin_top.php';
?>

<div id="divMain">
    <div class="divHeader"><?php echo $blogtitle;?></div>
    <div class="SubMenu">
        <?php echo yuran_zixun_SubMenu(0); ?>
    </div>
    <div id="divMain2">

        <form enctype="multipart/form-data" method="post" action="save.php?type=base">  
            <input id="reset" name="reset" type="hidden" value="" />
            <table border="1" class="tableFull tableBorder">
                <tr>
                    <th class="td30"><p align='left'><b>标题</b><br><span class='note'></span></p></th>
                    <th>说明</th>
                </tr>
                <tr>
                    <td class="td30"><p align='left'><b>前提条件</b></p></td>
                    <td>准备SSL加密证书，开启CDN加速，申请百度小程序云缓存+推荐组件</td>
                </tr>
                <tr>
                    <td class="td30"><p align='left'><b>特别说明</b></p></td>
                    <td>上传小程序代码前，请先配置根目录的app.json文件</td>
                </tr>
                <tr>
                    <td class="td30"><p align='left'><b>技术支持</b></p></td>
                    <td><a target="_blank" href="https://opssh.cn/">彧繎叔叔</a></td>
                </tr>
                <tr>
                    <td class="td30"><p align='left'><b>合作伙伴</b></p></td>
					<td><a target="_blank" href="https://www.ytecn.com/">豫唐网络</a></td>
                </tr>
            </table>
        </form>
    </div>
</div>

<?php
require $blogpath . 'zb_system/admin/admin_footer.php';   	    	 	    	    	    			    			 			 
RunTime(); 			     	  	  	  	 				
?>