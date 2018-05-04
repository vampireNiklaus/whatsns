<?php

class Note_model extends CI_Model {

	function __construct() {
		parent::__construct ();
		$this->load->database ();
	}

	function get($id) {
		$note = $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "note WHERE id='$id'" )->row_array ();
		$note ['format_time'] = tdate ( $note ['time'], 3, 0 );
		$note ['title'] = checkwordsglobal ( $note ['title'] );
		$note ['content'] = checkwordsglobal ( $note ['content'] );
		$note ['artlen'] = strlen ( strip_tags ( $note ['content'] ) );
		$note ['avatar'] = get_avatar_dir ( $note ['authorid'] );
		return $note;
	}
	//查找我是否评论过
	function getbyuid($uid, $id) {
		$note = $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "note_comment WHERE authorid='$uid' and id='$id'" )->row_array ();

		return $note;
	}
	function get_list($start = 0, $limit = 10) {
		$notelist = array ();
		$query = $this->db->query ( "select * from " . $this->db->dbprefix . "note order by id desc limit $start,$limit" );
		foreach ( $query->result_array () as $note ) {
			$note ['format_time'] = tdate ( $note ['time'], 3, 0 );
			$note ['title'] = checkwordsglobal ( $note ['title'] );
			$note ['avatar'] = get_avatar_dir ( $note ['authorid'] );
			$note ['image'] = getfirstimg ( $note ['content'] );
			$note ['content'] = cutstr ( checkwordsglobal ( strip_tags ( $note ['content'] ) ), 240, '...' );

			$notelist [] = $note;
		}
		return $notelist;
	}

	function add($title, $url, $content) {
		$username = $this->base->user ['username'];
		$uid = $this->base->user ['uid'];
		$this->db->query ( 'INSERT INTO ' . $this->db->dbprefix . "note(title,authorid,author,url,content,time) values ('$title','$uid','$username','$url','$content','{$this->base->time}')" );
		return $this->db->insert_id ();
	}

	function update_views($noteid) {
		$this->db->query ( "UPDATE " . $this->db->dbprefix . "note SET views=views+1 WHERE `id`='$noteid'" );
	}

	function update_comments($noteid) {
		$this->db->query ( "UPDATE " . $this->db->dbprefix . "note SET comments=comments+1 WHERE `id`='$noteid'" );
	}

	function update($id, $title, $url, $content) {
		$username = $this->base->user ['username'];
		$this->db->query ( 'update  ' . $this->db->dbprefix . "note  set title='$title',author='$username',url='$url',content='$content',time='{$this->base->time}' where id=$id " );
	}

	function remove_by_id($ids) {
		$this->db->query ( "DELETE FROM `" . $this->db->dbprefix . "note` WHERE `id` IN ($ids)" );
		$this->db->query ( "DELETE FROM `" . $this->db->dbprefix . "topdata` WHERE `typeid` IN ($ids) and type='note' " );
	}

}

?>
