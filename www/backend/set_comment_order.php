<?
// The source code packaged with this file is Free Software, Copyright (C) 2005 by
// manel villar <manelvf@gmail.com>
// It's licensed under the AFFERO GENERAL PUBLIC LICENSE unless stated otherwise.
// You can get copies of the licenses here:
// 		http://www.affero.org/oagpl.html
// AFFERO GENERAL PUBLIC LICENSE is also included in the file called "COPYING".

include('../config.php');
include(mnminclude.'ban.php');

header('Content-Type: application/json; charset=UTF-8');
array_push($globals['cache-control'], 'no-cache');
http_cache();

if(!$globals["development"] && check_ban_proxy()) {
	error(_('IP no permitida'));
}

if(!$current_user->user_id) {
	error(_('usuario incorrecto'));
}

$id = $current_user->user_id;

$db->query("DELETE FROM prefs WHERE pref_key='comment' AND pref_user_id=$id ");
if ($_REQUEST['order'] == 'korder') {
  $db->query("INSERT INTO prefs (pref_value, pref_key, pref_user_id) VALUES ('korder','comment', $id);");
}

echo 'OK';

function error($mess) {
	$dict['error'] = $mess;
	echo json_encode($dict);
	die;
}

?>
