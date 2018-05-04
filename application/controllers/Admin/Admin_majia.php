<?php

defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class Admin_majia extends CI_Controller {
	function __construct() {
		parent::__construct ();

	}

	function index($msg = '') {
		$msg && $message = $msg;
		if (null!==$this->input->post ('submit')) {

			$tmpassword = $this->input->post ('addpassword');
			$tmpassword1 = $this->input->post ('autopwd');
			$pass = '';
			if ($tmpassword1 == 0) {
				if (trim ( $tmpassword ) == '') {
					echo "自己设置的密码不能为空，因为您没有选择系统自动生成密码";
					exit ();
				} else {
					if (strlen ( $tmpassword ) < 6) {
						echo "自己设置的密码不能小于6位数";
						exit ();
					}
				}
				$pass = $tmpassword;
			} else {
				$pass = random ( 6 );
			}

			if (! $_FILES ['txtfile'] ['tmp_name'] || ! $_FILES ['txtfile'] ['name']) {

				echo "请选择要上传的文件";
				exit ();

			}

			if ((($_FILES ["txtfile"] ["type"] == "text/plain"))) {
				if ($_FILES ["txtfile"] ["error"] > 0) {
					echo "Return Code: " . $_FILES ["txtfile"] ["error"] . "
";
					exit ();
				} else {

					$date = date ( "Ymd", time () );
					$dir = FCPATH . "/data/majiauser/" . $date;
					if(is_dir($dir)){
						chmod ( $dir, 0777 ); //修改文件权限
					}

					if (! is_dir ( $dir )) {
						mkdir ( $dir, 0777, true ); //创建多级目录


					}
					$filename = $dir . '/' . random ( 6 ) . '.txt';
					if (file_exists ( $filename )) {
						$this->index ( "文件已经存在" );
					} else {
						move_uploaded_file ( $_FILES ["txtfile"] ["tmp_name"], $filename );

					}
				}
				if (! file_exists ( $filename )) {
					$this->index ( "文件不存在" );
				} else {
					$file = fopen ( $filename, "r" ) or exit ( "无法打开文件!" );
					header ( "Content-type: text/html; charset=utf-8" );
					$str_result = '';
					while ( ! feof ( $file ) ) {
						$line = fgets ( $file );
						$line = iconv ( 'gb2312', 'utf-8', $line );
						//如果用户名长度小于30就添加
						if (strlen ( $line ) < 30) {

							if (! $this->user_model->get_by_username ( $line )) {
								$this->user_model->caijiadd ( $line, $pass, random ( 8 ) . "@163.com", 1 );
								$str_result .= $line . ':添加成功!<br>';

							} else {
								$str_result .= $line . ':已经存在相同的用户名，不会被添加<br>';

							}
						} else {
							$str_result .= $line . ':长度大于30不能被添加,中文一个汉字3个字节<br>';
						}

					}
					fclose ( $file );
					echo $str_result;
					exit ();
				}

			} else {
				echo "无效的文件";
				exit ();
			}
		}

		include template ( "automajia", "admin" );
	}

}

?>