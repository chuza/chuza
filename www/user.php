<?
// The source code packaged with this file is Free Software, Copyright (C) 2005 by
// Ricardo Galli <gallir at uib dot es>.
// It's licensed under the AFFERO GENERAL PUBLIC LICENSE unless stated otherwise.
// You can get copies of the licenses here:
//              http://www.affero.org/oagpl.html
// AFFERO GENERAL PUBLIC LICENSE is also included in the file called "COPYING".
include('config.php');
include(mnminclude.'html1.php');
include(mnminclude.'geo.php');
include(mnminclude.'favorites.php');


$offset=(get_current_page()-1)*$page_size;
$globals['ads'] = true;


if (!empty($globals['base_user_url']) && !empty($_SERVER['PATH_INFO'])) {
	$url_args = preg_split('/\/+/', $_SERVER['PATH_INFO'], 6, PREG_SPLIT_NO_EMPTY);
	$_REQUEST['login'] = clean_input_string($url_args[0]);
	$_REQUEST['view'] = $url_args[1];
	$_REQUEST['uid'] = intval($url_args[2]);
	if (! $_REQUEST['uid'] && is_numeric($_REQUEST['view'])) {
		// This is a empty view but an user_id, change it
		$_REQUEST['uid'] = intval($_REQUEST['view']);
		$_REQUEST['view'] = '';
	}
} else {
	$_REQUEST['login'] = clean_input_string($_REQUEST['login']);
	$_REQUEST['uid'] = intval($_REQUEST['uid']);
	if (!empty($globals['base_user_url']) && !empty($_REQUEST['login'])) {
		header('Location: ' . html_entity_decode(get_user_uri($_REQUEST['login'], clean_input_string($_REQUEST['view']))));
		die;
	}
}

$login = clean_input_string($_REQUEST['login']);
if(empty($login)){
	if ($current_user->user_id > 0) {
		header('Location: ' . html_entity_decode(get_user_uri($current_user->user_login)));
		die;
	} else {
		header('Location: '.$globals['base_url']);
		die;
	}
}


$uid = $_REQUEST['uid']; // Should be clean before

$user=new User();

if ($current_user->admin) {
		// Check if it's used UID
		if($uid) {
			$user->id = $uid;
		} else {
			header('Location: ' . html_entity_decode(get_user_uri_by_uid($login, $_REQUEST['view'])));
			die;
		}
} else {
		if($uid > 0) {
			// Avoid anonymous and non admins users to use the id, it's a "duplicated" page
			header('Location: ' . html_entity_decode(get_user_uri($login, $_REQUEST['view'])));
			die;
		}
		$user->username = $login;
}

if(!$user->read()) {
	do_error(_('usuario inexistente'), 404);
}
$login = $user->username; // Just in case, we user the database username

$globals['search_options'] = array('u' => $user->username);

$view = clean_input_string($_REQUEST['view']);
if(empty($view)) $view = 'profile';


// For editing notes
if ($current_user->user_id == $user->id || $current_user->admin) {
	array_push($globals['extra_js'], 'jquery-form.pack.js');
	array_push($globals['extra_js'], 'ajaxupload.min.js');
}

// Enable user AdSense
// do_user_ad: 0 = noad, > 0: probability n/100
// 100 if the user is the current one
if($globals['external_user_ads'] && !empty($user->adcode)) {
	$globals['user_adcode'] = $user->adcode;
	$globals['user_adchannel'] = $user->adchannel;
	if ($current_user->user_id == $user->id || $current_user->admin) $globals['do_user_ad']  = 100; 
	else $globals['do_user_ad'] = $user->karma * 2;
}

// Load Google GEO
if (! $user->disabled()
		&& $view == 'profile' 
		&& $globals['google_maps_api'] 
		&& (($globals['latlng']=$user->get_latlng()) || $current_user->user_id == $user->id)) {
	if ($current_user->user_id == $user->id) {
		geo_init('geo_coder_editor_load', $globals['latlng'], 7, 'user');
	} else {
		geo_init('geo_coder_load', $globals['latlng'], 7, 'user');
	}
	$globals['do_geo'] = true;
}

// Check if it should be index AND if they are valids options, otherwise call do_error()
switch ($view) {
	case 'categories':
	case 'history':
	case 'shaken':
	case 'friends_shaken':
	case 'friends':
	case 'friend_of':
	case 'ignored':
	case 'favorites':
		$globals['noindex'] = true;
		breaK;
	case 'commented':
	case 'conversation':
	case 'shaken_comments':
	case 'favorite_comments':
		$globals['search_options']['w'] = 'comments';
		$globals['noindex'] = true;
		breaK;
	case 'profile':
		$globals['noindex'] = false;
		breaK;
	default:
		do_error(_('opción inexistente'), 404);
		break;
}

