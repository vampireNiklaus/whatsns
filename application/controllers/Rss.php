<?php

defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class Rss extends CI_Controller {

	var $whitelist;
	var $statusarray = array ('all' => '全部', '0' => '待审核', '1' => '待解决', '2' => '已解决', '4' => '悬赏', '9' => '已关闭' );
	function __construct() {
		$this->whitelist = "articlelist,tag,userspace,clist";
		parent::__construct ();
		$this->load->model ( 'category_model' );
		$this->load->model ( 'question_model' );
		$this->load->model ( 'answer_model' );
		$this->load->model ( "tag_model" );
		$this->load->model ( "topic_model" );
	}

	/*
	分类下的RSS
	rss/category/1/1
    */
	function category() {

		$cid = null !== $this->uri->segment ( 3 ) ? intval ( $this->uri->segment ( 3 ) ) : 'all';
		$status = null !== $this->uri->segment ( 4 ) ? $this->uri->segment ( 4 ) : 'all';
		$category = $this->category_model->get ( $cid ); //得到分类信息
		$cfield = 'cid' . $category ['grade']; //查询条件
		$questionlist = $this->question_model->list_by_cfield_cvalue_status ( $cfield, $cid, $status, 0, 20 ); //问题列表数据
		$this->writerss ( $questionlist, '分类' . $category ['name'] . $this->statusarray [$status] . '问题' );
	}
	/*
	列表下的RSS
	rss/list/1
    */
	function clist() {
		$status = null !== $this->uri->segment ( 3 ) ? $this->uri->segment ( 3 ) : 'all';
		$questionlist = $this->question_model->list_by_cfield_cvalue_status ( '', 0, $status, 0, 40 ); //问题列表数据
		$this->writerss2 ( $questionlist, $this->statusarray [$status] . '问题' );
	}
	/*
	列表下的RSS
	rss/articlelist/1
    */
	function articlelist() {

		$topiclist = $this->topic_model->get_list ( 2, 0, 40 ); //文章列表数据
		$this->writerssarticle ( $topiclist, '最新文章资讯' );

	}
	//tag标签
	function tag() {

		$taglist = $this->tag_model->get_list ( 0, 100 );
		$this->writetag ( $taglist, '站内标签' );
	}
	//用户
	function userspace() {

		$userlist = $this->user_model->get_active_list ( 0, 40 );
		$this->wirteuser ( $userlist, '用户空间' );
	}

	/*
	查看一个未解决问题的RSS
	rss/question/1
    */
	function question() {
		$qid = $this->uri->segment ( 3 );
		$question = $this->question_model->get ( $qid );
		$question ['category_name'] = $this->category [$question ['cid']];
		$answerlistarray = $this->answer_model->list_by_qid ( $qid );
		$answerlist = $answerlistarray [0];
		$items = array ();
		foreach ( $answerlist as $answer ) {
			$item ['id'] = $answer ['qid'];
			$item ['title'] = $question ['title'];
			$item ['description'] = $answer ['content'];
			$item ['category_name'] = $question ['category_name'];
			$item ['author'] = $answer ['author'];
			$item ['time'] = $answer ['time'];
			$items [] = $item;
		}
		$this->writerss ( $items, $question ['title'] . '所有回答' );
	}

	function writerss($items, $title) {

		header ( "Content-type: application/xml" );
		$suffix = '?';
		if ($this->setting ['seo_on']) {
			$suffix = '';
		}
		$fix = $this->setting ['seo_suffix'];
		echo "<?xml version=\"1.0\" encoding=\"" . 'UTF-8' . "\"?>\n" . "<rss version=\"2.0\">\n" . "  <channel>\n" . "    <title>" . $this->setting ['site_name'] . "</title>\n" . "    <link>" . SITE_URL . "</link>\n" . "    <description>" . $title . "</description>\n" . "    <copyright>Copyright(C) " . $this->setting ['site_name'] . "</copyright>\n" .

		"    <lastBuildDate>" . gmdate ( 'r', time() ) . "</lastBuildDate>\n" . "    <ttl>" . $this->setting ['rss_ttl'] . "</ttl>\n" . "    <image>\n" . "      <url>" . SITE_URL . "/css/default/logo.png</url>\n" . "      <title>" . $this->setting ['site_name'] . "</title>\n" . "      <link>" . SITE_URL . "</link>\n" . "    </image>\n";

		foreach ( $items as $item ) {
			if (! isset ( $item ['describtion'] )) {
				$item ['describtion'] = '';
			}
			$item ['description'] = strip_tags ( str_replace ( '&nbsp;', '', $item ['describtion'] ) );
			$item ['title'] = strip_tags ( str_replace ( '。', ',', $item ['title'] ) );
			echo "    <item>\n" . "      <title>" . htmlspecialchars ( $item ['title'] ) . "</title>\n" . "      <link>" . SITE_URL . $suffix . "q-$item[id]$fix</link>\n" . "      <description><![CDATA[$item[description]]]></description>\n" . "      <category>" . htmlspecialchars ( $item ['category_name'] ) . "</category>\n" . "      <author>" . htmlspecialchars ( $item ['author'] ) . "</author>\n" . "      <pubDate>" .date("Y-m-d H:i",$item ['time']) . "</pubDate>\n" . "    </item>\n";
		}

		echo "  </channel>\n" . "</rss>";
	}
	function utf8_for_xml($string) {
		return preg_replace ( '/[^\x{0009}\x{000a}\x{000d}\x{0020}-\x{D7FF}\x{E000}-\x{FFFD}]+/u', ' ', $string );
	}
	function wirteuser($items, $title) {
		header ( "Content-type: application/xml" );
		$suffix = '?';
		if ($this->setting ['seo_on']) {
			$suffix = '';
		}
		$fix = $this->setting ['seo_suffix'];

		echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n" . "<urlset>\n";
		foreach ( $items as $item ) {
			$viewurl = urlmap ( 'user/space/' . $item ['uid'], 2 );
			$item ['title'] = $this->utf8_for_xml ( $item ['username'] ) . "的个人空间";
			// $item['viewtime']=tdate($item['viewtime']);
			$mpurl = SITE_URL . $this->setting ['seo_prefix'] . $viewurl . $this->setting ['seo_suffix'];
			echo " <url>" . "  <loc><![CDATA[" . $mpurl . "]]></loc>\n" .

			" <changefreq>always</changefreq>\n" .

			"  <data>\n" . "  <display>\n";

			echo "<name>" . htmlspecialchars ( $item ['title'] ) . "</name>\n" .

			" <url><![CDATA[" . $mpurl . "]]></url>\n";

			echo " </display>\n" . " </data>\n" . " </url>\n";
		}
		echo "</urlset>\n";
	}
	function writetag($items, $title) {
		header ( "Content-type: application/xml" );
		$suffix = '?';
		if ($this->setting ['seo_on']) {
			$suffix = '';
		}
		$fix = $this->setting ['seo_suffix'];

		echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n" . "<urlset>\n";
		foreach ( $items as $item ) {

			$viewurl = urlmap ( 'tag-' . $item ['name'], 2 );
			if ($item ['pinyin'] != '') {
				$viewurl = urlmap ( 'tag-' . $item ['pinyin'], 2 );
			}
			$item ['title'] = strip_tags ( str_replace ( '。', ',', $item ['name'] ) );
			$item ['title'] = "关于" . $this->utf8_for_xml ( $item ['name'] ) . "的话题";
			// $item['viewtime']=tdate($item['viewtime']);
			$mpurl = SITE_URL . $this->setting ['seo_prefix'] . $viewurl . $this->setting ['seo_suffix'];
			echo " <url>" . "  <loc><![CDATA[" . $mpurl . "]]></loc>\n" . "  <lastmod>" . $item ['time'] . "</lastmod>\n" . " <changefreq>always</changefreq>\n" .

			"  <data>\n" . "  <display>\n";

			echo "<name>" . htmlspecialchars ( $item ['title'] ) . "</name>\n" .

			" <url><![CDATA[" . $mpurl . "]]></url>\n";

			echo " </display>\n" . " </data>\n" . " </url>\n";
		}
		echo "</urlset>\n";

	}

	function writerss2($items, $title) {
		header ( "Content-type: application/xml" );
		$suffix = '?';
		if ($this->setting ['seo_on']) {
			$suffix = '';
		}
		$fix = $this->setting ['seo_suffix'];

		echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n" . "<urlset>\n";

		foreach ( $items as $item ) {
			if (! isset ( $item ['describtion'] )) {
				$item ['describtion'] = '';
			}
			$item ['description'] = strip_tags ( str_replace ( '&nbsp;', '', isset ( $item ['describtion'] ) ? $item ['describtion'] : '' ) );
			$item ['title'] = strip_tags ( str_replace ( '。', ',', $item ['title'] ) );

			$item ['title'] = $this->utf8_for_xml ( isset ( $item ['title'] ) ? $item ['title'] : '' );
			$item ['author'] = str_replace ( '&nbsp;', '', $item ['author'] );
			$viewurl = urlmap ( 'question/view/' . $item ['id'], 2 );
			$mpurl = SITE_URL . $this->setting ['seo_prefix'] . $viewurl . $this->setting ['seo_suffix'];
			echo " <url>" . "  <loc><![CDATA[" . $mpurl . "]]></loc>\n" . "  <lastmod>" . @gmdate ( 'Y-n-j H:i', $item ['time'] ) . "</lastmod>\n" . " <changefreq>always</changefreq>\n" . "  <priority>1.0</priority>\n" . "  <data>\n" . "  <display>\n";
			$navlist = $this->category_model->get_navigation ( $item ['cid'], true );
			echo "<breadcrumb>\n";
			foreach ( $navlist as $nav ) {
				echo $nav ['name'] . "-";
			}
			echo "</breadcrumb>\n";
			echo "<name>" . htmlspecialchars ( $item ['title'] ) . "</name>\n" . " <url><![CDATA[" . $mpurl . "]]></url>\n" . "<genre>站内问答</genre>\n" . " <provider>\n" . " <name>" . $item ['author'] . "</name>\n" . " <url>" . SITE_URL . $suffix . "u-$item[authorid]$fix</url>\n" . " </provider>\n" . "<collectCount>$item[attentions]</collectCount>\n" . "<likeCount>$item[goods]</likeCount>\n" . "<commentCount>$item[answers]</commentCount>\n";
			$taglist = $this->tag_model->get_by_qid ( $item ['id'] );
			echo "<keywords>\n";
			foreach ( $taglist as $tag ) {
				echo $tag . ",";

			}
			echo "</keywords>\n";

			echo " <downloadUrl>" . $mpurl . "</downloadUrl>\n" . "<aggregateRating>\n" . "<ratingValue>3</ratingValue>\n" . "<bestRating>5</bestRating>\n" . "<ratingCount>50</ratingCount>\n" . " </aggregateRating>\n";
			$answerlistarray = $this->answer_model->list_by_qid ( $item ['id'] );
			$answerlist = $answerlistarray [0];
			$items = array ();
			foreach ( $answerlist as $answer ) {
				$answer ['content'] = strip_tags ( str_replace ( '&nbsp;', '', $answer ['content'] ) );
				$answer ['content'] = $this->utf8_for_xml ( $answer ['content'] );
				$answer ['author'] = str_replace ( '&nbsp;', '', $answer ['author'] );
				echo "<comment>\n" .

				//	"<commentText><![CDATA[$answer[content]]]></commentText>\n".
				"<commentText><![CDATA[" . $answer ['content'] . "]]></commentText>\n" . " <creator>" . $answer ['author'] . "</creator>\n" . "<commentTime>" . $answer ['time'] . "</commentTime>\n" . " </comment>\n";
			}
			echo " </display>\n" . " </data>\n" . " </url>\n";
		}
		echo "</urlset>\n";

	}

	function writerssarticle($items, $title) {
		header ( "Content-type: application/xml" );
		$suffix = '?';
		if ($this->setting ['seo_on']) {
			$suffix = '';
		}
		$fix = $this->setting ['seo_suffix'];

		echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n" . "<urlset>\n";
		foreach ( $items as $item ) {

			$viewurl = urlmap ( 'topic/getone/' . $item ['id'], 2 );
			$item ['describtion'] = strip_tags ( str_replace ( '&nbsp;', '', $item ['describtion'] ) );
			$item ['title'] = strip_tags ( str_replace ( '。', ',', $item ['title'] ) );
			$item ['title'] = $this->utf8_for_xml ( $item ['title'] );
			$item ['author'] = str_replace ( '&nbsp;', '', $item ['author'] );
			// $item['viewtime']=tdate($item['viewtime']);
			$mpurl = SITE_URL . $this->setting ['seo_prefix'] . $viewurl . $this->setting ['seo_suffix'];
			echo " <url>" . "  <loc><![CDATA[" . $mpurl . "]]></loc>\n" . "  <lastmod>" . $item ['viewtime'] . "</lastmod>\n" . " <changefreq>always</changefreq>\n" . "  <priority>1.0</priority>\n" . "  <data>\n" . "  <display>\n";
			$navlist = $this->category_model->get_navigation ( $item ['articleclassid'], true );
			echo "<breadcrumb>\n";
			foreach ( $navlist as $nav ) {
				echo $nav ['name'] . "-";
			}
			echo "</breadcrumb>\n";
			echo "<name>" . htmlspecialchars ( $item ['title'] ) . "</name>\n" .

			" <url><![CDATA[" . $mpurl . "]]></url>\n" . "<genre>站内资讯文章</genre>\n" . " <provider>\n" . " <name>" . $item ['author'] . "</name>\n" . " <url>" . SITE_URL . $suffix . "u-$item[authorid]$fix</url>\n" . " </provider>\n";

			echo " <downloadUrl>" . $mpurl . "</downloadUrl>\n" . "<aggregateRating>\n" . "<ratingValue>3</ratingValue>\n" . "<bestRating>5</bestRating>\n" . "<ratingCount>50</ratingCount>\n" . " </aggregateRating>\n";

			echo " </display>\n" . " </data>\n" . " </url>\n";
		}
		echo "</urlset>\n";

	}
}
?>