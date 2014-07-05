<?php
include('../config.php');
ini_set('display_errors', 'On');
include(mnminclude.'ban.php');

header('Content-Type: application/json; charset=UTF-8');
array_push($globals['cache-control'], 'no-cache');
http_cache();

if(check_ban_proxy()) {
	error(_('IP no permitida'));
}


// only for logged users
if ($current_user->user_id <= 0) {
	error(_("Non logged user"));
}

$css_name = clean_text($_POST['css_name']);
$css_text = $db->escape($_POST['css_text']);


if (strlen($css_text)>64000)
    error(_("Estilo demasiado longo"));
if (strlen($css_name) > 32)
    error(_("Titulo do tema demasiado longo"));

if (!strlen($css_text))
    error(_("O texto non debe estar baleiro"));
if (!strlen($css_name))
    error(_("O nome non debe estar baleiro"));


$s="SELECT css_id FROM `customcss` WHERE css_name='".$css_name."' AND css_user_id=".($current_user->user_id)." ORDER BY css_date DESC";

$db->query($s);

$results = $db->get_results($s);
$i = 0;
foreach($results as $result) {
	if ($i-2 > 0) {
		$s = "DELETE FROM customcss WHERE css_id = ".$result->css_id;
		$db->query($s);
	}
	$i++;
}

$s="INSERT INTO customcss (css_name, css_text, css_user_id) ".
"VALUES ('".$css_name."','".$css_text."',".($current_user->user_id).");";

$db->query($s);

success(_("Estilo <b>\"" . $css_name ."\"</b> gravado corretamente")); // Tudo bom


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