// Add canonical address
$globals['extra_head'] = '<link rel="canonical" href="http://'.get_server_name().get_user_uri($user->username).'" />'."\n";

if (!empty($user->names)) {
	do_header("$login ($user->names)");
} else {
	do_header($login);
}

echo '<div id="singlewrap" style="margin: 0 40px; padding-top: 30px">'."\n";

$url_login = urlencode($login);
switch ($view) {
	case 'history':
		do_user_tabs(2, $login, true);
		do_history();
		do_pages($rows, $page_size);
		break;
	case 'commented':
		do_user_tabs(3, $login, true);
		do_commented();
		do_pages($rows, $page_size, false);
		break;
	case 'shaken':
		do_user_tabs(2, $login, true);
		do_shaken();
		do_pages($rows, $page_size);
		break;
	case 'friends_shaken':
		do_user_tabs(2, $login, true);
		do_friends_shaken();
		do_pages(-1, $page_size);
		break;
	case 'friends':
		do_user_tabs(7, $login, true);
		do_friends(0);
		break;
	case 'friend_of':
		do_user_tabs(7, $login, true);
		do_friends(1);
		break;
	case 'ignored':
		do_user_tabs(7, $login, true);
		do_friends(2);
		break;
	case 'favorites':
		do_user_tabs(2, $login, true);
		do_favorites();
		do_pages($rows, $page_size);
		break;
	case 'favorite_comments':
		do_user_tabs(3, $login, true);
		do_favorite_comments();
		do_pages($rows, $page_size);
		break;
	case 'shaken_comments':
		do_user_tabs(3, $login, true);
		do_shaken_comments();
		do_pages($rows, $page_size);
		break;
	case 'categories':
		do_user_tabs(1, $login, true);
		do_categories();
		break;
	case 'conversation':
		do_user_tabs(3, $login, true);
		do_conversation();
		do_pages($rows, $page_size, false);
		break;
	case 'profile':
		do_user_tabs(1, $login, true);
		do_profile();
		break;
	default:
		do_error(_('opción inexistente'), 404);
		break;
}

echo '</div>'."\n";

do_footer();


