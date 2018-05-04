<?php

class Vertify_model extends CI_Model {

	function __construct() {
		parent::__construct ();
		$this->load->database ();
	}

	function get_by_uid($uid, $loginstatus = 1) {

		$vertify = $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "vertify WHERE uid='$uid'" )->row_array ();
		if($vertify){
		$vertify ['avatar'] = get_avatar_dir ( $uid );
		$vertify ['time'] = tdate ( $vertify ['time'] );
		if ($vertify ['status'] == null) {
			$vertify ['status'] = - 1;
		}
		switch ($vertify ['status']) {
			case 0 :
				$vertify ['msg'] = "等待审核";
				break;
			case 1 :
				$vertify ['msg'] = "审核通过";
				break;
			case 2 :
				$vertify ['msg'] = "审核被退回";
				break;
			default :
				$vertify ['msg'] = "未认证";
				break;
		}
		}

		return $vertify;
	}
	//获取审核列表
	function get_list($status, $start = 0, $limit = 10) {
		$vertifylist = array ();
		$query = $this->db->query ( "select * from " . $this->db->dbprefix . "vertify where status=$status order by time asc limit $start,$limit" );
		foreach ( $query->result_array () as $vertify ) {
			$vertify ['vcategory'] = $this->get_category ( $vertify ['uid'] );
			$vertify ['avatar'] = get_avatar_dir ( $vertify ['uid'] );
			$vertify ['time'] = tdate ( $vertify ['time'] );
			$vertify ['jieshao'] = cutstr ( checkwordsglobal ( strip_tags ( $vertify ['jieshao'] ) ), 120, '...' );
			$vertifylist [] = $vertify;
		}
		return $vertifylist;
	}
	//插入审核信息
	function add($uid, $type, $name, $idcode, $jieshao, $zhaopian1, $zhaopian2, $status) {
		$this->db->query ( "DELETE FROM " . $this->db->dbprefix . "vertify WHERE  uid=$uid" );
		$status = 0;
		$this->db->query ( "INSERT INTO " . $this->db->dbprefix . "vertify(uid,type,name,id_code,jieshao,zhaopian1,zhaopian2,status,time) values ('$uid','$type','$name','$idcode','$jieshao','$zhaopian1','$zhaopian2','$status',{$this->base->time})" );
		$id = $this->db->insert_id ();
		$this->db->query ( 'update  ' . $this->db->dbprefix . "user  set hasvertify=0 where uid=$uid" );
		return $id;
	}

	//更新审核信息
	function save($id, $uid, $status, $yuanyin) {

		$this->db->query ( 'update  ' . $this->db->dbprefix . "vertify  set status=$status,shibaiyuanyin='$yuanyin' where id=$id and uid=$uid" );
		if ($status == 1) {
			$this->db->query ( 'update  ' . $this->db->dbprefix . "user  set hasvertify=1 where uid=$uid" );
		}
	}
	//获取用户擅长分类
	function get_category($uid) {
		$query = $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "user_category WHERE uid=$uid" );
		$categorystr = '';
		foreach ( $query->result_array () as $category ) {
			$category ['categoryname'] = $this->base->category [$category ['cid']] ['name'];
			$categorystr .= "<span class='label'>" . $category ['categoryname'] . "</span>,";
		}
		return $categorystr;
	}
}

?>
