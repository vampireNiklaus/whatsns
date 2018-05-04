<?php

defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class Tags extends CI_Controller {

	function __construct() {
		$this->whitelist = "index,view";
		parent::__construct ();
		$this->load->model ( "tag_model" );
		$this->load->model ( "question_model" );

	}
	function index() {
		$navtitle = '标签列表';
		$metakeywords = $navtitle;
		$metadescription = '标签列表';
		$page = max ( 1, intval ( $this->uri->segment ( 3 ) ) );
		$pagesize = 600;
		$startindex = ($page - 1) * $pagesize;
		$rownum = returnarraynum ( $this->db->query ( getwheresql ( 'question_tag', " 1=1", $this->db->dbprefix ) )->row_array () );
		$taglist = $this->tag_model->get_list ( $startindex, $pagesize );
		$departstr = page ( $rownum, $pagesize, $page, "tags/index" );
		include template ( 'tag' );
	}
	/* 前台查看公告列表 */

	function view() {
		$navtitle = '标签搜索';
		$page = max ( 1, intval ( $this->uri->segment ( 3 ) ) );
		$pagesize = $this->setting ['list_default'];
		$startindex = ($page - 1) * $pagesize;
		$rownum = returnarraynum ( $this->db->query ( getwheresql ( 'question_tag', " 1=1 GROUP BY name", $this->db->dbprefix ) )->row_array () );
		$notelist = $this->tag_model->get_list ( $startindex, $pagesize );
		$departstr = page ( $rownum, $pagesize, $page, "note/list" );
		include template ( 'notelist' );
	}

}

?>