<?php

include('../config.php');
include(mnminclude.'external_post.php');
include_once(mnminclude.'log.php');
include_once(mnminclude.'ban.php');
include_once(mnminclude.'canon-AEDE.php');

$s = "SELECT * FROM `links` WHERE link_status != 'abuse' LIMIT 1000 ";
$r = $db->get_results($s);

echo "<pre>";
foreach ($r as $row) {
	if (Canon_AEDE::remove_shit($row->link_url)) {
		$s="UPDATE links SET link_status='abuse' WHERE link_id=".$row->link_id;
		echo $s."\n";
		$r = $db->query($s);
		echo $r;
	}
}

echo "Fin do script";

