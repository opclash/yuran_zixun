<?php
require '../../../zb_system/function/c_system_base.php';
require '../../../zb_system/function/c_system_admin.php';
$zbp->Load();
$action='root';
if (!$zbp->CheckRights($action)) {$zbp->ShowError(6);die();}
if (!$zbp->CheckPlugin('yuran_zixun')) {$zbp->ShowError(48);die();}

$blogtitle='百度智能小程序';
require $blogpath . 'zb_system/admin/admin_header.php';
require $blogpath . 'zb_system/admin/admin_top.php';
?>

<div id="divMain">
    <div class="divHeader"><?php echo $blogtitle;?></div>
    <div class="SubMenu">
        <?php echo yuran_zixun_SubMenu(5); ?>
    </div>
    <div id="divMain2">

            <table border="1" class="tableFull tableBorder">
                <tr>
                    <th class="td30"><p align='left'><b>标题</b><br><span class='note'></span></p></th>
                    <th>说明</th>
                </tr>
                <tr>
                    <td class="td30"><p align='left'><b>首页</b></p></td>
                    <td>/pages/home/index</td>
                </tr>
                <tr>
                    <td class="td30"><p align='left'><b>文章页</b></p></td>
                    <td>/pages/article/index?id=文章id</td>
                </tr>
                <tr>
                    <td class="td30"><p align='left'><b>分类中心</b></p></td>
                    <td>/pages/sorts/index</td>
                </tr>
                <tr>
                    <td class="td30"><p align='left'><b>关于我们</b></p></td>
                    <td>/pages/about/index</td>
                </tr>
                <tr>
                    <td class="td30"><p align='left'><b>分类列表页</b></p></td>
                    <td>/pages/list/index?id=分类id</td>
                </tr>
                <tr>
                    <td class="td30"><p align='left'><b>索引页路径</b></p></td>
                    <td>/swan-sitemap/index</td>
                </tr>
                <tr>
                    <td class="td30"><p align='left'><b>轮播图修改地址</b></p></td>
                    <td><a href="https://smartprogram.baidu.com/developer/vscloud/applist.html?pagetype=banner" target="_blank" textvalue="轮播图管理（点击访问）">轮播图管理（点击访问）</a>，自定义的无视</td>
                </tr>
            </table>

    </div>
</div>

<?php
require $blogpath . 'zb_system/admin/admin_footer.php';   	    	 	    	    	    			    			 			 
RunTime(); 			     	  	  	  	 				
?>