<?php

include('../config.php');
include(mnminclude.'external_post.php');
include_once(mnminclude.'log.php');
include_once(mnminclude.'ban.php');
include_once(mnminclude.'canon-AEDE.php');

$counter = 0;

function kill_me($from, $to) {
	global $db, $counter;

	echo "batch $from, $to \n";
	$s = "SELECT * FROM `links` WHERE link_status != 'autodiscard' LIMIT $from, $to";
	$r = $db->get_results($s);

	echo "<pre>";
	foreach ($r as $row) {
		if (Canon_AEDE::remove_shit($row->link_url)) {
			$s="UPDATE links SET link_status='autodiscard' WHERE link_id=".$row->link_id;
			echo $s." = ";
			$r = $db->query($s);
			echo $r."\n";
			$counter++;
		}
	}
}

$s = "UPDATE FROM `links` SET link_status='published' WHERE link_status = 'autodiscard' ";
$r = $db->query($s);

echo 'start<br>';
for ($k=0; $k<10000; $k++) {
	$x = $k * 5000;
	kill_me($x, $x+5000);
}

echo "$counter noticias mudadas\n";
echo "Fin do script";

