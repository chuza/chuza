<?php
include('../config.php');
include(mnminclude.'ban.php');

header('Content-Type: application/json; charset=UTF-8');
array_push($globals['cache-control'], 'no-cache');
http_cache();

if(check_ban_proxy()) {
	error(_('IP no permitida'));
}


// only for logged users
if ($current_user->user_id < 0) {
//	error(_("Non logged user"));
}

$css_id = (int)$_GET['css_id'];

$s="SELECT css_name FROM customcss WHERE css_id='$css_id'";
$results = $db->get_results($s);
if ($results) {
	setcookie('chuza-css-style', $css_id, time()+60*60*24*30);
	success(_("OK")); // Tudo bom
}


/*
$s="INSERT INTO customcss (css_name, css_text, css_user_id, css_status) ".
"VALUES ('".$css_name."','".$css_text."',".($current_user->user_id).",".
"'pending');";

$db->query($s);


 */

// final error shit
function error($mess) {
	$dict['error'] = $mess;
	echo json_encode($dict);
	die;
}

function success($mess) {
	$dict['success'] = $mess;
	echo json_encode($dict);
	die;
}
