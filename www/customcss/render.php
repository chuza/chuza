<?php

include('../config.php');

header('Content-type: text/css', true);

$css_id = (int)$_GET['customcss'];

$s="SELECT css_text FROM customcss WHERE css_id='$css_id'";
$results = $db->get_results($s);
if ($results) {
	echo $results[0]->css_text;
}
