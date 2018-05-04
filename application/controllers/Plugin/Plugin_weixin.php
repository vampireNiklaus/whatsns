<?php

defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class Plugin_weixin extends CI_Controller {

	var $whitelist;

	function __construct() {
		$this->whitelist = "index,login,wxauth";
		parent::__construct ();
		$this->load->model ( 'weixin_setting_model' );
		$this->load->model ( 'weixin_info_model' );
		$this->load->model ( 'user_model' );
	}

	function index() {
		exit ( "Access Denied" );
	}

	function login() {

		require FCPATH . 'lib' . DIRECTORY_SEPARATOR . 'php' . DIRECTORY_SEPARATOR . 'jssdk.php';
		$wx = $this->weixin_setting_model->get ();

		if (empty ( $wx ['appsecret'] ) || empty ( $wx ['appid'] )) {
			exit ( "公众号配置中 appid和appsecret没有填写，创建菜单必须认证公众号!" );
		}

		$appid = $wx ['appid'];
		$appsecret = $wx ['appsecret'];

		$weixin = new JSSDK ( $appid, $appsecret );

		if (isset ( $_GET ['code'] )) {
			$oauth2Url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=$appid&secret=$appsecret&code=" . $_GET ['code'] . "&grant_type=authorization_code";

			$oauth2 = $this->getJson ( $oauth2Url );

			//   $res = $weixin->https_request($url);


			//  $res=(json_decode($res, true));
			$access_token = $oauth2 ["access_token"];
			$refresh_token = $oauth2 ["refresh_token"];
			$openid = $oauth2 ['openid'];
			$get_user_info_url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=$access_token&openid=$openid&lang=zh_CN";
			// $row=$weixin->get_user_info($res['openid']);
			$userinfo = $this->getJson ( $get_user_info_url );

			if ($userinfo ['errcode'] == '40001' || $oauth2 ['errcode'] == '40029') {
				$refreshtoken = "https://api.weixin.qq.com/sns/oauth2/refresh_token?appid=$appid&grant_type=refresh_token&refresh_token=$refresh_token ";
				$oauth2 = $this->getJson ( $refreshtoken );

				$access_token = $oauth2 ["access_token"];

				$openid = $oauth2 ['openid'];
				$get_user_info_url = "https://api.weixin.qq.com/sns/userinfo?access_token=$access_token&openid=$openid&lang=zh_CN ";
				// $row=$weixin->get_user_info($res['openid']);
				$userinfo = $this->getJson ( $get_user_info_url );
			}

			if ($userinfo ['openid']) {
				$model = $this->weixin_info_model->f_get ( $userinfo ['openid'] );
				if ($model) {
					$this->weixin_info_model->f_update ( $userinfo );
				} else {
					$this->weixin_info_model->f_insert ( $userinfo );
				}


				$_tmp_user = $this->user_model->get_by_openid ( $userinfo ['openid'] );

				$hduid = $_tmp_user ['uid'];
				if (! $_tmp_user) {
					$rurl = SITE_URL . $this->setting ['seo_prefix'] .'account/bindregister/' . $openid . $this->config->item ( 'url_suffix' );

					header ( "Location:$rurl" );

		// $hduid=$_ENV['user']->weixinadd($userinfo['nickname'],'123456',$userinfo['openid']);
				}
				$hduid = intval ( $hduid );
				$avatardir = "/data/avatar/";
				$extname = 'jpg';
				$upload_tmp_file = FCPATH . '/data/tmp/user_avatar_' . $hduid . '.' . $extname;
				$hduid = abs ( $hduid );
				$hduid = sprintf ( "%09d", $hduid );
				$dir1 = $avatardir . substr ( $hduid, 0, 3 );
				$dir2 = $dir1 . '/' . substr ( $hduid, 3, 2 );
				$dir3 = $dir2 . '/' . substr ( $hduid, 5, 2 );
				(! is_dir ( FCPATH . $dir1 )) && forcemkdir ( FCPATH . $dir1 );
				(! is_dir ( FCPATH . $dir2 )) && forcemkdir ( FCPATH . $dir2 );
				(! is_dir ( FCPATH . $dir3 )) && forcemkdir ( FCPATH . $dir3 );

				$smallimg = $dir3 . "/small_" . $hduid . '.' . $extname;
				$smallimgdir = $dir3 . "/";
				// get_remote_image($userinfo['headimgurl'],FCPATH . $smallimgdir."small_" . $hduid . '.' . $extname);
				//$this->getImage($userinfo['headimgurl'],"small_" . $hduid . '.' . $extname, FCPATH . $smallimgdir, array('jpg','jpeg','png', 'gif'));
				$cookietime = 2592000;
				$this->user_model->refresh ( $hduid, 1, $cookietime );

				$this->message ( '登陆成功!', 'index' );
			} else {
				$this->message ( '授权出错,请重新授权!' );
			}

		} else {

			$this->message ( '授权出错,没有CODE,请重新授权!' );
		}
	}
	function wxauth() {
		$wx = $this->weixin_setting_model->get ();

		if (empty ( $wx ['appsecret'] ) || empty ( $wx ['appid'] )) {
			exit ( "公众号配置中 appid和appsecret没有填写，创建菜单必须认证公众号!" );
		}

		$appid = $wx ['appid'];
		$appsecret = $wx ['appsecret'];
		$rurl = SITE_URL . $this->setting ['seo_prefix'] . 'plugin_weixin/login' . $this->config->item ( 'url_suffix' );
		$url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=$appid&redirect_uri=$rurl&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect";

		header ( "Location:$url" );
	}
	function getImage($url, $filename = '', $dirName, $fileType, $type = 0) {
		if ($url == '') {
			return false;
		}
		//获取文件原文件名
		$defaultFileName = basename ( $url );
		//获取文件类型
		// $suffix = substr(strrchr($url,'.'), 1);
		//if(!in_array($suffix, $fileType)){
		// return false;
		// }
		//设置保存后的文件名
		//  $filename = $filename == '' ? time().rand(0,9).'.'.$suffix : $defaultFileName;


		//获取远程文件资源
		if ($type) {
			$ch = curl_init ();
			$timeout = 5;
			curl_setopt ( $ch, CURLOPT_URL, $url );
			curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
			curl_setopt ( $ch, CURLOPT_CONNECTTIMEOUT, $timeout );
			$file = curl_exec ( $ch );
			curl_close ( $ch );
		} else {
			ob_start ();
			readfile ( $url );
			$file = ob_get_contents ();
			ob_end_clean ();
		}
		//设置文件保存路径
		// $dirName = $dirName.'/'.date('Y', time()).'/'.date('m', time()).'/'.date('d',time()).'/';
		if (! file_exists ( $dirName )) {
			mkdir ( $dirName, 0777, true );
		}
		//保存文件
		$res = fopen ( $dirName . $filename, 'a' );
		fwrite ( $res, $file );
		fclose ( $res );
		return "{'fileName':$filename, 'saveDir':$dirName}";
	}
	function getJson($url) {
		$curl = curl_init ();
		curl_setopt ( $curl, CURLOPT_RETURNTRANSFER, true );
		curl_setopt ( $curl, CURLOPT_TIMEOUT, 500 );
		// 为保证第三方服务器与微信服务器之间数据传输的安全性，所有微信接口采用https方式调用，必须使用下面2行代码打开ssl安全校验。
		// 如果在部署过程中代码在此处验证失败，请到 http://curl.haxx.se/ca/cacert.pem 下载新的证书判别文件。


		curl_setopt ( $curl, CURLOPT_SSL_VERIFYPEER, FALSE );
		curl_setopt ( $curl, CURLOPT_SSL_VERIFYHOST, FALSE );
		curl_setopt ( $curl, CURLOPT_URL, $url );

		$res = curl_exec ( $curl );
		curl_close ( $curl );

		return json_decode ( $res, true );
	}

}

?>