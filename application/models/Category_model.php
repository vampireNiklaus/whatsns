<?php

class Category_model extends CI_Model {

	function __construct() {
		parent::__construct ();
		$this->load->database ();
	}

	/* 获取分类信息 */

	function get($id) {
		$id = intval ( $id );
		$category = $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "category WHERE id='$id'" )->row_array ();
	    if(isset($category)){
	    	$category['image'] = get_cid_dir ( $category['id'], 'big' );
		$category['bigimage'] = get_cid_dir ( $category['id'], 'big' );
	    }
		return $category;
	}

	function get_list() {
		$categorylist = array ();
		$query = $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "category" );
		foreach ( $query->result_array () as $category ) {
			$category ['image'] = get_cid_dir ( $category ['id'], 'small' );
			$category ['bigimage'] = get_cid_dir ( $category ['id'], 'big' );
			$categorylist [] = $category;
		}
		return $categorylist;
	}

	function listtopic($status, $start, $limit) {
		$categorylist = array ();
		$order = 'ORDER BY `followers` DESC';
		switch ($status) {
			case 'hot' :
				$order = 'ORDER BY `followers` DESC';
				break;
			case 'new' :
				$order = 'ORDER BY `id` DESC';
				break;
		}
		$query = $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "category $order  LIMIT $start,$limit" );
		foreach ( $query->result_array () as $category ) {
			$category ['image'] = get_cid_dir ( $category ['id'], 'small' );
			$category ['bigimage'] = get_cid_dir ( $category ['id'], 'big' );
			$category ['follow'] = $this->is_followed ( $category ['id'], $this->base->user ['uid'] );
			$category ['miaosu'] = cutstr ( checkwordsglobal ( strip_tags ( $category ['miaosu'] ) ), 40, '...' );
			if ($category ['miaosu'] == '') {
				$category ['miaosu'] = "该专题暂无描述";
			}
			$categorylist [] = $category;
		}
		return $categorylist;
	}
	/* 用于在首页左侧显示 */

	function list_by_grade($grade = 1) {
		$categorylist = array ();
		$query = $this->db->query ( "select id,name,questions,grade,image,miaosu,followers from " . $this->db->dbprefix . "category where grade=1 and isshowindex=1 order by displayorder asc,id asc" );
		foreach ( $query->result_array () as $category1 ) {
			$category1 ['image'] = get_cid_dir ( $category1 ['id'], 'small' );
			$category1 ['bigimage'] = get_cid_dir ( $category1 ['id'], 'big' );
			$query2 = $this->db->query ( "select id,name,questions,miaosu,followers from " . $this->db->dbprefix . "category where pid=$category1[id] and grade=2 order by displayorder asc,id asc" );
			$category1 ['sublist'] = array ();
			foreach ( $query2->result_array () as $category2 ) {
				$category2 ['image'] = get_cid_dir ( $category2 ['id'], 'small' );
				$category2 ['bigimage'] = get_cid_dir ( $category2 ['id'], 'big' );
				$category1 ['sublist'] [] = $category2;
			}
			$categorylist [] = $category1;
		}
		return $categorylist;
	}

	/**
	 * 获得分类树
	 *
	 * @param array $allcategory
	 * @return string
	 */
	function get_categrory_tree($type = 1) {
		$where='';
		$type == 1 && $where = ' and isuseask=1 ';
		$type == 2 && $where = ' and isusearticle=1 ';
		$categorylist = array ();
		$query = $this->db->query ( "select * from " . $this->db->dbprefix . "category where grade=1 $where order by displayorder asc,id asc" );
		foreach ( $query->result_array () as $category1 ) {

			$categorylist [] = $category1;
		}
		$allcategory = $categorylist;
		$categrorytree = '';
		foreach ( $allcategory as $key => $category ) {
			if ($category ['pid'] == 0) {
				$categrorytree .= "<option value=\"{$category['id']}\">{$category['name']}</option>";
				$categrorytree .= $this->get_child_tree ( $allcategory, $category ['id'], 1 );
			}
		}
		return $categrorytree;
	}

	function get_child_tree($allcategory, $pid, $depth = 1) {
		$childtree = '';
		foreach ( $allcategory as $key => $category ) {
			if ($pid == $category ['pid']) {
				$childtree .= "<option value=\"{$category['id']}\">";
				$depthstr = str_repeat ( "--", $depth );
				$childtree .= $depth ? "&nbsp;&nbsp;|{$depthstr}&nbsp;{$category['name']}</option>" : "{$category['name']}</option>";
				$childtree .= $this->get_child_tree ( $allcategory, $category ['id'], $depth + 1 );
			}
		}
		return $childtree;
	}
	/* 后台管理编辑分类别名 */
	function update_by_id_alias($id, $alias) {

		$this->db->query ( "UPDATE `" . $this->db->dbprefix . "category` SET   `alias`='$alias' WHERE `id`=$id" );
	}
	//应用新模板
	function update_by_id_tmplate($id, $tmpname) {
		$this->db->query ( "UPDATE `" . $this->db->dbprefix . "category` SET   `template`='$tmpname' WHERE `id`=$id" );
	}
	//修改分类显示状态
	function update_by_type($id, $type, $typevalue) {

		$this->db->query ( "UPDATE `" . $this->db->dbprefix . "category` SET   `$type`='$typevalue' WHERE `id`=$id" );
	}
	/* 后台管理编辑分类描述*/
	function update_by_id_miaosu($id, $miaosu) {

		$sql = "UPDATE `" . $this->db->dbprefix . "category` SET   `miaosu`='$miaosu' WHERE `id`=$id";
		$this->db->query ( $sql );
	}
	/* 获取某一根节点的所有分类 */

	function list_by_pid($pid, $limit = 100) {
		$categorylist = array ();
		$pid = intval ( $pid );
		$query = $this->db->query ( "SELECT * FROM `" . $this->db->dbprefix . "category` WHERE `pid`=$pid ORDER BY displayorder ASC,id ASC LIMIT $limit" );
		foreach ( $query->result_array () as $category ) {
			$category ['image'] = get_cid_dir ( $category ['id'], 'big' );
			$categorylist [] = $category;
		}
		return $categorylist;
	}
	/*根据cid获取关注分类的人*/
	function get_followers($cid, $start, $limit) {
		$followerlist = array ();
		$cid = intval ( $cid );
		$query = $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "categotry_follower WHERE cid=$cid ORDER BY `time` DESC LIMIT $start,$limit" );
		foreach ( $query->result_array () as $follower ) {
			$_user = $this->get_by_uid ( $follower ['uid'] );
			$follower ['follower'] = $_user ['username'];
			$follower ['avatar'] = get_avatar_dir ( $follower ['uid'] );
			$follower ['format_time'] = tdate ( $follower ['time'] );
			$followerlist [] = $follower;
		}
		return $followerlist;
	}

	/*根据uid获取用户名*/
	function get_by_uid($uid) {
		$user = $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "user WHERE uid='$uid'" )->row_array ();

		return $user;
	}
	/* 根据分类名检索 */

	function list_by_name($name, $start = 0, $limit = 10) {
		global $user;
		$categorylist = array ();
		$query = $this->db->query ( "SELECT * FROM `" . $this->db->dbprefix . "category` WHERE `name` like '%$name%' ORDER BY followers DESC LIMIT $limit" );
		foreach ( $query->result_array () as $category ) {
			$category ['follow'] = $this->is_followed ( $category ['id'], $user ['uid'] );
			$category ['image'] = get_cid_dir ( $category ['id'], 'big' );
			$categorylist [] = $category;
		}
		return $categorylist;
	}

	/* 分类浏览页面显示子分类 */

	function list_by_cid_pid($cid, $pid) {
		$sublist = array ();
		if ($cid == 'all') {
			$cid = 0;
		}
		if ($pid == 'all') {
			$pid = 0;
		}
		$query = $this->db->query ( "select * from " . $this->db->dbprefix . "category where pid=$cid and isuseask=1 order by displayorder asc,id asc" );
//		$subcount = $this->db->affected_rows ();
//		if ($subcount <= 0) {
//			$query = $this->db->query ( "select id,name,questions,grade,alias from " . $this->db->dbprefix . "category where pid=$pid order by displayorder asc,id asc" );
//		}
		foreach ( $query->result_array () as $category ) {
			$category ['image'] = get_cid_dir ( $category ['id'], 'big' );
			$category ['bigimage'] = get_cid_dir ( $category ['id'], 'big' );
			$sublist [] = $category;
		}
		return $sublist;
	}
