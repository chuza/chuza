<?php

include('../config.php');
include(mnminclude.'ban.php');
include(mnminclude.'html1.php');

// only for logged users
if ($current_user->user_id <= 0) {
	die;
}

$results = Array();

if ($_REQUEST['remove']) {
	$s="DELETE FROM customcss WHERE css_id=".(int)$_REQUEST['remove']." AND css_user_id=".(int)$current_user->user_id;
	$db->get_results($s);
} else if ($_REQUEST['edit']) {
	$s="SELECT css_text FROM customcss WHERE css_id=".(int)$_REQUEST['edit']." AND css_user_id=".(int)$current_user->user_id;
	$css_text = $db->get_results($s);
	$result['css_text'] = $css_text;
}

$s="SELECT css_id, css_name FROM customcss WHERE css_user_id=".(int)$current_user->user_id;
$styles = $db->get_results($s);
$results['styles'] = $styles;
echo json_encode($results);