function do_profile() {
	global $user, $current_user, $login, $db, $globals;

	$options = array();
	$options[$user->username] = get_user_uri($user->username);
	$options[_('categorías personalizadas')] = get_user_uri($user->username, 'categories');
	if ($current_user->user_id == $user->id || $current_user->user_level == 'god') {
		$options[_('modificar perfil').' &rarr;'] = $globals['base_url'].'profile.php?login='.urlencode($login);
	}
	
	do_user_subheader($options, 0, 'rss2.php?sent_by='.$user->id, _('envíos en rss2'));

	if(!empty($user->url)) {
		if ($user->karma < 10) $nofollow = 'rel="nofollow"';
		if (!preg_match('/^http/', $user->url)) $url = 'http://'.$user->url;
		else $url = $user->url;
	}

	// Print last user's note
	$post = new Post;
	if ($post->read_last($user->id)) {
		echo '<div id="addpost"></div>';
		echo '<ol class="comments-list" id="last_post">';   
		echo '<li>';
		$post->print_summary();
		echo '</li>';
		echo "</ol>\n";
	}   

	echo '<fieldset><legend>';
	echo _('información personal');
	echo '</legend>';


	// Avatar
	echo '<div style="float:right;text-align:center">';
	echo '<img id="avatar" class="avatar" src="'.get_avatar_url($user->id, $user->avatar, 80).'" width="80" height="80" alt="'.$user->username.'" title="avatar" />';

	// Print the button and associated div to change the avatar
	if ($current_user->user_id == $user->id) {
		echo '<div id="avatar_indicator" style="margin:0;padding:0;height:12px"></div>';
		echo '<button id="avatar_upload" style="margin:0" title="'._('imagen cuadrada de no más de 400 KB, sin transparencias').'">'._('cambiar avatar').'</button>'."\n";
		@include(mnminclude.'foreign/avatar_upload.html');
	}
	echo '</div>';


	// Geo div
	echo '<div style="width:140px; float:left;">';
	if($globals['do_geo']) {
		echo '<div id="map" class="thumbnail" style="width:130px; height:130px; overflow:hidden; float:left"></div>';
		if ($current_user->user_id > 0 && $current_user->user_id != $user->id && $globals['latlng'] && ($my_latlng = geo_latlng('user', $current_user->user_id))) {
			$distance = (int) geo_distance($my_latlng, $globals['latlng']);
			echo '<p style="color: #FF9400; font-size: 90%">'."$user->username "._('está a')." <strong>$distance kms</strong></p>";
		}
	}
	echo '&nbsp;</div>';


	echo '<div style="float:left;min-width:65%">';
	echo '<dl>';	
	if(!empty($user->username)) {
		echo '<dt>'._('usuario').':</dt><dd>';
		if (!empty($url)) {
			echo '<a href="'.$url.'" '.$nofollow.'>'.$user->username.'</a>';
		} else {
			echo $user->username;
		}

		$user->print_medals();

		$clones_from = "and clon_date > date_sub(now(), interval 30 day)";
		if ($current_user->admin &&
			($nclones = $db->get_var("select count(distinct clon_to) from clones where clon_from = $user->id $clones_from")) > 0 ) {
			echo ' (<a href="javascript:modal_from_ajax(\''.$globals['base_url'].'backend/ip_clones.php?id='.
			$user->id.'\', \''. _('clones por IP'). '\')" title="'._('clones').'">'._('clones').'</a><sup>'.$nclones.'</sup>) ';
		}
		// Print friend icon
		if ($current_user->user_id > 0 && $current_user->user_id != $user->id) {
			echo '&nbsp;<a id="friend-'.$current_user->user_id.'-'.$user->id.'" href="javascript:get_votes(\'get_friend.php\',\''.$current_user->user_id.'\',\'friend-'.$current_user->user_id.'-'.$user->id.'\',0,\''.$user->id.'\')">'.User::friend_teaser($current_user->user_id, $user->id).'</a>';
		}
		// Print user detailed info
		if ($user->id==$current_user->user_id || $current_user->admin) {
			echo " (" . _('id'). ": <em>$user->id</em>, ";
			echo "<em>$user->level</em>)";
		}
		if($current_user->user_level=='god') {
			echo " (<em>$user->username_register</em>)";
		}
		echo '</dd>';
	}

	if(!empty($user->names)) {
		echo '<dt>'._('nombre').':</dt><dd>'.$user->names.'</dd>';
	}

	// Show public info is it's a friend or god
	if($current_user->user_id > 0 && !empty($user->public_info) && (
			$current_user->user_id == $user->id
			|| $current_user->user_level=='god' 
			/*|| friend_exists($user->id, $current_user->user_id)*/ )) {  //friends cannot see the IM address (it was public before)
		echo '<dt>'._('IM/email').':</dt><dd> '.$user->public_info.'</dd>';
	}

	if(!empty($url)) {
		echo '<dt>'._('sitio web').':</dt><dd><a href="'.$url.'" '.$nofollow.'>'.$url.'</a></dd>';
	}

	echo '<dt>'._('desde').':</dt><dd>'.get_date_time($user->date).'</dd>';

	if($current_user->user_level=='god') {
		echo '<dt>'._('email').':</dt><dd>'.$user->email. " (<em>$user->email_register</em>)</dd>";
	}

	if ($user->id == $current_user->user_id || $current_user->user_level=='god' ) {
		echo '<dt>'._('clave API').':</dt><dd id="api-key"><a href="javascript:get_votes(\'get_user_api_key.php\',\'\',\'api-key\',0,\''.$user->id.'\')">'._('leer clave API').'</a> ('._('no la divulgues').')</dd>';
		if(!empty($user->adcode)) {
			echo '<dt>'._('Código AdSense').':</dt><dd>'.$user->adcode.'&nbsp;</dd>';
			echo '<dt>'._('Canal AdSense').':</dt><dd>'.$user->adchannel.'&nbsp;</dd>';
		}
	}

	echo '<dt>'._('karma').':</dt><dd>'.$user->karma;
	// Karma details
	if ($user->id == $current_user->user_id || $current_user->user_level=='god' ) {
		echo ' (<a href="javascript:modal_from_ajax(\''.$globals['base_url'].'backend/get_karma_numbers.php?id='.$user->id.'\', \''.
			_('cálculo del karma').
			'\')" title="'._('detalles').'">'._('detalle cálculo').'</a>)';
	}
	echo '</dd>';

	echo '<dt>'._('ranking').':</dt><dd>#'.$user->ranking().'</dd>';

	$user->all_stats();
	echo '<dt>'._('noticias enviadas').':</dt><dd>'.$user->total_links.'</dd>';
	if ($user->total_links > 0 && $user->published_links > 0) {
		$percent = intval($user->published_links/$user->total_links*100);
	} else {
		$percent = 0;
	}
	if ($user->total_links > 1) {
		$entropy = intval(($user->blogs() - 1) / ($user->total_links - 1) * 100);
		echo '<dt><em>'._('entropía').'</em>:</dt><dd>'.$entropy.'%</dd>';
	}
	echo '<dt>'._('noticias publicadas').':</dt><dd>'.$user->published_links.' ('.$percent.'%)</dd>';
	echo '<dt>'._('comentarios').':</dt><dd>'.$user->total_comments.'</dd>';
	echo '<dt>'._('notas').':</dt><dd>'.$user->total_posts.'</dd>';
	echo '<dt>'._('número de votos').':</dt><dd>'.$user->total_votes.'</dd>';

	// Print affinity to this user
	if ($current_user->user_id && ($aff_to = User::get_affinity($user->id, $current_user->user_id))) {
		$aff_to = round($aff_to/100, 2);
		echo '<dt><strong>'._('afinidad con este usuario').'</strong>:</dt><dd>'.$aff_to .'</dd>';
	}


	echo '</dl>';

	if ($user->id == $current_user->user_id) {
		echo '<div style="margin-top: 20px" align="center">';
		print_oauth_icons($_REQUEST['return']);
		echo '</div>'."\n";
	}

	echo '</div>';
	echo '</fieldset>';


	// Print GEO form
	if($globals['do_geo'] && $current_user->user_id == $user->id) {
		echo '<div class="geoform">';
		geo_coder_print_form('user', $current_user->user_id, $globals['latlng'], _('ubícate en el mapa (si te apetece)'), 'user');
		echo '</div>';
	}

	// Print a chart of the last 30 days activity
	if ($user->total_votes > 20 && ($current_user->user_id == $user->id || $current_user->admin)) {
		echo '<fieldset><legend>'._('votos/hora últimos 30 días').'</legend>';
		// Call to generate HMTL and javascript for the Flot chart
		echo '<script src="'.$globals['base_static'].'js/jquery.flot.min.js" type="text/javascript"></script>'."\n";
		//echo '<div id="flot" style="width:600px;height:150px;"></div>'."\n";
		echo '<div id="flot" style="width:100%;height:150px;"></div>'."\n";
		@include (mnminclude.'foreign/chart_user_votes_history.js');
		echo '</fieldset>';
	}

	// Show first numbers of the address if the user has god privileges
	if ($current_user->user_level == 'god' &&  ! $user->admin ) { // gods and admins know each other for sure, keep privacy
		$addresses = $db->get_results("select INET_NTOA(vote_ip_int) as ip from votes where vote_type='links' and vote_user_id = $user->id order by vote_date desc limit 30");

		// Try with comments
		if (! $addresses) {
			$addresses = $db->get_results("select comment_ip as ip from comments where comment_user_id = $user->id and comment_date > date_sub(now(), interval 30 day) order by comment_date desc limit 30");
		}

		if (! $addresses) {
			// Use register IP
			$addresses = $db->get_results("select user_ip as ip from users where user_id = $user->id");
		}

		// Not addresses to show
		if (! $addresses) {
			return;
		}

		$clone_counter = 0;
		echo '<fieldset><legend>'._('últimas direcciones IP').'</legend>';
		$prev_address = '';
		foreach ($addresses as $dbaddress) {
			$ip_pattern = preg_replace('/\.[0-9]+$/', '', $dbaddress->ip);
			if($ip_pattern != $prev_address) {
				echo '<p>'. $ip_pattern . '</p>';
				$clone_counter++;
				$prev_address = $ip_pattern;
				if ($clone_counter >= 30) break;
			}
		}
		echo '</fieldset>';
	}
}


