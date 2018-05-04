<?php
$sql = file_get_contents('whatsns.sql');
$sql = str_replace("\r", "\n", str_replace("`ask_", "`mytb_", $sql));
echo $sql;