<?php

defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class Attach extends CI_Controller {
	var $whitelist;
	function __construct() {
		$this->whitelist = "upimg";
		parent::__construct ();
		$this->load->model ( 'attach_model' );

	}

	function upload() {
		if ($this->user ['uid'] <= 0) {

			echo "{'state':'禁止匿名操作！','url':'null','fileType':'null'}";
			exit ();

		}
		//上传配置
		$config = array ("uploadPath" => "data/attach/", //保存路径
"fileType" => array (".rar", ".doc", ".docx", ".zip", ".pdf", ".txt", ".swf", ".wmv", "xsl" ), //文件允许格式
"fileSize" => 10 )//文件大小限制，单位MB
;

		//文件上传状态,当成功时返回SUCCESS，其余值将直接返回对应字符窜
		$state = "SUCCESS";
		$clientFile = $_FILES ["upfile"];

		if (! isset ( $clientFile )) {
			echo "{'state':'文件大小超出服务器配置！','url':'null','fileType':'null'}"; //请修改php.ini中的upload_max_filesize和post_max_size
			exit ();
		}
		//$clientFile["name"]
		if ($this->checkattackfile ( $clientFile ["name"] )) {
			echo "{'state':'文件名存在sql注入！','url':'null','fileType':'null'}";
			exit ();
		}
		if (preg_match ( "/[\',:;*?~`!@#$%^&+=)(<>{}]|\]|\[|\/|\\\|\"|\|/", $clientFile ["name"] )) { //不允许特殊字符
			echo "{'state':'文件名不合法！','url':'null','fileType':'null'}";
			exit ();
		}
		//格式验证
		$current_type = strtolower ( strrchr ( $clientFile ["name"], '.' ) );
		if (! in_array ( $current_type, $config ['fileType'] )) {
			$state = "不支持的文件类型！";
		}
		//大小验证
		$file_size = 1024 * 1024 * $config ['fileSize'];
		if ($clientFile ["size"] > $file_size) {
			$state = "文件大小超出限制！";
		}
		//保存文件
		if ($state == "SUCCESS") {
			$targetfile = $config ['uploadPath'] . gmdate ( 'ym', time() ) . '/' . random ( 8 ) . strrchr ( $clientFile ["name"], '.' );
			$result = $this->attach_model->movetmpfile ( $clientFile, $targetfile );
			if (! $result) {
				$state = "文件保存失败！";
			} else {
				$this->attach_model->add ( $clientFile ["name"], $current_type, $clientFile ["size"], $targetfile, 0 );
			}
		}

		//向浏览器返回数据json数据
		echo '{"state":"' . $state . '","url":"' . $targetfile . '","fileType":"' . $current_type . '","original":"' . $clientFile ["name"] . '"}';
	}
	function checkattackfile($reqarr, $reqtype = 'post') {
		$filtertable = array ('get' => 'sleep\s*?\(.*\)|\'|(and|or)\\b.+?(>|<|=|in|like)|\\/\\*.+?\\*\\/|<\\s*script\\b|\\bEXEC\\b|UNION.+?SELECT|UPDATE.+?SET|INSERT\\s+INTO.+?VALUES|(SELECT|DELETE).+?FROM|(CREATE|ALTER|DROP|TRUNCATE)\\s+(TABLE|DATABASE)', 'post' => 'sleep\s*?\(.*\)|\\b(and|or)\\b.{1,6}?(=|>|<|\\bin\\b|\\blike\\b)|\\/\\*.+?\\*\\/|<\\s\\b|\\bEXEC\\b|UNION.+?SELECT|UPDATE.+?SET|INSERT\\s+INTO.+?VALUES|(SELECT|DELETE).+?FROM|(CREATE|ALTER|DROP|TRUNCATE)\\s+(TABLE|DATABASE)', 'cookie' => 'sleep\s*?\(.*\)|\\b(and|or)\\b.{1,6}?(=|>|<|\\bin\\b|\\blike\\b)|\\/\\*.+?\\*\\/|<\\s*script\\b|\\bEXEC\\b|UNION.+?SELECT|UPDATE.+?SET|INSERT\\s+INTO.+?VALUES|(SELECT|DELETE).+?FROM|(CREATE|ALTER|DROP|TRUNCATE)\\s+(TABLE|DATABASE)' );

		if (is_array ( $reqarr )) {
			foreach ( $reqarr as $reqkey => $reqvalue ) {

				if (is_array ( $reqvalue )) {

					checkattack ( $reqvalue, $reqtype );
				}

				if (preg_match ( "/" . $filtertable [$reqtype] . "/is", $reqvalue ) == 1 && ! in_array ( $reqkey, array ('content' ) )) {
					return false;
				}
				return true;

			}
		}

	}
	function upimg() {
		if ($this->user ['uid'] <= 0) {

			echo 'error|禁止匿名操作';
			exit ();

		}
		//上传配置
		$config = array ("uploadPath" => "data/attach/", //保存路径
"fileType" => array (".png", ".jpg", ".jpeg", ".bmp" ), "fileSize" => 2048 );

		if ($_FILES ['wangEditorMobileFile'] != null) {
			$iswapeditor = true;
			$file = $_FILES ['wangEditorMobileFile'];
		} else {
			echo 'error|没上传文件';
			exit ();
		}
		//文件上传状态,当成功时返回SUCCESS，其余值将直接返回对应字符窜并显示在图片预览框，同时可以在前端页面通过回调函数获取对应字符窜
		$state = "SUCCESS";
		//格式验证
		$current_type = strtolower(strrchr($file["name"], '.'));
        if (!in_array($current_type, $config['fileType'])) {
            $state = $current_type;
             echo 'error|图片类型不对'.$_FILES['wangEditorMobileFile'];
               exit();
        }


		//大小验证
		$file_size = 1024 * $config ['fileSize'];
		if ($file ["size"] > $file_size) {
			$state = "b";
			echo 'error|图片大小不对最大支持:' . $file_size . '当前上传大小:' . $file ["size"];
			exit ();
		}

		if ($this->checkattackfile ( $file ["name"] )) {
			echo 'error|dont sql inject';
			exit ();
		}
		if (preg_match ( "/[\',:;*?~`!@#$%^&+=)(<>{}]|\]|\[|\/|\\\|\"|\|/", $file ["name"] )) { //不允许特殊字符
			echo 'error|文件名不合法';
			exit ();
		}
		//保存图片
		if ($state == "SUCCESS") {
			$targetfile = $config ['uploadPath'] . gmdate ( 'ym', time() ) . '/' . random ( 8 ) . strrchr ( $file ["name"], '.' );
			$result = $this->attach_model->movetmpfile ( $file, $targetfile );
			if (! $result) {
				echo 'error|上传失败';
				exit ();
			} else {
				$this->attach_model->add ( $file ["name"], $current_type, $file ["size"], $targetfile );
			}
		} else {
			echo 'error|图片大小或者类型不对';
			exit ();
		}
		//runlog('fileimg', FCPATH.'/'.$targetfile);
		$this->watermark ( FCPATH . '/' . $targetfile, FCPATH . '/' . $targetfile );
		try {
			require_once STATICPATH . 'js/neweditor/php/Config.php';
			if (Config::OPEN_OSS) {

				require_once STATICPATH . 'js/neweditor/php/up.php';
				if (Common::getOpenoss () == '1') {
					$diross = $targetfile;
					$tmpfile = $targetfile;

					if (substr ( $targetfile, 0, 1 ) == '/') {
						$diross = substr ( $targetfile, 1 );
					}
					$filepath = uploadFile ( Common::getOssClient (), Common::getBucketName (), $diross, FCPATH . $targetfile );
					if ($filepath != 'error') {
						echo $filepath;
						exit ();

					}
				}
			} else {
				echo SITE_URL . $targetfile;
				exit ();
			}
		} catch ( Exception $e ) {
			print $e->getMessage ();
		}

	}
	function uploadimage() {
		//上传配置
		$config = array ("uploadPath" => "data/attach/", //保存路径
"fileType" => array (".gif", ".png", ".jpg", ".jpeg", ".bmp" ), "fileSize" => 2048 );
		//原始文件名，表单名固定，不可配置
		$oriName = rand ( 11111111, 99999999 ); // htmlspecialchars($this->post['fileName'], ENT_QUOTES);


		//上传图片框中的描述表单名称，
		$title = "移动端图片"; //htmlspecialchars($this->post['pictitle'], ENT_QUOTES);


		//文件句柄
		$file = $_FILES ["wangEditorMobileFile"];

		//文件上传状态,当成功时返回SUCCESS，其余值将直接返回对应字符窜并显示在图片预览框，同时可以在前端页面通过回调函数获取对应字符窜
		$state = "SUCCESS";
		//格式验证
		$current_type = strtolower ( strrchr ( $file ["name"], '.' ) );
		if (! in_array ( $current_type, $config ['fileType'] )) {
			$state = $current_type;
		}
		//大小验证
		$file_size = 1024 * $config ['fileSize'];
		if ($file ["size"] > $file_size) {
			$state = "b";
		}
		if ($this->checkattackfile ( $file ["name"] )) {
			echo 'error|文件名存在sql注入';
			exit ();
		}
		//     if(preg_match("/[\'.,:;*?~`!@#$%^&+=)(<>{}]|\]|\[|\/|\\\|\"|\|/",$file["name"])){  //不允许特殊字符
		//             echo 'error|文件名不合法';
		//               exit();
		//      }
		//保存图片
		if ($state == "SUCCESS") {
			$targetfile = $config ['uploadPath'] . gmdate ( 'ym', time() ) . '/' . random ( 8 ) . strrchr ( $file ["name"], '.' );
			$result = $this->attach_model->movetmpfile ( $file, $targetfile );
			if (! $result) {
				$state = "c";
			} else {
				$this->attach_model->add ( $file ["name"], $current_type, $file ["size"], $targetfile );
			}
		}

		$this->watermark ( APPPATH . '/' . $targetfile, APPPATH . '/' . $targetfile );

		if ($state != "SUCCESS") {
			echo 'error|' . $state;
		} else {
			echo $targetfile;
		}

		//echo "{'url':'" . $targetfile . "','title':'" . $title . "','original':'" . $oriName . "','state':'" . $state . "'}";
	}
	public function watermark($source, $target = '', $w_pos = '', $w_img = '', $w_text = 'www.ask2.cn', $w_font = 10, $w_color = '#CC0000') {
		$this->w_img = FCPATH . 'static/js/neweditor/marker.png'; //水印图片
		$this->w_pos = 9;
		$this->w_minwidth = 400; //最少宽度
		$this->w_minheight = 200; //最少高度
		$this->w_quality = 80; //图像质量
		$this->w_pct = 85; //透明度
		$w_pos = $w_pos ? $w_pos : $this->w_pos;
		$w_img = $w_img ? $w_img : $this->w_img;
		if (! $this->check ( $source ))
			return false;
		if (! $target)
			$target = $source;
		$source_info = getimagesize ( $source ); //图片信息
		$source_w = $source_info [0]; //图片宽度
		$source_h = $source_info [1]; //图片高度
		if ($source_w < $this->w_minwidth || $source_h < $this->w_minheight)
			return false;
		switch ($source_info [2]) { //图片类型
			case 1 : //GIF格式
				$source_img = imagecreatefromgif ( $source );
				break;
			case 2 : //JPG格式
				$source_img = imagecreatefromjpeg ( $source );
				break;
			case 3 : //PNG格式
				$source_img = imagecreatefrompng ( $source );
				//imagealphablending($source_img,false); //关闭混色模式
				imagesavealpha ( $source_img, true ); //设置标记以在保存 PNG 图像时保存完整的 alpha 通道信息（与单一透明色相反）
				break;
			default :
				return false;
		}
		if (! empty ( $w_img ) && file_exists ( $w_img )) { //水印图片有效
			$ifwaterimage = 1; //标记
			$water_info = getimagesize ( $w_img );
			$width = $water_info [0];
			$height = $water_info [1];
			switch ($water_info [2]) {
				case 1 :
					$water_img = imagecreatefromgif ( $w_img );
					break;
				case 2 :
					$water_img = imagecreatefromjpeg ( $w_img );
					break;
				case 3 :
					$water_img = imagecreatefrompng ( $w_img );
					imagealphablending ( $water_img, false );
					imagesavealpha ( $water_img, true );
					break;
				default :
					return;
			}
		} else {
			$ifwaterimage = 0;
			$temp = imagettfbbox ( ceil ( $w_font * 2.5 ), 0, '../wt.ttf', $w_text ); //imagettfbbox返回一个含有 8 个单元的数组表示了文本外框的四个角
			$width = $temp [2] - $temp [6];
			$height = $temp [3] - $temp [7];
			unset ( $temp );
		}
		switch ($w_pos) {
			case 1 :
				$wx = 5;
				$wy = 5;
				break;
			case 2 :
				$wx = ($source_w - $width) / 2;
				$wy = 0;
				break;
			case 3 :
				$wx = $source_w - $width;
				$wy = 0;
				break;
			case 4 :
				$wx = 0;
				$wy = ($source_h - $height) / 2;
				break;
			case 5 :
				$wx = ($source_w - $width) / 2;
				$wy = ($source_h - $height) / 2;
				break;
			case 6 :
				$wx = $source_w - $width;
				$wy = ($source_h - $height) / 2;
				break;
			case 7 :
				$wx = 0;
				$wy = $source_h - $height;
				break;
			case 8 :
				$wx = ($source_w - $width) / 2;
				$wy = $source_h - $height;
				break;
			case 9 :
				$wx = $source_w - ($width + 5);
				$wy = $source_h - ($height + 5);
				break;
			case 10 :
				$wx = rand ( 0, ($source_w - $width) );
				$wy = rand ( 0, ($source_h - $height) );
				break;
			default :
				$wx = rand ( 0, ($source_w - $width) );
				$wy = rand ( 0, ($source_h - $height) );
				break;
		}
		if ($ifwaterimage) {
			if ($water_info [2] == 3) {
				imagecopy ( $source_img, $water_img, $wx, $wy, 0, 0, $width, $height );
			} else {
				imagecopymerge ( $source_img, $water_img, $wx, $wy, 0, 0, $width, $height, $this->w_pct );
			}
		} else {
			if (! empty ( $w_color ) && (strlen ( $w_color ) == 7)) {
				$r = hexdec ( substr ( $w_color, 1, 2 ) );
				$g = hexdec ( substr ( $w_color, 3, 2 ) );
				$b = hexdec ( substr ( $w_color, 5 ) );
			} else {
				return;
			}
			imagestring ( $source_img, $w_font, $wx, $wy, $w_text, imagecolorallocate ( $source_img, $r, $g, $b ) );
		}
		switch ($source_info [2]) {
			case 1 :
				imagegif ( $source_img, $target );
				//GIF 格式将图像输出到浏览器或文件(欲输出的图像资源, 指定输出图像的文件名)
				break;
			case 2 :
				imagejpeg ( $source_img, $target, $this->w_quality );
				break;
			case 3 :
				imagepng ( $source_img, $target );
				break;
			default :
				return;
		}
		if (isset ( $water_info )) {
			unset ( $water_info );
		}
		if (isset ( $water_img )) {
			imagedestroy ( $water_img );
		}
		unset ( $source_info );
		imagedestroy ( $source_img );
		return true;
	}
	public function check($image) {
		return extension_loaded ( 'gd' ) && preg_match ( "/\.(jpg|jpeg|gif|png)/i", $image, $m ) && file_exists ( $image ) && function_exists ( 'imagecreatefrom' . ($m [1] == 'jpg' ? 'jpeg' : $m [1]) );
	}
}

?>