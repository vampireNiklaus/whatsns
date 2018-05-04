<?php

defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class Message extends CI_Controller {
	var $whitelist;
	function __construct() {
		$this->whitelist = "updateunread,sendmessage";
		parent::__construct ();

		$this->load->model ( 'user_model' );
		$this->load->model ( "message_model" );

	}

	/**
	 * 私人消息
	 */
	function personal() {
		$panneltype = "hidefixed";
		$navtitle = '个人消息';
		$type = 'personal';
		$page = max ( 1, intval ( $this->uri->segment ( 3 ) ) );
		$pagesize = $this->setting ['list_default'];
		$startindex = ($page - 1) * $pagesize;
		$messagelist = $this->message_model->group_by_touid ( $this->user ['uid'], $startindex, $pagesize );
		$messagenum = $this->message_model->rownum_by_touid ( $this->user ['uid'] );
		$departstr = page ( $messagenum, $pagesize, $page, "message/personal" );
		include template ( "message" );
	}

	/**
	 * 系统消息
	 */
	function system() {
		$panneltype = "hidefixed";
		$navtitle = '系统消息';
		$type = 'system';
		$page = max ( 1, intval ( $this->uri->segment ( 3 ) ) );
		$pagesize = $this->setting ['list_default'];
		$startindex = ($page - 1) * $pagesize;
		$this->message_model->read_by_fromuid ( 0, $this->user ['uid'] );
		$messagelist = $this->message_model->list_by_touid ( $this->user ['uid'], $startindex, $pagesize );
		$messagenum = returnarraynum ( $this->db->query ( getwheresql ( 'message', 'touid=' . $this->user ['uid'] . ' AND fromuid=0 AND status<>2 ', $this->db->dbprefix ) )->row_array () );
		$departstr = page ( $messagenum, $pagesize, $page, "message/system" );
		include template ( "message" );
	}

	/* 发消息 */

	function sendmessage() {
		$panneltype = "hidefixed";
		$navtitle = '发站内消息';
		if ($this->user ['uid'] == 0) {
			$this->message ( '请先登录!', get_url_source () );
		}
		if (null !== $this->uri->segment ( 3 )) {
			$sendto = $this->user_model->get_by_uid ( intval ( $this->uri->segment ( 3 ) ) );
		}

		if (null !== $this->input->post ( 'submit' )) {
			if (isset ( $this->setting ['code_message'] ) && $this->setting ['code_message'] == '1') {
				if (strtolower ( trim ( $this->input->post ( 'code' ) ) ) != $this->user_model->get_code ()) {
					$this->message ( $this->input->post ( 'state' ) . "验证码错误!", 'BACK' );
				}
			}
			$touser = $this->user_model->get_by_username ( $this->input->post ( 'username' ) );
			if (! $touser ['isnotify']) {
				$this->message ( '用户设置不允许私信Ta!', get_url_source () );
			}
			(! $touser) && $this->message ( '该用户不存在!', "message/send" );
			($touser ['uid'] == $this->user ['uid']) && $this->message ( "不能给自己发消息!", "message/send" );
			(trim ( $this->input->post ( 'content' ) ) == '') && $this->message ( "消息内容不能为空!", "message/send" );
			$this->message_model->add ( $this->user ['username'], $this->user ['uid'], $touser ['uid'], htmlspecialchars ( $this->input->post ( 'subject' ) ), $this->input->post ( 'content' ) );
			$this->credit ( $this->user ['uid'], $this->setting ['credit1_message'], $this->setting ['credit2_message'] );
			$this->message ( '消息发送成功!', get_url_source () );
		}
		include template ( 'sendmsg' );
	}

	/*更新没有读的消息*/
	function updateunread() {
		$type = "hidefixed";
		if ($this->user ['uid'] == 0) {
			$this->message ( '游客没有权限操作!' );
		}
		$this->message_model->update_allstatus ( $this->user ['uid'], 0 );
		$this->message ( '已将全部消息更新为已读!', get_url_source () );
	}
	/* 查看消息 */

	function view() {
		$panneltype = "hidefixed";
		$navtitle = "查看消息";
		$type = ($this->uri->segment ( 3 ) == 'personal') ? 'personal' : 'system';
		$fromuid = intval ( $this->uri->segment ( 4 ) );
		$id = intval ( $this->uri->segment ( 5 ) );
		$page = max ( 1, intval ( $this->uri->segment ( 6 ) ) );
		$pagesize = $this->setting ['list_default'];
		$startindex = ($page - 1) * $pagesize;
		$this->message_model->read_by_fromuid ( $fromuid, $this->user ['uid'], $id );
		$fromuser = $this->user_model->get_by_uid ( $fromuid );
		$status = 1;
		$messagelist = $this->message_model->list_by_fromuid ( $fromuid, $startindex, $pagesize );
		$messagenum = returnarraynum ( $this->db->query ( getwheresql ( 'message', "fromuid<>touid AND ((fromuid=$fromuid AND touid=" . $this->user ['uid'] . ") AND status IN (0,1)) OR ((touid=" . $this->user ['uid'] . " AND fromuid=" . $fromuid . ") AND  status IN (0,2))", $this->db->dbprefix ) )->row_array () );
		$departstr = page ( $messagenum, $pagesize, $page, "message/view/$type/$fromuid" );
		include template ( 'viewmessage' );
	}

	/* 删除消息 */

	/**
	 * 对于消息状态 status = 0  消息在两者都没有删除，1代表被发消息者删除，2代表被收件人删除
	 */
	function remove() {
		$panneltype = "hidefixed";
		if (null !== $this->input->post ( 'submit' )) {
			$inbox = checkattack ( $_POST ['messageid'] ['inbox'] );
			$outbox = checkattack ( $_POST ['messageid'] ['outbox'] );
			if ($inbox)
				$this->message_model->remove ( "inbox", $inbox );

			if ($outbox)
				$this->message_model->remove ( "outbox", $outbox );

			$this->message ( "消息删除成功!", get_url_source () );
		}
	}

	/**
	 * 删除对话
	 */
	function removedialog() {
		if ($this->input->post ( 'message_author' )) {
			$authors = $this->input->post ( 'message_author' );
			$this->message_model->remove_by_author ( $authors );
			$this->message ( "对话删除成功!", get_url_source () );
		}
	}

}

?>