/* 分类浏览页面显示子分类 */

	function list_by_cid_pid_all($cid, $pid) {
		$sublist = array ();
		if ($cid == 'all') {
			$cid = 0;
		}
		if ($pid == 'all') {
			$pid = 0;
		}
		$query = $this->db->query ( "select * from " . $this->db->dbprefix . "category where pid=$cid and isusearticle=1 order by displayorder asc,id asc" );
//		$subcount = $this->db->affected_rows ();
//		if ($subcount <= 0) {
//			$query = $this->db->query ( "select id,name,questions,grade,alias from " . $this->db->dbprefix . "category where pid=$pid order by displayorder asc,id asc" );
//		}
		foreach ( $query->result_array () as $category ) {
			$category ['image'] = get_cid_dir ( $category ['id'], 'big' );
			$category ['bigimage'] = get_cid_dir ( $category ['id'], 'big' );
			$sublist [] = $category;
		}
		return $sublist;
	}
		function list_by_cid_pid_wenzhang($cid, $pid) {
		$sublist = array ();
		if ($cid == 'all') {
			$cid = 0;
		}
		if ($pid == 'all') {
			$pid = 0;
		}
		$query = $this->db->query ( "select * from " . $this->db->dbprefix . "category where pid=$cid order by displayorder asc,id asc" );
//		$subcount = $this->db->affected_rows ();
//		if ($subcount <= 0) {
//			$query = $this->db->query ( "select id,name,questions,grade,alias from " . $this->db->dbprefix . "category where pid=$pid order by displayorder asc,id asc" );
//		}
		foreach ( $query->result_array () as $category ) {
			$category ['image'] = get_cid_dir ( $category ['id'], 'big' );
			$category ['bigimage'] = get_cid_dir ( $category ['id'], 'big' );
			$sublist [] = $category;
		}
		return $sublist;
	}


	/* 用于提问时候分类的选择 type类型值  0:表示问答和文章都可以显示，1：显示问答，2：显示文章*/

	function get_js($cid = 0, $type = 0) {
		$cid = intval ( $cid );
		$categoryjs = array ();
		$category1 = $category2 = $category3 = '';
		switch ($type) {
			case 0 :
				$query = $this->db->query ( "SELECT *  FROM " . $this->db->dbprefix . "category WHERE `id` != $cid  order by displayorder asc " );
				break;
			case 1 :
				$query = $this->db->query ( "SELECT *  FROM " . $this->db->dbprefix . "category WHERE `id` != $cid  and isuseask = 1 order by displayorder asc " );
				break;
			case 2 :
				$query = $this->db->query ( "SELECT *  FROM " . $this->db->dbprefix . "category WHERE `id` != $cid and isusearticle = 1 order by displayorder asc " );
				break;
		}

		foreach ( $query->result_array () as $category ) {
			switch ($category ['grade']) {
				case 1 :
					$category1 .= '["' . $category ['id'] . '","' . $category ['name'] . '"],';
					break;
				case 2 :
					$category2 .= '["' . $category ['pid'] . '","' . $category ['id'] . '","' . $category ['name'] . '"],';
					break;
				case 3 :
					$category3 .= '["' . $category ['pid'] . '","' . $category ['id'] . '","' . $category ['name'] . '"],';
					break;
			}
		}
		$categoryjs ['category1'] = "[" . substr ( $category1, 0, - 1 ) . "]";
		$categoryjs ['category2'] = "[" . substr ( $category2, 0, - 1 ) . "]";
		$categoryjs ['category3'] = "[" . substr ( $category3, 0, - 1 ) . "]";
		return $categoryjs;
	}

	/* 分类显示页面分类导航 */

	function get_navigation($cid = 0, $contain = false) {
		global $category;
		$navlist = array ();
		do {
			$category = isset ( $category [$cid] ) ? $category [$cid] : null;
			if ($category) {
				$cid = $category ['pid'];
				$navlist [] = $category;
			}
		} while ( $category && $cid );
		$navlist = array_reverse ( $navlist );
		! $contain && array_pop ( $navlist ); //是否需要本分类
		return $navlist;
	}

	/* 后台管理批量添加分类 */

	function add($lines, $pid = 0, $displayorder = 0, $questions = 0) {
		global $category;
		$grade = (0 == $pid) ? 1 : $category [$pid] ['grade'] + 1;
		$sql = "INSERT INTO `" . $this->db->dbprefix . "category`(`name` ,`dir` , `pid` , `grade` , `displayorder`,`questions`) VALUES ";
		foreach ( $lines as $line ) {
			$line = str_replace ( array ("\r\n", "\n", "\r" ), '', $line );
			if (empty ( $line ))
				continue;
			$name = trim ( $line );
			$categorydir = '';
			$sql .= "('$name','$categorydir', $pid,$grade,$displayorder,$questions),";
			$displayorder ++;
		}
		$sql = substr ( $sql, 0, - 1 );
		return $this->db->query ( $sql );
	}

	/* 后台管理编辑分类 */

	function update_by_id($id, $name, $categorydir, $pid, $aliasname = '', $edit_miaosu = '', $s_tmplist = '') {
		global $category;
		$grade = (0 == $pid) ? 1 : $category [$pid] ['grade'] + 1;
		$aliasname = $aliasname == '' ? '' : ", `alias`='$aliasname'";
		$miaosu = $edit_miaosu == '' ? '' : ", `miaosu`='$edit_miaosu'";
		$template = $s_tmplist == '' ? '' : ", `template`='$s_tmplist'";
		$this->db->query ( "UPDATE `" . $this->db->dbprefix . "category` SET   `name`='$name', `dir`='$categorydir' $aliasname $miaosu $template WHERE `id`=$id" );
	}

	/* 后台管理删除分类 */

	function remove($cids) {
		$this->db->query ( "DELETE FROM `" . $this->db->dbprefix . "answer` WHERE `qid` IN  (SELECT id FROM `" . $this->db->dbprefix . "question` WHERE `cid` IN ($cids))" );
		$this->db->query ( "DELETE FROM `" . $this->db->dbprefix . "category` WHERE `id` IN  ($cids)" );
		$this->db->query ( "DELETE FROM `" . $this->db->dbprefix . "category` WHERE `pid` IN  ($cids)" );
		$this->db->query ( "DELETE FROM `" . $this->db->dbprefix . "question` WHERE `cid` IN ($cids)" );
	}

	/* 后台管理移动分类顺序 */

	function order_category($id, $order) {
		$this->db->query ( "UPDATE `" . $this->db->dbprefix . "category` SET 	`displayorder` = '{$order}' WHERE `id` = '{$id}'" );
	}

	/* 是否关注分类 */

	function is_followed($cid, $uid) {

		$m = $this->db->query ( "SELECT count(*) as num FROM " . $this->db->dbprefix . "categotry_follower WHERE uid=$uid AND cid=$cid" )->row_array ();
		return $m ['num'];
	}

	/* 关注 */

	function follow($sourceid, $followerid) {
		$sourceid = intval ( $sourceid );
		$followerid = intval ( $followerid );
		$time = time ();
		$this->db->query ( "INSERT INTO " . $this->db->dbprefix . "categotry_follower(cid,uid,time) VALUES ($sourceid,$followerid,{$time})" );
		$this->db->query ( "UPDATE " . $this->db->dbprefix . "category SET followers=followers+1 WHERE `id`=$sourceid" );
	}

	/* 取消关注 */

	function unfollow($sourceid, $followerid) {
		$sourceid = intval ( $sourceid );
		$followerid = intval ( $followerid );
		$this->db->query ( "DELETE FROM " . $this->db->dbprefix . "categotry_follower WHERE cid=$sourceid AND uid=$followerid" );
		$this->db->query ( "UPDATE " . $this->db->dbprefix . "category SET followers=followers-1 WHERE `id`=$sourceid" );
	}
}

?>