function do_history () {
	global $db, $rows, $user, $offset, $page_size, $globals;

	do_user_subheader(array(_('envíos propios') => get_user_uri($user->username, 'history'), _('votados') => get_user_uri($user->username, 'shaken'), _('favoritos') => get_user_uri($user->username, 'favorites'), _('votados por amigos') => get_user_uri($user->username, 'friends_shaken')), 0,
		'rss2.php?sent_by='.$user->id, _('envíos en rss2'));
	$link = new Link;
	$rows = $db->get_var("SELECT count(*) FROM links WHERE link_author=$user->id AND link_votes > 0");
	$links = $db->get_col("SELECT link_id FROM links WHERE link_author=$user->id AND link_votes > 0 ORDER BY link_date DESC LIMIT $offset,$page_size");
	if ($links) {
		foreach($links as $link_id) {
			$link->id=$link_id;
			$link->read();
			$link->print_summary('short');
		}
	}
}

function do_favorites () {
	global $db, $rows, $user, $offset, $page_size, $globals;

	do_user_subheader(array(_('envíos propios') => get_user_uri($user->username, 'history'), _('votados') => get_user_uri($user->username, 'shaken'), _('favoritos') => get_user_uri($user->username, 'favorites'), _('votados por amigos') => get_user_uri($user->username, 'friends_shaken')), 2,
		'rss2.php?favorites='.$user->id.'&amp;option=favorites&amp;url=source', _('favoritos en rss2'));
	$link = new Link;
	$rows = $db->get_var("SELECT count(*) FROM favorites WHERE favorite_user_id=$user->id AND favorite_type='link'");
	$links = $db->get_col("SELECT link_id FROM links, favorites WHERE favorite_user_id=$user->id AND favorite_type='link' AND favorite_link_id=link_id ORDER BY link_date DESC LIMIT $offset,$page_size");
	if ($links) {
		foreach($links as $link_id) {
			$link->id=$link_id;
			$link->read();
			$link->print_summary('short');
		}
	}
}

