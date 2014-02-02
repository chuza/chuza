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
if ($current_user->user_id < 0) {
	error(_("Non logged user"));
}

$css_name = clean_text($_POST['css_name']);
$css_text = $db->escape($_POST['css_text']);


if (strlen($css_text)>65000)
    error(_("Estilo demasiado longo"));
if (strlen($css_name) > 32)
    error(_("Titulo do tema demasiado longo"));

if (!strlen($css_text))
    error(_("O texto non debe estar baleiro"));
if (!strlen($css_name))
    error(_("O nome non debe estar baleiro"));

$s="SELECT css_name FROM customcss WHERE css_name='$css_name'";
$results = $db->get_results($s);
if ($results) {
	// check for duplicated names
	error(_("Ese nome xa existe"));
}

$s="INSERT INTO customcss (css_name, css_text, css_user_id, css_status) ".
"VALUES ('".$css_name."','".$css_text."',".($current_user->user_id).",".
"'pending');";

$db->query($s);

success(_("Estilo <b>\"" . $css_name ."\"</b> engadido correctamente")); // Tudo bom


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
