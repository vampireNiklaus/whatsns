<?php


class Gift_model  extends  CI_Model{

function __construct() {
		 parent::__construct();
		$this->load->database ();
	}
    function get($id) {
        return $this->db->query("SELECT * FROM " . $this->db->dbprefix . "gift WHERE id='$id'")->row_array();
    }

    function get_list($start = 0, $limit = 10) {
        $giftlist = array();
        $query = $this->db->query("select * from " . $this->db->dbprefix . "gift order by time desc limit $start,$limit");
        foreach ( $query->result_array () as $gift ) {
            $gift['time'] = tdate($gift['time'], 3, 0);
            $giftlist[] = $gift;
        }
        return $giftlist;
    }

    function get_by_range($from, $to, $start = 0, $limit = 10) {
        $giftlist = array();
        $query = $this->db->query("SELECT * FROM " . $this->db->dbprefix . "gift WHERE `credit`>=$from AND `credit`<=$to ORDER BY `time` DESC LIMIT $start,$limit");
        foreach ( $query->result_array () as $gift ) {
            $gift['time'] = tdate($gift['time'], 3, 0);
            $giftlist[] = $gift;
        }
        return $giftlist;
    }

    function get_by_range_name($ranges, $name = '', $start = 0, $limit = 10) {
        $giftlist = array();
        $rangesql = '';
        (count($ranges) > 1) && $rangesql = "AND `credit`>=$ranges[0] AND `credit`<=$ranges[1]";
        $query = $this->db->query("SELECT * FROM " . $this->db->dbprefix . "gift WHERE  `title` LIKE '$name%' $rangesql ORDER BY `time` DESC LIMIT $start,$limit");
        foreach ( $query->result_array () as $gift ) {
            $gift['time'] = tdate($gift['time'], 3, 0);
            $giftlist[] = $gift;
        }
        return $giftlist;
    }

    function add($title, $description, $image, $credit) {
    	$time=time();
        $this->db->query('INSERT INTO ' . $this->db->dbprefix . "gift(title,description,image,credit,time) values ('$title','$description','$image',$credit,'{$time}')");
        return $this->db->insert_id();
    }

    function update($title, $desrc, $filepath, $credit, $id) {
        $this->db->query('update  ' . $this->db->dbprefix . "gift  set title='$title',description='$desrc',image='$filepath',credit=$credit where id=$id ");
    }

    function remove_by_id($ids) {
        $this->db->query("DELETE FROM `" . $this->db->dbprefix . "gift` WHERE `id` IN ($ids)");
    }

    function update_available($id, $available) {
        $this->db->query("UPDATE " . $this->db->dbprefix . "gift SET `available`=$available WHERE `id`in ($id)");
    }

    function addlog($uid, $gid, $username, $realname, $email, $phone, $address, $postcode, $giftname, $qq, $notes, $credit) {
        $time=time();
        $this->db->query("INSERT INTO " . $this->db->dbprefix . "giftlog SET `uid`=$uid,`gid`=$gid,`notes`='$notes',`email`='$email',`qq`='$qq',`phone`='$phone',`postcode`='$postcode',`address`='$address',`username`='$username',`realname`='$realname',`giftname`='$giftname',`credit`=$credit,`time`=" . $time);
    }

    function getlog($logid) {
        return $this->db->query("SELECT * FROM " . $this->db->dbprefix . "giftlog WHERE id='$logid'")->row_array();
    }

    function getloglist($start = 0, $limit = 10) {
        $loglist = array();
        $query = $this->db->query("SELECT * FROM " . $this->db->dbprefix . "giftlog ORDER BY `time` DESC LIMIT $start,$limit");
        foreach ( $query->result_array () as $log ) {
            $log['time'] = tdate($log['time'], 3, 0);
            $loglist[] = $log;
        }
        return $loglist;
    }

    function update_gift_status($ids, $status = 1) {
        $this->db->query("UPDATE " . $this->db->dbprefix . "giftlog SET `status`=$status WHERE `status`!=$status AND `id` IN ($ids)");
    }

    function list_by_searchlog($pricerange, $giftname, $username, $datestart, $dateend, $start = 0, $limit = 10) {
        $sql = "SELECT * FROM `" . $this->db->dbprefix . "giftlog` WHERE 1=1 ";
        $giftname && $sql.=" AND `giftname` LIKE '$giftname%' ";
        $username && $sql.="AND `username` LIKE '$username%' ";
        $datestart && ($sql .= " AND `time` >= " . strtotime($datestart));
        $dateend && ($sql .=" AND `time` <= " . strtotime($dateend));
        if ($pricerange && ($pricerange != 'all')) {
            $ranges = explode("-", $pricerange);
            print_r($ranges);
            $sql.=" AND `credit`>" . intval($ranges[0]) . " AND `credit`<= " . intval($ranges[1]);
        }
        $sql.=" ORDER BY `time` DESC LIMIT $start,$limit";
        $giftloglist = array();
        $query = $this->db->query($sql);
        foreach ( $query->result_array () as $log ) {
            $log['time'] = tdate($log['time'], 3, 0);
            $giftloglist[] = $log;
        }
        return $giftloglist;
    }

    function rownum_by_searchlog($pricerange, $giftname, $username, $datestart, $dateend) {
        $condition = " 1=1 ";
        $giftname && $condition.=" AND `giftname` LIKE '$giftname%' ";
        $username && $condition.=" AND `username` LIKE '$username%' ";
        $datestart && ($condition .= " AND `time` >= " . strtotime($datestart));
        $dateend && ($condition .=" AND `time` <= " . strtotime($dateend));
        if ($pricerange && ($pricerange != 'all')) {
            $ranges = explode("-", $pricerange);
            $condition.=" AND `credit`>$ranges[0] AND `credit`<= $ranges[1] ";
        }

        $m= $this->db->query("select count(*) as num from ".$this->db->dbprefix."giftlog where $condition ")->row_array();
        return $m['num'];
    }

}

?>
