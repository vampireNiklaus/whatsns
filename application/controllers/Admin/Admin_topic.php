<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class Admin_topic extends CI_Controller {

	function __construct() {
		parent::__construct ();
		$this->load->model ( "topic_model" );
		$this->load->model ( "topic_tag_model" );
		$this->load->model ( "category_model" );
	}

	function index($msg = '', $ty = '') {
		$catetree = $this->category_model->get_categrory_tree ( $this->category_model->get_list () );
		if ($this->input->post ( 'submit' )) {
			@$page = max ( 1, intval ( $this->uri->segment ( 3 ) ) );
			$pagesize = $this->setting ['list_default'];
			$startindex = ($page - 1) * $pagesize;
			$srchtitle = $this->input->post ( 'srchtitle' );
			$srchauthor = $this->input->post ( 'srchauthor' );

			$srchcategory = $this->input->post ( 'srchcategory' );

			$topiclist = $this->topic_model->list_by_search ( $srchtitle, $srchauthor, $srchcategory, $startindex, $pagesize );

			$rownum = $this->topic_model->rownum_by_search ( $srchtitle, $srchauthor, $srchcategory );
			$departstr = page ( $rownum, $pagesize, $page, "admin_topic/index" );

			$msg && $message = $msg;
			$ty && $type = $ty;

		} else {
			@$page = max ( 1, intval ( $this->uri->segment ( 3 ) ) );
			$pagesize = $this->setting ['list_default'];
			$startindex = ($page - 1) * $pagesize;
			$rownum = returnarraynum ( $this->db->query ( getwheresql ( 'topic' ,'1=1', $this->db->dbprefix ) )->row_array () );
			$topiclist = $this->topic_model->get_list ( 2, $startindex, $pagesize );
			$departstr = page ( $rownum, $pagesize, $page, "admin_topic/index" );

		}

		include template ( "topiclist", 'admin' );
	}

	function add() {
		if (null!== $this->input->post ( 'submit' ) ) {
			$title = $this->input->post ( 'title' );
			$desrc = $this->input->post ( 'content' );
			$isphone = $this->input->post ( 'isphone' );
			$topic_tag = $this->input->post ( 'topic_tag' );
			$taglist = explode ( ",", $topic_tag );
			if ($isphone == 'on') {
				$isphone = 1;
			} else {
				$isphone = 0;
			}
			$acid = $this->input->post ( 'topicclass' );

			if ($acid == null)
				$acid = 1;
			$imgname = strtolower ( $_FILES ['image'] ['name'] );
			if ('' == $title || '' == $desrc) {
				$this->index ( '请完整填写专题相关参数!', 'errormsg' );
				exit ();
			}
			$type = substr ( strrchr ( $imgname, '.' ), 1 );
			if (! isimage ( $type )) {
				$this->index ( '当前图片图片格式不支持，目前仅支持jpg、gif、png格式！', 'errormsg' );
				exit ();
			}
			$upload_tmp_file = FCPATH . '/data/tmp/topic_' . random ( 6, 0 ) . '.' . $type;

			$filepath = '/data/attach/topic/topic' . random ( 6, 0 ) . '.' . $type;
			forcemkdir ( FCPATH . '/data/attach/topic' );
			if (move_uploaded_file ( $_FILES ['image'] ['tmp_name'], $upload_tmp_file )) {
				image_resize ( $upload_tmp_file, FCPATH . $filepath, 270, 220 );

				$this->topic_model->add ( $title, $desrc, $filepath, $isphone, '1', $acid );
				$this->index ( '添加成功！' );
			} else {
				$this->index ( '服务器忙，请稍后再试！' );
			}
		} else {
			include template ( "addtopic", 'admin' );
		}
	}
	/*百度推送*/

	function baidutui() {

		$urls = array ();
		$suffix = '?';
		if ($this->setting ['seo_on']) {
			$suffix = '';
		}
		$fix = $this->setting ['seo_suffix'];
		if (null!== $this->input->post ( 'tid' ) ) {
			//SITE_URL.$suffix."q-$item[id]$fix
			$tids = $this->input->post ( 'tid' );
			$q_size = count ( $tids );
			for($i = 0; $i < $q_size; $i ++) {
				array_push ( $urls, SITE_URL . $suffix . "article-" . $tids [$i] . $fix );
			}
		} else {
			$this->index ( '您还没选择推送文章!' );
		}
		if (trim ( $this->setting ['baidu_api'] ) != '' && $this->setting ['baidu_api'] != null) {

			$api = $this->setting ['baidu_api'];
			$result = baidusend ( $api, $urls );
			$this->index ( '文章推送成功!' );
		} else {
			$this->index ( '文章推送不成功，您还没设置百度推送的api地址，前往系统设置--seo设置里配置!' );
		}
	}
	/**
	 * 后台修改专题
	 */
	function edit() {
		if (null!== $this->input->post ( 'submit' ) ) {

			$title = $this->input->post ( 'title' );
			$topic_tag = $this->input->post ( 'topic_tag' );
			$taglist = explode ( ",", $topic_tag );
			$desrc = $this->input->post ( 'content' );
			$tid = intval ( $this->input->post ( 'id' ) );
			$upimg = $this->input->post ( 'upimg' );
			$views = $this->input->post ( 'views' );
			$isphone = $this->input->post ( 'isphone' );
			$ispc = $this->input->post ( 'ispc' );
			if ($isphone == 'on') {
				$isphone = 1;
			} else {
				$isphone = 0;
			}
			if ($ispc == 'on') {
				$ispc = 1;
			} else {
				$ispc = 0;
			}
			$acid = $this->input->post ( 'topicclass' );

			if ($acid == null)
				$acid = 1;
			$imgname = strtolower ( $_FILES ['image'] ['name'] );
			if ('' == $title || '' == $desrc) {
				$this->index ( '请完整填写专题相关参数!', 'errormsg' );
				exit ();
			}
			$topic = $this->topic_model->get ( $tid );
			$filepath=$topic['image'];
			if ($imgname) {
				$type = substr ( strrchr ( $imgname, '.' ), 1 );
				if (! isimage ( $type )) {
					$this->index ( '当前图片图片格式不支持，目前仅支持jpg、gif、png格式！', 'errormsg' );
					exit ();
				}
				$filepath = '/data/attach/topic/topic' . random ( 6, 0 ) . '.' . $type;
				$upload_tmp_file = FCPATH . '/data/tmp/topic_' . random ( 6, 0 ) . '.' . $type;
				forcemkdir ( FCPATH . '/data/attach/topic' );
				if (move_uploaded_file ( $_FILES ['image'] ['tmp_name'], $upload_tmp_file )) {
					image_resize ( $upload_tmp_file, FCPATH . $filepath, 270, 220 );
					$this->topic_model->updatetopic ( $tid, $title, $desrc, $filepath, $isphone, $views, $acid, $ispc, $topic ['price'] );
					$taglist && $this->topic_tag_model->multi_add ( array_unique ( $taglist ), $tid );
					$viewhref = urlmap ( 'admin_topic/index', 1 );
					$url = SITE_URL . $this->setting ['seo_prefix'] . $viewhref . $this->setting ['seo_suffix'];
					header ( "Location:$url" );
				} else {
					$this->index ( '服务器忙，请稍后再试！' );
				}
			} else {

				$this->topic_model->updatetopic ( $tid, $title, $desrc, $filepath, $isphone, $views, $acid, $ispc, $topic ['price'] );
				$taglist && $this->topic_tag_model->multi_add ( array_unique ( $taglist ), $tid );
				$this->index ( '专题修改成功！' );

			}
		} else {
			$topic = $this->topic_model->get ( intval ( $this->uri->segment ( 3 ) ) );

			$tagmodel = $this->topic_tag_model->get_by_aid ( $topic ['id'] );

			$topic ['topic_tag'] = implode ( ',', $tagmodel );

			$catmodel = $this->category_model->get ( $topic ['articleclassid'] );
			$categoryjs = $this->category_model->get_js ();
			include template ( "addtopic", 'admin' );
		}
	}

	//专题删除
	function remove() {
		if (null!== $this->input->post ( 'tid' ) ) {
			$tids = implode ( ",", $this->input->post ( 'tid' ) );
			$this->topic_model->remove ( $tids );
			$this->index ( '专题删除成功！' );
		}
	}

	/* 后台分类排序 */

	function reorder() {
		$orders = explode ( ",", $this->input->post ( 'order' ) );
		foreach ( $orders as $order => $tid ) {
			$this->topic_model->order_topic ( intval ( $tid ), $order );
		}
		$this->cache->remove ( 'topic' );
	}

	function ajaxgetselect() {
		echo $this->topic_model->get_select ();
		exit ();
	}

	function makeindex() {
		ignore_user_abort ();
		set_time_limit ( 0 );
		$this->topic_model->makeindex ();
		echo 'ok';
		exit ();
	}
}

?>