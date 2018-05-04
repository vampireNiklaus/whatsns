<?php


class Tag_model   extends CI_Model{

	function __construct() {
		parent::__construct ();
		$this->load->database ();
	}

    function get_by_qid($qid) {
        $taglist = array();
        $query = $this->db->query("SELECT DISTINCT name FROM `" . $this->db->dbprefix . "question_tag` WHERE qid=$qid ORDER BY `time` ASC LIMIT 0,10");
        foreach ( $query->result_array () as $tag ) {
            $taglist[] = $tag['name'];
        }
        return $taglist;
    }

    function list_by_name($name) {
        return $this->db->query("SELECT * FROM `" . $this->db->dbprefix . "question_tag` WHERE name='$name'")->row_array();
    }

    function getname_by_pinyin($pinyin) {
        $tag= $this->db->query("SELECT * FROM `" . $this->db->dbprefix . "question_tag` WHERE pinyin='$pinyin'")->row_array();

        return $tag['name'];
    }
    function list_by_countname($name) {
        return $this->db->query("SELECT count(*) as sum FROM `" . $this->db->dbprefix . "question_tag` WHERE name='$name'")->row_array();
    }
    function list_by_tagname($tagname,$start = 0, $limit = 100){
    	   $taglist = array();
    	$query=$this->db->query("SELECT  distinct name FROM `" . $this->db->dbprefix . "question_tag` WHERE name like '%$tagname%'  ORDER BY qid DESC LIMIT $start,$limit");
    	foreach ( $query->result_array () as $tag ) {
      	$tag['count']=$this->list_by_countname($tag['name']);
            $taglist[] = $tag;
        }
          return $taglist;
    }

    function get_list($start = 0, $limit = 100) {
        $taglist = array();
        $query = $this->db->query("SELECT * FROM " . $this->db->dbprefix . "question_tag ORDER BY qid DESC LIMIT $start,$limit");
        foreach ( $query->result_array () as $tag ) {
        	$tag['time']=tdate($tag['time']);
            $taglist[] = $tag;
        }
        return $taglist;
    }

    function rownum() {
        $m= $this->db->query("SELECT count(name) as num FROM " . $this->db->dbprefix . "question_tag GROUP BY name")->row_array();
        return $m['num'];
    }

    function multi_add($namelist, $qid) {
        if (empty($namelist))
            return false;
        $this->db->query("DELETE FROM " . $this->db->dbprefix . "question_tag WHERE qid=$qid");
        $insertsql = "INSERT INTO " . $this->db->dbprefix . "question_tag(`qid`,`name`,`time`) VALUES ";
        foreach ($namelist as $name) {
            $insertsql .= "($qid,'".  htmlspecialchars($name)."',{$this->base->time}),";
        }
        $this->db->query(substr($insertsql, 0, -1));
    }

    function remove_by_name($names) {
        $namestr = "'" . implode("','", $names) . "'";
        $this->db->query("DELETE FROM " . $this->db->dbprefix . "question_tag WHERE `name` IN ($namestr)");
    }

}

?>