function do_shaken () {
	global $db, $rows, $user, $offset, $page_size, $globals;

	if ($globals['bot']) return;

	do_user_subheader(array(_('envíos propios') => get_user_uri($user->username, 'history'), _('votados') => get_user_uri($user->username, 'shaken'), _('favoritos') => get_user_uri($user->username, 'favorites'), _('votados por amigos') => get_user_uri($user->username, 'friends_shaken')), 1,
		'rss2.php?voted_by='.$user->id, _('votadas en rss2'));
	$link = new Link;
	$rows = $db->get_var("SELECT count(*) FROM votes WHERE vote_type='links' and vote_user_id=$user->id");
	$links = $db->get_results("SELECT vote_link_id as id, vote_value FROM votes WHERE vote_type='links' and vote_user_id=$user->id ORDER BY vote_date DESC LIMIT $offset,$page_size");
	if ($links) {
		foreach($links as $linkdb) {
			$link->id=$linkdb->id;
			$link->read();
			if ($link->author == $user->id) continue;
			echo '<div style="max-width: 60em">';
			$link->print_summary('short', 0, false);
			if ($linkdb->vote_value < 0) {
				echo '<div class="box" style="z-index:20000;margin:0 0 -5x 0;background:#FF3333;position:relative;top:-5px;left:85px;width:8em;padding: 1px 1px 1px 1px;border-color:#f00;opacity:0.9;text-align:center;font-size:0.9em;color:#fff;text-shadow: 0 1px 0 #000">';
				echo get_negative_vote($linkdb->vote_value);
				echo "</div>\n";
			}
			echo "</div>\n";
		}
		echo '<br/><span style="color: #FF6400;"><strong>'._('Nota').'</strong>: ' . _('sólo se visualizan los votos de los últimos meses') . '</span><br />';
	}
}

function do_friends_shaken () {
	global $db, $rows, $user, $offset, $page_size, $globals;

	if ($globals['bot']) return;

	do_user_subheader(array(_('envíos propios') => get_user_uri($user->username, 'history'), _('votados') => get_user_uri($user->username, 'shaken'), _('favoritos') => get_user_uri($user->username, 'favorites'), _('votados por amigos') => get_user_uri($user->username, 'friends_shaken')), 3);

	$friends = $db->get_col("select friend_to from friends where friend_type = 'manual' and friend_from = $user->id and friend_value > 0");
	if ($friends) {
		$friends_list = implode(',', $friends);
		$sql = "select distinct vote_link_id as link_id from votes where vote_type = 'links' and vote_user_id in ($friends_list) and vote_value > 0 order by vote_link_id desc";

		$links = $db->get_results("$sql LIMIT $offset,$page_size");
	}

	if ($links) {
		foreach($links as $dblink) {
			$link = Link::from_db($dblink->link_id);
			$link->do_inline_friend_votes = true;
			$link->print_summary();
		}
	}

}


function do_commented () {
	global $db, $rows, $user, $offset, $page_size, $globals, $current_user;

	do_user_subheader(array(_('mis comentarios') => get_user_uri($user->username, 'commented'), _('conversación') => get_user_uri($user->username, 'conversation'), _('votados') => get_user_uri($user->username, 'shaken_comments'), _('favoritos') => get_user_uri($user->username, 'favorite_comments')), 0,
		'comments_rss2.php?user_id='.$user->id, _('comentarios en rss2'));
	$rows = $db->get_var("SELECT count(*) FROM comments WHERE comment_user_id=$user->id");
	$comments = $db->get_results("SELECT comment_id, link_id, comment_type FROM comments, links WHERE comment_user_id=$user->id and link_id=comment_link_id ORDER BY comment_date desc LIMIT $offset,$page_size");
	if ($comments) {
		print_comment_list($comments, $user);
	}
}

