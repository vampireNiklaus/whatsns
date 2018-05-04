<?php

defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class Update extends CI_Controller {
	var $whitelist;
	function __construct() {
		$this->whitelist = "index";
		parent::__construct ();
		$this->load->model ( 'usergroup_model' );

	}

	function index() {

		header ( "Content-Type: text/html;charset=utf-8" );

		$sql = "CREATE TABLE IF NOT EXISTS `" . $this->db->dbprefix . "article_support` (
  `sid` char(16) NOT NULL,
  `aid` int(10) NOT NULL,
  `time` int(10) NOT NULL,
  PRIMARY KEY (`sid`,`aid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
		$this->db->query ( $sql );
		echo ' 更新成功:新增article_support文章评论点赞表<br>';

		//新增文章评论表
		$sql="CREATE TABLE `" . $this->db->dbprefix ."article_comment` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `tid` int(10) NOT NULL,
  `authorid` int(10) NOT NULL,
  `author` char(18) NOT NULL,
  `content` varchar(500) NOT NULL DEFAULT '',
  `time` int(10) NOT NULL DEFAULT '0',
  `aid` int(11) DEFAULT NULL COMMENT '文章评论id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
		";
		$this->db->query ( $sql );
		echo ' 更新成功:新增article_comment文章评论回复表<br>';
		//---用户邀请码
		//-----
		$sql_class1 = "alter table " . $this->db->dbprefix . "user add COLUMN invatecode VARCHAR(200)  DEFAULT NULL;";
		$this->db->query ( $sql_class1 );
		echo ' 更新成功:更新user表，增加invatecode邀请码字段<br>';
	    //---邀请人的邀请码
		//-----
		$sql_class1 = "alter table " . $this->db->dbprefix . "user add COLUMN frominvatecode VARCHAR(200)  DEFAULT NULL;";
		$this->db->query ( $sql_class1 );
		echo ' 更新成功:更新user表，增加frominvatecode邀请码字段<br>';
		//---用户邀请人数
		//-----
		$sql_class1 = "alter table " . $this->db->dbprefix . "user add COLUMN invateusers int(10)  DEFAULT 0;";
		$this->db->query ( $sql_class1 );
		echo ' 更新成功:更新user表，增加invateusers邀请码字段<br>';
		//------
		$sql_model = "select * from " . $this->db->dbprefix . "setting where k='weixin_fenceng_zuijia'";

		$result_model = $this->db->query ( $sql_model );
		$numlogo1 = 0;
		foreach ( $result_model->result_array () as $logo ) {

			$numlogo1 = count ( $logo );
		}

		if ($numlogo1 > 1) {
			echo "setting表weixin_fenceng_zuijia存在<br>";
		} else {
			$sql_model1 = "insert into " . $this->db->dbprefix . "setting  values('weixin_fenceng_zuijia','0.1')";
			$this->db->query ( $sql_model1 );
			echo ' 更新成功:更新setting表，增加weixin_fenceng_zuijia<br>';
		}
		//-----
		$sql_model = "select * from " . $this->db->dbprefix . "setting where k='weixin_fenceng_hangjia'";

		$result_model = $this->db->query ( $sql_model );
		$numlogo1 = 0;
		foreach ( $result_model->result_array () as $logo ) {

			$numlogo1 = count ( $logo );
		}

		if ($numlogo1 > 1) {
			echo "setting表weixin_fenceng_zuijia存在<br>";
		} else {
			$sql_model1 = "insert into " . $this->db->dbprefix . "setting  values('weixin_fenceng_hangjia','0.1')";
			$this->db->query ( $sql_model1 );
			echo ' 更新成功:更新setting表，增加weixin_fenceng_hangjia<br>';
		}
		//-----
		$sql_model = "select * from " . $this->db->dbprefix . "setting where k='weixin_fenceng_toutingpingtai'";

		$result_model = $this->db->query ( $sql_model );
		$numlogo1 = 0;
		foreach ( $result_model->result_array () as $logo ) {

			$numlogo1 = count ( $logo );
		}

		if ($numlogo1 > 1) {
			echo "setting表weixin_fenceng_toutingpingtai存在<br>";
		} else {
			$sql_model1 = "insert into " . $this->db->dbprefix . "setting  values('weixin_fenceng_toutingpingtai','0.2')";
			$this->db->query ( $sql_model1 );
			echo ' 更新成功:更新setting表，增加weixin_fenceng_toutingpingtai<br>';
		}
		//-----
		$sql_model = "select * from " . $this->db->dbprefix . "setting where k='weixin_fenceng_toutingtiwen'";

		$result_model = $this->db->query ( $sql_model );
		$numlogo1 = 0;
		foreach ( $result_model->result_array () as $logo ) {

			$numlogo1 = count ( $logo );
		}

		if ($numlogo1 > 1) {
			echo "setting表weixin_fenceng_toutingtiwen存在<br>";
		} else {
			$sql_model1 = "insert into " . $this->db->dbprefix . "setting  values('weixin_fenceng_toutingtiwen','0.4')";
			$this->db->query ( $sql_model1 );
			echo ' 更新成功:更新setting表，增加weixin_fenceng_toutingtiwen<br>';
		}
		//-----
		$sql_model = "select * from " . $this->db->dbprefix . "setting where k='weixin_fenceng_toutinghuida'";

		$result_model = $this->db->query ( $sql_model );
		$numlogo1 = 0;
		foreach ( $result_model->result_array () as $logo ) {

			$numlogo1 = count ( $logo );
		}

		if ($numlogo1 > 1) {
			echo "setting表weixin_fenceng_toutinghuida存在<br>";
		} else {
			$sql_model1 = "insert into " . $this->db->dbprefix . "setting  values('weixin_fenceng_toutinghuida','0.4')";
			$this->db->query ( $sql_model1 );
			echo ' 更新成功:更新setting表，增加weixin_fenceng_toutinghuida<br>';
		}
		//-----
		$sql_model = "select * from " . $this->db->dbprefix . "setting where k='cansetcatnum'";

		$result_model = $this->db->query ( $sql_model );
		$numlogo1 = 0;
		foreach ( $result_model->result_array () as $logo ) {

			$numlogo1 = count ( $logo );
		}

		if ($numlogo1 > 1) {
			echo "setting表cansetcatnum存在<br>";
		} else {
			$sql_model1 = "insert into " . $this->db->dbprefix . "setting  values('cansetcatnum','3')";
			$this->db->query ( $sql_model1 );
			echo ' 更新成功:更新setting表，增加cansetcatnum<br>';
		}
		//-----
		$sql_model = "select * from " . $this->db->dbprefix . "setting where k='list_answernum'";

		$result_model = $this->db->query ( $sql_model );
		$numlogo1 = 0;
		foreach ( $result_model->result_array () as $logo ) {

			$numlogo1 = count ( $logo );
		}

		if ($numlogo1 > 1) {
			echo "setting表list_answernum存在<br>";
		} else {
			$sql_model1 = "insert into " . $this->db->dbprefix . "setting  values('list_answernum','3')";
			$this->db->query ( $sql_model1 );
			echo ' 更新成功:更新setting表，增加list_answernum<br>';
		}
		//-----
		$sql_model = "select * from " . $this->db->dbprefix . "setting where k='list_topdatanum'";

		$result_model = $this->db->query ( $sql_model );
		$numlogo1 = 0;
		foreach ( $result_model->result_array () as $logo ) {

			$numlogo1 = count ( $logo );
		}

		if ($numlogo1 > 1) {
			echo "setting表list_topdatanum存在<br>";
		} else {
			$sql_model1 = "insert into " . $this->db->dbprefix . "setting  values('list_topdatanum','3')";
			$this->db->query ( $sql_model1 );
			echo ' 更新成功:更新setting表，增加list_topdatanum<br>';
		}
		//-----
		$sql_model = "select * from " . $this->db->dbprefix . "setting where k='jingyan'";

		$result_model = $this->db->query ( $sql_model );
		$numlogo1 = 0;
		foreach ( $result_model->result_array () as $logo ) {

			$numlogo1 = count ( $logo );
		}

		if ($numlogo1 > 1) {
			echo "setting表jingyan存在<br>";
		} else {
			$sql_model1 = "insert into " . $this->db->dbprefix . "setting  values('jingyan','200')";
			$this->db->query ( $sql_model1 );
			echo ' 更新成功:更新setting表，增加jingyan<br>';
		}
		//-----
		$sql = "
CREATE TABLE IF NOT EXISTS `" . $this->db->dbprefix . "autocaiji` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `caiji_url` varchar(100) NOT NULL COMMENT '采集网址',
  `tiwenshijian` int(11) NOT NULL COMMENT '提问时间',
  `huidashijian` int(11) NOT NULL COMMENT '回答时间',
  `caiji_prefix` varchar(100) NOT NULL COMMENT '采集列表规则',
  `category1` int(11) NOT NULL COMMENT '一级分类',
  `category2` int(11) NOT NULL COMMENT '2级分类',
  `category3` int(11) NOT NULL COMMENT '3级分类',
  `cid` int(11) NOT NULL COMMENT '当前选择的分类id',
  `ckabox` int(11) NOT NULL COMMENT '过滤回答超链接',
  `imgckabox` int(11) NOT NULL COMMENT '过滤图片',
  `bianma` varchar(100) NOT NULL COMMENT '网页编码',
  `guize` varchar(100) NOT NULL COMMENT '其它回答',
  `daanyuming` varchar(100) NOT NULL COMMENT '域名',
  `daandesc` varchar(100) NOT NULL COMMENT '描述',
  `caiji_best` varchar(100) NOT NULL COMMENT '最佳答案',
  `caiji_hdusername` varchar(100) NOT NULL COMMENT '采集用户名',
  `caiji_hdusertx` varchar(100) NOT NULL COMMENT '采集头像',
  `source` varchar(100) NOT NULL COMMENT '采集来源',
    `biaotiguolv` text NOT NULL COMMENT '标题过滤',
      `miaosuguolv` text NOT NULL COMMENT '问题描述过滤',
        `neirongguolv` text NOT NULL COMMENT '问题回答过滤',
        `usernameguolv` text NOT NULL COMMENT '用户名过滤',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
    	";

		$this->db->query ( $sql );
		echo ' 更新成功:新增autocaiji表<br>';
		//--增加支付宝支付成功订单表
		//-------
		$sql = "CREATE TABLE IF NOT EXISTS `" . $this->db->dbprefix . "alipayorder` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `discount` varchar(200) NOT NULL COMMENT '折扣价格',
  `payment_type` varchar(200) NOT NULL COMMENT '付款类型',
  `trade_no` varchar(200) NOT NULL COMMENT '交易流水号',
  `subject` varchar(200) NOT NULL COMMENT '交易主题',
  `buyer_email` varchar(200) NOT NULL COMMENT '付款人支付宝账号',
  `gmt_create` varchar(200) NOT NULL COMMENT '订单创建时间',
  `notify_type` varchar(200) NOT NULL COMMENT '通知类型，同步还是异步',
  `quantity` varchar(200) NOT NULL COMMENT '质量',
    `out_trade_no` varchar(200) NOT NULL  COMMENT '',
  `seller_id` varchar(200) NOT NULL COMMENT '',
  `notify_time` varchar(200) NOT NULL,
  `body` varchar(200) NOT NULL,
  `trade_status` varchar(200) NOT NULL,
  `is_total_fee_adjust` varchar(200) NOT NULL,
  `total_fee` varchar(200) NOT NULL,
  `gmt_payment` varchar(200) NOT NULL,
  `seller_email` varchar(200) NOT NULL,
  `price` varchar(200) NOT NULL,
  `buyer_id` varchar(200) NOT NULL,
   `notify_id` varchar(200) NOT NULL,
    `use_coupon` varchar(200) NOT NULL,
     `sign_type` varchar(200) NOT NULL,
      `sign` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;";
		$this->db->query ( $sql );
		echo ' 更新成功:新增alipayorder支付宝订单支付表<br>';
		//-----
		$sql = "alter table " . $this->db->dbprefix . "alipayorder add COLUMN uid int(10) DEFAULT 0;";
		$this->db->query ( $sql );
		echo ' 更新成功:更新alipayorder表，增加uid字段<br>';
		//-----
		$sql = "alter table " . $this->db->dbprefix . "question_tag add COLUMN pinyin varchar(200) DEFAULT '';";
		$this->db->query ( $sql );
		echo ' 更新成功:更新question_tag表，增加pinyin字段<br>';
		//-----
		$sql = "alter table " . $this->db->dbprefix . "topic_tag add COLUMN pinyin varchar(200) DEFAULT '';";
		$this->db->query ( $sql );
		echo ' 更新成功:更新topic_tag表，增加pinyin字段<br>';

		//---------


		//-------
		$sql = "CREATE TABLE IF NOT EXISTS `" . $this->db->dbprefix . "vertify` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `uid` int(11) NOT NULL COMMENT '用户uid唯一标示',
  `type` int(11) NOT NULL COMMENT '认证类型,企业还是个人',
  `name` varchar(200) NOT NULL COMMENT '用户名或者企业名字',
  `id_code` varchar(200) NOT NULL COMMENT '身份证或者企业组织机构代码',
  `jieshao` text NOT NULL COMMENT '认证说明',
  `zhaopian1` varchar(200) NOT NULL COMMENT '身份证或者组织机构代码证',
  `zhaopian2` varchar(200) NOT NULL COMMENT '其它附件照片',
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '审核状态',
  `time` int(10) NOT NULL COMMENT '认证时间',
  `shibaiyuanyin` varchar(500) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;";
		$this->db->query ( $sql );
		echo ' 更新成功:新增vertify认证表<br>';
		//---
		$sql_bankcard = "alter table " . $this->db->dbprefix . "autocaiji add COLUMN source VARCHAR(100) DEFAULT NULL;";
		$this->db->query ( $sql_bankcard );
		echo ' 更新成功:更新autocaiji表，增加source字段<br>';

		//---------


		$sql = "
CREATE TABLE IF NOT EXISTS `" . $this->db->dbprefix . "weixin_order` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `appid` varchar(200) NOT NULL,
  `openid` varchar(200) NOT NULL,
  `mch_id` varchar(200) NOT NULL,
  `is_subscribe` varchar(100) NOT NULL,
  `nonce_str` varchar(200) NOT NULL,
  `product_id` varchar(200) NOT NULL,
  `sign` varchar(200) NOT NULL,
  `result_code` varchar(100) NOT NULL,
  `return_code` varchar(100) NOT NULL,
  `return_msg` varchar(100) NOT NULL,
  `trade_type` varchar(100) NOT NULL,
  `code_url` varchar(200) NOT NULL,
  `time` int(10) NOT NULL,
  `type` varchar(100) NOT NULL,
  `typeid` int(10) NOT NULL,
  `money` int(10) NOT NULL,
  `touid` int(10) NOT NULL,
   `title` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
		$this->db->query ( $sql );
		echo ' 更新成功:新增微信支付订单表<br>';

		$sql = "
CREATE TABLE IF NOT EXISTS `" . $this->db->dbprefix . "user_tixian` (
  `id` int(10) NOT NULL AUTO_INCREMENT,

  `uid` int(10) NOT NULL,
  `jine` double NOT NULL,
  `state` int(10) NOT NULL,
  `time` int(10) NOT NULL,
  `beizu` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
		$this->db->query ( $sql );
		echo ' 更新成功:新增用户提现表<br>';

		$sql = "ALTER TABLE  `ask_weixin_keywords` ADD  `title` VARCHAR( 200 ) NOT NULL ,
ADD  `content` TEXT NOT NULL ,
ADD  `fmtu` VARCHAR( 200 ) NOT NULL ,
ADD  `wzid` INT( 10) NOT NULL ,
ADD  `wburl` VARCHAR( 200 ) NOT NULL";
		$this->db->query ( $sql );
		echo ' 更新成功:更新微信关键词表，增加图文标题，封面图片,图文内容和外部链接字段<br>';

		$sql_select_logo = "select * from " . $this->db->dbprefix . "setting where k='baidu_api'";

		$result_sitelogo = $this->db->query ( $sql_select_logo );
		$numlogo1 = 0;
		foreach ( $result_sitelogo->result_array () as $logo ) {

			$numlogo1 = count ( $logo );
		}

		if ($numlogo1 > 1) {
			echo "setting表baidu_api存在<br>";
		} else {
			$sql_sitelogo1 = "insert into " . $this->db->dbprefix . "setting  values('baidu_api','')";
			$this->db->query ( $sql_sitelogo1 );
			echo ' 更新成功:更新setting表，增加baidu_api<br>';
		}
		//------
		$sql_model = "select * from " . $this->db->dbprefix . "setting where k='admin_list_default'";

		$result_model = $this->db->query ( $sql_model );
		$numlogo1 = 0;
		foreach ( $result_model->result_array () as $logo ) {

			$numlogo1 = count ( $logo );
		}

		if ($numlogo1 > 1) {
			echo "setting表admin_list_default存在<br>";
		} else {
			$sql_model1 = "insert into " . $this->db->dbprefix . "setting  values('admin_list_default','30')";
			$this->db->query ( $sql_model1 );
			echo ' 更新成功:更新setting表，增加admin_list_default<br>';
		}
		//------
		$sql_model = "select * from " . $this->db->dbprefix . "setting where k='jingyan'";

		$result_model = $this->db->query ( $sql_model );
		$numlogo1 = 0;
		foreach ( $result_model->result_array () as $logo ) {

			$numlogo1 = count ( $logo );
		}

		if ($numlogo1 > 1) {
			echo "setting表jingyan存在<br>";
		} else {
			$sql_model1 = "insert into " . $this->db->dbprefix . "setting  values('jingyan','200')";
			$this->db->query ( $sql_model1 );
			echo ' 更新成功:更新setting表，增加jingyan<br>';
		}

		//---------------


		$sql_select_logo = "select * from " . $this->db->dbprefix . "setting where k='banner_color'";

		$result_sitelogo = $this->db->query ( $sql_select_logo );
		$numlogo1 = 0;
		foreach ( $result_sitelogo->result_array () as $logo ) {

			$numlogo1 = count ( $logo );
		}

		if ($numlogo1 > 1) {
			echo "setting表banner_color存在<br>";
		} else {
			$sql_sitelogo1 = "insert into " . $this->db->dbprefix . "setting  values('banner_color','#858c96')";
			$this->db->query ( $sql_sitelogo1 );
			echo ' 更新成功:更新setting表，增加banner_color<br>';
		}
		//---------------
		$sql_select_logo = "select * from " . $this->db->dbprefix . "setting where k='editor_choose'";

		$result_sitelogo = $this->db->query ( $sql_select_logo );
		$numlogo1 = 0;
		foreach ( $result_sitelogo->result_array () as $logo ) {

			$numlogo1 = count ( $logo );
		}

		if ($numlogo1 > 1) {
			echo "setting表editor_choose存在<br>";
		} else {
			$sql_sitelogo1 = "insert into " . $this->db->dbprefix . "setting  values('editor_choose','1')";
			$this->db->query ( $sql_sitelogo1 );
			echo ' 更新成功:更新setting表，增加editor_choose<br>';
		}
		//---------------
		$sql_select_logo = "select * from " . $this->db->dbprefix . "setting where k='hct_logincode'";

		$result_sitelogo = $this->db->query ( $sql_select_logo );
		$numlogo1 = 0;
		foreach ( $result_sitelogo->result_array () as $logo ) {

			$numlogo1 = count ( $logo );
		}

		if ($numlogo1 > 1) {
			echo "setting表hct_logincode存在<br>";
		} else {
			$code = rand ( 11111111, 999999999 );
			$sql_sitelogo1 = "insert into " . $this->db->dbprefix . "setting  values('hct_logincode',$code)";
			$this->db->query ( $sql_sitelogo1 );
			echo ' 更新成功:更新setting表，增加hct_logincode火车头采集文章的全局变量<br>';
		}

		//---------------


		$sql_select_logo = "select * from " . $this->db->dbprefix . "setting where k='banner_img'";

		$result_sitelogo = $this->db->query ( $sql_select_logo );
		$numlogo1 = 0;
		foreach ( $result_sitelogo->result_array () as $logo ) {

			$numlogo1 = count ( $logo );
		}

		if ($numlogo1 > 1) {
			echo "setting表banner_img存在<br>";
		} else {
			$sql_sitelogo1 = "insert into " . $this->db->dbprefix . "setting  values('banner_img','https://gss0.bdstatic.com/7051cy89RcgCncy6lo7D0j9wexYrbOWh7c50/zhidaoribao/2016/0710/top.jpg')";
			$this->db->query ( $sql_sitelogo1 );
			echo ' 更新成功:更新setting表，增加banner_img<br>';
		}

		//-------------
		try {
			$groupid = 2;
			$regular_code = ',user/sendcheckmail,user/editemail';

			$group = $this->usergroup_model->get ( $groupid );

			if (! strstr ( $group ['regulars'], $regular_code )) {
				$tmp = $group ['regulars'] . $regular_code;
				$group ['regulars'] = $tmp;
				$this->usergroup_model->update ( $groupid, $group );
			}

			$groupid = 3;
			$group = $this->usergroup_model->get ( $groupid );
			if (! strstr ( $group ['regulars'], $regular_code )) {
				$tmp = $group ['regulars'] . $regular_code;
				$group ['regulars'] = $tmp;
				$this->usergroup_model->update ( $groupid, $group );
			}

			for($i = 7; $i <= 26; $i ++) {
				$group = $this->usergroup_model->get ( $i );
				if (! strstr ( $group ['regulars'], $regular_code )) {
					$tmp = $group ['regulars'] . $regular_code;
					$group ['regulars'] = $tmp;
					$this->usergroup_model->update ( $i, $group );
				}
			}
		} catch ( Exception $e ) {
		}

		//-----------------
		$sql_select_logo = "select * from " . $this->db->dbprefix . "setting where k='register_on'";

		$result_sitelogo = $this->db->query ( $sql_select_logo );
		$numlogo1 = 0;
		foreach ( $result_sitelogo->result_array () as $logo ) {

			$numlogo1 = count ( $logo );
		}

		if ($numlogo1 > 1) {
			echo "setting表register_on存在<br>";
		} else {
			$sql_sitelogo1 = "insert into " . $this->db->dbprefix . "setting  values('register_on','0')";
			$this->db->query ( $sql_sitelogo1 );
			echo ' 更新成功:更新setting表，增加register_on<br>';
		}
		//-----------------------------
		$sql_select_logo = "select * from " . $this->db->dbprefix . "setting where k='hot_on'";

		$result_sitelogo = $this->db->query ( $sql_select_logo );
		$numlogo1 = 0;
		foreach ( $result_sitelogo->result_array () as $logo ) {

			$numlogo1 = count ( $logo );
		}

		if ($numlogo1 > 1) {
			echo "setting表hot_on存在<br>";
		} else {
			$sql_sitelogo1 = "insert into " . $this->db->dbprefix . "setting  values('hot_on','0')";
			$this->db->query ( $sql_sitelogo1 );
			echo ' 更新成功:更新setting表，增加hot_on<br>';
		}

		//---------------------
		$sql_select_logo = "select * from " . $this->db->dbprefix . "setting where k='title_description'";

		$result_sitelogo = $this->db->query ( $sql_select_logo );
		$numlogo1 = 0;
		foreach ( $result_sitelogo->result_array () as $logo ) {

			$numlogo1 = count ( $logo );
		}

		if ($numlogo1 > 1) {
			echo "setting表title_description存在<br>";
		} else {
			$sql_sitelogo1 = "insert into " . $this->db->dbprefix . "setting  values('title_description','知名专家为您解答')";
			$this->db->query ( $sql_sitelogo1 );
			echo ' 更新成功:更新setting表，增加title_description<br>';
		}

		//------------------------------
		$sql_select_logo = "select * from " . $this->db->dbprefix . "setting where k='search_shownum'";

		$result_sitelogo = $this->db->query ( $sql_select_logo );
		$numlogo1 = 0;
		foreach ( $result_sitelogo->result_array () as $logo ) {

			$numlogo1 = count ( $logo );
		}

		if ($numlogo1 > 1) {
			echo "setting表search_shownum存在<br>";
		} else {
			$sql_sitelogo1 = "insert into " . $this->db->dbprefix . "setting  values('search_shownum','5')";
			$this->db->query ( $sql_sitelogo1 );
			echo ' 更新成功:更新setting表，增加search_shownum<br>';
		}

		//------------------------------
		$sql_select_logo = "select * from " . $this->db->dbprefix . "setting where k='site_logo'";

		$result_sitelogo = $this->db->query ( $sql_select_logo );
		$numlogo1 = 0;
		foreach ( $result_sitelogo->result_array () as $logo ) {

			$numlogo1 = count ( $logo );
		}

		if ($numlogo1 > 1) {
			echo "setting表site_logo存在<br>";
		} else {
			$sql_sitelogo1 = "insert into " . $this->db->dbprefix . "setting  values('site_logo','站点别名')";
			$this->db->query ( $sql_sitelogo1 );
			echo ' 更新成功:更新setting表，增加site_logo<br>';
		}

		//--------------------------------------
		$sql_site_qrcode = "select * from " . $this->db->dbprefix . "setting where k='site_qrcode'";

		$result_qrcode = $this->db->query ( $sql_site_qrcode );
		$numqrcode = 0;
		foreach ( $result_qrcode->result_array () as $qrcode ) {

			$numqrcode = count ( $qrcode );
		}

		if ($numqrcode > 1) {
			echo "setting表site_qrcode存在<br>";
		} else {
			$sql_qrcode = "insert into " . $this->db->dbprefix . "setting  values('site_qrcode','站点别名')";
			$this->db->query ( $sql_qrcode );
			echo ' 更新成功:更新setting表，增加site_qrcode<br>';
		}

		$sql_select_setting1 = "select * from " . $this->db->dbprefix . "setting where k='site_alias'";

		$result_setting1 = $this->db->query ( $sql_select_setting1 );
		$num1 = 0;
		foreach ( $result_setting1->result_array () as $user1 ) {

			$num1 = count ( $user1 );
		}

		if ($num1 > 1) {
			echo "setting表site_alias存在<br>";
		} else {
			$sql_setting1 = "insert into " . $this->db->dbprefix . "setting  values('site_alias','站点别名')";
			$this->db->query ( $sql_setting1 );
			echo ' 更新成功:更新setting表，增加site_alias<br>';
		}
		$sql_select_setting2 = "select * from " . $this->db->dbprefix . "setting where k='maxindex_keywords'";

		$result_setting2 = $this->db->query ( $sql_select_setting2 );
		$num2 = 0;
		foreach ( $result_setting2->result_array () as $user2 ) {

			$num2 = count ( $user2 );
		}

		if ($num2 > 1) {
			echo "setting表maxindex_keywords,pagemaxindex_keywords存在<br>";
		} else {
			$sql_setting2 = "insert into " . $this->db->dbprefix . "setting  values('maxindex_keywords','3'),('pagemaxindex_keywords','8')";
			$this->db->query ( $sql_setting2 );
			echo ' 更新成功:更新setting表，增加maxindex_keywords,pagemaxindex_keywords<br>';
		}
		//-----
		$sql_class1 = "alter table " . $this->db->dbprefix . "topic add COLUMN likes int(10)  DEFAULT 0;";
		$this->db->query ( $sql_class1 );
		echo ' 更新成功:更新topic表，增加likes字段<br>';

		//-----
		$sql_class1 = "alter table " . $this->db->dbprefix . "user add COLUMN activecode VARCHAR(200)  DEFAULT NULL;";
		$this->db->query ( $sql_class1 );
		echo ' 更新成功:更新user表，增加activecode字段<br>';
		//-----
		$sql_class1 = "alter table " . $this->db->dbprefix . "user add COLUMN phoneactive int(10)  DEFAULT 0;";
		$this->db->query ( $sql_class1 );
		echo ' 更新成功:更新user表，增加activecode字段<br>';
		//----
		$sql_class1 = "alter table " . $this->db->dbprefix . "answer add COLUMN serverid VARCHAR(200) DEFAULT NULL;";
		$this->db->query ( $sql_class1 );
		echo ' 更新成功:更新answer表，增加serverid字段<br>';

		//----askcity


		$sql_class1 = "alter table " . $this->db->dbprefix . "question add COLUMN askcity VARCHAR(200) DEFAULT NULL;";
		$this->db->query ( $sql_class1 );
		echo ' 更新成功:更新question表，增加askcity字段<br>';
		//----
		$sql_class1 = "alter table " . $this->db->dbprefix . "answer add COLUMN openid VARCHAR(200) DEFAULT NULL;";
		$this->db->query ( $sql_class1 );
		echo ' 更新成功:更新answer表，增加openid字段<br>';
		//----
		$sql_class1 = "alter table " . $this->db->dbprefix . "user add COLUMN openid VARCHAR(200) DEFAULT NULL;";
		$this->db->query ( $sql_class1 );
		echo ' 更新成功:更新user表，增加openid字段<br>';
		//----
		$sql_class1 = "alter table " . $this->db->dbprefix . "user add COLUMN hasvertify int(10) DEFAULT 0;";
		$this->db->query ( $sql_class1 );
		echo ' 更新成功:更新user表，增加hasvertify字段<br>';
		//----


		$sql_class1 = "alter table " . $this->db->dbprefix . "answer add COLUMN voicetime int(10) DEFAULT 0;";
		$this->db->query ( $sql_class1 );
		echo ' 更新成功:更新answer表，增加voicetime字段<br>';

		//-----
		$sql_class1 = "alter table " . $this->db->dbprefix . "question add COLUMN hasvoice int(10) DEFAULT 0;";
		$this->db->query ( $sql_class1 );
		echo ' 更新成功:更新question表，增加hasvoice字段<br>';
		//-----
		$sql_class1 = "alter table " . $this->db->dbprefix . "question add COLUMN askuid int(10) DEFAULT 0;";
		$this->db->query ( $sql_class1 );
		echo ' 更新成功:更新question表，增加askuid字段<br>';
		//-----
		$sql_class1 = "ALTER TABLE  `" . $this->db->dbprefix . "category` ADD  `miaosu` text NOT NULL ,
ADD  `image` VARCHAR( 200 ) NOT NULL ,ADD  `followers` INT( 10 ) NOT NULL;";
		$this->db->query ( $sql_class1 );
		$sql_class1 = "ALTER TABLE  `" . $this->db->dbprefix . "category` ADD  `isshowindex` int(10) DEFAULT 1 ,
ADD  `isusearticle` int(10) DEFAULT 1 ,ADD  `isuseask` int(10) DEFAULT 1;";
		$this->db->query ( $sql_class1 );
		echo ' 更新成功:更新category表，增加isshowindex和isusearticle，isuseask字段<br>';
		//-----
		$sql_class1 = "ALTER TABLE  `" . $this->db->dbprefix . "category` ADD  `template` VARCHAR( 200 ) NOT NULL ;";
		$this->db->query ( $sql_class1 );
		echo ' 更新成功:更新category表，增加template模板字段<br>';
		//-----
		$sql_class1 = "alter table " . $this->db->dbprefix . "user add COLUMN active int(10) DEFAULT 0;";
		$this->db->query ( $sql_class1 );
		echo ' 更新成功:更新user表，增加active字段<br>';
		//----
		$sql_class1 = "alter table " . $this->db->dbprefix . "user add COLUMN jine double DEFAULT 0;";
		$this->db->query ( $sql_class1 );
		echo ' 更新成功:更新user表，增加jine字段<br>';
		//----
		$sql_class1 = "alter table " . $this->db->dbprefix . "question add COLUMN shangjin double DEFAULT 0;";
		$this->db->query ( $sql_class1 );
		echo ' 更新成功:更新question表，增加shangjin字段<br>';
		//----


		$sql_class1 = "alter table " . $this->db->dbprefix . "user add COLUMN articles int(10) DEFAULT 0;";
		$this->db->query ( $sql_class1 );
		echo ' 更新成功:更新user表，增加articles字段<br>';
		$sql_class1 = "alter table " . $this->db->dbprefix . "topic add COLUMN articles int(10) DEFAULT 0;";
		$this->db->query ( $sql_class1 );
		echo ' 更新成功:更新topic表，增加articles字段<br>';

		$sql_class1 = "alter table " . $this->db->dbprefix . "user add COLUMN mypay double DEFAULT 0;";
		$this->db->query ( $sql_class1 );
		echo ' 更新成功:更新user表，增加mypay字段<br>';
		$sql_class1 = "alter table " . $this->db->dbprefix . "user add COLUMN fromsite int(10) DEFAULT 0;";
		$this->db->query ( $sql_class1 );
		echo ' 更新成功:更新user表，增加fromsite字段<br>';
		//------
		$sql_class1 = "alter table " . $this->db->dbprefix . "answer add COLUMN reward DOUBLE DEFAULT 0;";
		$this->db->query ( $sql_class1 );
		echo ' 更新成功:更新answer表，增加reward字段<br>';
		$sql_class1 = "alter table " . $this->db->dbprefix . "user add COLUMN isblack int(10) DEFAULT 0;";
		$this->db->query ( $sql_class1 );
		echo ' 更新成功:更新user表，增加isblack字段<br>';

		$sql_class1 = "alter table " . $this->db->dbprefix . "usergroup add COLUMN doarticle int(10) DEFAULT 0;";
		$this->db->query ( $sql_class1 );
		echo ' 更新成功:更新usergroup表，增加doarticle字段<br>';

		$sql_class1 = "alter table " . $this->db->dbprefix . "usergroup add COLUMN articlelimits int(10) DEFAULT 1;";
		$this->db->query ( $sql_class1 );
		echo ' 更新成功:更新usergroup表，增加articlelimits字段<br>';

		//------
		$sql_class1 = "alter table " . $this->db->dbprefix . "weixin_order add COLUMN prepay_id VARCHAR(200) DEFAULT 0;";
		$this->db->query ( $sql_class1 );
		echo ' 更新成功:更新weixin_order表，增加prepay_id字段<br>';
		//------
		$sql_class1 = "alter table " . $this->db->dbprefix . "category add COLUMN alias VARCHAR(200) DEFAULT NULL;";
		$this->db->query ( $sql_class1 );
		echo ' 更新成功:更新category表，增加alias字段<br>';

		//-------


		$sql_bankcard = "alter table " . $this->db->dbprefix . "user add COLUMN bankcard VARCHAR(200) DEFAULT NULL;";
		$this->db->query ( $sql_bankcard );
		echo ' 更新成功:更新category表，增加bankcard字段<br>';

		//-----
		//mediafile


		$sql_bankcard = "alter table " . $this->db->dbprefix . "answer add COLUMN mediafile VARCHAR(200) DEFAULT NULL;";
		$this->db->query ( $sql_bankcard );
		echo ' 更新成功:更新answer表，增加mediafile字段<br>';
		//-----
		$sql_bankcard = "alter table " . $this->db->dbprefix . "weixin_notify add COLUMN type VARCHAR(100) DEFAULT NULL;";
		$this->db->query ( $sql_bankcard );
		echo ' 更新成功:更新category表，增加type字段<br>';

		//----
		$sql_bankcard = "alter table " . $this->db->dbprefix . "weixin_notify add COLUMN typeid int(10) DEFAULT NULL;";
		$this->db->query ( $sql_bankcard );
		echo ' 更新成功:更新category表，增加typeid字段<br>';

		//-----
		$sql_bankcard = "alter table " . $this->db->dbprefix . "weixin_notify add COLUMN touid int(10) DEFAULT NULL;";
		$this->db->query ( $sql_bankcard );
		echo ' 更新成功:更新category表，增加touid字段<br>';
		//-----
		$sql_bankcard = "alter table " . $this->db->dbprefix . "weixin_notify add COLUMN haspay int(10) DEFAULT 0;";
		$this->db->query ( $sql_bankcard );
		echo ' 更新成功:更新category表，增加haspay字段<br>';
		//-------------------------------


		$sql_select_setting3 = "select * from " . $this->db->dbprefix . "setting where k='openweixin'";

		$result_setting3 = $this->db->query ( $sql_select_setting3 );
		$num3 = 0;
		foreach ( $result_setting3->result_array () as $user3 ) {

			$num3 = count ( $user3 );
		}

		if ($num3 > 1) {
			echo "setting表openweixin存在<br>";
		} else {
			$sql_setting3 = "insert into " . $this->db->dbprefix . "setting  values('openweixin','0')";
			$this->db->query ( $sql_setting3 );
			echo ' 更新成功:更新setting表，增加maxindex_keywords,pagemaxindex_keywords<br>';
		}

		//----------------------------
		//表面前缀: $this->db->dbprefix
		//1 更新setting表，增加tpl_wapdir，wap_domain
		//tpl_wapdir表示wap模板的文件夹名字  wap_domain表示手机站域名
		//查询是否存在字段
		$sql_select_setting = "select * from " . $this->db->dbprefix . "setting where k='tpl_wapdir'";

		$result_setting = $this->db->query ( $sql_select_setting );
		$num = 0;
		foreach ( $result_setting->result_array () as $user ) {

			$num = count ( $user );
		}

		if ($num > 1) {
			echo "setting表tpl_wapdir，wap_domain存在<br>";
		} else {
			$sql_setting = "insert into " . $this->db->dbprefix . "setting  values('tpl_wapdir','wap'),('wap_domain','')";
			$this->db->query ( $sql_setting );
			echo '1 更新成功:更新setting表，增加tpl_wapdir，wap_domain<br>';
		}

		//---
		//     --
		//-- 表的结构 `ask_favorite`
		//--


		$sql = "CREATE TABLE IF NOT EXISTS `" . $this->db->dbprefix . "topic_likes` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `tid` mediumint(10) unsigned NOT NULL DEFAULT '0',
  `time` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`),
  KEY `tid` (`tid`),
  KEY `time` (`time`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;";

		$this->db->query ( $sql );
		echo '更新成功:增加 topic_likes表<br>';
		//     --
		//-- 表的结构 `topic_viewhistory`
		//--


		$sql = "CREATE TABLE IF NOT EXISTS `" . $this->db->dbprefix . "topic_viewhistory` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uid` mediumint(8) unsigned NOT NULL DEFAULT '0',
   `username` varchar(200) NOT NULL,
  `tid` mediumint(10) unsigned NOT NULL DEFAULT '0',
  `time` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`),
  KEY `tid` (`tid`),
  KEY `time` (`time`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;";

		$this->db->query ( $sql );
		echo '更新成功:增加 topic_viewhistory表<br>';
		//----------------------
		//2  增加管理员分类表 category_admin


		$sql_category_admin = "
CREATE TABLE IF NOT EXISTS `" . $this->db->dbprefix . "category_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `categoryid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
     ";

		$this->db->query ( $sql_category_admin );
		echo '2 更新成功:增加 category_admin表<br>';

		//---


		$sql = "CREATE TABLE IF NOT EXISTS `" . $this->db->dbprefix . "categotry_follower` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `cid` int(10) NOT NULL,
  `uid` int(10) NOT NULL,
  `time` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

		$this->db->query ( $sql );
		echo '2 更新成功:增加 categotry_follower表<br>';
		//---
		$sql = "CREATE TABLE IF NOT EXISTS `" . $this->db->dbprefix . "paylog` (
 `id` int(10) NOT NULL AUTO_INCREMENT,
  `type` varchar(100) NOT NULL,
  `money` double NOT NULL,
  `openid` varchar(200) NOT NULL,
  `fromuid` int(10) NOT NULL,
  `touid` int(10) NOT NULL,
  `time` int(10) NOT NULL,
  `typeid` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
		$this->db->query ( $sql );
		echo '2 更新成功:增加 paylog支付流水表<br>';
		//----


		$sql = "CREATE TABLE IF NOT EXISTS `" . $this->db->dbprefix . "user_depositmoney` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `needpay` double NOT NULL,
  `type` varchar(100) NOT NULL,
  `typeid` int(10) NOT NULL,
  `fromuid` int(10) NOT NULL,
    `state` int(10) NOT NULL default 0,
     `touid` int(10) NOT NULL ,
  `time` int(10) NOT NULL,
   PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
		$this->db->query ( $sql );
		echo '2 更新成功:增加 user_depositmoney托管资金表<br>';
		//------
		$sql = "
     	  CREATE TABLE IF NOT EXISTS `" . $this->db->dbprefix . "articlecomment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tid` int(10) unsigned NOT NULL DEFAULT '0',
  `title` char(50) NOT NULL,
  `author` varchar(15) NOT NULL DEFAULT '',
  `authorid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `time` int(10) unsigned NOT NULL DEFAULT '0',
  `adopttime` int(10) unsigned NOT NULL DEFAULT '0',
  `content` mediumtext NOT NULL,
  `comments` int(10) NOT NULL,
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `ip` varchar(20) DEFAULT NULL,
  `supports` int(10) NOT NULL DEFAULT '0',
  `reward` int(10) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `tid` (`tid`),
  KEY `authorid` (`authorid`),
  KEY `adopttime` (`adopttime`),
  KEY `time` (`time`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;";
		$this->db->query ( $sql );
		echo '2 更新成功:增加 articlecomment文章评论表<br>';
		//-------------------------
		//weixin_notify 支付通知表
		$sql = "


CREATE TABLE IF NOT EXISTS `" . $this->db->dbprefix . "weixin_notify` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `appid` varchar(200) NOT NULL,
  `attach` varchar(200) NOT NULL,
  `bank_type` varchar(50) NOT NULL,
  `cash_fee` varchar(100) NOT NULL,
  `fee_type` varchar(100) NOT NULL,
  `is_subscribe` varchar(50) NOT NULL,
  `mch_id` varchar(200) NOT NULL,
  `nonce_str` varchar(200) NOT NULL,
  `openid` varchar(200) NOT NULL,
  `out_trade_no` varchar(200) NOT NULL,
  `result_code` varchar(200) NOT NULL,
  `return_code` varchar(100) NOT NULL,
  `return_msg` varchar(100) NOT NULL,
  `sign` varchar(200) NOT NULL,
  `time_end` int(10) NOT NULL,
  `total_fee` int(10) NOT NULL,
  `trade_state` varchar(100) NOT NULL,
  `trade_type` varchar(100) NOT NULL,
  `transaction_id` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
     	 ";
		$this->db->query ( $sql );
		echo '2 更新成功:增加 weixin_notify表<br>';

		//-----------------------------------
		$sql_userbank = "
CREATE TABLE IF NOT EXISTS `" . $this->db->dbprefix . "userbank` (
  `id` int(10) NOT NULL,
  `fromuid` int(10) NOT NULL,
  `touid` int(10) NOT NULL,
  `operation` varchar(200) NOT NULL,
   `money` int(10) NOT NULL,
  `time` int(11) NOT NULL,
   PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

		$this->db->query ( $sql_userbank );
		echo '2 更新成功:增加 userbank表<br>';
		//------------------------------
		$sqlkeywords = "
CREATE TABLE IF NOT EXISTS `" . $this->db->dbprefix . "keywords` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `find` varchar(200) NOT NULL,
  `replacement` varchar(200) NOT NULL,
  `admin` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;
   ";
		$this->db->query ( $sqlkeywords );
		echo '------ 更新成功:增加 keywords表<br>';
		//3 inform修改


		//-------------------


		$sql = "CREATE TABLE IF NOT EXISTS `" . $this->db->dbprefix . "weixin_info` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `msg` text NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;";

		$this->db->query ( $sql );
		echo '------ 更新成功:增加 weixin_info表<br>';
		//-----------------------------------------------------
		$sql = "CREATE TABLE IF NOT EXISTS `" . $this->db->dbprefix . "weixin_follower` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `openid` varchar(200) NOT NULL,
  `nickname` varchar(100) NOT NULL,
  `language` varchar(100) NOT NULL,
  `province` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `country` varchar(100) NOT NULL,
  `headimgurl` varchar(200) NOT NULL,
  `privilege` varchar(200) NOT NULL,
  `unionid` varchar(200) NOT NULL,
  `sex` varchar(100) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

		$this->db->query ( $sql );
		echo '------ 更新成功:增加 weixin_follower表<br>';

		//------------------------------------------


		$sql = "CREATE TABLE IF NOT EXISTS `" . $this->db->dbprefix . "weixin_menu` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `menu_name` varchar(200) NOT NULL,
  `menu_type` varchar(200) NOT NULL,
  `menu_keyword` varchar(200) NOT NULL,
  `menu_link` varchar(200) NOT NULL,
  `menu_pid` int(10) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;";

		$this->db->query ( $sql );
		echo '------ 更新成功:增加 weixin_menu表<br>';
		//-----------------------------
		$sql = "
     	 CREATE TABLE IF NOT EXISTS `" . $this->db->dbprefix . "weixin_setting` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `wxname` varchar(200) NOT NULL,
  `wxid` varchar(200) NOT NULL,
  `weixin` varchar(200) NOT NULL,
  `appid` varchar(200) NOT NULL,
  `appsecret` varchar(200) NOT NULL,
  `winxintype` varchar(200) NOT NULL,
   PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;";

		$this->db->query ( $sql );
		echo '------ 更新成功:增加 weixin_setting表<br>';

		//---------------------------------------
		$sql = "
CREATE TABLE IF NOT EXISTS `" . $this->db->dbprefix . "weixin_keywords` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `txtname` varchar(200) NOT NULL,
  `txtcontent` varchar(200) NOT NULL,
  `txttype` varchar(200) NOT NULL,
  `showtype` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

		$this->db->query ( $sql );
		echo '------ 更新成功:增加 weixin_keywords表<br>';

		//创建站点日志表


		$site_log = "CREATE TABLE IF NOT EXISTS `" . $this->db->dbprefix . "site_log` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `guize` varchar(200) NOT NULL,
   `miaoshu` varchar(200)  NULL,
   `uid` int(10)  NULL,
     `username` varchar(200) NOT NULL,
  `time` int(10) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

		$this->db->query ( $site_log );
		echo " site_log站点日志表插入成功<br>";

		//----------------------------
		//删除 inform DROP TABLE IF EXISTS t_bd_shop_bi;
		$sql_inform = 'DROP TABLE IF EXISTS ' . $this->db->dbprefix . 'inform;';

		$this->db->query ( $sql_inform );

		$sql_create_inform = "

CREATE TABLE IF NOT EXISTS `" . $this->db->dbprefix . "inform` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `username` varchar(200) NOT NULL,
  `uid` int(10) NOT NULL,
  `qtitle` varchar(200) NOT NULL,
  `qid` int(100) NOT NULL,
  `aid` int(11) NOT NULL,
  `content` text NOT NULL,
  `title` varchar(100) NOT NULL,
  `keywords` varchar(100) NOT NULL,
  `counts` int(11) NOT NULL DEFAULT '1',
  `time` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;";

		$this->db->query ( $sql_create_inform );
		echo '3 更新INform成功<br>';
		// 4 更新 topic专题变成文章
		$sql_topicprice = "alter table " . $this->db->dbprefix . "topic add COLUMN price  int(10) DEFAULT 0;";
		$sql_topic1 = "alter table " . $this->db->dbprefix . "topic add COLUMN author VARCHAR(200) DEFAULT NULL;";
		$sql_topic2 = "alter table " . $this->db->dbprefix . "topic add COLUMN authorid int(10) DEFAULT 1;";
		$sql_topic3 = "alter table " . $this->db->dbprefix . "topic add COLUMN views int(10) DEFAULT 1;";
		$sql_topic4 = "alter table " . $this->db->dbprefix . "topic add COLUMN articleclassid int(10) DEFAULT 1;";
		$sql_topic5 = "alter table " . $this->db->dbprefix . "topic add COLUMN isphone int(10) DEFAULT 0;";
		$sql_topic6 = "alter table " . $this->db->dbprefix . "topic add COLUMN viewtime int(10) DEFAULT 0;";
		$sql_topic7 = "alter table " . $this->db->dbprefix . "topic add COLUMN ispc int(10) DEFAULT 0;";
		$sql_editcontent = "ALTER TABLE  `" . $this->db->dbprefix . "topic` CHANGE  `describtion`  `describtion` TEXT  DEFAULT NULL";

		$this->db->query ( $sql_topicprice );
		$this->db->query ( $sql_editcontent );
		$this->db->query ( $sql_topic1 );
		$this->db->query ( $sql_topic2 );
		$this->db->query ( $sql_topic3 );
		$this->db->query ( $sql_topic4 );
		$this->db->query ( $sql_topic5 );
		$this->db->query ( $sql_topic6 );
		$this->db->query ( $sql_topic7 );
		echo '4 更新topic表成功<br>';
		//5 插入表


		$topic_tag = "CREATE TABLE IF NOT EXISTS `" . $this->db->dbprefix . "topic_tag` (
  `aid` int(10) NOT NULL,
  `name` varchar(200) NOT NULL,
  `time` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
     	  ";
		$this->db->query ( $topic_tag );
		echo "4.1 topic_tag文章标签表插入成功<br>";

		//--------------------顶置表


		$topdata = "CREATE TABLE IF NOT EXISTS `" . $this->db->dbprefix . "topdata` (
     	  `id` int(10) NOT NULL AUTO_INCREMENT,
  `typeid` int(10) NOT NULL,
  `type` varchar(200) NOT NULL,
   `order` int(10) NOT NULL DEFAULT '1',
  `time` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
     	  ";
		$this->db->query ( $topdata );
		echo " topdata文章标签表插入成功<br>";

		//===========================
		$cat_topic = "
CREATE TABLE IF NOT EXISTS `" . $this->db->dbprefix . "topicclass` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `dir` varchar(200) NOT NULL,
  `pid` int(10) NOT NULL,
  `displayorder` int(10) NOT NULL,
  `articles` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;
     	  ";
		$this->db->query ( $cat_topic );
		echo "5 topicclass表插入成功<br>";
		$this->config_edit ();
		exit ( "重新配置成功" );
	}

	function config_edit() {
		$version = '3.7';
		$versiondate = date ( "Ymd" );
		$config = "<?php \r\n";
		$config .= "defined('BASEPATH') OR exit('No direct script access allowed');\r\n";
		$config .= '$active_group' . " = 'default';\r\n";
		$config .= '$query_builder' . "  = TRUE;\r\n";
		$config .= "define('ASK2_CHARSET', 'UTF-8');\r\n";
		$config .= "define('ASK2_VERSION', '$version');\r\n";
		$config .= "define('ASK2_RELEASE', '$versiondate');\r\n";

		if (! file_exists ( $file_path = APPPATH . 'config' . DIRECTORY_SEPARATOR . ENVIRONMENT . DIRECTORY_SEPARATOR . 'database.php' ) && ! file_exists ( $file_path = APPPATH . 'config' . DIRECTORY_SEPARATOR . 'database.php' )) {
			show_error ( 'The configuration file database.php does not exist.' );
		}

		include ($file_path);

		$strdata = $config . "$" . "db['default'] =" . var_export ( $db [$active_group], true ) . ";\n?>";
		writetofile ( APPPATH . 'config/' . ENVIRONMENT . '/database.php', $strdata );

	}

}

?>