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
if ($current_user->user_id <= 0) {
	die;
}

$results = Array();

if ($_REQUEST['remove']) {
	$s="DELETE FROM customcss WHERE css_id=".(int)$_REQUEST['remove']." AND css_user_id=".(int)$current_user->user_id;
	$db->get_results($s);
} else if (array_key_exists('edit', $_REQUEST)) {
	$css_id = (int)$_REQUEST['edit'];

	if ($css_id) {
		$s="SELECT a.css_id, a.css_name, a.css_text, a.css_date FROM customcss a"
			." WHERE a.css_status!='descartado' AND css_user_id=".(int)$current_user->user_id
			." AND a.css_id=".$css_id;
		$css = $db->get_results($s);
		$results['css'] = $css[0];
	} else { // == 0
		$results['css']['css_text'] = file_get_contents($globals['css_main_static'], FILE_USE_INCLUDE_PATH);
	}

}


$s="SELECT a.css_id, a.css_name, user_login FROM customcss a"
	." INNER JOIN (SELECT css_name, css_user_id, MAX(css_date) max_css_date FROM customcss b WHERE 1=1 GROUP BY css_name, css_user_id ORDER BY css_date DESC)"
	." b on a.css_date=max_css_date AND a.css_name=b.css_name AND a.css_user_id=b.css_user_id"
	." LEFT JOIN users ON a.css_user_id=user_id"
	." WHERE a.css_user_id=".(int)$current_user->user_id
	." ORDER BY a.css_name, a.css_user_id;";
$styles = $db->get_results($s);
$results['styles'] = $styles;
echo json_encode($results);