function do_conversation () {
	global $db, $rows, $user, $offset, $page_size, $globals, $current_user;

	do_user_subheader(array(_('mis comentarios') => get_user_uri($user->username, 'commented'), _('conversación') => get_user_uri($user->username, 'conversation'), _('votados') => get_user_uri($user->username, 'shaken_comments'), _('favoritos') => get_user_uri($user->username, 'favorite_comments')), 1,
		'comments_rss2.php?answers_id='.$user->id, _('conversación en rss2'));
	$rows = $db->get_var("SELECT count(*) FROM conversations WHERE conversation_user_to=$user->id and conversation_type='comment'");
	$comments = $db->get_results("SELECT comment_id, link_id, comment_type FROM conversations, comments, links WHERE conversation_user_to=$user->id and conversation_type='comment' and comment_id=conversation_from and link_id=comment_link_id ORDER BY conversation_time desc LIMIT $offset,$page_size");
	if ($comments) {
		print_comment_list($comments, $user);
	}
}

function do_favorite_comments () {
	global $db, $rows, $user, $offset, $page_size, $globals;

	do_user_subheader(array(_('mis comentarios') => get_user_uri($user->username, 'commented'), _('conversación') => get_user_uri($user->username, 'conversation'), _('votados') => get_user_uri($user->username, 'shaken_comments'), _('favoritos') => get_user_uri($user->username, 'favorite_comments')), 3);
	$comment = new Comment;
	$rows = $db->get_var("SELECT count(*) FROM favorites WHERE favorite_user_id=$user->id AND favorite_type='comment'");
	$comments = $db->get_col("SELECT comment_id FROM comments, favorites WHERE favorite_user_id=$user->id AND favorite_type='comment' AND favorite_link_id=comment_id ORDER BY comment_id DESC LIMIT $offset,$page_size");
	if ($comments) {
		echo '<ol class="comments-list">';
		foreach($comments as $comment_id) {
			$comment->id=$comment_id;
			$comment->read();
			echo '<li>';
			$comment->print_summary($link, 2000, false);
			echo '</li>';
		}
		echo "</ol>\n";
	}
}

function do_shaken_comments () {
	global $db, $rows, $user, $offset, $page_size, $globals;

	do_user_subheader(array(_('mis comentarios') => get_user_uri($user->username, 'commented'), _('conversación') => get_user_uri($user->username, 'conversation'), _('votados') => get_user_uri($user->username, 'shaken_comments'), _('favoritos') => get_user_uri($user->username, 'favorite_comments')), 2);

	$comment = new Comment;
	$rows = $db->get_var("SELECT count(*) FROM votes, comments WHERE vote_type='comments' and vote_user_id=$user->id and comment_id = vote_link_id and comment_user_id != vote_user_id");
	$comments = $db->get_results("SELECT vote_link_id as id, vote_value as value FROM votes, comments WHERE vote_type='comments' and vote_user_id=$user->id  and comment_id = vote_link_id and comment_user_id != vote_user_id ORDER BY vote_date DESC LIMIT $offset,$page_size");
	if ($comments) {
		echo '<ol class="comments-list">';
		foreach($comments as $c) {
			$comment->id=$c->id;
			if ($c->value > 0) $color = '#00d';
			else $color = '#f00';
			$comment->read();
			if ($comment->author != $user->id && ! $comment->admin) {
				echo '<li>';
				$comment->print_summary(false, 1000, false);
				echo '<div class="box" style="margin:0 0 -16px 0;background:'.$color.';position:relative;top:-24px;left:0px;width:30px;height:12px;border-color:'.$color.';opacity: 0.7"></div>';
				echo '</li>';
			}
		}
		echo "</ol>\n";
	}
}

function print_comment_list($comments, $user) {
	global $globals, $current_user;

	$link = new Link;
	$comment = new Comment;

	foreach ($comments as $dbcomment) {
		if ($dbcomment->comment_type == 'admin' && ! $current_user->admin) continue;
		$link->id=$dbcomment->link_id;
		$comment->id = $dbcomment->comment_id;
		if ($last_link != $link->id) {
			$link->read();
			echo '<h4>';
			echo '<a href="'.$link->get_permalink().'">'. $link->title. '</a>';
			echo ' ['.$link->comments.']';
			echo '</h4>';
			$last_link = $link->id;
		}
		$comment->read();
		echo '<ol class="comments-list">';
		echo '<li>';
		$comment->print_summary($link, 2000, false);
		echo '</li>';
		echo "</ol>\n";
	}
}


