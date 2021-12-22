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
        <?php echo yuran_zixun_SubMenu(3); ?>
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
                    <td class="td30"><p align='left'><b>开启云缓存加速</b></p></td>
                    <td>
                        <input id="edtoriginal" name="yuran['cloudcache']" type="text" value="<?php echo (int)$zbp->Config('yuran_zixun')->cloudcache; ?>" class="checkbox"/>
                    </td>
                </tr>
                <tr>
                    <td class="td30"><p align='left'><b>开启首页轮播图</b></p></td>
                    <td>
                        <input id="edtoriginal" name="yuran['contacton']" type="text" value="<?php echo (int)$zbp->Config('yuran_zixun')->contacton; ?>" class="checkbox"/>
                    </td>
                </tr>
                <tr>
                    <td class="td30"><p align='left'><b>关闭新文章摘要生成</b></p></td>
                    <td>
                        <input id="edtoriginal" name="yuran['newintro']" type="text" value="<?php echo (int)$zbp->Config('yuran_zixun')->newintro; ?>" class="checkbox"/>
                    </td>
                </tr>
                <tr>
                    <td class="td30"><p align='left'><b>开启老文章摘要处理</b></p></td>
                    <td>
                        <input id="edtoriginal" name="yuran['oldintro']" type="text" value="<?php echo (int)$zbp->Config('yuran_zixun')->oldintro; ?>" class="checkbox"/>
                    </td>
                </tr>
                <tr>
                    <td class="td30"><p align='left'><b>开启文章页内视频展示</b></p></td>
                    <td>
                        <input id="edtoriginal" name="yuran['videoon']" type="text" value="<?php echo (int)$zbp->Config('yuran_zixun')->videoon; ?>" class="checkbox"/>
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