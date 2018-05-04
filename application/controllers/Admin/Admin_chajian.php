<?php

defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class Admin_chajian extends CI_Controller {
	var $search;
	var $index;
	function __construct() {
		parent::__construct ();
		if ($this->setting ['xunsearch_open']) {
			require_once $this->setting ['xunsearch_sdk_file'];

			$xs = new XS ( 'question' );

			$this->search = $xs->search;

			$this->index = $xs->index;
		}
		$this->load->model ( 'setting_model' );
		$this->load->model ( 'question_model' );
		$this->load->model ( 'answer_model' );
		$this->load->model ( 'doing_model' );
		$this->load->model ( 'category_model' );
	}

	function autoasnwer() {

		$categoryjs = $this->category_model->get_js ();
		include template ( "autoanswer", "admin" );
	}

	function postanswer() {
		$message = array ();
			if (null !== $this->input->post ( 'submit' )) {

			$title = strip_tags ( $this->input->post ('title') );
			$miaosu = $this->input->post ('q_miaosu_eidtor_content');
			$zuijiadaan = $this->input->post ('q_best_eidtor_content');
			$qtime = strtotime ( $this->input->post ('qtime') );
			$qbesttime = $this->input->post ('qbesttime');
			if ($zuijiadaan != '') {
				$qbesttime = strtotime ( $qbesttime );
			}
			$views = $this->input->post ('views');
			$cid = $this->input->post ('cid');
			$cid1 = $this->input->post ('cid1');
			$cid2 = $this->input->post ('cid2');
			$cid3 = $this->input->post ('cid3');
			$userlist = $this->user_model->get_caiji_list ( 0, 200 );
			if (count ( $userlist ) <= 0) {
				$message ['msg'] = '没有可用的马甲用户，先去用户管理设置马甲';
				echo json_encode ( $message );
				exit ();
			}

			$mwtuid = array_rand ( $userlist, 1 );
			$q_uid = $userlist [$mwtuid] ['uid'];
			$q_username = $userlist [$mwtuid] ['username'];

			$qid = $this->add ( $title, $miaosu, $zuijiadaan, $cid, $qtime, $views, $q_uid, $q_username, $cid1, $cid2, $cid3 );

			if ($qid <= 0) {
				$message ['msg'] = '提交问题失败';
				echo json_encode ( $message );
				exit ();
			} else {
				$mwtuid = array_rand ( $userlist, 1 );
				$b_uid = $userlist [$mwtuid] ['uid'];
				$b_username = $userlist [$mwtuid] ['username'];

				$aid = $this->addanswer ( $qid, $title, $zuijiadaan, $qbesttime, $b_uid, $b_username );

				$numuser = rand ( 3, 20 );
				for($i = 0; $i <= $numuser; $i ++) {
					$auid = array_rand ( $userlist, 1 );
					$_uid = $userlist [$auid] ['uid'];
					$_username = $userlist [$auid] ['username'];
					$this->attention_question ( $qid, $_uid, $_username );
				}

				$question = $this->question_model->get ( $qid );

				$answer = $this->answer_model->get ( $aid );

				$ret = $this->answer_model->adopt ( $qid, $answer );

				if ($ret) {
					$this->load->model ( "answer_comment_model" );
					$this->answer_comment_model->add ( $aid, '非常感谢', $question ['authorid'], $question ['author'] );

					$this->credit ( $answer ['authorid'], $this->setting ['credit1_adopt'], intval ( $question ['price'] + $this->setting ['credit2_adopt'] ), 0, 'adopt' );

					$viewurl = urlmap ( 'question/view/' . $qid, 2 );

		//$_ENV['doing']->add($question['authorid'], $question['author'], 8, $qid, '非常感谢', $answer['id'], $answer['authorid'], $answer['content']);
				}
				$message ['msg'] = 'ok';
				echo json_encode ( $message );
				exit ();
			}

		} else {
			$message ['msg'] = '非法提交表单';
			echo json_encode ( $message );
			exit ();
		}
	}
	//关注问题
	function attention_question($qid, $user_uid, $user_username) {
		$uid = $user_uid;
		$username = $user_username;
		$is_followed = $this->question_model->is_followed ( $qid, $uid );
		if ($is_followed) {
			$this->user_model->unfollow ( $qid, $uid );
		} else {
			$this->user_model->follow ( $qid, $uid, $username );

			$this->doing_model->add ( $uid, $username, 4, $qid );
		}
	}
	/* 插入问题到question表 */

	function add($title, $description, $zuijiadaan, $cid, $qtime, $views, $uid, $username, $cid1 = 0, $cid2 = 0, $cid3 = 0, $status = 1, $shangjin = 0, $askfromuid = 0) {
		$overdue_days = intval ( $this->setting ['overdue_days'] );
		$creattime = $qtime;
		$hidanswer = 0;
		$price = 0;
		$answers = 0;
		if ($zuijiadaan != '') {
			$answers = 1;
		}
		$endtime = $this->time + $overdue_days * 86400;

		(! strip_tags ( $description, '<img>' )) && $description = '';
		$data=array('views'=>$views,'cid'=>$cid,'cid1'=>$cid1,'cid2'=>$cid2,'cid2'=>$views,'cid3'=>$cid3,'askuid'=>$askfromuid,'authorid'=>$uid,'shangjin'=>$shangjin,'author'=>$username,'title'=>$title,'description'=>$description,'price'=>$price,'time'=>$creattime,'endtime'=>$endtime,'hidden'=>$hidanswer,'status'=>$status,'ip'=>getip());
		$this->db->insert('question',$data);
		/* 分词索引 */
		$qid = $this->db->insert_id ();
		if ($this->setting ['xunsearch_open'] && $qid) {
			$question = array ();
			$question ['id'] = $qid;
			$question ['cid'] = $cid;
			$question ['cid1'] = $cid1;
			$question ['cid2'] = $cid2;
			$question ['cid3'] = $cid3;
			$question ['author'] = $username;
			$question ['authorid'] = $uid;
			$question ['answers'] = $answers;
			$question ['price'] = $price;
			$question ['attentions'] = 1;
			$question ['shangjin'] = $shangjin;
			$question ['status'] = $status;
			$question ['time'] = $creattime;
			$question ['title'] = checkwordsglobal ( $title );
			$question ['description'] = checkwordsglobal ( $description );
			$doc = new XSDocument ();
			$doc->setFields ( $question );
			$this->index->add ( $doc );
		}
		$cid1 = intval ( $cid1 );
		$cid2 = intval ( $cid2 );
		$cid3 = intval ( $cid3 );
		$this->db->query ( "UPDATE " . $this->db->dbprefix . "category SET questions=questions+1 WHERE  id IN ($cid1,$cid2,$cid3) " );
		$uid && $this->db->query ( "UPDATE " . $this->db->dbprefix . "user SET questions=questions+1 WHERE  uid =$uid" );
		return $qid;
	}
	/* 添加答案 */

	function addanswer($qid, $title, $content, $qbesttime, $uid, $username, $status = 1, $chakanjine = 0) {
		$content = checkwordsglobal ( $content );
		$supports = rand ( 20, 100 );
	    $data=array('qid'=>$qid,'title'=>$title,'supports'=>$supports,'author'=>$username,'authorid'=>$uid,'time'=>$qbesttime,'content'=>$content,'reward'=>$chakanjine,'status'=>$status,'ip'=>getip());
	    $this->db->insert('answer',$data);
		$aid = $this->db->insert_id ();
		$this->db->query ( "UPDATE " . $this->db->dbprefix . "question SET  answers=answers+1  WHERE id=" . $qid );
		$this->db->query ( "UPDATE " . $this->db->dbprefix . "user SET answers=answers+1 WHERE  uid =$uid" );
		return $aid;
	}

}
