<?php

defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class Admin_question extends CI_Controller {

	function __construct() {
		parent::__construct ();
		$this->load->model ( "question_model" );
		$this->load->model ( "category_model" );
		$this->load->model ( "answer_model" );

	}

	function index() {
		$this->searchquestion ();
	}

	function searchquestion($msg = '', $ty = '') {

		$srchtitle =  trim ($this->input->post ( 'srchtitle' ));

		$srchauthor = trim ($this->input->post ( 'srchauthor' ) );
		$srchdatestart = $this->input->post ( 'srchdatestart' );

		$srchdateend = $this->input->post ( 'srchdateend' );
		$srchstatus =$this->input->post ( 'srchstatus' );
		$srchcategory = $this->input->post ( 'srchcategory' );

		@$page = max ( 1, intval ( $this->uri->segment (3)) );

		$pagesize = isset ( $this->setting ['admin_list_default'] ) ? $this->setting ['admin_list_default'] : $this->setting ['list_default'];
		$startindex = ($page - 1) * $pagesize;
		$questionlist = $this->question_model->list_by_search ( $srchtitle, $srchauthor, $srchdatestart, $srchdateend, $srchstatus, $srchcategory, $startindex, $pagesize );
		$rownum = $this->question_model->rownum_by_search ( $srchtitle, $srchauthor, $srchdatestart, $srchdateend, $srchstatus, $srchcategory );
		$departstr = page ( $rownum, $pagesize, $page,"admin_question/searchquestion");



		$msg && $message = $msg;
		$ty && $type = $ty;
		$catetree = $this->category_model->get_categrory_tree ( $this->category_model->get_list () );

		include template ( 'questionlist', 'admin' );
	}

	function searchanswer($msg = '', $ty = '') {
		$srchtitle =$this->input->post ( 'srchtitle' );
		$srchauthor = $this->input->post ( 'srchauthor' );
		$srchdatestart =$this->input->post ( 'srchdatestart' );
		$srchdateend =$this->input->post ( 'srchdateend' );
		$keywords = $this->input->post ( 'keywords' );
		@$page = max ( 1, intval ( $this->uri->segment ( 3 ) ) );
		$pagesize = $this->setting ['list_default'];
		$startindex = ($page - 1) * $pagesize;
		$answerlist = $this->answer_model->list_by_search ( $srchtitle, $srchauthor, $keywords, $srchdatestart, $srchdateend, $startindex, $pagesize );
		$rownum = $this->answer_model->rownum_by_search ( $srchtitle, $srchauthor, $keywords, $srchdatestart, $srchdateend );
		$departstr = page ( $rownum, $pagesize, $page, "admin_question/searchanswer" );
		$msg && $message = $msg;
		$ty && $type = $ty;
		include template ( 'answerlist', 'admin' );
	}

	function removequestion() {
		if (null !== $this->input->post ( 'qid' )) {
			$qids = implode ( ",", $this->input->post ( 'qid' ) );
			$this->question_model->remove ( $qids );
		}
		$this->index ();
	}

	function removeanswer() {
		if (null !== $this->input->post ( 'aid' )) {
			$aids = implode ( ",", $this->input->post ( 'aid' ) );
			$this->answer_model->remove ( $aids );
		}
		$this->searchanswer ();
	}

	function edit() {
		$qid = null !== $this->input->post ( 'submit' ) ? $this->input->post ( 'qid' ) : $this->uri->segment ( 3 );
		if (null !== $this->input->post ( 'submit' )) {
			$title = $this->input->post ( 'title' );
			$description = $this->input->post ( 'description' );
			$cid1 = $this->input->post ( 'classlevel1' );
			$cid2 = $this->input->post ( 'classlevel2' );
			$cid3 = $this->input->post ( 'classlevel3' );
			$cid = $this->input->post ( 'cid' );
			$hidden = intval ( null !== $this->input->post ( 'hidden' ) );
			$price = intval ( $this->input->post ( 'price' ) );
			$status = intval ( null !== $this->input->post ( 'status' ) );
			$this->question_model->update ( $qid, $title, $description, $hidden, $price, $status, $cid, $cid1, $cid2, $cid3, $this->input->post ( 'time' ) );
			$message = '问题编辑成功!';
		}
		$question = $this->question_model->get ( $qid );
		$question ['date'] = date ( "Y-m-d", $question ['time'] );
		$question_status = array (array (0, '未审核' ), array (1, '待解决' ), array (6, '推荐问题' ), array (9, '已关闭问题' ) );
		$prices = array (0, 5, 10, 15, 20, 30, 50, 80, 100 );
		include template ( 'editquestion', 'admin' );
	}

	function editanswer() {
		$aid = null !== $this->input->post ( 'submit' ) ? $this->input->post ( 'aid' ) : $this->uri->segment ( 3 );
		if (null !== $this->input->post ( 'submit' )) {
			$content = $this->input->post ( 'content' );
			$answertime = strtotime ( $this->input->post ( 'time' ) );
			$this->answer_model->update_time_content ( $aid, $answertime, $content );
		}
		$answer = $this->answer_model->get ( $aid );
		$answer ['date'] = date ( "Y-m-d", $answer ['time'] );
		include template ( 'editanswer', 'admin' );
	}

	//回答审核
	function verifyanswer() {
		if (null !== $this->input->post ( 'aid' )) {
			$aids = implode ( ",", $this->input->post ( 'aid' ) );
			$this->answer_model->change_to_verify ( $aids );
			$type = 'correctmsg';
			$message = '回答审核完成!';
		}
		@$page = max ( 1, intval ( $this->uri->segment ( 3 ) ) );
		$pagesize = 20;
		$startindex = ($page - 1) * $pagesize;
		$answerlist = $this->answer_model->list_by_condition ( '`status`=0', $startindex, $pagesize );
		$rownum = returnarraynum ( $this->db->query ( getwheresql ( 'answer', ' `status`=0', $this->db->dbprefix ) )->row_array () );
		$departstr = page ( $rownum, $pagesize, $page, "admin_question/verifyanswer" );
		include template ( "verifyanswers", "admin" );
	}

	//问题审核
	function verify() {
		if (null !== $this->input->post ( 'qid' )) {
			$qids = implode ( ",", $this->input->post ( 'qid' ) );
			$this->question_model->change_to_verify ( $qids );
			$this->examine ( '问题审核成功!' );
			exit ();
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
		if (null !== $this->input->post ( 'qid' )) {
			//SITE_URL.$suffix."q-$item[id]$fix
			$qids = $this->input->post ( 'qid' );
			$q_size = count ( $qids );
			for($i = 0; $i < $q_size; $i ++) {
				array_push ( $urls, SITE_URL . $suffix . "q-" . $qids [$i] . $fix );
			}
		} else {
			$this->searchquestion ( '您还没选择推送问题!' );
		}
		if (trim ( $this->setting ['baidu_api'] ) != '' && $this->setting ['baidu_api'] != null) {

			$api = $this->setting ['baidu_api'];
			$result = baidusend ( $api, $urls );
			$this->searchquestion ( '问题推送成功!' );
		} else {
			$this->searchquestion ( '问题推送不成功，您还没设置百度推送的api地址，前往系统设置--seo设置里配置!' );
		}
	}

	//问题推荐
	function recommend() {
		if (null !== $this->input->post ( 'qid' )) {
			$qids = implode ( ",", $this->input->post ( 'qid' ) );
			$this->question_model->change_recommend ( $qids, 6, 2 );
			$this->searchquestion ( '问题推荐成功!' );
			exit ();
		}
	}

	//取消推荐
	function inrecommend() {
		if (null !== $this->input->post ( 'qid' )) {
			$qids = implode ( ",", $this->input->post ( 'qid' ) );
			$this->question_model->change_recommend ( $qids, 2, 6 );
			$this->searchquestion ( '取消问题推荐成功!' );
			exit ();
		}
	}

	//关闭问题
	function close() {
		if (null !== $this->input->post ( 'qid' )) {
			$qids = implode ( ",", $this->input->post ( 'qid' ) );
			$this->question_model->update_status ( $qids, 9 );
			$this->searchquestion ( '问题关闭成功!' );
			exit ();
		}
	}

	//删除问题
	function delete() {
		if (null !== $this->input->post ( 'qid' )) {
			$qids = implode ( ",", $this->input->post ( 'qid' ) );

			$this->question_model->remove ( $qids );
			$this->searchquestion ( '问题删除成功!' );
			exit ();
		}
	}

	//修改问题标题
	function renametitle() {
		if (null !== $this->input->post ( 'title' )) {
			$title = trim ( $this->input->post ( 'title' ) );
			if ('' == $title) {
				$this->searchquestion ( '问题标题不能为空!', 'errormsg' );
			} else {
				$this->question_model->renametitle ( intval ( $this->input->post ( 'qid' ) ), $title );
				$this->searchquestion ( '问题编辑成功!' );
			}
		}
	}

	//修改问题内容
	function editquescont() {
		if (null !== $this->input->post ( 'content' )) {
			$content = trim ( $this->input->post ( 'content' ) );
			if ('' == $content) {
				$this->searchquestion ( '问题内容不能为空!', 'errormsg' );
				exit ();
			}
			$this->question_model->update_content ( intval ( $this->input->post ( 'qid' ) ), $content );
			$this->searchquestion ( '问题内容修改成功!' );
		}
	}

	//移动分类
	function movecategory() {
		if (intval ( $this->input->post ( 'category' ) )) {
			$cid = intval ( $this->input->post ( 'category' ) );
			$cid1 = 0;
			$cid2 = 0;
			$cid3 = 0;
			$qids = $this->input->post ( 'qids' );
			$category = $this->cache->load ( 'category' );
			if ($category [$cid] ['grade'] == 1) {
				$cid1 = $cid;
			} else if ($category [$cid] ['grade'] == 2) {
				$cid2 = $cid;
				$cid1 = $category [$cid] ['pid'];
			} else if ($category [$cid] ['grade'] == 3) {
				$cid3 = $cid;
				$cid2 = $category [$cid] ['pid'];
				$cid1 = $category [$cid2] ['pid'];
			} else {
				$this->searchquestion ( '分类不存在，请更下缓存!', 'errormsg' );
				exit ();
			}
			$this->question_model->update_category ( $qids, $cid, $cid1, $cid2, $cid3 );
			$this->searchquestion ( '问题分类修改成功!' );
			exit ();
		}
	}

	//设为未解决
	function nosolve() {
		if (null !== $this->input->post ( 'qid' )) {
			$qids = implode ( ",", $this->input->post ( 'qid' ) );
			$this->question_model->change_to_nosolve ( $qids );
			$this->searchquestion ( '问题状态设置成功!' );
			exit ();
		}
		$this->searchquestion ();
	}
	//设为已解决
	function solve() {
		if (null !== $this->input->post ( 'qid' )) {
			$qids = implode ( ",", $this->input->post ( 'qid' ) );
			$this->question_model->change_to_solve ( $qids );
			$this->searchquestion ( '问题状态设置成功!' );
			exit ();
		}
		$this->searchquestion ();
	}
	//编辑回答内容
	function editanswercont() {
		if (null !== $this->input->post ( 'content' )) {
			$content = trim ( $this->input->post ( 'content' ) );
			if ('' == $content) {
				$this->searchanswer ( '回答内容不能为空!', 'errormsg' );
				exit ();
			}
			$this->answer_model->update_content ( intval ( $this->input->post ( 'aid' ) ), $content );
			$this->searchanswer ( '回答内容修改成功!' );
		}
	}

	//删除回答
	function deleteanswer() {
		if (null !== $this->input->post ( 'aid' )) {
			$aids = implode ( ",", $this->input->post ( 'aid' ) );
			$this->answer_model->remove ( $aids );
			$this->searchanswer ( '删除回答成功!' );
			exit ();
		}
	}

	function addtotopic() {
		$this->load->model ( "topic_model" );
		if (null !== $this->input->post ( 'qids' )) {
			$this->topic_model->addtotopic ( $this->input->post ( 'qids' ), $this->input->post ( 'topiclist' ) );
			$this->searchquestion ( '专题添加成功!' );
		}
	}

	/* 问题审核 */

	function examine($msg = '', $ty = '') {
		$msg && $message = $msg;
		$ty && $type = $ty;
		@$page = max ( 1, intval ( $this->uri->segment ( 3 ) ) );
		$pagesize = 20;
		$startindex = ($page - 1) * $pagesize;
		$questionlist = $this->question_model->list_by_search ( 0, 0, 0, 0, 0, 0, $startindex, $pagesize );
		$rownum = $this->question_model->rownum_by_search ( 0, 0, 0, 0, 0 );
		$departstr = page ( $rownum, $pagesize, $page, "admin_question/examine" );
		include template ( "verifyquestions", "admin" );
	}

	/* 回答审核 */

	function examineanswer($msg = '', $ty = '') {
		$msg && $message = $msg;
		$ty && $type = $ty;
		@$page = max ( 1, intval ( $this->uri->segment ( 3 ) ) );
		$pagesize = 20;
		$startindex = ($page - 1) * $pagesize;
		$answerlist = $this->answer_model->list_by_condition ( '`status`=0', $startindex, $pagesize );
		$rownum = returnarraynum ( $this->db->query ( getwheresql ( 'answer', ' `status`=0', $this->db->dbprefix ) )->row_array () );
		$departstr = page ( $rownum, $pagesize, $page, "admin_question/examineanswer" );
		include template ( "verifyanswers", "admin" );
	}

	function makeindex() {
		ignore_user_abort ();
		set_time_limit ( 0 );
		$this->question_model->makeindex ();
		echo 'ok';
		exit ();
	}

}

?>