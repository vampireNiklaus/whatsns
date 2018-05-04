<?php

defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class Newpage extends CI_Controller {

	var $whitelist;
	function __construct() {
		$this->whitelist = "index,nmaketag";
		parent::__construct ();
		$this->load->model ( 'question_model' );
	}
	function index() {

		$navtitle = "最近更新_";
		$seo_description = $this->setting ['site_name'] . '最近更新相关内容。';
		$seo_keywords = '最近更新';
		//回答分页
		@$page = 1;
		@$page = max ( 1, intval ( $this->uri->segment ( 3 ) ) );
		$pagesize = 50;
		$startindex = ($page - 1) * $pagesize;
		$paixu = intval ( $this->uri->segment ( 4 ) ); //0 全部，1，积分悬赏，2 现金悬赏，3 语音悬赏，4 解决问题


		$rownum = $this->question_model->rownum_by_cfield_cvalue_status ( '', 'all', 1, $paixu ); //获取总的记录数
		$questionlist = $this->question_model->list_by_cfield_cvalue_status ( '', 'all', 1, $startindex, $pagesize, $paixu ); //问题列表数据
		$departstr = page ( $rownum, $pagesize, $page, "new-" ); //得到分页字符串
		$this->load->model ( 'tag_model' );
		foreach ( $questionlist as $key => $val ) {

			$taglist = $this->tag_model->get_by_qid ( $val ['id'] );

			$questionlist [$key] ['tags'] = $taglist;

		}
		include template ( 'new' );
	}

	function maketag() {
		$navtitle = "最近更新_";
		$seo_description = $this->setting ['site_name'] . '最近更新相关内容。';
		$seo_keywords = '最近更新';
		//回答分页
		@$page = 1;
		@$page = max ( 1, intval ( $this->uri->segment ( 3 ) ) );
		$pagesize = 50;
		$startindex = ($page - 1) * $pagesize;
		$rownum = $this->question_model->rownum_by_cfield_cvalue_status ( '', 'all', 1 ); //获取总的记录数


		$questionlist = $this->question_model->list_by_cfield_cvalue_status ( '', 'all', 1, $startindex, $pagesize ); //问题列表数据
		$departstr = page ( $rownum, $pagesize, $page, "new/maketag" ); //得到分页字符串
		//
		$this->load->model ( 'tag_model' );
		foreach ( $questionlist as $key => $val ) {

			$taglist = dz_segment ( htmlspecialchars ( $val ['title'] ) );
			$questionlist [$key] ['tags'] = $taglist;
			$taglist && $this->tag_model->multi_add ( array_unique ( $taglist ), $val ['id'] );

		}

		include template ( 'maketag' );
	}
}