function do_friends($option) {
	global $db, $user, $globals, $current_user;

	
	$header_options = array(_('amigos') => get_user_uri($user->username, 'friends'), _('elegido por') => get_user_uri($user->username, 'friend_of'));
	if ($user->id == $current_user->user_id) {
		$header_options[_('ignorados')] = get_user_uri($user->username, 'ignored');
	}


	$prefered_id = $user->id;
	$prefered_admin = $user->admin;
	switch ($option) {
		case 2:
			do_user_subheader($header_options, $option);
			$prefered_type = 'ignored';
			break;
		case 1:
			$prefered_type = 'to';
			do_user_subheader($header_options, $option);
			break;
		default:
			do_user_subheader($header_options, $option, 'rss2.php?friends_of='.$user->id, _('envíos de amigos en rss2'));
			$prefered_type = 'from';
	}
	echo '<div style="padding: 5px 0px 10px 5px">';
	echo '<div id="'.$prefered_type.'-container">'. "\n";
	require('backend/get_friends_bars.php');
	echo '</div>'. "\n";
	echo '</div>'. "\n";
}

function do_user_tabs($option, $user, $has_subheader = false) {
	global $globals, $current_user;

	$active = array();
	$active[$option] = ' class="tabsub-this"';

	if ($has_subheader) {
		echo '<ul class="tabsub" style="margin-bottom: 0">'."\n";
	} else {
		echo '<ul class="tabsub">'."\n";
	}
	echo '<li'.$active[1].'><a href="'.get_user_uri($user).'">'._('personal'). '</a></li>';
	// echo '<li'.$active[8].'><a href="'.get_user_uri($user, 'categories').'">'._('personalización'). '</a></li>';
	//echo '<li'.$active[9].'><a href="'.get_user_uri($user, 'conversation').'">'._('conversación'). '</a></li>';
	echo '<li'.$active[7].'><a href="'.get_user_uri($user, 'friends').'">&nbsp;<img src="'.$globals['base_static'].'img/common/icon_friend_bi_00.png" alt="amigos e ignorados" width="18" height="16" title="'._('amigos e ignorados').'"/>&nbsp;</a></li>';
	echo '<li'.$active[2].'><a href="'.get_user_uri($user, 'history').'">'._('enlaces'). '</a></li>';
	//echo '<li'.$active[6].'><a href="'.get_user_uri($user, 'favorites').'">&nbsp;'.FAV_YES. '&nbsp;</a></li>';
	echo '<li'.$active[3].'><a href="'.get_user_uri($user, 'commented').'">'._('comentarios'). '</a></li>';
	//echo '<li'.$active[4].'><a href="'.get_user_uri($user, 'shaken').'">'._('votadas'). '</a></li>';
	echo '<li><a href="'.post_get_base_url($user).'">'._('notas'). '&nbsp;&rarr;</a></li>';
	echo '</ul>';
}

function do_categories() {
	global $globals, $current_user, $db, $user, $login;

	$options = array();
	$options[$user->username] = get_user_uri($user->username);
	$options[_('categorías personalizadas')] = get_user_uri($user->username, 'categories');
	if ($current_user->user_id == $user->id || $current_user->user_level == 'god') {
		$options[_('modificar perfil').' &rarr;'] = $globals['base_url'].'profile.php?login='.urlencode($login);
	}
	
	do_user_subheader($options, 1, 'rss2.php?personal='.$user->id, _('categorías personalizadas en rss2'));
	
	if (is_array($_POST['categories'])) {
		$db->query("delete from prefs where pref_user_id = $current_user->user_id and pref_key = 'category'");
		$total = (int) $db->get_var("SELECT count(*) FROM categories WHERE category_parent != 0");
		if (count($_POST['categories']) < $total) {
			for ($i=0; $i<count($_POST['categories']); $i++){ 
				$cat = intval($_POST['categories'][$i]); 
				$db->query("insert into prefs (pref_user_id, pref_key, pref_value) values ($current_user->user_id, 'category', $cat)");
			}
		}
	}

  if ($_POST['comment_options_form']) {
    if ($_POST['karma_order']) {
      $db->query("delete from prefs where pref_user_id = $current_user->user_id and pref_key = 'comment'");
      $db->query("insert into prefs (pref_user_id, pref_key, pref_value) values ($current_user->user_id, 'comment', 'korder');"); // korder : karma_order
    } else {
      $db->query("delete from prefs where pref_user_id = $current_user->user_id and pref_key = 'comment'");
    }
  }

	print_options_checkboxes($user);
	print_categories_checkboxes($user);
}


