<?php

class Articlecomment_model extends CI_Model {

	var $statustable = array ('all' => ' AND status!=0', '0' => ' AND status=0', '1' => ' AND status!=0 ', '2' => ' AND status!=0 ' );

	function __construct() {
		parent::__construct ();
		$this->load->database ();
	}

	/* 根据aid获取一个答案的内容，暂时无用 */

	function get($id) {
		$id = intval ( $id );
		$answer = $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "articlecomment WHERE id='$id'" )->row_array ();

		if ($answer) {

			$answer ['title'] = checkwordsglobal ( $answer ['title'] );
			$answer ['content'] = checkwordsglobal ( $answer ['content'] );
		}
		return $answer;
	}

	function updatecmsupport($cmid) {
		$cmid = intval ( $cmid );
		$this->db->query ( "UPDATE " . $this->db->dbprefix . "articlecomment SET supports=supports+1 WHERE id =$cmid" );

	}
	function list_by_tid($tid, $status, $start = 0, $limit = 5) {
		$answerlist = array ();
		$sql = 'SELECT * FROM `' . $this->db->dbprefix . 'articlecomment` WHERE `tid`=' . $tid;
		$sql .= ' AND status=1 ' . ' ORDER BY `supports` DESC , `time` DESC   LIMIT ' . $start . ',' . $limit;

		$query = $this->db->query ( $sql );
		foreach ( $query->result_array () as $answer ) {
			$answer ['time'] = tdate ( $answer ['time'] );
			$answer ['avatar'] = get_avatar_dir ( $answer ['authorid'] );
			$answer ['author_has_vertify'] = get_vertify_info ( $answer ['authorid'] ); //用户是否认证
			$answer ['content'] = checkwordsglobal ( $answer ['content'] );
			$answerlist [] = $answer;
		}
		return $answerlist;
	}
	//检查用户是否评论过
	function checkhascomment($tid, $uid) {
		$tid = intval ( $tid );
		$uid = intval ( $uid );
		$comment = $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "articlecomment WHERE tid=$tid and authorid=$uid" )->row_array ();
		return $comment;
	}
	function add_seo($tid, $title, $content, $uid1, $username1, $status = 0, $supports = 13) {
		try {
			$uid = $uid1;
			$tid = intval ( $tid );
			$uid = intval ( $uid );
			$username = $username1;
			$mtime = time ();
			$data = array ('tid' => $tid, 'title' => $title, 'author' => $username, 'authorid' => $uid, 'time' => $mtime, 'content' => $content, 'supports' => $supports, 'status' => $status, 'ip' => getip () );
			$this->db->insert ( 'articlecomment', $data );
			$aid = $this->db->insert_id ();
			$this->db->query ( "UPDATE " . $this->db->dbprefix . "topic SET  articles=articles+1  WHERE id=" . $tid );
			$this->db->query ( "UPDATE " . $this->db->dbprefix . "user SET articles=articles+1 WHERE  uid =$uid" );
			return $aid;
		} catch ( Exception $er ) {
			return '0';
		}
	}
	function ondeletecomment() {
		if (null!== $this->input->post ( 'id' ) ) {
			$commentid = intval ( $this->input->post ( 'id' ) );
			$this->db->query ( "DELETE FROM `" . $this->db->dbprefix . "articlecomment ` WHERE `id` IN ($commentid)" );

			exit ( '1' );
		}
	}
	function addarticlecomment($data){
       $this->db->insert('article_comment',$data);
       $aid = $this->db->insert_id ();
       if($aid){
       	$this->db->query ( "UPDATE " . $this->db->dbprefix . "articlecomment SET  comments=comments+1  WHERE id=" . $data['aid'] );
       }
       return $aid;
	}
    function getarticlecommentlist($tid,$aid){
    	$commentlist=$this->db->get_where( 'article_comment', array ('tid' => $tid, 'aid' => $aid ))->result_array();
    	foreach ($commentlist as $key=>$val){
           $commentlist[$key]['time']=tdate($commentlist[$key]['time']);
           $commentlist[$key]['userhomelink']=url('user/space/'.$commentlist[$key]['authorid']);
           $commentlist[$key]['deltag']=$this->user['uid']==$commentlist[$key]['authorid'] ? '<span class="deltag" dataid="'.$commentlist[$key]['id'].'">删除</span>':'' ;
    		}
    	return $commentlist;
    }
    //获取当前文章评论回复
    function getoneartcomment($id){
      $comment=$this->db->get_where( 'article_comment', array ('id' => $id))->row_array();
      return $comment;
    }
    //删除文章评论
    function delartcomment($id,$aid){
    	$this->db->delete( 'article_comment', array ('id' => $id));
    	$this->db->query ( "UPDATE " . $this->db->dbprefix . "articlecomment SET  comments=comments-1  WHERE id=" . $aid );
    }

}

?>
