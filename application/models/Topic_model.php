<?php

class Topic_model extends CI_Model {

	var $index;
	var $search;
	function __construct() {
		parent::__construct ();
		$this->load->database ();
		if ($this->base->setting ['xunsearch_open']) {
			require_once $this->base->setting ['xunsearch_sdk_file'];
			$xs = new XS ( 'topic' );
			$this->search = $xs->search;
			$this->index = $xs->index;
		}
	}

	/* 获取某个文章信息 */

	function get($id) {
		$topic = $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "topic WHERE id='$id'" )->row_array ();

		if ($topic) {
			$topic ['author_has_vertify'] = get_vertify_info ( $topic ['authorid'] ); //用户是否认证
			$topic ['viewtime'] = tdate ( $topic ['viewtime'] );
			$topic ['title'] = checkwordsglobal ( $topic ['title'] );
			$topic ['artlen'] = strlen ( strip_tags ( $topic ['describtion'] ) );
			$topic ['describtion'] = checkwordsglobal ( $topic ['describtion'] );

		}
		return $topic;
	}
	/* 获取某个文章信息 */

	function getcomment($id) {
		$commenttopic = $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "articlecomment WHERE id='$id'" )->row_array ();

		return $commenttopic;
	}
	//删除文章评论
	function remove_by_tid($id, $tid) {
		$this->db->query ( "DELETE FROM `" . $this->db->dbprefix . "articlecomment` WHERE `id`=$id" );
		$this->db->query ( "DELETE FROM `" . $this->db->dbprefix . "article_comment` WHERE `aid`=$id" );
		$this->db->query ( "UPDATE `" . $this->db->dbprefix . "topic` SET articles=articles-1 WHERE `id`=$tid" );
	}
	//查看已经付费阅读的人
	function getreaduser($uid, $tid) {

		$topic = $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "topic_viewhistory WHERE uid=$uid and tid=$tid " )->row_array ();
		return $topic;
	}
	//获取点赞人数
	function get_support_by_sid_aid($sid, $aid) {
		$query = $this->db->query ( "select count(*) as num from " . $this->db->dbprefix . "article_support where sid='$sid' AND aid=$aid " );
		$m = $query->row_array ();
		return $m ['num'];
	}
	function add_support($sid, $aid, $authorid) {
		$this->db->query ( "REPLACE INTO " . $this->db->dbprefix . "article_support(sid,aid,time) VALUES ('$sid',$aid,{$this->base->time})" );
		$this->db->query ( "UPDATE `" . $this->db->dbprefix . "articlecomment` SET `supports`=supports+1 WHERE `id`=$aid" );
		$this->db->query ( "UPDATE `" . $this->db->dbprefix . "user` SET `supports`=supports+1 WHERE `uid`=$authorid" );
	}
	function get_byname($title) {
		$topic = $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "topic WHERE title='$title'" )->row_array ();

		if ($topic) {

			$topic ['viewtime'] = tdate ( $topic ['viewtime'] );
			$topic ['title'] = checkwordsglobal ( $topic ['title'] );
			$topic ['describtion'] = checkwordsglobal ( $topic ['describtion'] );
			$topic ['author_has_vertify'] = get_vertify_info ( $topic ['authorid'] ); //用户是否认证
		}
		return $topic;
	}
	function get_bylikename($word, $start = 0, $limit = 6) {
		$topiclist = array ();
		if ($this->base->setting ['xunsearch_open']) {

			$result = $this->search->setQuery ( $word )->setLimit ( $limit, $start )->search ();
			foreach ( $result as $doc ) {
				$topic = array ();
				$topic ['id'] = $doc->id;
				$question ['cid'] = $doc->articleclassid;
				$question ['category_name'] = $this->base->category [$question ['articleclassid']] ['name'];
				$topic ['author_has_vertify'] = get_vertify_info ( $topic ['authorid'] ); //用户是否认证
				$topic ['author'] = $doc->author;
				$topic ['authorid'] = $doc->authorid;
				$topic ['image'] = $topic->image;

				$topic ['title'] = $this->search->highlight ( $doc->title );
				$topic ['describtion'] = $this->search->highlight ( $doc->describtion );
				$topic ['category_name'] = $this->base->category [$topic ['articleclassid']] ['name'];
				$topic ['describtion'] = highlight ( cutstr ( checkwordsglobal ( strip_tags ( $topic ['describtion'] ) ), 240, '...' ), $word );
				$topic ['format_time'] = tdate ( $topic ['viewtime'] );
				$topic ['avatar'] = get_avatar_dir ( $topic ['authorid'] );
				$topic ['views'] = $doc->views;
				$topic ['articles'] = $doc->articles;
				$topic ['likes'] = $doc->likes;
				$topic ['viewtime'] = tdate ( $doc->viewtime );
				$topiclist [] = $topic;
			}
			if (count ( $topiclist ) == 0) {
				$topiclist = $this->get_by_likename ( $word, $start, $limit );
			}

		} else {
			$query = $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "topic WHERE title like '%$word%' or describtion like '%$word%' order by id desc LIMIT $start,$limit" );

			foreach ( $query->result_array () as $topic ) {
				$topic ['title'] = checkwordsglobal ( $topic ['title'] );
				$topic ['describtion'] = checkwordsglobal ( $topic ['describtion'] );
				$topic ['title'] = highlight ( $topic ['title'], $word );
				$topic ['author_has_vertify'] = get_vertify_info ( $topic ['authorid'] ); //用户是否认证
				if (isset ( $this->base->category [$topic ['articleclassid']] )) {
					$topic ['category_name'] = $this->base->category [$topic ['articleclassid']] ['name'];
				} else {
					$topic ['category_name'] = '';
				}

				$topic ['describtion'] = highlight ( cutstr ( checkwordsglobal ( strip_tags ( $topic ['describtion'] ) ), 240, '...' ), $word );
				$topic ['format_time'] = tdate ( $topic ['viewtime'] );
				$topic ['avatar'] = get_avatar_dir ( $topic ['authorid'] );
				$topic ['viewtime'] = tdate ( $topic ['viewtime'] );
				$topiclist [] = $topic;
			}
		}

		return $topiclist;
	}
	function get_by_likename($word, $start = 0, $limit = 6) {
		$topiclist = array ();

		$query = $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "topic WHERE title like '%$word%' or describtion like '%$word%' order by id desc LIMIT $start,$limit" );

		foreach ( $query->result_array () as $topic ) {
			$topic ['title'] = checkwordsglobal ( $topic ['title'] );
			$topic ['describtion'] = checkwordsglobal ( $topic ['describtion'] );
			$topic ['title'] = highlight ( $topic ['title'], $word );
			$topic ['author_has_vertify'] = get_vertify_info ( $topic ['authorid'] ); //用户是否认证
			$topic ['category_name'] = $this->base->category [$topic ['articleclassid']] ['name'];
			$topic ['describtion'] = highlight ( cutstr ( checkwordsglobal ( strip_tags ( $topic ['describtion'] ) ), 240, '...' ), $word );
			$topic ['format_time'] = tdate ( $topic ['viewtime'] );
			$topic ['avatar'] = get_avatar_dir ( $topic ['authorid'] );
			$topic ['viewtime'] = tdate ( $topic ['viewtime'] );

			$topiclist [] = $topic;
		}

		return $topiclist;
	}
	function rownum_by_user_article() {
		$sql = "SELECT COUNT(wz.authorid) as num FROM `" . $this->db->dbprefix . "user` as u ," . $this->db->dbprefix . "topic as wz where u.uid=wz.authorid group by u.uid ORDER BY num DESC ";
		$m = $this->db->query ( $sql )->row_array ();
		return $m ['num'];
	}

	/* 后台文章数目 */

	function rownum_by_search($title = '', $author = '', $cid = 0) {

		if ($this->base->setting ['xunsearch_open']) {
			$rownum = $this->search->getLastCount ();

			return $rownum;
		} else {

			$condition = " 1=1 ";
			$title && ($condition .= " AND `title` like '$title%' ");
			$author && ($condition .= " AND `author`='$author'");

			if ($cid) {
				$category = $this->base->category [$cid];
				$condition .= " AND `articleclassid" . "`= $cid ";
			}
			$query = $this->db->query ( "select count(*) as num from " . $this->db->dbprefix . "topic where $condition " );
			$m = $query->row_array ();
			return $m ['num'];

		}
	}
	function get_user_articles($start = 0, $limit = 8) {
		$sql = "SELECT COUNT(wz.authorid) as num, u.uid,u.username,u.signature,u.followers,u.answers FROM `" . $this->db->dbprefix . "user` as u ," . $this->db->dbprefix . "topic as wz where u.uid=wz.authorid group by u.uid ORDER BY num DESC LIMIT $start,$limit";
		$modellist = array ();
		$query = $this->db->query ( $sql );
		foreach ( $query->result_array () as $model ) {
			$model ['author_has_vertify'] = get_vertify_info ( $model ['uid'] ); //用户是否认证
			$model ['avatar'] = get_avatar_dir ( $model ['uid'] );
			$is_followed = $this->is_followed ( $model ['uid'], $this->base->user ['uid'] );
			$model ['hasfollower'] = $is_followed == 0 ? "0" : "1";
			$modellist [] = $model;
		}
		return $modellist;

	}
	/* 是否关注问题 */

	function is_followed($uid, $followerid) {
		$m = $this->db->query ( "SELECT COUNT(*) as num FROM " . $this->db->dbprefix . "user_attention WHERE uid=$uid AND followerid=$followerid" )->row_array ();
		return $m ['num'];
	}
	function get_article_by_uid($uid) {
		$sql = "SELECT COUNT(t.id) as num ,c.name ,c.id ,t.authorid,u.username FROM `" . $this->db->dbprefix . "topic` as t ," . $this->db->dbprefix . "category as c," . $this->db->dbprefix . "user as u where c.id=t.articleclassid and t.authorid=$uid and t.authorid=u.uid GROUP BY t.articleclassid HAVING COUNT(t.id)>0 ORDER BY num DESC LIMIT 0,15";
		$modellist = array ();
		$query = $this->db->query ( $sql );
		foreach ( $query->result_array () as $model ) {

			$model ['author_has_vertify'] = get_vertify_info ( $model ['authorid'] ); //用户是否认证


			$modellist [] = $model;
		}
		return $modellist;
	}
	function get_bycatid($catid, $start = 0, $limit = 6, $questionsize = 10) {
		$topiclist = array ();
		$query = $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "topic where articleclassid in($catid) order by id desc LIMIT $start,$limit" );
		foreach ( $query->result_array () as $topic ) {

			$topic ['title'] = checkwordsglobal ( $topic ['title'] );
			$topic ['avatar'] = get_avatar_dir ( $topic ['authorid'] );
			$topic ['describtion'] = cutstr ( str_replace ( '&nbsp;', '', checkwordsglobal ( strip_tags ( $topic ['describtion'] ) ) ), 240, '...' );
			$topic ['author_has_vertify'] = get_vertify_info ( $topic ['authorid'] ); //用户是否认证
			$topic ['description'] = cutstr ( checkwordsglobal ( strip_tags ( $topic ['describtion'] ) ), 240, '...' );
			$topic ['answers'] = $topic ['articles'];
			$topic ['format_time'] = tdate ( $topic ['viewtime'] );
			$topic ['viewtime'] = tdate ( $topic ['viewtime'] );
			$topic ['attentions'] = $topic ['likes'];
			$topiclist [] = $topic;
		}
		return $topiclist;
	}
	function get_list($showquestion = 0, $start = 0, $limit = 6, $questionsize = 10) {
		$topiclist = array ();
		$query = $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "topic order by id desc LIMIT $start,$limit" );
		foreach ( $query->result_array () as $topic ) {
			if ($topic ['articleclassid'] > 0) {
				($showquestion == 1) && $topic ['questionlist'] = $this->get_questions ( $topic ['id'], 0, $questionsize ); //首页专题掉用
				($showquestion == 2) && $topic ['questionlist'] = $this->get_questions ( $topic ['id'] ); //专题列表页掉用
				$topic ['sortime'] = $topic ['viewtime']; //用于排序
				$topic ['format_time'] = tdate ( $topic ['viewtime'] );
				$topic ['viewtime'] = tdate ( $topic ['viewtime'] );
				$topic ['author_has_vertify'] = get_vertify_info ( $topic ['authorid'] ); //用户是否认证
				$topic ['title'] = checkwordsglobal ( $topic ['title'] );
				if (isset ( $this->base->category [$topic ['articleclassid']] )) {
					$topic ['category_name'] = $this->base->category [$topic ['articleclassid']] ['name'];
				}
				$topic ['describtion'] = cutstr ( str_replace ( '&nbsp;', '', checkwordsglobal ( strip_tags ( $topic ['describtion'] ) ) ), 240, '...' );
				$topic ['description'] = cutstr ( checkwordsglobal ( strip_tags ( $topic ['describtion'] ) ), 240, '...' );
				$topic ['answers'] = $topic ['articles'];
				$topic ['attentions'] = $topic ['likes'];
				$topic ['avatar'] = get_avatar_dir ( $topic ['authorid'] );
				$topiclist [] = $topic;
			}
		}
		return $topiclist;
	}
	function get_hotlist($showquestion = 0, $start = 0, $limit = 6, $questionsize = 10) {
		$topiclist = array ();
		$query = $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "topic where ispc=1 order by id desc LIMIT $start,$limit" );
		foreach ( $query->result_array () as $topic ) {
			($showquestion == 1) && $topic ['questionlist'] = $this->get_questions ( $topic ['id'], 0, $questionsize ); //首页专题掉用
			($showquestion == 2) && $topic ['questionlist'] = $this->get_questions ( $topic ['id'] ); //专题列表页掉用
			$topic ['sortime'] = $topic ['viewtime']; //用于排序
			$topic ['format_time'] = tdate ( $topic ['viewtime'] );
			$topic ['author_has_vertify'] = get_vertify_info ( $topic ['authorid'] ); //用户是否认证
			$topic ['viewtime'] = tdate ( $topic ['viewtime'] );
			$topic ['title'] = checkwordsglobal ( $topic ['title'] );
			if (isset ( $this->base->category [$topic ['articleclassid']] )) {
				$topic ['category_name'] = $this->base->category [$topic ['articleclassid']] ['name'];
			}

			$topic ['describtion'] = cutstr ( str_replace ( '&nbsp;', '', checkwordsglobal ( strip_tags ( $topic ['describtion'] ) ) ), 240, '...' );

			$topic ['avatar'] = get_avatar_dir ( $topic ['authorid'] );
			$topiclist [] = $topic;
		}
		return $topiclist;
	}
	function rownum_by_tag($name) {
		$query = $this->db->query ( "SELECT * FROM `" . $this->db->dbprefix . "topic` AS q," . $this->db->dbprefix . "topic_tag AS t WHERE q.id=t.aid AND t.name='$name' ORDER BY q.views DESC" );
		return $this->db->num_rows ( $query );
	}
	function rownum_by_title($word) {
		if ($this->base->setting ['xunsearch_open']) {
			$rownum = $this->search->getLastCount ();
		} else {

			$query = $this->db->query ( "select count(*) as num from " . $this->db->dbprefix . "topic where title like '%$word%' or describtion like '%$word%'  " );
			$m = $query->row_array ();
			$rownum = $m ['num'];

		}
		return $rownum;
	}
	function list_by_tag($name, $start = 0, $limit = 20) {
		$toipiclist = array ();

		$query = $this->db->query ( "SELECT * FROM `" . $this->db->dbprefix . "topic` AS q," . $this->db->dbprefix . "topic_tag AS t WHERE q.id=t.aid AND t.name='$name'  ORDER BY q.views  DESC LIMIT $start,$limit" );
		foreach ( $query->result_array () as $topic ) {
			$topic ['category_name'] = $this->base->category [$topic ['articleclassid']] ['name'];
			$topic ['format_time'] = tdate ( $topic ['viewtime'] );
			$topic ['author_has_vertify'] = get_vertify_info ( $topic ['authorid'] ); //用户是否认证
			$topic ['description'] = checkwordsglobal ( strip_tags ( $topic ['describtion'] ) );
			$topic ['title'] = highlight ( checkwordsglobal ( $topic ['title'] ), $name );
			$topic ['describtion'] = highlight ( $topic ['describtion'], $name );
			$toipiclist [] = $topic;
		}
		return $toipiclist;
	}
	function get_list_byuid($uid, $start = 0, $limit = 6, $questionsize = 10) {
		$topiclist = array ();
		$query = $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "topic where authorid=$uid order by id desc LIMIT $start,$limit" );
		foreach ( $query->result_array () as $topic ) {
			//$topic['describtion']= cutstr(strip_tags(str_replace('&nbsp;','',$topic['describtion'])),110,'...');
			$topic ['questionlist'] = $this->get_questions ( $topic ['id'] ); //专题列表页掉用
			$topic ['format_time'] = tdate ( $topic ['viewtime'] );
			$topic ['viewtime'] = tdate ( $topic ['viewtime'] );
			$topic ['author_has_vertify'] = get_vertify_info ( $topic ['authorid'] ); //用户是否认证
			//$topic['image']=getfirstimg($topic['description']);
			$topic ['avatar'] = get_avatar_dir ( $topic ['authorid'] );
			$topic ['describtion'] = cutstr ( checkwordsglobal ( strip_tags ( $topic ['describtion'] ) ), 240, '...' );
			$topiclist [] = $topic;
		}
		return $topiclist;
	}
	/* 后台文章搜索 */

	function list_by_search($title = '', $author = '', $cid = 0, $start = 0, $limit = 10) {
		$sql = "SELECT * FROM `" . $this->db->dbprefix . "topic` WHERE 1=1 ";
		$title && ($sql .= " AND `title` like '%$title%' ");
		$author && ($sql .= " AND `author`='$author'");

		if ($cid) {
			$category = $this->base->category [$cid];
			$sql .= " AND `articleclassid" . "`= $cid ";
		}

		$sql .= " ORDER BY `viewtime` DESC LIMIT $start,$limit";
		$topiclist = array ();

		if ($this->base->setting ['xunsearch_open']) {

			$result = $this->search->setQuery ( $title )->setLimit ( $limit, $start )->search ();
			foreach ( $result as $doc ) {
				$topic = array ();
				$topic ['id'] = $doc->id;
				$question ['cid'] = $doc->articleclassid;
				$question ['category_name'] = $this->base->category [$question ['articleclassid']] ['name'];

				$topic ['author'] = $doc->author;
				$topic ['authorid'] = $doc->authorid;
				$topic ['image'] = $topic->image;
				$topic ['author_has_vertify'] = get_vertify_info ( $topic ['authorid'] ); //用户是否认证
				$topic ['title'] = $this->search->highlight ( $doc->title );
				$topic ['describtion'] = $this->search->highlight ( $doc->describtion );
				$topic ['views'] = $doc->views;
				$topic ['articles'] = $doc->articles;
				$topic ['likes'] = $doc->likes;
				$topic ['viewtime'] = tdate ( $doc->viewtime );
				$topiclist [] = $topic;
			}
			if (count ( $topiclist ) == 0) {

				$topiclist = $this->list_by_search2 ( $title, $author, $cid, $start, $limit );
			}

		} else {
			$query = $this->db->query ( $sql );
			foreach ( $query->result_array () as $topic ) {
				$topic ['describtion'] = cutstr ( strip_tags ( str_replace ( '&nbsp;', '', $topic ['describtion'] ) ), 110, '...' );
				$topic ['questionlist'] = $this->get_questions ( $topic ['id'] ); //专题列表页掉用
				$topic ['viewtime'] = tdate ( $topic ['viewtime'] );
				$topic ['author_has_vertify'] = get_vertify_info ( $topic ['authorid'] ); //用户是否认证
				$topiclist [] = $topic;
			}
		}

		return $topiclist;
	}
	function list_by_search2($title = '', $author = '', $cid = 0, $start = 0, $limit = 10) {
		$sql = "SELECT * FROM `" . $this->db->dbprefix . "topic` WHERE 1=1 ";
		$title && ($sql .= " AND `title` like '%$title%' ");
		$author && ($sql .= " AND `author`='$author'");

		if ($cid) {
			$category = $this->base->category [$cid];
			$sql .= " AND `articleclassid" . "`= $cid ";
		}

		$sql .= " ORDER BY `viewtime` DESC LIMIT $start,$limit";
		$topiclist = array ();

		$query = $this->db->query ( $sql );
		foreach ( $query->result_array () as $topic ) {
			$topic ['describtion'] = cutstr ( strip_tags ( str_replace ( '&nbsp;', '', $topic ['describtion'] ) ), 110, '...' );
			$topic ['questionlist'] = $this->get_questions ( $topic ['id'] ); //专题列表页掉用
			$topic ['viewtime'] = tdate ( $topic ['viewtime'] );
			$topic ['author_has_vertify'] = get_vertify_info ( $topic ['authorid'] ); //用户是否认证
			$topiclist [] = $topic;
		}

		return $topiclist;
	}
	function get_list_bycidanduid($cid, $uid, $start = 0, $limit = 6) {
		$topiclist = array ();
		$query = $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "topic where authorid=$uid and articleclassid=$cid order by viewtime  desc LIMIT $start,$limit" );
		foreach ( $query->result_array () as $topic ) {

			$topic ['describtion'] = cutstr ( strip_tags ( str_replace ( '&nbsp;', '', $topic ['describtion'] ) ), 110, '...' );
			$topic ['viewtime'] = tdate ( $topic ['viewtime'] );
			$topic ['author_has_vertify'] = get_vertify_info ( $topic ['authorid'] ); //用户是否认证
			$topiclist [] = $topic;
		}
		return $topiclist;
	}

	function get_questions($id, $start = 0, $limit = 5) {
		$questionlist = array ();
		$query = $this->db->query ( "SELECT q.title,q.id FROM " . $this->db->dbprefix . "tid_qid as t," . $this->db->dbprefix . "question as q WHERE t.qid=q.id AND t.tid=$id LIMIT $start,$limit" );
		foreach ( $query->result_array () as $question ) {
			$question ['title'] = checkwordsglobal ( $question ['title'] );

			$questionlist [] = $question;
		}
		return $questionlist;
	}
	function get_list_bywhere($showquestion, $questionsize) {
		$topiclist = array ();
		$query = $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "topic where isphone='1' order by displayorder asc " );
		foreach ( $query->result_array () as $topic ) {
			($showquestion == 1) && $topic ['questionlist'] = $this->get_questions ( $topic ['id'], 0, $questionsize ); //首页专题掉用
			($showquestion == 2) && $topic ['questionlist'] = $this->get_questions ( $topic ['id'] ); //专题列表页掉用
			$topic ['viewtime'] = tdate ( $topic ['viewtime'] );
			$topic ['title'] = checkwordsglobal ( $topic ['title'] );
			$topic ['author_has_vertify'] = get_vertify_info ( $topic ['authorid'] ); //用户是否认证
			$topic ['describtion'] = checkwordsglobal ( $topic ['describtion'] );
			$topiclist [] = $topic;

		}
		return $topiclist;
	}
	function get_select() {
		$query = $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "topic   LIMIT 0,50" );
		$select = '<select name="topiclist">';
		foreach ( $query->result_array () as $topic ) {
			$select .= '<option value="' . $topic ['id'] . '">' . $topic ['title'] . '</option>';
		}
		$select .= '</select>';
		return $select;
	}

	/* 后台管理编辑专题 */

	function update($id, $title, $desrc, $filepath = '') {
		if ($filepath)
			$this->db->query ( "UPDATE `" . $this->db->dbprefix . "topic` SET  `title`='$title' ,`describtion`='$desrc' , `image`='$filepath'  WHERE `id`=$id" );
		else
			$this->db->query ( "UPDATE `" . $this->db->dbprefix . "topic` SET  `title`='$title' ,`describtion`='$desrc'  WHERE `id`=$id" );
		if ($this->base->setting ['xunsearch_open']) {
			$topic = array ();
			$topic ['id'] = $id;

			$topic ['image'] = $filepath;
			$topic ['title'] = $title;
			$topic ['describtion'] = $desrc;
			$doc = new XSDocument ();
			$doc->setFields ( $topic );
			$this->index->update ( $doc );
		}

	}

	function updatetopic($id, $title, $desrc, $filepath = '', $isphone = '', $views = '', $cid, $ispc = 0, $price) {
		if ($filepath) {
			$data = array ('title' => $title, 'price' => $price, 'describtion' => $desrc, 'image' => $filepath, 'isphone' => $isphone, 'ispc' => $ispc, 'views' => $views, 'articleclassid' => $cid );
			$this->db->where ( array ('id' => $id ) )->update ( 'topic', $data );

		} else {
			$data = array ('title' => $title, 'price' => $price, 'describtion' => $desrc, 'isphone' => $isphone, 'ispc' => $ispc, 'views' => $views, 'articleclassid' => $cid );
			$this->db->where ( array ('id' => $id ) )->update ( 'topic', $data );
		}

		if ($this->base->setting ['xunsearch_open']) {
			$topic = array ();
			$topic ['id'] = $id;
			$topic ['views'] = $views;
			$topic ['articleclassid'] = $cid;

			if ($filepath) {
				$topic ['image'] = $filepath;
			}

			$topic ['title'] = $title;
			$topic ['describtion'] = $desrc;
			$doc = new XSDocument ();
			$doc->setFields ( $topic );
			$this->index->update ( $doc );
		}

	}
	function updatetopichot($id, $ispc = 0) {
		$this->db->query ( "UPDATE `" . $this->db->dbprefix . "topic` SET  `ispc`='$ispc' WHERE `id`=$id" );

	}
	function addtopicviewhistory($uid, $username, $tid) {
		$creattime = $this->base->time;
		$this->db->query ( "INSERT INTO `" . $this->db->dbprefix . "topic_viewhistory`(`uid`,`username`,`tid`,`time`) VALUES ('$uid','$username','$tid',$creattime)" );
		$id = $this->db->insert_id ();

		return $id;
	}
	/* 后台添加专题 */

	function add($title, $desc, $image, $isphone = '0', $views = '1', $cid = 1) {
		$creattime = $this->base->time;
		$author = $this->base->user ['username'];
		$authorid = $this->base->user ['uid'];
		$data = array ('title' => $title, 'describtion' => $desc, 'image' => $image, 'author' => $author, 'authorid' => $authorid, 'views' => $views, 'articleclassid' => $cid, 'viewtime' => $creattime, 'isphone' => $isphone );
		$this->db->insert ( 'topic', $data );
		$aid = $this->db->insert_id ();
		if ($this->base->setting ['xunsearch_open'] && $aid) {
			$topic = array ();
			$topic ['id'] = $aid;
			$topic ['views'] = $views;
			$topic ['articles'] = 0;
			$topic ['likes'] = 0;
			$topic ['articleclassid'] = $cid;
			$topic ['title'] = checkwordsglobal ( $title );
			$topic ['describtion'] = checkwordsglobal ( $desc );
			$topic ['author'] = $author;
			$topic ['authorid'] = $authorid;
			$topic ['viewtime'] = $creattime;

			$doc = new XSDocument ();
			$doc->setFields ( $topic );
			$this->index->add ( $doc );
		}
		return $aid;
	}
	function addtopic($title, $desc, $image, $author, $authorid, $views, $articleclassid, $price = 0) {
		$creattime = $this->base->time;
		$data = array ('title' => $title, 'describtion' => $desc, 'image' => $image, 'author' => $author, 'authorid' => $authorid, 'views' => $views, 'articleclassid' => $articleclassid, 'viewtime' => $creattime, 'price' => $price );
		$this->db->insert ( 'topic', $data );
		$aid = $this->db->insert_id ();
		if ($this->base->setting ['xunsearch_open'] && $aid) {
			$topic = array ();
			$topic ['id'] = $aid;
			$topic ['views'] = $views;
			$topic ['articles'] = 0;
			$topic ['likes'] = 0;
			$topic ['articleclassid'] = $articleclassid;
			$topic ['title'] = checkwordsglobal ( $title );
			$topic ['describtion'] = checkwordsglobal ( $desc );
			$topic ['author'] = $author;
			// $topic['price'] = $price;
			$topic ['authorid'] = $authorid;
			$topic ['viewtime'] = $creattime;

			$doc = new XSDocument ();
			$doc->setFields ( $topic );
			$this->index->add ( $doc );
		}
		return $aid;
	}
	function addtotopic($qids, $tid) {
		$qidlist = explode ( ",", $qids );
		$sql = "INSERT INTO " . $this->db->dbprefix . "tid_qid (`tid`,`qid`) VALUES ";
		foreach ( $qidlist as $qid ) {
			$sql .= " ($tid,$qid),";
		}
		$this->db->query ( substr ( $sql, 0, - 1 ) );
	}

	/* 后台管理删除分类 */

	function remove($tids) {
		$this->db->query ( "DELETE FROM `" . $this->db->dbprefix . "topic` WHERE `id` IN  ($tids)" );
		$this->db->query ( "DELETE FROM `" . $this->db->dbprefix . "tid_qid` WHERE `tid` IN ($tids)" );

		if ($this->base->setting ['xunsearch_open']) {
			$this->index->del ( explode ( ",", $tids ) );
		}
	}

	/* 后台管理移动分类顺序 */

	function order_topic($id, $order) {
		$this->db->query ( "UPDATE `" . $this->db->dbprefix . "topic` SET `displayorder` = '{$order}' WHERE `id` = '{$id}'" );
	}

	/*创建文章索引*/
	function makeindex() {
		if ($this->base->setting ['xunsearch_open']) {
			$this->index->clean ();
			$query = $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "topic " );
			foreach ( $query->result_array () as $topic ) {
				$data = array ();
				$data ['id'] = $topic ['id'];
				$data ['articleclassid'] = $topic ['articleclassid'];
				$data ['image'] = $topic ['image'];
				$data ['author'] = $topic ['author'];
				$data ['authorid'] = $topic ['authorid'];
				$data ['views'] = $topic ['views'];
				$data ['articles'] = $topic ['articles'];
				$data ['likes'] = $topic ['likes'];
				$data ['viewtime'] = $topic ['viewtime'];

				$data ['title'] = $topic ['title'];
				$data ['describtion'] = $topic ['describtion'];
				$doc = new XSDocument ();
				$doc->setFields ( $data );
				$this->index->add ( $doc );
			}
		}
	}

}

?>
