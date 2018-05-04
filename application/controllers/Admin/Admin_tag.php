<?php

defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class Admin_tag extends CI_Controller {

	function __construct() {
		parent::__construct ();
		$this->load->model ( 'tag_model' );

	}

	function index($msg = '') {
		$msg && $message = $msg;
		@$page = max ( 1, intval ( $this->uri->segment ( 3 ) ) );
		$pagesize = 500;
		$startindex = ($page - 1) * $pagesize;
		$taglist = $this->tag_model->get_list ( $startindex, $pagesize );
		$rownum = $this->tag_model->rownum ();
		$departstr = page ( $rownum, $pagesize, $page, "admin_tag/index" );
		include template ( 'taglist', 'admin' );
	}
	function changepinyin() {
		$names = trim ( $this->input->post ('spname'), ',' );
		$name = trim ( $this->input->post ('name'), ',' );
		$id = trim ( $this->input->post ('id'), ',' );
		$char_split = '';
		$_name_arr = explode ( ',', $names );
		for($i = 0; $i < count ( $_name_arr ); $i ++) {
			$char_split = $char_split . $this->getfirstchar ( $_name_arr [$i] );

		}

		$pinyin = $char_split;

		$pinyin = 'q_' . $pinyin . '_' . $id;

		$this->db->query ( "UPDATE " . $this->db->dbprefix . "question_tag SET  `pinyin`='$pinyin' WHERE `name`='$name'" );
		echo $pinyin;
		exit ();
	}
	function delete() {
		$msg = '';
		if (null!== $this->input->post ('delete') ) {
			$this->tag_model->remove_by_name ( $this->input->post ('delete') );
			$message = '标签刪除成功！';
		}
		$this->index ( $message );
	}
	function getfirstchar($s0) {
		$firstchar_ord = ord ( strtoupper ( $s0 {0} ) );
		if (($firstchar_ord >= 65 and $firstchar_ord <= 91) or ($firstchar_ord >= 48 and $firstchar_ord <= 57))
			return $s0 {0};
		$s = iconv ( "UTF-8", "gb2312", $s0 );
		$asc = ord ( $s {0} ) * 256 + ord ( $s {1} ) - 65536;
		if ($asc >= - 20319 and $asc <= - 20284)
			return "a";
		if ($asc >= - 20283 and $asc <= - 19776)
			return "b";
		if ($asc >= - 19775 and $asc <= - 19219)
			return "c";
		if ($asc >= - 19218 and $asc <= - 18711)
			return "d";
		if ($asc >= - 18710 and $asc <= - 18527)
			return "e";
		if ($asc >= - 18526 and $asc <= - 18240)
			return "f";
		if ($asc >= - 18239 and $asc <= - 17923)
			return "g";
		if ($asc >= - 17922 and $asc <= - 17418)
			return "h";
		if ($asc >= - 17417 and $asc <= - 16475)
			return "j";
		if ($asc >= - 16474 and $asc <= - 16213)
			return "k";
		if ($asc >= - 16212 and $asc <= - 15641)
			return "l";
		if ($asc >= - 15640 and $asc <= - 15166)
			return "m";
		if ($asc >= - 15165 and $asc <= - 14923)
			return "m";
		if ($asc >= - 14922 and $asc <= - 14915)
			return "o";
		if ($asc >= - 14914 and $asc <= - 14631)
			return "p";
		if ($asc >= - 14630 and $asc <= - 14150)
			return "q";
		if ($asc >= - 14149 and $asc <= - 14091)
			return "r";
		if ($asc >= - 14090 and $asc <= - 13319)
			return "s";
		if ($asc >= - 13318 and $asc <= - 12839)
			return "t";
		if ($asc >= - 12838 and $asc <= - 12557)
			return "w";
		if ($asc >= - 12556 and $asc <= - 11848)
			return "x";
		if ($asc >= - 11847 and $asc <= - 11056)
			return "y";
		if ($asc >= - 11055 and $asc <= - 10247)
			return "z";
		return null;
	}

}

?>