<?php
/**
 * 相关数据库结构信息
 */
$baiduapp_database = array(
    /**
     * Swiper管理表
     */
    'baiduapp_swiper'   => array(
        'name'           => '%pre%baiduapp_swiper',
        'info'           => array(
            'ID'          => array('baiduapp_swiper_ID','integer','',0),
            'Related'     => array('baiduapp_swiper_Related','string',255,''),
            'Type'        => array('baiduapp_swiper_Type','string',255,''),
            'Imgurl'      => array('baiduapp_swiper_Imgurl','string',255,''),
            'Order'       => array('baiduapp_swiper_Order','integer','',0),
            'Status'      => array('baiduapp_swiper_Status','integer','',0),
            'Class'      => array('baiduapp_swiper_Class','integer','',0),
            'Meta'        => array('baiduapp_swiper_Meta','string','',''),
        ),
    ),
);
foreach ($baiduapp_database as $k => $v) {
    $table[$k] = $v['name'];
    $datainfo[$k] = $v['info'];
}
/**
 * 检查是否有创建数据库
 */
function baiduapp_CreateTable() {
    global $zbp, $baiduapp_database;
    foreach ($baiduapp_database as $k => $v) {
        if (!$zbp->db->ExistTable($v['name'])) {
            $s = $zbp->db->sql->CreateTable($v['name'],$v['info']);
            $zbp->db->QueryMulit($s);
        }
    }
}

class BaiduappSwiper extends Base {
    public function __construct() {
        global $zbp;
        parent::__construct($zbp->table['baiduapp_swiper'], $zbp->datainfo['baiduapp_swiper'], __CLASS__);
    }
}



$yurancollect_database = array(
    /**
     * Swiper管理表
     */
    'yuran_ask'   => array(
        'name'           => '%pre%yuranbd_ask',
        'info'           => array(
            'ID'=>array('coll_ID','integer','',0),
            'AuthorID'=>array('coll_AuthorID','integer','',0),
            'Title'=>array('coll_Title','string',255,''),
            'PostTime'=>array('coll_PostTime','integer','',0),
            'IP'=>array('coll_IP','string',255,''),
            'Intro' => array('coll_Intro', 'string', '', ''),
            'Content' => array('coll_Content', 'string', '', ''),
            'Type' => array('coll_Type','integer','',0),
            'more' => array('coll_Meta', 'string', '', '')
        ),
    ),
);
foreach ($yurancollect_database as $k => $v) {
    $table[$k] = $v['name'];
    $datainfo[$k] = $v['info'];
}

function yuran_zixun_CreateTable() {
    global $zbp, $yurancollect_database;
    foreach ($yurancollect_database as $k => $v) {
        if (!$zbp->db->ExistTable($v['name'])) {
            $s = $zbp->db->sql->CreateTable($v['name'],$v['info']);
            $zbp->db->QueryMulit($s);
        }
    }
}

class daycollect extends Base {
    public function __construct() {
        global $zbp;
        parent::__construct($zbp->table['yuran_ask'], $zbp->datainfo['yuran_ask'], __CLASS__);
    }
}

class Baiduapp extends ZBlogPHP {
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
            $zbp->table['baiduapp_swiper'],
            $select,
            $w,
            $order,
            $limit,
            $option
        );
        $result = $zbp->GetListType('BaiduappSwiper', $sql);
        return $result;
    }

    public function GetaslList($select = null, $w = null, $order = null, $limit = null, $option = null) {
        global $zbp;
        if (empty($select)) {
            $select = array('*');
        }
        if (empty($w)) {
            $w = array();
        }
        $sql = $zbp->db->sql->Select(
            $zbp->table['yuran_ask'],
            $select,
            $w,
            $order,
            $limit,
            $option
        );
        $result = $zbp->GetListType('daycollect', $sql);
        return $result;
    }
}