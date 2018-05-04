<?php

class Keywords_model extends CI_Model {

	function __construct() {
		parent::__construct ();
		$this->load->database ();
	}

	function get_list($start = 0, $limit = 20) {
		$wordlist = array ();
		$query = $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "keywords  ORDER BY `id` DESC LIMIT $start,$limit" );
		foreach ( $query->result_array () as $word ) {

			$word ['num'] = 0;
			$wordlist [] = $word;
		}
		return $wordlist;
	}
	function add($wids, $finds, $replacements, $admin) {
		$wsize = count ( $wids );
		for($i = 0; $i < $wsize; $i ++) {
			if ($wids [$i]) {
				$this->db->query ( "UPDATE " . $this->db->dbprefix . "keywords SET `find`='$finds[$i]',`replacement`='$replacements[$i]' WHERE `id`=$wids[$i]" );
			} else {
				$finds [$i] && $this->db->query ( "INSERT INTO `" . $this->db->dbprefix . "keywords` SET `admin`='$admin',`find`='$finds[$i]',`replacement`='$replacements[$i]'" );
			}
		}
	}

	function multiadd($lines, $admin) {
		$sql = "INSERT INTO `" . $this->db->dbprefix . "keywords`(`admin` ,`find` , `replacement`) VALUES ";
		foreach ( $lines as $line ) {
			$line = str_replace ( array ("\r\n", "\n", "\r" ), '', $line );
			if (empty ( $line ))
				continue;
			@list ( $find, $replacement ) = explode ( '=', $line );
			$sql .= "('$admin','$find', '$replacement'),";
		}
		$sql = substr ( $sql, 0, - 1 );
		$this->db->query ( $sql );
	}

	function remove_by_id($ids) {
		$this->db->query ( "DELETE FROM " . $this->db->dbprefix . "keywords WHERE `id` IN ($ids)" );
	}

}
?>