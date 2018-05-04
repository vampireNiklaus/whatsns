<?php

defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class User extends CI_Controller {
	var $whitelist;
	public function __construct() {
		$this->whitelist = "invatelist,myjifen,invateme,search,spacefollower,vertifyemail,creditrecharge,vertify,editemail,editphone,sendcheckmail,space_attention,userbank,getsmscode";
		parent::__construct ();
		$this->load->model ( 'user_model' );

		$this->load->model ( 'topic_model' );
		$this->load->model ( 'question_model' );
		$this->load->model ( 'answer_model' );
		$this->load->model ( "category_model" );
		$this->load->model ( "favorite_model" );

	}

	function index() {

		$this->score ();
	}

	function code() {
		ob_clean ();
		$code = random ( 4 );
		$this->user_model->save_code ( strtolower ( $code ) );
		makecode ( $code );
	}
	//发送短信验证码
	function getsmscode() {
		//     	 $startime=tcookie('smstime');
		//          $timespan=time()-$startime;
		//          echo $timespan;exit();
		if ($this->setting ['smscanuse'] == 0) {
			echo '0';
			exit ();
		}
		$phone = $this->input->post ( 'phone' );
		if (! preg_match ( "/^1[34578]{1}\d{9}$/", $phone )) {

			exit ( "3" );
		}
		//                $userone=$_ENV['user']->get_by_phone($phone);
		//            if($userone!=null){
		//            	exit("2");
		//            }
		session_start ();
		if ($_SESSION ["time"] != null) {
			$startime = $_SESSION ['time'];

			$timespan = time () - $startime;

			if ($timespan < 60) {

				echo '0';
				exit ();
			} else {
				$phone = $this->input->post ( 'phone' );
				$_SESSION ["time"] = null;
				$_SESSION ["time"] = time ();
				$code = random ( 4 );
				$this->user_model->save_code ( strtolower ( $code ) );
				$codenum = $this->setting ['smstmpvalue'];
				$codenum = str_replace ( '{code}', $code, $codenum );
				$msg = sendsms ( $this->setting ['smskey'], $phone, $this->setting ['smstmpid'], $codenum );
				exit ( '1' );
			}
		} else {
			//             	$phone=$this->post['phone'];
			//                $userone=$_ENV['user']->get_by_phone($phone);
			//            if($userone!=null){
			//            	exit("2");
			//            }


			$code = random ( 4 );
			$this->user_model->save_code ( strtolower ( $code ) );
			$codenum = $this->setting ['smstmpvalue'];
			$codenum = str_replace ( '{code}', $code, $codenum );
			$msg = sendsms ( $this->setting ['smskey'], $phone, $this->setting ['smstmpid'], $codenum );
			$_SESSION ["time"] = time ();
			exit ( '1' );
		}

		echo $timespan;
		exit ();

	}
	//用户认证
	function vertify() {
		$navtitle = "我的认证中心";
		$uid = $this->user ['uid'];
		if ($uid <= 0) {
			//没用登录跳转登录
			$this->message ( "请先登录在认证!", 'user/login' );
		}
		$this->load->model ( "vertify_model" );
		$vertify = $this->vertify_model->get_by_uid ( $uid );

		if ($vertify ['status'] == null) {
			$vertify ['status'] = - 1;
		}
		$categoryjs = $this->category_model->get_js ();
		include template ( 'myvertify' );
	}
	//用户认证
	function ajaxvertify() {
		$message = array ();
		$uid = $this->user ['uid'];
		if ($uid <= 0) {
			$message ['code'] = 300;
			$message ['result'] = '用户没有登录!';
			exit ();
		}

		$uploadpath = 'data/attach/vertify/';
		if (! is_dir ( $uploadpath )) {
			mkdir ( $uploadpath );
		}

		$this->load->model ( "vertify_model" );
		$vertify = $this->vertify_model->get_by_uid ( $uid );
		checkattack ( $_POST ['zhaopian1'] );
		$img = $_POST ['zhaopian1'];
		$file = '';
		if ($img != SITE_URL . $vertify ['zhaopian1']) {
			$img = str_replace ( 'data:image/png;base64,', '', $img );
			$img = str_replace ( ' ', '+', $img );
			$data = base64_decode ( $img );
			$radname = $uid . "_1";
			$file = $uploadpath . $radname . '.png';
			$success = file_put_contents ( $file, $data );
		} else {
			$file = $vertify ['zhaopian1'];
		}
		checkattack ( $_POST ['zhaopian2'] );
		$img2 = $_POST ['zhaopian2'];

		$file2 = '';
		if ($img2 != '') {
			if ($img2 != SITE_URL . $vertify ['zhaopian2']) {
				$img2 = str_replace ( 'data:image/png;base64,', '', $img2 );
				$img2 = str_replace ( ' ', '+', $img2 );
				$data1 = base64_decode ( $img2 );
				$radname = $uid . "_2";
				;
				$file2 = $uploadpath . $radname . '.png';
				$success = file_put_contents ( $file2, $data1 );
			} else {
				$file2 = $vertify ['zhaopian2'];
			}

		}

		$type = intval ( $this->input->post ( 'type' ) );
		$name = strip_tags ( $this->input->post ( 'name' ) );
		$idcode = strip_tags ( $this->input->post ( 'idcode' ) );
		$jieshao = strip_tags ( $this->input->post ( 'jieshao' ) );

		$id = $this->vertify_model->add ( $uid, $type, $name, $idcode, $jieshao, $file, $file2, 0 );

		if ($id > 0) {
			$message ['code'] = 200;
			$message ['result'] = '提交成功，等待审核!';
			//取消设置为行家/专家
			$this->db->query ( "UPDATE " . $this->db->dbprefix . "user SET `expert`=0 WHERE uid=$uid" );
			if (file_exists ( $uploadpath . $uid . ".txt" ))
				unlink ( $uploadpath . $uid . ".txt" );
		} else {
			$message ['code'] = 300;
			$message ['result'] = '提交失败!';
		}
		echo json_encode ( $message );
	}
	//检索用户
	function search() {
		$hidefooter = 'hidefooter';
		$type = "user";
		$this->load->helper ( 'security' );
		if ($this->uri->rsegments [3]) {
			$word = xss_clean ( $this->uri->rsegments [3] );
		} else {
			if ($_GET ['word']) {
				$word = xss_clean ( $_GET ['word'] );
			} else {
				$word = xss_clean ( $_GET [0] );
			}
		}
		$word = str_replace ( array ("\\", "'", " ", "/", "&" ), "", $word );
		$word = strip_tags ( $word );
		$word = htmlspecialchars ( $word );
		$word = taddslashes ( $word, 1 );
		(! $word) && $this->message ( "搜索关键词不能为空!", 'BACK' );
		$navtitle = $word;
		@$page = max ( 1, intval ( $this->uri->rsegments [4]) );
		// var_dump($this->get);exit();
		$pagesize = $this->setting ['list_default'];
		$startindex = ($page - 1) * $pagesize;
		$seo_description = $word;
		$seo_keywords = $word;
		$rownum = returnarraynum ( $this->db->query ( getwheresql ( 'user', " username like '%$word%'", $this->db->dbprefix ) )->row_array () );
		$userlist = $this->user_model->list_by_search_condition ( " username like '%$word%'", $startindex, $pagesize );

		$departstr = page ( $rownum, $pagesize, $page, "user/search/$word" );
		include template ( 'serach_huser' );
	}
	//检查http请求的主机和请求的来路域名是否相同，不相同拒绝请求
	function check_apikey() {

		session_start ();
		if ($_SESSION ["tokenid"] == null || $this->input->post ( 'tokenkey' ) == null) {
			$this->message ( '非法操作!', user / addxinzhi );
			exit ();
		}
		if ($_SESSION ["tokenid"] != $this->input->post ( 'tokenkey' )) {

			$this->message ( '页面过期，请保存数据刷新页面在操作!', user / addxinzhi );
		}

	}
	//我的文章--暂时不用
	function xinzhi() {

		include template ( 'myxinzhi' );
	}
	//发布文章
	function addxinzhi() {
		$navtitle = "添加文章";
		if (is_mobile ()) {

			$catetree = $this->category_model->get_categrory_tree ( 2 );
		}
		if ($this->user ['doarticle'] == 0 && $this->user ['grouptype'] != 1) {
			$this->message ( '您所在用户组站长设置不允许发布文章！', 'topic/default' );
		}

		if ($this->input->post ( 'submit' ) !== null) {
			if (isset ( $this->setting ['register_on'] ) && $this->setting ['register_on'] == '1' && $this->user ['grouptype'] != 1) {
				if ($this->user ['active'] != 1) {
					$viewhref = urlmap ( 'user/editemail', 1 );
					$this->message ( "必须激活邮箱才能发布文章!", $viewhref );
				}
			}
			if ($this->user ['isblack'] == 1) {
				$this->message ( '黑名单用户无法发布文章！', 'index/default' );
			}
			/* 检查提问数是否超过组设置 */
			$this->load->model ( "userlog_model" );
			if ($this->user ['articlelimits'] && ($this->userlog_model->rownum_by_time ( 'topic' ) >= $this->user ['articlelimits']) && $this->user ['grouptype'] != 1)

			{

				$this->message ( '你已超过每小时最大文章发布数,请稍后再试！', 'user/addxinzhi' );
				exit ();
			}

			$this->load->model ( "topic_model" );

			$this->load->model ( "topic_tag_model" );

			$title = $this->input->post ( 'title' );
			$topic_price = intval ( $this->input->post ( 'topic_price' ) );

			$topic_tag = $this->input->post ( 'topic_tag' );
			$ataglist = explode ( ",", $topic_tag );
			$desrc = $this->input->post ( 'content' );
			$outimgurl = $this->input->post ( 'outimgurl' );
			// $tagarr= dz_segment($title,$desrc);
			$acid = $this->input->post ( 'topicclass' );
			// if($ataglist!=null){
			//	$tagarr=array_merge($ataglist,$tagarr);
			//}


			if ($acid == null)
				$acid = 1;

			if ('' == $title || '' == $desrc) {
				$this->message ( '请完整填写专题相关参数!', 'user/addxinzhi' );

				exit ();
			}
			if ($_FILES ['image'] ['name'] == null && trim ( $outimgurl ) == '') {
				$this->message ( '封面图和外部图片至少填写一个!', 'user/addxinzhi' );

				exit ();
			}
			if ($_FILES ['image'] ['name'] != null) {

				$imgname = strtolower ( $_FILES ['image'] ['name'] );
				$type = substr ( strrchr ( $imgname, '.' ), 1 );
				if (! isimage ( $type )) {
					$this->message ( '当前图片图片格式不支持，目前仅支持jpg、gif、png格式！', 'user/addxinzhi' );

					exit ();
				}
				$upload_tmp_file = FCPATH . 'data/tmp/topic_' . random ( 6, 0 ) . '.' . $type;

				$filepath = '/data/attach/topic/topic' . random ( 6, 0 ) . '.' . $type;
				forcemkdir ( FCPATH . 'data/attach/topic' );
				if (move_uploaded_file ( $_FILES ['image'] ['tmp_name'], $upload_tmp_file )) {
					image_resize ( $upload_tmp_file, FCPATH . $filepath, 300, 240, 1 );

					$filepath = SITE_URL . $filepath;

				} else {

					$this->message ( '服务器忙，请稍后再试！', 'user/addxinzhi' );
				}
			}
			if (trim ( $outimgurl ) != '' && $_FILES ['image'] ['name'] == null) {

				$filepath = '/data/attach/topic/topic' . random ( 6, 0 ) . '.jpg';
				image_resize ( $outimgurl, FCPATH . $filepath, 300, 240 );
				$filepath = SITE_URL . $filepath;
			}
			$aid = $this->topic_model->addtopic ( $title, $desrc, $filepath, $this->user ['username'], $this->user ['uid'], 1, $acid, $topic_price );
			$this->db->query ( "UPDATE " . $this->db->dbprefix . "user SET articles=articles+1 WHERE  uid =" . $this->user ['uid'] );
			//发布文章，添加积分
		$this->credit ( $this->user ['uid'], $this->setting ['credit1_article'], $this->setting ['credit2_article'] ,0,'addarticle');

			$this->userlog_model->add ( 'topic' );
			$ataglist && $this->topic_tag_model->multi_add ( array_unique ( $ataglist ), $aid );

			$this->load->model ( "doing_model" );
			$this->doing_model->add ( $this->user ['uid'], $this->user ['username'], 9, $aid, $title );
			$this->message ( '添加成功！', 'topic/getone/' . $aid );
		} else {
			// $this->load("topicclass");
			//$topiclist=  $_ENV['topicclass']->get_list();
			if ($this->user ['uid'] == 0 || $this->user ['uid'] == null) {
				$this->message ( '您还没有登录！', 'user/login' );
			}

			$categoryjs = $this->category_model->get_js ( 0, 2 );
			include template ( 'addxinzhi' );
		}

	}
	//删除文章
	function deletexinzhi() {
		if ($this->user ['uid'] == 0 || $this->user ['uid'] == null) {
			$this->message ( '非法操作，你的ip已被记录' );
		}

		$this->load->model ( "doing_model" );
		$topic = $this->topic_model->get ( intval ( $this->uri->segment ( 3 ) ) );

		if ($this->user ['uid'] != $topic ['authorid'] && $this->user ['grouptype'] != 1) {
			$this->message ( '非法操作，你的ip已被记录' );
		}
		$this->topic_model->remove ( intval ( $this->uri->segment ( 3 ) ) );
		$this->load->model ( 'topdata_model' );
		$this->topdata_model->remove ( $topic ['id'], 'topic' );
		$uid = $topic ['authorid'];

		$this->doing_model->deletedoing ( $uid, 9, $topic ['id'] ); //删除动态
		$this->db->query ( "UPDATE " . $this->db->dbprefix . "user SET articles=articles-1 WHERE  uid =$uid" );
		$this->message ( '文章删除成功！', 'topic/default' );
	}
	//编辑文章
	function editxinzhi() {
		if (is_mobile ()) {
			$catetree = $this->category_model->get_categrory_tree ( 2 );
		}
		session_start ();

		$this->load->model ( "topic_tag_model" );
		$tid = intval ( $this->uri->segment ( 3 ) ) > 0 ? intval ( $this->uri->segment ( 3 ) ) : intval ( $this->input->post ( 'id' ) );

		$topic = $this->topic_model->get ( intval ( $tid ) );

		//判断当前用户是不是超级管理员
		$candone = false;
		if ($this->user ['grouptype'] == 1) {
			$candone = true;
		} else {
			//判断当前用户是不是回答者本人


			if ($this->user ['uid'] == $topic ['authorid']) {
				$candone = true;
			}
		}

		if ($candone == false) {
			$this->message ( "非法操作,您的ip已被系统记录！", "STOP" );
		}
		if (null !== $this->input->post ( 'submit' )) {
			if ($this->user ['uid'] == 0 || $this->user ['uid'] == null) {
				$this->message ( '您还没有登录！', 'user/login' );
			}
			// $this->check_apikey();
			$tid = intval ( $this->input->post ( 'id' ) );
			$topic = $this->topic_model->get ( $tid );

			if ($topic ['authorid'] != $this->user ['uid'] && $candone == false) {
				$this->message ( '非法操作，你的ip已被记录' );
			}
			if (isset ( $this->setting ['register_on'] ) && $this->setting ['register_on'] == '1') {
				if ($this->user ['active'] != 1) {
					$viewhref = urlmap ( 'user/editemail', 1 );
					$this->message ( "必须激活邮箱才能修改文章!", $viewhref );
				}
			}
			$title = $this->input->post ( 'title' );
			$topic_price = intval ( $this->input->post ( 'topic_price' ) );
			$topic_tag = $this->input->post ( 'topic_tag' );
			$taglist = explode ( ",", $topic_tag );
			$desrc = $this->input->post ( 'content' );
			$outimgurl = $this->input->post ( 'outimgurl' );
			$upimg = $this->input->post ( 'upimg' );
			$views = $this->input->post ( 'views' );
			$isphone = $this->input->post ( 'isphone' );
			if ($isphone == 'on') {
				$isphone = 1;
			} else {
				$isphone = 0;
			}
			$acid = $this->input->post ( 'topicclass' );
			if ($acid == null)
				$acid = 1;
			$imgname = strtolower ( $_FILES ['image'] ['name'] );
			if ('' == $title || '' == $desrc) {
				$this->message ( '请完整填写专题相关参数!', 'errormsg' );
				exit ();
			}
			// print_r($tagarr);
			// exit();
			if ($imgname) {
				$type = substr ( strrchr ( $imgname, '.' ), 1 );
				if (! isimage ( $type )) {
					$this->message ( '当前图片图片格式不支持，目前仅支持jpg、gif、png格式！', 'errormsg' );
					exit ();
				}
				$filepath = '/data/attach/topic/topic' . random ( 6, 0 ) . '.' . $type;
				$upload_tmp_file = FCPATH . 'data/tmp/topic_' . random ( 6, 0 ) . '.' . $type;
				forcemkdir ( FCPATH . 'data/attach/topic' );
				if (move_uploaded_file ( $_FILES ['image'] ['tmp_name'], $upload_tmp_file )) {
					image_resize ( $upload_tmp_file, FCPATH . $filepath, 300, 240 );
					$filepath = SITE_URL . $filepath;
					$ispc = $topic ['ispc'];
					$this->topic_model->updatetopic ( $tid, $title, $desrc, $filepath, $isphone, $views, $acid, $ispc, $topic_price );
					$taglist && $this->topic_tag_model->multi_add ( array_unique ( $taglist ), $tid );
					$this->message ( '文章修改成功！', 'topic/getone/' . $tid );
				} else {
					$this->message ( '服务器忙，请稍后再试！' );
				}
			} else {
				//if($outimgurl!=$upimg&&trim($upimg)!=''){
				$upimg = $outimgurl;
				$filepath = 'data/attach/topic/topic' . random ( 6, 0 ) . '.jpg';

				image_resize ( $outimgurl, FCPATH . $filepath, 300, 240 );

				$upimg = SITE_URL . $filepath;
				//}
				$ispc = $topic ['ispc'];
				$this->topic_model->updatetopic ( $tid, $title, $desrc, $upimg, $isphone, $views, $acid, $ispc, $topic_price );
				$taglist && $this->topic_tag_model->multi_add ( array_unique ( $taglist ), $tid );
				$this->message ( '文章修改成功,即将跳转!', 'topic/getone/' . $tid );
			}
		} else {

			$tagmodel = $this->topic_tag_model->get_by_aid ( $topic ['id'] );

			$topic ['topic_tag'] = implode ( ',', $tagmodel );

			$_SESSION ["userid"] = getRandChar ( 56 );
			$catmodel = $this->category_model->get ( $topic ['articleclassid'] );
			$categoryjs = $this->category_model->get_js ( 0, 2 );
			include template ( 'editxinzhi' );
		}

	}

	function register() {
		if ($this->user ['uid']) {
			header ( "Location:" . SITE_URL );
		}
		$useragent = $_SERVER ['HTTP_USER_AGENT'];
		if (strstr ( $useragent, 'MicroMessenger' )) {
			$wxbrower = true;
		}
		$navtitle = '注册新用户';

		if (! $this->setting ['allow_register']) {
			$this->message ( "系统注册功能暂时处于关闭状态!", 'STOP' );
		}
		if (isset ( $this->setting ['max_register_num'] ) && $this->setting ['max_register_num'] && ! $this->user_model->is_allowed_register ()) {
			$this->message ( "您的当前的IP已经超过当日最大注册数目，如有疑问请联系管理员!", 'STOP' );
			exit ();
		}
		$forward = isset ( $_SERVER ['HTTP_REFERER'] ) ? $_SERVER ['HTTP_REFERER'] : SITE_URL;

		$this->setting ['passport_open'] && ! $this->setting ['passport_type'] && $this->user_model->passport_client (); //通行证处理
		if (! isset ( $_SESSION )) {
			session_start ();
		}
		$_SESSION ['registrtokenid'] = md5 ( time () );
		$invatecode = intval ( $this->uri->segment ( 3 ) );
		include template ( 'register' );

	}

	function login() {

		if ($this->user ['uid']) {

			header ( "Location:" . SITE_URL );
		}

		$useragent = $_SERVER ['HTTP_USER_AGENT'];
		if (strstr ( $useragent, 'MicroMessenger' )) {
			$wxbrower = true;
		}
		$navtitle = '用户登录';

		$forward = isset ( $_SERVER ['HTTP_REFERER'] ) ? $_SERVER ['HTTP_REFERER'] : SITE_URL;
		if (! isset ( $_SESSION )) {
			session_start ();
		}
		$_SESSION ['logintokenid'] = md5 ( time () );
		include template ( 'login' );

	}

	/* 用于ajax检测用户名是否存在 */

	function ajaxusername() {
		$username = $this->input->post ( 'username' );
		$user = $this->user_model->get_by_username ( $username );
		if (is_array ( $user ))
			exit ( '-1' );
		$usernamecensor = $this->user_model->check_usernamecensor ( $username );
		if (FALSE == $usernamecensor)
			exit ( '-2' );
		exit ( '1' );
	}
	/* 用于ajax检测用户名是否存在 */

	function ajaxupdateusername() {

		if ($this->user ['uid'] == 0) {
			exit ( '0' );
		}
		$username = $this->input->post ( 'username' );

		$user = $this->user_model->get_by_username ( $username );
		if (is_array ( $user ))
			exit ( '-1' );
		$usernamecensor = $this->user_model->check_usernamecensor ( $username );
		if (FALSE == $usernamecensor)
			exit ( '-2' );

		$useremail = $this->input->post ( 'useremail' );
		$emailaccess = $this->user_model->check_emailaccess ( $useremail );
		if (FALSE == $emailaccess) {
			exit ( "-3" );
		}
		$user = $this->user_model->get_by_email ( $useremail );
		if (is_array ( $user )) {
			exit ( '-4' );
		}

		//更新用户名
		$this->user_model->update_username ( $this->user ['uid'], $username, $useremail );

		//发送邮件确认
		$sitename = $this->setting ['site_name'];
		$activecode = md5 ( rand ( 10000, 50000 ) );
		$url = SITE_URL . 'index.php?user/checkemail/' . $this->user ['uid'] . '/' . $activecode;
		$message = "这是一封来自$sitename邮箱验证，<a target='_blank' href='$url'>请点击此处验证邮箱邮箱账号</a>";
		$v = md5 ( "yanzhengask2email" );
		$v1 = md5 ( "yanzhengask2time" );
		setcookie ( "emailsend" );
		setcookie ( "useremailcheck" );
		$expire1 = time () + 20; // 设置1分钟的有效期
		setcookie ( "emailsend", $v1, $expire1 ); // 设置一个名字为var_name的cookie，并制定了有效期
		$expire = time () + 86400; // 设置24小时的有效期
		setcookie ( "useremailcheck", $v, $expire ); // 设置一个名字为var_name的cookie，并制定了有效期
		$this->user_model->update_emailandactive ( $useremail, $activecode, $this->user ['uid'] );
		$this->user_model->refresh ( $this->user ['uid'], 1 );
		sendmailto ( $useremail, "邮箱验证提醒-$sitename", $message, $this->user ['username'] );

		exit ( '1' );
	}

	/* 用于ajax检测用户名是否存在 */

	function ajaxemail() {
		$email = $this->input->post ( 'email' );
		$user = $this->user_model->get_by_email ( $email );
		if (is_array ( $user ))
			exit ( '-1' );
		$emailaccess = $this->user_model->check_emailaccess ( $email );
		if (FALSE == $emailaccess)
			exit ( '-2' );
		exit ( '1' );
	}

	/* 用于ajax检测验证码是否匹配 */

	function ajaxcode() {
		$code = strtolower ( trim ( $this->uri->segment ( 3 ) ) );
		if ($code == $this->user_model->get_code ()) {
			exit ( '1' );
		}
		exit ( '0' );
	}

	/* 退出系统 */

	function logout() {
		$navtitle = '登出系统';
		//ucenter退出成功，则不会继续执行后面的代码。
		if ($this->setting ["ucenter_open"]) {
			$this->load->model ( 'ucenter_model' );
			$this->ucenter_model->ajaxlogout ();
		}
		$forward = isset ( $_SERVER ['HTTP_REFERER'] ) ? $_SERVER ['HTTP_REFERER'] : SITE_URL;
		$this->user_model->logout ();
		$this->message ( '成功退出！', "index" );
	}

	/* 找回密码 */

	function getpass() {
		$navtitle = '找回密码';
		if (null !== $this->input->post ( 'submit' )) {
			$email = $this->input->post ( 'email' );
			$name = $this->input->post ( 'username' );
			//$this->checkcode(); //检查验证码
			if (strtolower ( trim ( $this->input->post ( 'code' ) ) ) != $this->user_model->get_code ()) {
				$this->message ( $this->input->post ( 'state' ) . "验证码错误!", 'BACK' );
			}
			$touser = $this->user_model->get_by_name_email ( $name, $email );
			if ($touser) {
				$activecode = md5 ( rand ( 10000, 50000 ) );
				$getpassurl = SITE_URL . 'index.php?user/resetpass/' . encode ( $touser ['uid'] ) . '/' . $activecode;

				$this->user_model->update_emailandactive ( $email, $activecode, $touser ['uid'] );

				$subject = "找回您在" . $this->setting ['site_name'] . "的密码";
				$message = '<p>如果是您在<a swaped="true" target="_blank" href="' . SITE_URL . '">' . $this->setting ['site_name'] . '</a>的密码丢失，请点击下面的链接找回：</p><p><a swaped="true" target="_blank" href="' . $getpassurl . '">' . $getpassurl . '</a></p><p>如果直接点击无法打开，请复制链接地址，在新的浏览器窗口里打开。</p>';
				sendmail ( $touser, $subject, $message );
				$this->message ( "找回密码的邮件已经发送到你的邮箱，请查收!", 'BACK' );
			}
			$this->message ( "用户名或邮箱填写错误，请核实!", 'BACK' );
		}
		include template ( 'getpass' );
	}

	/* 重置密码 */

	function resetpass() {
		if ($this->user ['uid'] > 0) {
			$this->message ( "您已经登录了!" );
		}
		$navtitle = '重置密码';
		$uid = intval ( decode ( $this->uri->segment ( 3 ) ) );
		$activecode = strip_tags ( $this->uri->segment ( 4 ) );
		$user = $this->user_model->get_by_uid ( $uid );

		if ($user ['activecode'] != null && $user ['activecode'] == $activecode) {
			$this->user_model->update_useractive ( $uid );

		} else {
			$this->message ( "非法操作!" );
		}
		$authcode = $this->uri->segment ( 3 );
		if (null !== $this->input->post ( 'submit' )) {
			$password = $this->input->post ( 'password' );
			$repassword = $this->input->post ( 'repassword' );
			$uid = decode ( $this->input->post ( 'authcode' ) );
			if (strlen ( $password ) < 6) {
				$this->message ( "密码长度不能少于6位!", 'BACK' );
			}
			if ($password != $repassword) {
				$this->message ( "两次密码输入不一致!", 'BACK' );
			}
			$this->user_model->uppass ( $uid, $password );
			$this->user_model->update_authstr ( $uid, '' );
			$this->message ( "重置密码成功，请使用新密码登录!" );
		}
		include template ( 'resetpass' );
	}

	function ask() {
		$navtitle = '我的问题';
		$status = intval ( $this->uri->segment ( 3 ) ) == 0 ? 'all' : intval ( $this->uri->segment ( 3 ) );
		@$page = max ( 1, intval ( $this->uri->segment ( 4 ) ) );
		$pagesize = $this->setting ['list_default'];
		$startindex = ($page - 1) * $pagesize; //每页面显示$pagesize条
		$questionlist = $this->question_model->list_by_uid ( $this->user ['uid'], $status, $startindex, $pagesize );
		$questiontotal = intval ( returnarraynum ( $this->db->query ( getwheresql ( 'question', 'authorid=' . $this->user ['uid'] . $this->question_model->statustable [$status], $this->db->dbprefix ) )->row_array () ) );
		$departstr = page ( $questiontotal, $pagesize, $page, "user/ask/$status" ); //得到分页字符串
		include template ( 'myask' );
	}

	function recommend() {
		$this->load->model ( 'message_model' );
		$navtitle = '为我推荐的问题';
		@$page = max ( 1, intval ( $this->uri->segment ( 3 ) ) );
		$pagesize = $this->setting ['list_default'];
		$startindex = ($page - 1) * $pagesize;
		$user_categorys = array_per_fields ( $this->user ['category'], 'cid' );
		$this->message_model->read_user_recommend ( $this->user ['uid'], $user_categorys );
		$questionlist = $this->message_model->list_user_recommend ( $this->user ['uid'], $user_categorys, $startindex, $pagesize );
		$questiontotal = $this->message_model->rownum_user_recommend ( $this->user ['uid'], $user_categorys );
		$departstr = page ( $questiontotal, $pagesize, $page, "user/recommend" );
		include template ( 'myrecommend' );
	}

	function space_ask() {

		$uid = intval ( $this->uri->rsegments [3] );
		$member = $this->user_model->get_by_uid ( $uid, 0 );
		$navtitle = $member ['username'] . '的提问';
		$seo_description = $member ['username'] . '，' . $member ['introduction'] . '，' . $member ['signature'];
		$seo_keywords = $member ['username'];
		$status = $this->uri->rsegments [4] ? $this->uri->rsegments [4] : 'all';
		//升级进度
		$membergroup = $this->usergroup [$member ['groupid']];
		@$page = max ( 1, intval ( $this->uri->rsegments [5] ) );
		$pagesize = $this->setting ['list_default'];
		$startindex = ($page - 1) * $pagesize; //每页面显示$pagesize条
		$questionlist = $this->question_model->list_by_uid ( $uid, $status, $startindex, $pagesize );
		// print_r($questionlist);
		// exit();
		$questiontotal = returnarraynum ( $this->db->query ( getwheresql ( 'question', 'authorid=' . $uid . $this->question_model->statustable [$status], $this->db->dbprefix ) )->row_array () );
		$departstr = page ( $questiontotal, $pagesize, $page, "user/space_ask/$uid/$status" ); //得到分页字符串
		include template ( 'space_ask' );
	}

	function answer() {
		$navtitle = '我的回答';
		$status = intval ( $this->uri->rsegments [3] ) == 0 ? 'all' : intval ( $this->uri->rsegments [3] );

		@$page = max ( 1, intval ( $this->uri->rsegments [4] ) );
		$pagesize = $this->setting ['list_default'];
		$startindex = ($page - 1) * $pagesize; //每页面显示$pagesize条
		$answerlist = $this->answer_model->list_by_uid ( $this->user ['uid'], $status, $startindex, $pagesize );
		$answersize = returnarraynum ( $this->db->query ( getwheresql ( 'answer', 'authorid=' . $this->user ['uid'] . $this->answer_model->statustable [$status], $this->db->dbprefix ) )->row_array () );
		$departstr = page ( $answersize, $pagesize, $page, "user/answer/$status" ); //得到分页字符串
		include template ( 'myanswer' );
	}

	function space_answer() {

		$uid = intval ( $this->uri->rsegments [3] );
		$status = $this->uri->rsegments [4] ? $this->uri->rsegments [4] : 'all';
		$member = $this->user_model->get_by_uid ( $uid, 0 );
		$navtitle = $member ['username'] . '的回答';
		$seo_description = $member ['username'] . '，' . $member ['introduction'] . '，' . $member ['signature'];
		$seo_keywords = $member ['username'];
		//升级进度
		$membergroup = $this->usergroup [$member ['groupid']];
		@$page = max ( 1, intval ( $this->uri->rsegments [5] ) );
		$pagesize = $this->setting ['list_default'];
		$startindex = ($page - 1) * $pagesize; //每页面显示$pagesize条
		$answerlist = $this->answer_model->list_by_uid ( $uid, $status, $startindex, $pagesize );
		$answersize = intval ( returnarraynum ( $this->db->query ( getwheresql ( 'answer', 'authorid=' . $uid . $this->answer_model->statustable [$status], $this->db->dbprefix ) )->row_array () ) );
		$departstr = page ( $answersize, $pagesize, $page, "user/space_answer/$uid/$status" ); //得到分页字符串
		include template ( 'space_answer' );
	}

	function follower() {
		$navtitle = '关注者';
		$page = max ( 1, intval ( $this->uri->rsegments [3] ) );
		$pagesize = $this->setting ['list_default'];
		$startindex = ($page - 1) * $pagesize;
		$followerlist = $this->user_model->get_follower ( $this->user ['uid'], $startindex, $pagesize );
		$rownum = returnarraynum ( $this->db->query ( getwheresql ( 'user_attention', " uid=" . $this->user ['uid'], $this->db->dbprefix ) )->row_array () );
		$departstr = page ( $rownum, $pagesize, $page, "user/follower" );
		include template ( "myfollower" );
	}
	function spacefollower() {

		$uid = intval ( $this->uri->rsegments [3] );
		$member = $this->user_model->get_by_uid ( $uid, 0 );

		$navtitle = $member ['username'] . '的粉丝';
		$page = max ( 1, intval ( $this->uri->rsegments [4] ) );
		$pagesize = $this->setting ['list_default'];
		$startindex = ($page - 1) * $pagesize;

		$followerlist = $this->user_model->get_follower ( $uid, $startindex, $pagesize );

		$rownum = returnarraynum ( $this->db->query ( getwheresql ( 'user_attention', " uid=" . $uid, $this->db->dbprefix ) )->row_array () );

		$departstr = page ( $rownum, $pagesize, $page, "user/spacefollower" );
		include template ( "space_follower" );
	}

	function attention() {
		$navtitle = '已关注';
		$attentiontype = null !== $this->uri->rsegments [3] ? $this->uri->rsegments [3] : '';

		if ($attentiontype == 'article') {
			$this->load->model ( 'favorite_model' );
			$navtitle = "我关注的文章";
			$seo_description = "";
			$seo_keywords = "";
			@$page = max ( 1, intval ( $this->uri->rsegments [4] ) );
			$pagesize = $this->setting ['list_default'];
			$startindex = ($page - 1) * $pagesize;
			$rownum = $this->favorite_model->get_list_byalltidtotal ();

			$topiclist = $this->favorite_model->get_list_byalltid ( $startindex, $pagesize );

			$departstr = page ( $rownum, $pagesize, $page, "user/attentionarticle" );
			include template ( 'myattention_article' );
		} else if ($attentiontype == 'question') {
			$navtitle = '已关注问题';
			$page = max ( 1, intval ( $this->uri->rsegments [4] ) );
			$pagesize = $this->setting ['list_default'];
			$startindex = ($page - 1) * $pagesize;
			$questionlist = $this->user_model->get_attention_question ( $this->user ['uid'], $startindex, $pagesize );
			$rownum = $this->user_model->rownum_attention_question ( $this->user ['uid'] );
			$departstr = page ( $rownum, $pagesize, $page, "user/attention/$attentiontype" );
			include template ( "myattention_question" );
		} else if ($attentiontype == 'topic') {

			$navtitle = '已关注话题';
			$page = max ( 1, intval ( $this->uri->rsegments [4] ) );
			$pagesize = $this->setting ['list_default'];
			$startindex = ($page - 1) * $pagesize;
			$categorylist = $this->user_model->get_attention_category ( $this->user ['uid'], $startindex, $pagesize );
			$rownum = $this->user_model->rownum_attention_category ( $this->user ['uid'] );
			$departstr = page ( $rownum, $pagesize, $page, "user/attention/$attentiontype" );
			include template ( "myattention_category" );
		} else {
			$navtitle = '已关注用户';
			$page = max ( 1, intval ( $this->uri->rsegments [3] ) );
			$pagesize = $this->setting ['list_default'];
			$startindex = ($page - 1) * $pagesize;
			$attentionlist = $this->user_model->get_attention ( $this->user ['uid'], $startindex, $pagesize );
			$rownum = returnarraynum ( $this->db->query ( getwheresql ( 'user_attention', " followerid=" . $this->user ['uid'], $this->db->dbprefix ) )->row_array () );
			$departstr = page ( $rownum, $pagesize, $page, "user/attention" );
			include template ( "myattention" );
		}
	}
	function space_attention() {
		$navtitle = '已关注';
		$attentiontype = null !== $this->uri->segment ( 3 ) ? $this->uri->segment ( 3 ) : '';
		$uid = intval ( $this->uri->segment ( 4 ) );
		$member = $this->user_model->get_by_uid ( $uid, 0 );
		if ($attentiontype == 'question') {
			$navtitle = '已关注问题';
			$page = max ( 1, intval ( $this->uri->segment ( 5 ) ) );
			$pagesize = $this->setting ['list_default'];
			$startindex = ($page - 1) * $pagesize;
			$questionlist = $this->user_model->get_attention_question ( $uid, $startindex, $pagesize );
			$rownum = $this->user_model->rownum_attention_question ( $uid );
			$departstr = page ( $rownum, $pagesize, $page, "user/attention/$attentiontype" );
			include template ( "space_myattention_question" );
		} else if ($attentiontype == 'topic') {

			$navtitle = '已关注话题';
			$page = max ( 1, intval ( $this->uri->segment ( 5 ) ) );
			$pagesize = $this->setting ['list_default'];
			$startindex = ($page - 1) * $pagesize;
			$categorylist = $this->user_model->get_attention_category ( $uid, $startindex, $pagesize );
			$rownum = $this->user_model->rownum_attention_category ( $uid );
			$departstr = page ( $rownum, $pagesize, $page, "user/attention/$attentiontype" );
			include template ( "space_myattention_category" );
		} else {
			$navtitle = '已关注用户';
			$page = max ( 1, intval ( $this->uri->segment ( 5 ) ) );
			$pagesize = $this->setting ['list_default'];
			$startindex = ($page - 1) * $pagesize;
			$attentionlist = $this->user_model->get_attention ( $uid, $startindex, $pagesize );
			$rownum = returnarraynum ( $this->db->query ( getwheresql ( 'user_attention', " followerid=" . $uid, $this->db->dbprefix ) )->row_array () );
			$departstr = page ( $rownum, $pagesize, $page, "user/attention" );
			include template ( "space_myattention" );
		}
	}

	function score() {
		$navtitle = '我的个人中心';
		if (isset ( $this->setting ['outextcredits'] ) && $this->setting ['outextcredits']) {
			$outextcredits = unserialize ( $this->setting ['outextcredits'] );
		}
		$higherneeds = intval ( $this->user ['creditshigher'] - $this->user ['credit1'] );
		$adoptpercent = $this->user_model->adoptpercent ( $this->user );
		$highergroupid = $this->user ['groupid'] + 1;
		isset ( $this->usergroup [$highergroupid] ) && $nextgroup = $this->usergroup [$highergroupid];
		$credit_detail = $this->user_model->credit_detail ( $this->user ['uid'] );

		if ($credit_detail) {
			$detail1 = isset ( $credit_detail [0] ) && $credit_detail [0];
			$detail2 = isset ( $credit_detail [1] ) && $credit_detail [1];
		}

		$status = 'all';
		@$page = max ( 1, intval ( $this->uri->segment ( 4 ) ) );
		$pagesize = $this->setting ['list_default'];
		$startindex = ($page - 1) * $pagesize; //每页面显示$pagesize条
		$userid = $this->user ['uid'];
		$this->load->model ( 'doing_model' );

		$doinglist = $this->doing_model->list_by_type ( "my", $userid, $startindex, $pagesize );

		$rownum = $this->doing_model->rownum_by_type ( "my", $userid );

		$departstr = page ( $rownum, $pagesize, $page, "user/score/$userid" );

		$answerlist = $this->answer_model->list_by_uid ( $userid, 'all', $startindex, $pagesize );
		$questionlist = $this->question_model->list_by_uid ( $userid, 'all', $startindex, $pagesize );

		$topiclist = $this->topic_model->get_list_byuid ( $userid, $startindex, $pagesize );
		$followerlist = $this->user_model->get_follower ( $userid, $startindex, $pagesize );
		$attentionlist = $this->user_model->get_attention ( $userid, $startindex, $pagesize );

		include template ( 'myscore' );

	}

	function level() {
		$navtitle = '我的等级';
		$usergroup = $this->usergroup;
		include template ( "mylevel" );
	}

	function exchange() {
		$navtitle = '积分兑换';
		if ($this->setting ['outextcredits']) {
			$outextcredits = unserialize ( $this->setting ['outextcredits'] );
		} else {
			$this->message ( "系统没有开启积分兑换!", 'BACK' );
		}
		$exchangeamount = $this->input->post ( 'exchangeamount' ); //先要兑换的积分数
		$outextindex = $this->input->post ( 'outextindex' ); //读取相应积分配置
		$outextcredit = $outextcredits [$outextindex];
		$creditsrc = $outextcredit ['creditsrc']; //积分兑换的源积分编号
		$appiddesc = $outextcredit ['appiddesc']; //积分兑换的目标应用程序 ID
		$creditdesc = $outextcredit ['creditdesc']; //积分兑换的目标积分编号
		$ratio = $outextcredit ['ratio']; //积分兑换比率
		$needamount = $exchangeamount / $ratio; //需要扣除的积分数


		if ($needamount <= 0) {
			$this->message ( "兑换的积分必需大于0 !", 'BACK' );
		}
		if (1 == $creditsrc) {
			$titlecredit = '经验值';
			if ($this->user ['credit1'] < $needamount) {
				$this->message ( "{$titlecredit}不足!", 'BACK' );
			}
			$this->credit ( $this->user ['uid'], - $needamount, 0, 0, 'exchange' ); //扣除本系统积分
		} else {
			$titlecredit = '财富值';
			if ($this->user ['credit2'] < $needamount) {
				$this->message ( "{$titlecredit}不足!", 'BACK' );
			}
			$this->credit ( $this->user ['uid'], 0, - $needamount, 0, 'exchange' ); //扣除本系统积分
		}
		$this->load->model ( 'ucenter_model' );
		$this->ucenter_model->exchange ( $this->user ['uid'], $creditsrc, $creditdesc, $appiddesc, $exchangeamount );
		$this->message ( "积分兑换成功!  你在“{$this->setting[site_name]}”的{$titlecredit}减少了{$needamount}。" );
	}

	/* 个人中心修改资料 */

	function profile() {
		$navtitle = '个人资料';
		if (null !== $this->input->post ( 'submit' )) {
			$gender = $this->input->post ( 'gender' );
			$bday = $this->input->post ( 'birthyear' ) . '-' . $this->input->post ( 'birthmonth' ) . '-' . $this->input->post ( 'birthday' );
			$phone = $this->input->post ( 'phone' );
			$qq = $this->input->post ( 'qq' );
			$msn = $this->input->post ( 'msn' );
			$messagenotify = null !== $this->input->post ( 'messagenotify' ) ? 1 : 0;
			$mailnotify = null !== $this->input->post ( 'mailnotify' ) ? 2 : 0;
			$isnotify = $messagenotify + $mailnotify;
			$introduction = htmlspecialchars ( $this->input->post ( 'introduction' ) );
			$signature = htmlspecialchars ( $this->input->post ( 'signature' ) );

			$userone = $this->user_model->get_by_phone ( $phone );
			if ($userone != null && $phone != $this->user ['phone']) {
				$this->message ( "手机号已被占用!", 'user/profile' );
			}
			if (($this->input->post ( 'email' ) != $this->user ['email']) && (! preg_match ( "/^[a-z'0-9]+([._-][a-z'0-9]+)*@([a-z0-9]+([._-][a-z0-9]+))+$/", $this->input->post ( 'email' ) ) || returnarraynum ( $this->db->query ( getwheresql ( 'user', " email='" . $this->input->post ( 'email' ) . "' ", $this->db->dbprefix ) )->row_array () ))) {
				$this->message ( "邮件格式不正确或已被占用!", 'user/profile' );
			}
			$this->user_model->update ( $this->user ['uid'], $gender, $bday, $phone, $qq, $msn, $introduction, $signature, $isnotify );
			null !== $this->input->post ( 'email' ) && $this->user_model->update_email ( $this->input->post ( 'email' ), $this->user ['uid'] );
			$this->message ( "个人资料更新成功", 'user/profile' );
		}
		include template ( 'profile' );
	}

	function uppass() {
		// $this->load("ucenter");
		$navtitle = "修改密码";
		if (null !== $this->input->post ( 'submit' )) {
			if (strtolower ( trim ( $this->input->post ( 'code' ) ) ) != $this->user_model->get_code ()) {
				$this->message ( $this->input->post ( 'state' ) . "验证码错误!", 'BACK' );
			}
			if (trim ( $this->input->post ( 'newpwd' ) ) == '') {
				$this->message ( "新密码不能为空！", 'user/uppass' );
			} else if (trim ( $this->input->post ( 'newpwd' ) ) != trim ( $this->input->post ( 'confirmpwd' ) )) {
				$this->message ( "两次输入不一致", 'user/uppass' );
			} else if (trim ( $this->input->post ( 'oldpwd' ) ) == trim ( $this->input->post ( 'newpwd' ) )) {
				$this->message ( '新密码不能跟当前密码重复!', 'user/uppass' );
			} else if (md5 ( trim ( $this->input->post ( 'oldpwd' ) ) ) == $this->user ['password']) {
				if ($this->setting ["ucenter_open"]) {
					$this->load->model ( "ucenter_model" );
					$this->ucenter_model->uppass ( $this->user ['username'], $this->input->post ( 'oldpwd' ), $this->input->post ( 'newpwd' ), $this->user ['email'] );

				}

				$this->user_model->uppass ( $this->user ['uid'], trim ( $this->input->post ( 'newpwd' ) ) );
				$this->message ( "密码修改成功,请重新登录系统!", 'user/login' );
			} else {
				$this->message ( "旧密码错误！", 'user/uppass' );
			}
		}
		include template ( 'uppass' );
	}

	// 1提问  2回答
	function space() {
		$navtitle = "个人空间";
		$userid = intval ( $this->uri->rsegments [3] );
		$member = $this->user_model->get_by_uid ( $userid, 2 );
		if ($member) {
			$this->load->model ( 'doing_model' );
			$membergroup = $this->usergroup [$member ['groupid']];
			$adoptpercent = $this->user_model->adoptpercent ( $member );
			$page = max ( 1, intval ( $this->uri->segment ( 4 ) ) );
			$pagesize = 15;
			$startindex = ($page - 1) * $pagesize;
			$doinglist = $this->doing_model->list_by_type ( "my", $userid, $startindex, $pagesize );
			$rownum = $this->doing_model->rownum_by_type ( "my", $userid );

			$is_followed = $this->user_model->is_followed ( $member ['uid'], $this->user ['uid'] );

			$departstr = page ( $rownum, $pagesize, $page, "user/space/$userid" );

			$answerlist = $this->answer_model->list_by_uid ( $userid, 'all', $startindex, $pagesize );
			$questionlist = $this->question_model->list_by_uid ( $userid, 'all', $startindex, $pagesize );
			$topiclist = $this->topic_model->get_list_byuid ( $userid, $startindex, $pagesize );
			$followerlist = $this->user_model->get_follower ( $userid, $startindex, $pagesize );
			$attentionlist = $this->user_model->get_attention ( $userid, $startindex, $pagesize );

			$navtitle = $member ['username'] . $navtitle;
			$seo_description = $member ['username'] . '，' . $member ['introduction'] . '，' . $member ['signature'];
			$seo_keywords = $member ['username'];
			include template ( 'space' );
		} else {

			header ( 'HTTP/1.1 404 Not Found' );
			header ( "status: 404 Not Found" );
			echo '<!DOCTYPE html><html><head><meta charset=utf-8 /><title>404-您访问的页面不存在</title>';
			echo "<style>body { background-color: #ECECEC; font-family: 'Open Sans', sans-serif;font-size: 14px; color: #3c3c3c;}";
			echo ".nullpage p:first-child {text-align: center; font-size: 150px;  font-weight: bold;  line-height: 100px; letter-spacing: 5px; color: #fff;}";
			echo ".nullpage p:not(:first-child) {text-align: center;color: #666;";
			echo "font-family: cursive;font-size: 20px;text-shadow: 0 1px 0 #fff;  letter-spacing: 1px;line-height: 2em;margin-top: -50px;}";
			echo ".nullpage p a{margin-left:10px;font-size:20px;}";
			echo '</style></head><body> <div class="nullpage"><p><span>4</span><span>0</span><span>4</span></p><p>抱歉，该用户个人空间不存在！⊂((δ⊥δ))⊃<a href="/">返回主页</a></p></div></body></html>';
			exit ();
		}
	}

	// 0总排行、1上周排行 、2上月排行
	//user/scorelist/1/
	function scorelist() {
		$navtitle = "乐帮排行榜";
		$seo_description = "乐帮排行榜展示问答最活跃的用户列表，包括达人财富榜，并推荐最新文章和关注问题排行榜。";
		$seo_keywords = "活跃用户,达人财富,最新文章推荐,关注问题排行榜";
		$type = null !== $this->uri->segment ( 3 ) ? $this->uri->segment ( 3 ) : 0;
		$userlist = $this->user_model->list_by_credit ( $type, 100 );

		$useractivelistlist = $this->user_model->get_active_list ( 0, 6 );
		$usercount = count ( $userlist );
		include template ( 'scorelist' );
	}

	function activelist() {
		$cid = intval ( $this->uri->segment ( 3 ) ) ? $this->uri->segment ( 3 ) : 'all'; //分类id
		$status = null !== $this->uri->segment ( 4 ) ? $this->uri->segment ( 4 ) : 'all'; //排序


		if ($cid != 'all') {
			$category = $this->category [$cid]; //得到分类信息
			$navtitle = $category ['name'] . "专家列表";
			$cfield = 'cid' . $category ['grade'];
		} else {
			$category ['name'] = '';
			$category ['id'] = 'all';
			$cfield = '';
			$category ['pid'] = 0;
		}
		if ($cid != 'all') {
			$category = $this->category_model->get ( $cid );
		}

		$sublist = $this->category_model->list_by_cid_pid ( $cid, $category ['pid'] ); //获取子分类
		$page = max ( 1, intval ( $this->uri->segment ( 5 ) ) );
		$pagesize = $this->setting ['list_default'];
		$startindex = ($page - 1) * $pagesize;
		$userlist = $this->user_model->get_active_list ( $startindex, $pagesize, $cid, $status );
		$answertop = $this->user_model->get_answer_top ();
		$orderwhere = '';
		switch ($status) {
			case 'all' : //全部
				$orderwhere = '';
				break;
			case '1' : //付费
				$orderwhere = ' and mypay>0 ';
				break;
			case '2' : //免费
				$orderwhere = " and mypay=0 ";
				break;
		}
		$rownum = $cid == 'all' ? returnarraynum ( $this->db->query ( getwheresql ( 'user', " 1=1 " . $orderwhere, $this->db->dbprefix ) )->row_array () ) : returnarraynum ( $this->db->query ( getwheresql ( 'user', " 1=1 " . $orderwhere . "and uid IN (SELECT uid FROM " . $this->db->dbprefix . "user_category WHERE cid=$cid)", $this->db->dbprefix ) )->row_array () );
		$departstr = page ( $rownum, $pagesize, $page, "user/activelist/$cid/$status" );
		if ($page == 1) {
			$navtitle = "站点用户活跃度列表";
		} else {
			$navtitle = "站点用户列表" . "_第" . $page . "页";
		}
		$userarticle = $this->topic_model->get_user_articles ( 0, 5 );
		$seo_description = "站点用户列表，根据用户活跃度展示用户排序。";
		$seo_keywords = "站点用户列表";
		include template ( "activelist" );
	}
	function checkemail() {

		// if(isset($_COOKIE["useremailcheck"])){


		$uid = intval ( $this->uri->segment ( 3 ) );
		$activecode = strip_tags ( $this->uri->segment ( 4 ) );
		$user = $this->user_model->get_by_uid ( $uid );
		if ($user ['active'] == 1) {
			$this->user_model->logout ();
			$this->message ( "您的邮箱已激活过，请勿重复激活!", 'index' );
		}

		$this->user_model->logout ();

		if ($user ['activecode'] == $activecode) {
			//if ($this->setting["ucenter_open"]) {
			//$this->load("ucenter");
			///$_ENV['ucenter']->uppass($user['username'], $user['password'], $user['password'], $user['email'],1);


			//}
			$this->user_model->update_useractive ( $uid );
			$this->message ( "邮箱激活成功!", 'index' );
		} else {
			$this->message ( "邮箱激活失败!", 'index' );
		}

		// }else{
	//	$this->message("邮箱激活已经过期!");
	// }


	}
	//发送邮件验证
	function sendcheckmail() {

		if ($this->user ['uid'] > 0) {
			if ($this->user ['active'] == 1) {
				exit ( "您激活过邮箱了,您是不是想修改邮箱!" );
			}
			if ($_COOKIE ['emailsend'] != null) {
				exit ( "已发送过激活邮箱，请1分钟之后再试，不要恶意发送!" );
			}
			$email = $this->user ['email'];
			if (isset ( $this->user ['email'] ) && $this->user ['email'] != "") {
				$sitename = $this->setting ['site_name'];

				//if(isset($this->setting['register_on'])&&$this->setting['register_on']=='1'){


				$activecode = md5 ( rand ( 10000, 50000 ) );
				$url = SITE_URL . 'index.php?user/checkemail/' . $this->user ['uid'] . '/' . $activecode;
				$message = "这是一封来自$sitename邮箱验证，<a target='_blank' href='$url'>请点击此处验证邮箱邮箱账号</a>";
				$v = md5 ( "yanzhengask2email" );
				$v1 = md5 ( "yanzhengask2time" );
				setcookie ( "emailsend" );
				setcookie ( "useremailcheck" );
				setcookie ( "emailsend", "OKadmin", time () - 1 );
				setcookie ( "emailsend", "OKadmin", 0 ); //浏览器关闭 是自动失效
				setcookie ( "useremailcheck", "OKadmin", time () - 1 );
				setcookie ( "useremailcheck", "OKadmin", 0 ); //浏览器关闭 是自动失效
				$expire1 = time () + 60; // 设置1分钟的有效期
				setcookie ( "emailsend", $v1, $expire1 ); // 设置一个名字为var_name的cookie，并制定了有效期
				$expire = time () + 86400; // 设置24小时的有效期
				setcookie ( "useremailcheck", $v, $expire ); // 设置一个名字为var_name的cookie，并制定了有效期
				$this->user_model->update_emailandactive ( $email, $activecode, $this->user ['uid'] );
				$this->user_model->refresh ( $this->user ['uid'], 1 );
				sendmailto ( $email, "邮箱验证提醒-$sitename", $message, $this->user ['username'] );
				exit ( "邮箱验证发送成功，24小时之内请进行邮箱验证，在您没激活邮件之前你不能发布问题和文章等操作！" );

		//}else{
			//exit("网站还没做邮箱配置或者开启邮箱注册!");
			//}
			} else {
				exit ( "您还没设置过邮箱，请先使用修改邮箱功能!" );
			}
		} else {
			exit ( "您还没登陆!" );
		}

	}

	//邮箱激活验证
	function vertifyemail() {
		//验证是否登录
		if ($this->user ['uid'] == 0) {
			$this->message ( "您还没登陆！", 'index' );
		}
		//验证是否设置过邮箱
		if (trim ( $this->user ['email'] ) == '' || ! isset ( $this->user ['email'] )) {
			$this->message ( "您还没设置过邮箱！", 'user/editemail' );
		}

		if ($this->user ['active'] == 1) {
			$this->message ( "您的邮箱已经激活过！", 'index' );
		}

		if ($this->user ['activecode'] == '' || $this->user ['activecode'] == 0 || $this->user ['activecode'] == null) {
			$sitename = $this->setting ['site_name'];
			$email = $this->user ['email'];
			$activecode = md5 ( rand ( 10000, 50000 ) );
			$url = SITE_URL . 'index.php?user/checkemail/' . $this->user ['uid'] . '/' . $activecode;
			$message = "这是一封来自$sitename邮箱验证，<a target='_blank' href='$url'>请点击此处验证邮箱邮箱账号</a>";
			$v = md5 ( "yanzhengask2email" );
			$v1 = md5 ( "yanzhengask2time" );
			setcookie ( "emailsend" );
			setcookie ( "useremailcheck" );
			$expire1 = time () + 60; // 设置1分钟的有效期
			setcookie ( "emailsend", $v1, $expire1 ); // 设置一个名字为var_name的cookie，并制定了有效期
			$expire = time () + 86400; // 设置24小时的有效期
			setcookie ( "useremailcheck", $v, $expire ); // 设置一个名字为var_name的cookie，并制定了有效期
			$this->user_model->update_emailandactive ( $email, $activecode, $this->user ['uid'] );
			$this->user_model->refresh ( $this->user ['uid'], 1 );
			sendmailto ( $email, "邮箱验证提醒-$sitename", $message, $this->user ['username'] );

		}
		include template ( "vertifyemail" );

	}
	//修改手机号码
	function editphone() {

		if ($this->user ['uid'] == 0) {
			$this->message ( "您还没登陆！", 'BACK' );
		}

		session_start ();
		if ($this->input->post ( 'submit' )) {

			if (strtolower ( trim ( $this->input->post ( 'code' ) ) ) != $this->user_model->get_code ()) {
				$this->message ( $this->input->post ( 'state' ) . "验证码错误!", 'BACK' );
			}
			$userphone = trim ( $this->input->post ( 'userphone' ) );
			if (empty ( $userphone )) {
				$this->message ( "抱歉，手机号不能为空！", 'BACK' );
			}
			if ($this->user ['isblack'] == 1) {
				$this->message ( "您是黑名单用户，无法激活手机号码！", 'BACK' );
			}
			$userone = $this->user_model->get_by_phone ( $userphone );

			if ($this->user ['phone'] == '') {
				//手机号为空，新增手机号，如果发现同名手机号，提示手机号存在
				if ($userone) {
					$this->message ( "这个手机号码已经存在！", 'BACK' );
				}
			} else {
				//如果用户手机号存在且查到手机号和自己的不同
				if ($userone && $userone ['uid'] != $this->user ['uid']) {
					$this->message ( "这个手机号码已经存在！", 'BACK' );
				}
			}
			$this->user_model->updatephone ( $this->user ['uid'], $userphone );
			$this->message ( "手机号码激活成功！" );
		}
	}
	//邀请我回答
	function invateme() {
		if ($this->user ['uid'] == 0) {
			$this->message ( "您还没登陆！", 'BACK' );
		}

		$navtitle = "邀请我回答的问题";
		$seo_description = "";
		$seo_keywords = "";
		@$page = max ( 1, intval ( $this->uri->segment ( 3 ) ) );
		$pagesize = $this->setting ['list_default'];
		$startindex = ($page - 1) * $pagesize;
		$condition = " askuid=" . $this->user ['uid'];
		$rownum = returnarraynum ( $this->db->query ( getwheresql ( 'question', $condition, $this->db->dbprefix ) )->row_array () );

		$questionlist = $this->question_model->list_by_condition ( $condition, $startindex, $pagesize );

		$departstr = page ( $rownum, $pagesize, $page, "user/invateme" );
		include template ( 'invatemequestion' );
	}
	/*
     *
     * 修改邮箱
     */
	function editemail() {

		$navtitle = "修改邮箱";
		if ($this->user ['uid'] == 0) {
			$this->message ( "您还没登陆！", 'BACK' );
		}

		if ($this->input->post ( 'submit' )) {

			if (strtolower ( trim ( $this->input->post ( 'code' ) ) ) != $this->user_model->get_code ()) {
				$this->message ( $this->input->post ( 'state' ) . "验证码错误!", 'BACK' );
			}

			$email = trim ( $this->input->post ( 'email' ) );
			if (empty ( $email )) {
				$this->message ( "抱歉，邮箱不能为空！", 'BACK' );
			}
			$emailaccess = $this->user_model->check_emailaccess ( $email );
			if (FALSE == $emailaccess) {
				$this->message ( "邮箱后缀被系统列入黑名单，禁止注册!", "BACK" );
			}
			$euser = $this->user_model->get_by_email ( $email );
			if (is_array ( $euser )) {
				$this->message ( "此邮箱已经被注册了!", "BACK" );
			}

			if ($this->user ['email'] != $email) {

				$sitename = $this->setting ['site_name'];

				if (isset ( $this->setting ['register_on'] ) && $this->setting ['register_on'] == '1') {

					$activecode = md5 ( rand ( 10000, 50000 ) );
					$url = SITE_URL . 'index.php?user/checkemail/' . $this->user ['uid'] . '/' . $activecode;
					$message = "这是一封来自$sitename邮箱验证，<a target='_blank' href='$url'>请点击此处验证邮箱邮箱账号</a>";
					$v = md5 ( "yanzhengask2email" );
					$v1 = md5 ( "yanzhengask2time" );
					setcookie ( "emailsend" );
					setcookie ( "useremailcheck" );
					$expire1 = time () + 60; // 设置1分钟的有效期
					setcookie ( "emailsend", $v1, $expire1 ); // 设置一个名字为var_name的cookie，并制定了有效期
					$expire = time () + 86400; // 设置24小时的有效期
					setcookie ( "useremailcheck", $v, $expire ); // 设置一个名字为var_name的cookie，并制定了有效期
					$this->user_model->update_emailandactive ( $email, $activecode, $this->user ['uid'] );
					$this->user_model->refresh ( $this->user ['uid'], 1 );
					sendmailto ( $email, "邮箱验证提醒-$sitename", $message, $this->user ['username'] );

					$this->message ( "邮箱验证发送成功，24小时之内请进行邮箱验证，在您没激活邮件之前你不能发布问题和文章等操作！", 'BACK' );
				} else {
					$this->user_model->update_email ( $email, $this->user ['uid'] );
					$this->user_model->refresh ( $this->user ['uid'], 1 );
					$this->message ( "邮箱修改成功，站长没有配置邮箱验证", 'BACK' );
				}

			}

		}
		$_SESSION ["formkey"] = getRandChar ( 56 );
		include template ( "editemail" );
	}
	function editimg() {
		$navtitle = "修改个人头像";
		if (isset ( $_FILES ["userimage"] )) {
			$uid = intval ( $this->uri->segment ( 3 ) );

			$avatardir = "/data/avatar/";
			$extname = extname ( $_FILES ["userimage"] ["name"] );
			if (! isimage ( $extname ))
				$this->message ( "图片扩展名不正确!", 'user/editimg' );
			$upload_tmp_file = FCPATH . 'data/tmp/user_avatar_' . $uid . '.' . $extname;
			$uid = abs ( $uid );
			$uid = sprintf ( "%09d", $uid );
			$dir1 = $avatardir . substr ( $uid, 0, 3 );
			$dir2 = $dir1 . '/' . substr ( $uid, 3, 2 );
			$dir3 = $dir2 . '/' . substr ( $uid, 5, 2 );
			(! is_dir ( FCPATH . $dir1 )) && forcemkdir ( FCPATH . $dir1 );
			(! is_dir ( FCPATH . $dir2 )) && forcemkdir ( FCPATH . $dir2 );
			(! is_dir ( FCPATH . $dir3 )) && forcemkdir ( FCPATH . $dir3 );
			$smallimg = $dir3 . "/small_" . $uid . '.' . $extname;
			if (move_uploaded_file ( $_FILES ["userimage"] ["tmp_name"], $upload_tmp_file )) {
				$avatar_dir = glob ( FCPATH . $dir3 . "/small_{$uid}.*" );
				foreach ( $avatar_dir as $imgfile ) {
					if (strtolower ( $extname ) != extname ( $imgfile ))
						unlink ( $imgfile );
				}
				image_resize ( $upload_tmp_file, FCPATH . $smallimg, 85, 85, 1 );
				$this->message ( '修改头像成功', 'user/index' );
			}

		} else {
			if ($this->setting ["ucenter_open"]) {
				$this->load->model ( 'ucenter_model' );
				$imgstr = $this->ucenter_model->set_avatar ( $this->user ['uid'] );
			}

		}

		include template ( "editimg" );
	}

	function mycategory() {
		$this->load->model ( "category_model" );
		$categoryjs = $this->category_model->get_js ();
		$qqlogin = $this->user_model->get_login_auth ( $this->user ['uid'], 'qq' );
		$sinalogin = $this->user_model->get_login_auth ( $this->user ['uid'], 'sina' );
		include template ( "mycategory" );
	}

	//解除绑定
	function unchainauth() {
		$type = ($this->uri->segment ( 3 ) == 'qq') ? 'qq' : 'sina';
		$this->user_model->remove_login_auth ( $this->user ['uid'], $type );
		$this->message ( $type . "绑定解除成功!", 'user/mycategory' );
	}

	function ajaxcategory() {
		$cid = intval ( $this->input->post ( 'cid' ) );
		if ($cid && $this->user ['uid']) {
			foreach ( $this->user ['category'] as $category ) {
				if ($category ['cid'] == $cid) {
					exit ();
				}
			}
			//如果超过当前最大分类选择数就终止
			if ($this->setting ['cansetcatnum'] == null || trim ( $this->setting ['cansetcatnum'] ) == '')
				$this->setting ['cansetcatnum'] = '1';
			if (count ( $this->user ['category'] ) > $this->setting ['cansetcatnum']) {
				exit ();
			}
			$this->user_model->add_category ( $cid, $this->user ['uid'] );
		}
	}

	function ajaxdeletecategory() {
		$cid = intval ( $this->input->post ( 'cid' ) );
		if ($cid && $this->user ['uid']) {
			$this->user_model->remove_category ( $cid, $this->user ['uid'] );
		}
	}

	function ajaxpoplogin() {
		$forward = isset ( $_SERVER ['HTTP_REFERER'] ) ? $_SERVER ['HTTP_REFERER'] : SITE_URL;
		if (! isset ( $_SESSION )) {
			session_start ();
		}
		$_SESSION ['logintokenid'] = md5 ( time () );
		include template ( "poplogin" );
	}

	/* 用户查看下详细信息 */

	function ajaxuserinfo() {
		$uid = intval ( $this->uri->segment ( 3 ) );
		if ($uid) {
			$userinfo = $this->user_model->get_by_uid ( $uid, 1 );
			$is_followed = $this->user_model->is_followed ( $userinfo ['uid'], $this->user ['uid'] );
			$userinfo_group = $this->usergroup [$userinfo ['groupid']];
			include template ( "usercard" );
		}
	}

	function ajaxloadmessage() {

		$uid = $this->user ['uid'];
		if ($uid == 0) {
			return;
		}
		$user_categorys = $this->user ['category'] && array_per_fields ( $this->user ['category'], 'cid' );
		$message = array ();
		$this->load->model ( 'message_model' );
		$message ['msg_system'] = returnarraynum ( $this->db->query ( getwheresql ( 'message', " new=1 AND touid=$uid AND fromuid<>$uid AND fromuid=0 AND status<>2", $this->db->dbprefix ) )->row_array () );
		$message ['msg_personal'] = returnarraynum ( $this->db->query ( getwheresql ( 'message', " new=1 AND touid=$uid AND fromuid<>$uid AND fromuid<>0 AND status<>2", $this->db->dbprefix ) )->row_array () );
		$message ['message_recommand'] = $this->message_model->rownum_user_recommend ( $uid, $user_categorys, 'notread' );
		echo tjson_encode ( $message );

		exit ();
	}

	//关注用户
	function attentto() {
		$navtitle = "我关注的用户";
		$uid = intval ( $this->input->post ( 'uid' ) );
		if (! $uid) {
			exit ( 'error' );
		}

		$is_followed = $this->user_model->is_followed ( $uid, $this->user ['uid'] );
		if ($is_followed) {

			$this->user_model->unfollow ( $uid, $this->user ['uid'], 'user' );
			$this->load->model ( "doing_model" );
			$this->doing_model->deletedoing ( $this->user ['uid'], 11, $uid );
		} else {
			if ($uid == $this->user ['uid']) {
				exit ( 'self' );
			}
			$this->user_model->follow ( $uid, $this->user ['uid'], $this->user ['username'], 'user' );
			$quser = $this->user_model->get_by_uid ( $uid );
			$this->load->model ( "doing_model" );
			$this->doing_model->add ( $this->user ['uid'], $this->user ['username'], 11, $uid, $quser ['username'] );
			$msgfrom = $this->setting ['site_name'] . '管理员';
			$username = addslashes ( $this->user ['username'] );
			$this->load->model ( "message_model" );
			$this->message_model->add ( $msgfrom, 0, $uid, $username . "刚刚关注了您", '<a target="_blank" href="' . url ( 'user/space/' . $this->user ['uid'], 1 ) . '">' . $username . '</a> 刚刚关注了您!<br /> <a href="' . url ( 'user/follower', 1 ) . '">点击查看</a>' );
		}
		exit ( 'ok' );
	}
	function myjifen() {
		$navtitle = "我的积分详情";
		if ($this->user ['uid'] <= 0) {
			$this->message ( "请先登录", 'user/login' );
		}
		//获取我的积分列表
		$page = max ( 1, intval ( $this->uri->segment ( 3 ) ) );
		$pagesize = $this->setting ['list_default'];
		$startindex = ($page - 1) * $pagesize;
		$jifenlist = $this->user_model->credit_detail ( $this->user ['uid'], $startindex, $pagesize );
		$rownum = returnarraynum ( $this->db->query ( getwheresql ( 'credit', " uid={$this->user['uid']}", $this->db->dbprefix ) )->row_array () );
		$departstr = page ( $rownum, $pagesize, $page, "user/myjifen" );
		//
		include template ( "myjifen" );
	}
	function invatelist() {
		$navtitle = "我邀请注册的用户列表";
		if ($this->user ['uid'] <= 0) {
			$this->message ( "请先登录", 'user/login' );
		}
		//获取我的邀请注册的用户列表
		$page = max ( 1, intval ( $this->uri->segment ( 3 ) ) );
		$pagesize = $this->setting ['list_default'];
		$startindex = ($page - 1) * $pagesize;
		$followerlist = $this->user_model->getinvatelist ( $this->user ['invatecode'], $startindex, $pagesize  );
		$rownum = returnarraynum ( $this->db->query ( getwheresql ( 'user', " frominvatecode='{$this->user ['invatecode']}'", $this->db->dbprefix ) )->row_array () );
		$departstr = page ( $rownum, $pagesize, $page, "user/invatelist" );
		include template ( "invatelist" );
	}
}

?>