<?php
require '../../../zb_system/function/c_system_base.php';
require '../../../zb_system/function/c_system_admin.php';
$zbp->Load();
$action='root';
if (!$zbp->CheckRights($action)) {$zbp->ShowError(6);die();}
if (!$zbp->CheckPlugin('yuran_zixun')) {$zbp->ShowError(48);die();}

if (count($_POST) > 0) {
    CheckIsRefererValid();
    if (isset($_POST['yuran'])) {
        foreach ($_POST['yuran'] as $key => $val) {
            $zbp->Config('yuran_zixun')->$key = $val;
        }
        $zbp->SaveConfig('yuran_zixun');
        $zbp->SetHint('good', '参数已保存');
    }
}

$blogtitle='百度智能小程序';
require $blogpath . 'zb_system/admin/admin_header.php';
require $blogpath . 'zb_system/admin/admin_top.php';
?>

<div id="divMain">
    <div class="divHeader"><?php echo $blogtitle;?></div>
    <div class="SubMenu">
        <?php echo yuran_zixun_SubMenu(1); ?>
    </div>
    <div id="divMain2">

        <form id="form1" name="form1" method="post">
            <input type="hidden" name="csrfToken" value="<?php echo $zbp->GetCSRFToken();?>">
            <table border="1" class="tableFull tableBorder">
                <tr>
                    <th class="td30"><p align='left'><b>标题</b><br><span class='note'></span></p></th>
                    <th>说明</th>
                </tr>
                <tr>
                    <td class="td30"><p align='left'><b>App Key</b></p></td>
                    <td>
                        <input name="yuran['appkey']" id="appkey" type="text" value="<?php echo $zbp->Config('yuran_zixun')->appkey; ?>" style="width:90%;height:30px;letter-spacing:1px; " required="required" />
                    </td>
                </tr>
                <tr>
                    <td class="td30"><p align='left'><b>App Secret</b></p></td>
                    <td>
                        <input name="yuran['appsecret']" id="appsecret" type="text" value="<?php echo $zbp->Config('yuran_zixun')->appsecret; ?>" style="width:90%;height:30px;letter-spacing:1px; " required="required" />
                    </td>
                </tr>
                <tr>
                    <td class="td30"><p align='left'><b>小程序名称</b></p></td>
                    <td>
                        <input name="yuran['name']" id="cloudcache" type="text" value="<?php echo $zbp->Config('yuran_zixun')->name; ?>" style="width:90%;height:30px;letter-spacing:1px; " required="required" />
                    </td>
                </tr>
                <tr>
                    <td class="td30"><p align='left'><b>小程序标题</b></p></td>
                    <td>
                        <input name="yuran['title']" id="cloudcache" type="text" value="<?php echo $zbp->Config('yuran_zixun')->title; ?>" style="width:90%;height:30px;letter-spacing:1px; " required="required" />
                    </td>
                </tr>
                <tr>
                    <td class="td30"><p align='left'><b>小程序关键词</b></p></td>
                    <td>
                        <input name="yuran['keywords']" id="cloudcache" type="text" value="<?php echo $zbp->Config('yuran_zixun')->keywords; ?>" style="width:90%;height:30px;letter-spacing:1px; " required="required" />
                    </td>
                </tr>
                <tr>
                    <td class="td30"><p align='left'><b>小程序描述</b></p></td>
                    <td>
                        <input name="yuran['description']" id="cloudcache" type="text" value="<?php echo $zbp->Config('yuran_zixun')->description; ?>" style="width:90%;height:30px;letter-spacing:1px; " required="required" />
                    </td>
                </tr>
                <tr>
                    <td class="td30"><p align='left'><b>首页轮播图ID值</b></p></td>
                    <td>
                        <input name="yuran['moduleId']" id="cloudcache" type="text" value="<?php echo (int)$zbp->Config('yuran_zixun')->moduleId; ?>" placeholder="填写轮播图的ID，不填不显示"  style="width:90%;height:30px;letter-spacing:1px; " required="required" />
                    </td>
                </tr>
                <tr>
                    <td class="td30"><p align='left'><b>关于我们文章ID值</b></p></td>
                    <td>
                        <input name="yuran['aboutid']" id="cloudcache" type="text" value="<?php echo (int)$zbp->Config('yuran_zixun')->aboutid; ?>" placeholder="填写文章的ID，不填不显示" style="width:90%;height:30px;letter-spacing:1px; " required="required" />
                    </td>
                </tr>
                <tr>
                    <td class="td30"></td>
                    <td>
                    <input name="" type="Submit" class="button" value="保存" />
                    </td>
                </tr>
            </table>
        </form>

        
    </div>
</div>

<?php
require $blogpath . 'zb_system/admin/admin_footer.php';   	    	 	    	    	    			    			 			 
RunTime(); 			     	  	  	  	 				
?>