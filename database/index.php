<?php
/**
 * 相关数据库结构信息
 */
$zblogapp_database = array(
    /**
     * Swiper管理表
     */
    'zblogapp_swiper'   => array(
        'name'           => '%pre%zblogapp_swiper',
        'info'           => array(
            'ID'          => array('zblogapp_swiper_ID','integer','',0),
            'Related'     => array('zblogapp_swiper_Related','string',255,''),
            'Type'        => array('zblogapp_swiper_Type','string',255,''),
            'Imgurl'      => array('zblogapp_swiper_Imgurl','string',255,''),
            'Order'       => array('zblogapp_swiper_Order','integer','',0),
            'Status'      => array('zblogapp_swiper_Status','integer','',0),
            'Class'      => array('zblogapp_swiper_Class','integer','',0),
            'Meta'        => array('zblogapp_swiper_Meta','string','',''),
        ),
    ),
);
foreach ($zblogapp_database as $k => $v) {
    $table[$k] = $v['name'];
    $datainfo[$k] = $v['info'];
}
/**
 * 检查是否有创建数据库
 */
function zblogapp_CreateTable() {
    global $zbp, $zblogapp_database;
    foreach ($zblogapp_database as $k => $v) {
        if (!$zbp->db->ExistTable($v['name'])) {
            $s = $zbp->db->sql->CreateTable($v['name'],$v['info']);
            $zbp->db->QueryMulit($s);
        }
    }
}

class zblogappSwiper extends Base {
    public function __construct() {
        global $zbp;
        parent::__construct($zbp->table['zblogapp_swiper'], $zbp->datainfo['zblogapp_swiper'], __CLASS__);
    }
}

class zblogapp extends ZBlogPHP {
    /**
     * GetSwiperList
     * 获取Swiper列表
     */
    public function GetSwiperList($select = null, $w = null, $order = null, $limit = null, $option = null) {
        global $zbp;
        if (empty($select)) {
            $select = array('*');
        }
        if (empty($w)) {
            $w = array();
        }

        $sql = $zbp->db->sql->Select(
            $zbp->table['zblogapp_swiper'],
            $select,
            $w,
            $order,
            $limit,
            $option
        );
        $result = $zbp->GetListType('zblogappSwiper', $sql);

        return $result;
    }
}