function print_options_checkboxes($user) {
	global $db, $current_user;

	if ($user->id != $current_user->user_id) $disabled = 'disabled="true"';
	else $disabled = false;

	$selected_set = $db->get_col("SELECT pref_value FROM prefs WHERE pref_user_id = $user->id and pref_key = 'comment' ");
	if ($selected_set) {
		foreach ($selected_set as $cat) {
			$selected["$cat"] = true;
		}
	} else {
		$empty = true;
	}

	echo '<form action="" method="POST" autocomplete="off" >';
	echo '<fieldset style="clear: both;">';
  echo '<input type="hidden" value="1" name="comment_options_form" >';
	echo '<legend>'._('comentarios').'</legend>'."\n";

  echo '<dl class="categorylist" id="meta-comment-order'.'"><dt>';
  echo '<label><input name="karma_order" type="checkbox" value="1" '
    .($selected['korder']?'checked="true"':'""').' /> ';
  echo 'Ordenados por karma </label></dt>'."\n";
  echo '</dl>'."\n";

	echo '<br style="clear: both;"/>' . "\n";
	echo '</fieldset>';
	if (!$disabled) {
		echo '<input class="button" type="submit" value="'._('grabar').'"/>';
	}
	echo '</form>';
}


function print_categories_checkboxes($user) {
	global $db, $current_user;

	if ($user->id != $current_user->user_id) $disabled = 'disabled="true"';
	else $disabled = false;

	$selected_set = $db->get_col("SELECT pref_value FROM prefs WHERE pref_user_id = $user->id and pref_key = 'category' ");
	if ($selected_set) {
		foreach ($selected_set as $cat) {
			$selected["$cat"] = true;
		}
	} else {
		$empty = true;
	}
	echo '<form action="" method="POST">';
	echo '<fieldset style="clear: both;">';
	echo '<legend>'._('categorías personalizadas').'</legend>'."\n";
	$metas = $db->get_results("SELECT category_id, category_name FROM categories WHERE category_parent = 0 ORDER BY category_name ASC");
	foreach ($metas as $meta) {
		echo '<dl class="categorylist" id="meta-'.$meta->category_id.'"><dt>';
		echo '<label><input '.$disabled.' name="meta_category[]" type="checkbox" value="'.$meta->category_id.'"';
		if ($empty) echo ' checked="true" ';
		echo 'onchange="select_meta(this, '.$meta->category_id.')" ';
		echo '/> ';
		echo $meta->category_name.'</label></dt>'."\n";
		$categories = $db->get_results("SELECT category_id, category_name FROM categories WHERE category_parent = $meta->category_id ORDER BY category_name ASC");
		foreach ($categories as $category) {
			echo '<dd><label><input '.$disabled.' name="categories[]" type="checkbox" ';
			if ($empty || $selected[$category->category_id]) echo ' checked="true" ';
			echo 'value="'.$category->category_id.'"/> '._($category->category_name).'</label></dd>'."\n";
		}
		echo '</dl>'."\n";
	}
	echo '<br style="clear: both;"/>' . "\n";
	echo '</fieldset>';
	if (!$disabled) {
		echo '<input class="button" type="submit" value="'._('grabar').'"/>';
	}
	echo '</form>';
}

function do_user_subheader($content, $selected = false, $rss = false, $rss_title = '') {
	global $globals;
	 
// arguments: hash array with "button text" => "button URI"; Nº of the selected button 
	echo '<ul class="subheader" style="margin-bottom: 20px">'."\n";
	if ($rss) {
		echo '<li class="icon"><a href="'.$globals['base_url'].$rss.'" title="'.$rss_title.'" rel="rss"><img src="'.$globals['base_static'].'img/common/feed-icon-001.png" width="18" height="18" alt="rss2"/></a></li>';
	} else {
		echo '<li class="icon"><img src="'.$globals['base_static'].'img/common/feed-icon-gy-001.png" width="18" height="18" alt=""/></li>';
	}
	if (is_array($content)) {
		$n = 0;
		foreach ($content as $text => $url) {
	   		if ($selected == $n) $class_b = ' class = "selected"'; 
			else $class_b='';
	   		echo '<li'.$class_b.'>'."\n";
	   		echo '<a href="'.$url.'">'.$text."</a>\n";
	   		echo '</li>'."\n";
	   		$n++;
		}
	} else {
	    echo '<h1>'.$content.'</h1>'; 
	}
	echo '</ul>'."\n";
}

?>
