<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class Asynsendemail extends CI_Controller {

	var $whitelist;
	function __construct() {
		$this->whitelist = "msend";
		parent::__construct ( );

	}

	function msend() {

		$tousername = $this->input->post ('tousername',FALSE);
		$mailtitle =  $this->input->post ('mailtitle');
		$mailcontent = $this->input->post ('mailcontent');

		sendemailtouser ( $tousername, $mailtitle, $mailcontent );
			exit("ok");
	}

}