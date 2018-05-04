<?php

defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class Admin_user extends CI_Controller {

	function __construct() {
		parent::__construct ();
		$this->load->model ( 'user_model' );

		$this->load->model ( 'usergroup_model' );
		$this->load->model ( 'famous_model' );
	}

	function index($msg = '') {

		//获取用户在平台账户的余额
		$usermoney = $this->user_model->getallusermoney ();
		$usermoney = doubleval ( $usermoney ) / 100 . "元"; //格式化用户金额
		//获取通过微信绑定个人账号的总数
		$bindopenidusernum = $this->user_model->getsumuserbyopenid ();
		//获取通过邮箱激活的的总数
		$emailactiveusernum = $this->user_model->getsumuserbyueamactive ();

		@$page = max ( 1, intval ( $this->uri->segment ( 3 ) ) );
		$pagesize = $this->setting ['list_default'];
		$startindex = ($page - 1) * $pagesize;
		$userlist = $this->user_model->get_list ( $startindex, $pagesize );
		$usernum = returnarraynum ( $this->db->query ( getwheresql ( 'user', '1=1', $this->db->dbprefix ) )->row_array () );
		$departstr = page ( $usernum, $pagesize, $page, "admin_user/index" );
		$msg && $message = $msg;
		$usergrouplist = $this->usergroup_model->get_list ();
		$sysgrouplist = $this->usergroup_model->get_list ( 1 );
		include template ( 'userlist', 'admin' );
	}

	function search() {
		//获取用户在平台账户的余额
		$usermoney = $this->user_model->getallusermoney ();
		$usermoney = doubleval ( $usermoney ) / 100 . "元"; //格式化用户金额
		//获取通过微信绑定个人账号的总数
		$bindopenidusernum = $this->user_model->getsumuserbyopenid ();
		//获取通过邮箱激活的的总数
		$emailactiveusernum = $this->user_model->getsumuserbyueamactive ();
		$search = array ();
		if (count ( $_POST ) > 2) {

			$search = $_POST;

		}

		@$page = max ( 1, intval ( $this->uri->segment ( 11 ) ) );
		$pagesize = $this->setting ['list_default'];
		$startindex = ($page - 1) * $pagesize;
		$condition = '1=1 ';
		if (isset ( $search ['srchname'] ) && '' != trim ( $search ['srchname'] )) {
			$condition .= " AND `username` like '" . trim ( $search ['srchname'] ) . "%' ";
		}
		if (isset ( $search ['ischeck'] ) && '' != trim ( $search ['ischeck'] ) && $search ['ischeck'] == 1) {
			$condition .= " AND `active` = '" . trim ( $search ['ischeck'] ) . "' ";
		}
		if (isset ( $search ['ischeck'] ) && '' != trim ( $search ['ischeck'] ) && $search ['ischeck'] == 2) {
			$condition .= " AND `openid` != '' ";
		}
		if (isset ( $search ['ischeck'] ) && '' != trim ( $search ['ischeck'] ) && $search ['ischeck'] == 3) {
			$condition .= " AND `openid` != '' AND active =1 ";
		}
		if (isset ( $search ['ischeck'] ) && '' != trim ( $search ['ischeck'] ) && $search ['ischeck'] == 4) {
			$condition .= " AND `jine` > 0 ";
		}
		//echo $search['ischeck'].'/'.$condition;exit();
		if (isset ( $search ['srchuid'] ) && '' != trim ( $search ['srchuid'] )) {
			$condition .= " AND `uid`=" . intval ( $search ['srchuid'] );
		}
		if (isset ( $search ['srchemail'] ) && '' != trim ( $search ['srchemail'] )) {
			$condition .= " AND `email` = '" . trim ( $search ['srchemail'] ) . "'";
		}
		if (isset ( $search ['srchregdatestart'] ) && '' != trim ( $search ['srchregdatestart'] )) {
			$datestart = strtotime ( $search ['srchregdatestart'] );
			$condition .= " AND `regtime` >= $datestart ";
		}
		if (isset ( $search ['srchregdateend'] ) && '' != trim ( $search ['srchregdateend'] )) {
			$dateend = strtotime ( $search ['srchregdateend'] );
			$condition .= " AND `regtime` <= " . $dateend;
		}
		if (isset ( $search ['srchregip'] ) && '' != trim ( $search ['srchregip'] )) {
			$condition .= " AND `regip` = '" . $search ['srchregip'] . "' ";
		}
		if (isset ( $search ['srchgroupid'] ) && 0 != $search ['srchgroupid']) {
			$condition .= " AND `groupid` = '" . $search ['srchgroupid'] . "' ";
		}
		$usergrouplist = $this->usergroup_model->get_list ();
		$sysgrouplist = $this->usergroup_model->get_list ( 1 );
		$userlist = $this->user_model->list_by_search_condition ( $condition, $startindex, $pagesize );
		$usernum = returnarraynum ( $this->db->query ( getwheresql ( 'user', $condition, $this->db->dbprefix ) )->row_array () );
		$departstr = page ( $usernum, $pagesize, $page, "admin_user/search/$search[srchname]/$search[srchuid]/$search[srchemail]/$search[srchregdatestart]/$search[srchregdateend]/$search[srchregip]/$search[srchgroupid]/$search[ischeck]" );
		include template ( 'userlist', 'admin' );
	}

	function add() {
		if (null !== $this->input->post ( 'submit' )) {
			if ($this->setting ["ucenter_open"]) {
				$this->index ( "开启ucenter后不能注册用户" );
				exit ();
			}
			$m = $this->user_model->get_by_username ( $this->input->post ( 'addname' ) );
			if (! $m) {
				$this->user_model->caijiadd ( $this->input->post ( 'addname' ), $this->input->post ( 'addpassword' ), $this->input->post ( 'addemail' ), $this->input->post ( 'fromtype' ) );
				$this->index ();
				exit ();
			} else {
				$this->index ( $this->input->post ( 'addname' ) . "已存在" );
			}
		}
		include template ( 'adduser', 'admin' );
	}

	function expert() {
		if (null !== $this->input->post ( 'uid' )) {
			$type = intval ( $this->uri->segment ( 3 ) );
			$uids = $this->input->post ( 'uid' );
			$uids = $this->user_model->update_expert ( $uids, $type );
			$this->index ( "专家设置完成" );
		}
	}
	function caijiuser() {
		if (null !== $this->input->post ( 'uid' )) {
			$type = intval ( $this->uri->segment ( 3 ) );
			$uids = $this->input->post ( 'uid' );
			$uids = $this->user_model->update_caijiuser ( $uids, $type );
			$this->index ( "采集用户设置完成" );
		}
	}
	function remove() {
		if (null !== $this->input->post ( 'uid' )) {
			$uids = implode ( ",", $this->input->post ( 'uid' ) );
			$all = null !== $this->uri->segment ( 3 ) ? 1 : 0;
			$this->user_model->remove ( $uids, $all );
			$this->index ( '用户删除成功!' );
		}
	}

	function edit() {
		$uid = (null !== $this->uri->segment ( 3 )) ? intval ( $this->uri->segment ( 3 ) ) : $this->input->post ( 'uid' );
		if (null !== $this->input->post ( 'submit' )) {
			$type = 'errormsg';
			//需要跟新的数据
			$username = $this->input->post ( 'username' );
			$password = $this->input->post ( 'password' );
			$email = $this->input->post ( 'email' );
			$groupid = $this->input->post ( 'groupid' );
			$credits = intval ( $this->input->post ( 'credits' ) );
			$credit1 = intval ( $this->input->post ( 'credit1' ) );
			$credit2 = intval ( $this->input->post ( 'credit2' ) );
			$jine = doubleval ( $this->input->post ( 'jine' ) ) * 100;
			$mypay = doubleval ( $this->input->post ( 'mypay' ) );
			$gender = $this->input->post ( 'gender' );
			$bday = $this->input->post ( 'bday' );
			$isblack = $this->input->post ( 'isblack' );
			$phone = $this->input->post ( 'phone' );
			$qq = $this->input->post ( 'qq' );

			$msn = $this->input->post ( 'msn' );
			$introduction = htmlspecialchars ( $this->input->post ( 'introduction' ) );
			$signature = htmlspecialchars ( $this->input->post ( 'signature' ) );
			//表单检查
			$user = $this->user_model->get_by_uid ( $uid );

			if ($username && '' == $username) {
				$message = '用户名不能为空';
			} else if ($username != $user ['username'] && $this->user_model->get_by_username ( $username )) {
				$message = '该用户名已经注册，请重新修改!';
			} else if ($password && $password != $this->input->post ( 'confirmpw' )) {
				$message = '两次密码不一致，请核实!';
			} else if ($email && ! preg_match ( "/^[a-z'0-9]+([._-][a-z'0-9]+)*@([a-z0-9]+([._-][a-z0-9]+))+$/", $email )) {
				$message = '邮箱地址不合法!';
			} else if ($user ['email'] != $email && $this->user_model->get_by_email ( $email ) && $email != '') {
				$message = '该邮箱已有人使用，请修改!';
			} else {
				$password = ($password == '') ? $user ['password'] : md5 ( $password );
				$this->user_model->update_user ( $uid, $username, $password, $email, $groupid, $credits, $credit1, $credit2, $gender, $bday, $phone, $qq, $msn, $introduction, $signature, $isblack );
				if ($user ['username'] != $username) {
					$this->db->query ( "UPDATE " . $this->db->dbprefix . "question SET author='$username' WHERE authorid=$uid " );
					$this->db->query ( "UPDATE " . $this->db->dbprefix . "topic SET author='$username' WHERE authorid=$uid " );
					$this->db->query ( "UPDATE " . $this->db->dbprefix . "answer SET author='$username' WHERE authorid=$uid " );
					$this->db->query ( "UPDATE " . $this->db->dbprefix . "answer_append SET author='$username' WHERE authorid=$uid " );
					$this->db->query ( "UPDATE " . $this->db->dbprefix . "answer_comment SET author='$username' WHERE authorid=$uid " );
				}
				if ($jine > 0) {
					$this->db->query ( "UPDATE " . $this->db->dbprefix . "user SET jine='$jine' WHERE uid=$uid " );
				}
				if ($mypay > 0) {
					$this->db->query ( "UPDATE " . $this->db->dbprefix . "user SET mypay='$mypay' WHERE uid=$uid " );
				}
				$message = '用户资料编辑成功!';
				unset ( $type );
			}
		}
		$member = $this->user_model->get_by_uid ( $uid );
		$usergrouplist = $this->usergroup_model->get_list ();
		$sysgrouplist = $this->usergroup_model->get_list ( 1 );
		include template ( 'edituser', 'admin' );
	}

	function elect() {
		if (null !== $this->input->post ( 'uid' )) {
			$uid = intval ( $this->input->post ( 'uid' ) );
			$this->user_model->update_elect ( $uid, intval ( $this->uri->segment ( 3 ) ) );
			$msg = intval ( $this->uri->segment ( 3 ) ) ? '推荐成功!' : '取消推荐成功!';
			unset ( $_GET );
			$this->index ( $msg );
		}
	}

	function famous() {
		if (null !== $this->input->post ( 'uid' )) {
			$uid = $this->input->post ( 'uid' );
			$is_elect = intval ( $this->uri->segment ( 3 ) );
			$this->user_model->update_elect ( $uid, $is_elect );
			if ($is_elect) {
				$this->famous_model->add ( $uid, $this->input->post ( 'reason' ) );
				$msg = '推荐成功!';
			} else {
				$this->famous_model->remove ( $uid );
				$msg = '取消推荐成功!';
			}
			unset ( $_GET );
			$this->index ( $msg );
		}
	}

	function ajaxgetcredit1() {
		$groupid = intval ( $this->uri->segment ( 3 ) );
		if (isset ( $this->usergroup [$groupid] ) && $this->usergroup [$groupid] ['grouptype'] == 2) {
			exit ( $this->usergroup [$groupid] ['creditslower'] );
		}
		exit ( '0' );
	}

}

?>