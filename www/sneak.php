<?
// The source code packaged with this file is Free Software, Copyright (C) 2005 by
// Ricardo Galli <gallir at uib dot es>.
// It's licensed under the AFFERO GENERAL PUBLIC LICENSE unless stated otherwise.
// You can get copies of the licenses here:
// 		http://www.affero.org/oagpl.html
// AFFERO GENERAL PUBLIC LICENSE is also included in the file called "COPYING".

include('config.php');
include(mnminclude.'html1.php');
include(mnminclude.'sneak.php');


#$globals['ads'] = true;
$globals['favicon'] = 'img/favicons/favicon-sneaker.ico';

init_sneak();

// Start html
array_push($globals['extra_css'], 'es/sneak01.css');
if (!empty($_REQUEST['friends'])) {
	do_header(_('amigos en la fisgona'));
} elseif ($current_user->user_id > 0 && !empty($_REQUEST['admin']) && $current_user->admin) {
	do_header(_('admin'));
} else {
	do_header(_('fisgona'));
}

?>
<script type="text/javascript">
//<![CDATA[
var my_version = '<? echo $sneak_version; ?>';
var ts=<? echo (time()-3600); ?>; // just due a freaking IE cache problem
var server_name = '<? echo get_server_name(); ?>';
var sneak_base_url = 'http://'+'<? echo get_server_name().$globals['base_url'];?>'+'backend/sneaker2.php';
var mykey = <? echo rand(100,999); ?>;
var is_admin = <? if ($current_user->admin) echo 'true'; else echo 'false'; ?>;


var default_gravatar = base_static+'img/common/no-gravatar-2-20.jpg';
var do_animation = true;
var animating = false;
var animation_colors = Array("#ffc387", "#ffc891", "#ffcd9c", "#ffd2a6", "#ffd7b0", "#ffddba", "#ffe7cf", "#ffecd9", "#fff1e3", "#fff6ed", "#fffbf7", "transparent");
var colors_max = animation_colors.length - 1;
var current_colors = Array();
var animation_timer;

var do_hoygan = <? if (isset($_REQUEST['hoygan']))  echo 'true'; else echo 'false'; ?>;
var do_flip = <? if (isset($_REQUEST['flip']))  echo 'true'; else echo 'false'; ?>;



// Reload the mnm banner each 5 minutes
var mnm_banner_reload = 180000;


$(function(){start_sneak()});

function play_pause() {
	if (is_playing()) {
		document.images['play-pause-img'].src = base_static+"img/common/sneak-play01.png";
		if( document.getElementById('comment-input'))
			document.getElementById('comment-input').disabled=true;
		do_pause();
		
	} else {
		document.images['play-pause-img'].src = base_static+"img/common/sneak-pause01.png";
		if (document.getElementById('comment-input'))
			document.getElementById('comment-input').disabled=false;
		do_play();
	}
	return false;

}

function set_initial_display(item, i) {
	var j;
	if (i >= colors_max)
		j = colors_max - 1;
	else j = i;
	current_colors[i] = j;
	item.css('background', animation_colors[j]);
}

function clear_animation() {
	clearInterval(animation_timer);
	animating = false;
	$('#items').children().css('background', 'transparent');
}

function animate_background() {
	if (current_colors[0] == colors_max) {
		clearInterval(animation_timer);
		animating = false;
		return;
	}
	var items = new Object; // For IE6
	items = $('#items').children();
	for (i=new_items-1; i>=0; i--) {
		if (current_colors[i] < colors_max) {
			current_colors[i]++;
			items.slice(i,i+1).css('background', animation_colors[current_colors[i]]);
		} else 
			new_items--;
	}
}


function to_html(data) {
	var tstamp=new Date(data.ts*1000);
	var timeStr;
	var text_style = '';
	var chat_class = 'sneaker-chat';

	var hours = tstamp.getHours();
	var minutes = tstamp.getMinutes();
	var seconds = tstamp.getSeconds();

	timeStr  = ((hours < 10) ? "0" : "") + hours;
	timeStr  += ((minutes < 10) ? ":0" : ":") + minutes;
	timeStr  += ((seconds < 10) ? ":0" : ":") + seconds;

	html = '<div class="sneaker-ts">'+timeStr+'<\/div>';

	tooltip_ajax_call= "onmouseout=\"tooltip.clear(event);\"  onclick=\"tooltip.clear(this);\"";
	html += '<div class="sneaker-type"  onmouseout="tooltip.clear(event);"  onclick="tooltip.clear(this);" >';
	switch (data.type) {
		case 'post':
			tooltip_ajax_call += " onmouseover=\"return tooltip.ajax_delayed(event, 'get_post_tooltip.php', '"+data.id+"', 10000);\"";
			html += '<img src="'+base_static+'img/common/sneak-newnotame01.png" width="21" height="17" alt="<?echo _('nótame');?>" '+tooltip_ajax_call+'/><\/div>';
			html += '<div class="sneaker-votes">&nbsp;<\/div>';
			if (check_user_ping(data.title)) {
				text_style = 'style="font-weight: bold;"';
			} 
			if (do_hoygan) data.title = to_hoygan(data.title);
			if (do_flip) data.title = flipString(data.title);
			html += '<div class="sneaker-story" '+text_style+'><a target="_blank" href="'+data.link+'">'+data.title+'<\/a><\/div>';
			html += '<div class="sneaker-who"  onmouseout="tooltip.clear(event);"  onclick="tooltip.clear(this);" >';
			if (data.icon != undefined && data.icon.length > 0) {
				html += '<a target="_blank" href="'+base_url+'user.php?login='+data.who+'"><img src="'+data.icon+'" width=20 height=20 onmouseover="return tooltip.ajax_delayed(event, \'get_user_info.php\', '+data.uid+');" onmouseout="tooltip.clear(event);"  onclick="tooltip.clear(this);" /><\/a>';
			}
			html += '&nbsp;<a target="_blank" href="'+base_url+'user.php?login='+data.who+'">'+data.who.substring(0,15)+'<\/a><\/div>';
			html += '<div class="sneaker-status">'+data.status+'<\/div>';
			return html;
			break;
		case 'chat':
			html += '<img src="'+base_static+'img/common/sneak-chat01.png" width="21" height="17" alt="<?echo _('mensaje');?>" title="<?echo _('mensaje');?>" '+tooltip_ajax_call+'/><\/div>';
			html += '<div class="sneaker-votes">&nbsp;<\/div>';
			// Change the style
			if (global_options.show_admin || data.status == 'admin') {
				chat_class = 'sneaker-chat-admin'
			} else if (global_options.show_friends || data.status == '<? echo _('amigo'); ?>') { 
				// The sender is a friend and sent the message only to friends
				chat_class = 'sneaker-chat-friends'
			}
			if (check_user_ping(data.title)  || (is_admin && data.status != 'admin' && check_admin_ping(data.title))) {
				text_style += 'font-weight: bold;';
			}
			if (text_style.length > 0) {
				// Put the anchor in the same color as the rest of the text
				data.title = data.title.replace(/ href="/gi, ' style="'+text_style+'" href="');
				text_style = 'style="'+text_style+'"';
			}
			// Open in a new window
			data.title = data.title.replace(/(href=")/gi, 'target="_blank" $1'); 
			if (do_hoygan) data.title = to_hoygan(data.title);
			if (do_flip) data.title = flipString(data.title);
			html += '<div class="'+chat_class+'" '+text_style+'>'+data.title+'<\/div>';
			html += '<div class="sneaker-who"  onmouseout="tooltip.clear(event);"  onclick="tooltip.clear(this);" >';
			if (data.icon != undefined &&  data.icon.length > 0) {
				html += '<a target="_blank" href="'+base_url+'user.php?login='+data.who+'"><img src="'+data.icon+'" width=20 height=20 onmouseover="return tooltip.ajax_delayed(event, \'get_user_info.php\', '+data.uid+');" onmouseout="tooltip.clear(event);"  onclick="tooltip.clear(this);" /><\/a>';
			}
			html += '&nbsp;<a target="_blank" href="'+base_url+'user.php?login='+data.who+'">'+data.who.substring(0,15)+'<\/a><\/div>';
			html += '<div class="sneaker-status">'+data.status+'<\/div>';
			return html;
			break;
		case 'vote':
			tooltip_ajax_call += " onmouseover=\"return tooltip.ajax_delayed(event, 'get_link.php', '"+data.id+"', 30000);\"";
			if (data.status == '<? echo _('publicada');?>')
				html += '<img src="'+base_static+'img/common/sneak-vote-published01.png" width="21" height="17" alt="<?echo _('voto');?>" '+tooltip_ajax_call+'/><\/div>';
			else
				html += '<img src="'+base_static+'img/common/sneak-vote01.png" width="21" height="17" alt="<?echo _('voto');?>"  '+tooltip_ajax_call+'/><\/div>';
			break;
		case 'problem':
			tooltip_ajax_call += " onmouseover=\"return tooltip.ajax_delayed(event, 'get_link.php', '"+data.id+"', 30000);\"";
			html += '<img src="'+base_static+'img/common/sneak-problem01.png" width="21" height="17" alt="<?echo _('problema');?>" '+tooltip_ajax_call+'/><\/div>';
			break;
		case 'comment':
			tooltip_ajax_call += " onmouseover=\"return tooltip.ajax_delayed(event, 'get_comment_tooltip.php', '"+data.id+"', 10000);\"";
			html += '<img src="'+base_static+'img/common/sneak-comment01.png" width="21" height="17" alt="<?echo _('comentario');?>" '+tooltip_ajax_call+'/><\/div>';
			break;
		case 'new':
			tooltip_ajax_call += " onmouseover=\"return tooltip.ajax_delayed(event, 'get_link.php', '"+data.id+"', 30000);\"";
			html += '<img src="'+base_static+'img/common/sneak-new01.png" width="21" height="17" alt="<?echo _('nueva');?>" '+tooltip_ajax_call+'/><\/div>';
			break;
		case 'published':
			tooltip_ajax_call += " onmouseover=\"return tooltip.ajax_delayed(event, 'get_link.php', '"+data.id+"', 30000);\"";
			html += '<img src="'+base_static+'img/common/sneak-published01.png" width="21" height="17" alt="<?echo _('publicada');?>" '+tooltip_ajax_call+'/><\/div>';
			break;
		case 'discarded':
			tooltip_ajax_call += " onmouseover=\"return tooltip.ajax_delayed(event, 'get_link.php', '"+data.id+"', 30000);\"";
			html += '<img src="'+base_static+'img/common/sneak-reject01.png" width="21" height="17" alt="<?echo _('descartada');?>" '+tooltip_ajax_call+'/><\/div>';
			break;
		case 'edited':
			tooltip_ajax_call += " onmouseover=\"return tooltip.ajax_delayed(event, 'get_link.php', '"+data.id+"', 10000);\"";
			html += '<img src="'+base_static+'img/common/sneak-edit-notice01.png" width="21" height="17" alt="<?echo _('editada');?>" '+tooltip_ajax_call+'/><\/div>';
			break;
		case 'cedited':
			tooltip_ajax_call += " onmouseover=\"return tooltip.ajax_delayed(event, 'get_comment_tooltip.php', '"+data.id+"', 10000);\"";
			html += '<img src="'+base_static+'img/common/sneak-edit-comment01.png" width="21" height="17" alt="<?echo _('comentario editado');?>" '+tooltip_ajax_call+'/><\/div>';
			break;
		case 'geo_edited':
			tooltip_ajax_call += " onmouseover=\"return tooltip.ajax_delayed(event, 'get_link.php', '"+data.id+"', 10000);\"";
			html += '<img src="'+base_static+'img/common/sneak-geo01.png" width="21" height="17" alt="<?echo _('geo editado');?>" '+tooltip_ajax_call+'/><\/div>';
			break;
		default:
			html += data.type+'<\/div>';
	}

	html += '<div class="sneaker-votes" onmouseout="tooltip.clear(event);" onmouseover="tooltip.clear(event);">'+data.votes+'/'+data.com+'<\/div>';
	if ("undefined" != typeof(data.cid) && data.cid > 0) anchor='#c-'+data.cid;
	else anchor='';
	if (do_hoygan) data.title = to_hoygan(data.title);
	if (do_flip) data.title = flipString(data.title);
	html += '<div class="sneaker-story"><a target="_blank" href="'+data.link+anchor+'">'+data.title+'<\/a><\/div>';
	if (data.type == 'problem') {
		html += '<div class="sneaker-who">';
		html += '<img src="'+base_static+'img/mnm/mnm-anonym-vote-01.png" width=20 height=20 onmouseout="tooltip.clear(event);"/>';
		html += '<span class="sneaker-problem">&nbsp;'+data.who+'<\/span><\/div>';
	} else if (data.uid > 0)  {
		html += '<div class="sneaker-who"  onmouseout="tooltip.clear(event);"  onclick="tooltip.clear(this);" >';
		if (data.icon != undefined && data.icon.length > 0) {
			html += '<a target="_blank" href="'+base_url+'user.php?login='+data.who+'"><img src="'+data.icon+'" width=20 height=20  onmouseover="return tooltip.ajax_delayed(event, \'get_user_info.php\', '+data.uid+');" onmouseout="tooltip.clear(event);"  onclick="tooltip.clear(this);"/><\/a>';
		}
		html += '&nbsp;<a target="_blank" href="'+base_url+'user.php?login='+data.who+'">'+data.who.substring(0,15)+'<\/a><\/div>';
	} else {
		html += '<div class="sneaker-who">&nbsp;'+data.who.substring(0,15)+'<\/div>';
	}
	if (data.status == '<? echo _('publicada');?>')
		html += '<div class="sneaker-status"><a target="_blank" href="'+base_url+'"><span class="sneaker-published">'+data.status+'<\/span><\/a><\/div>';
	else if (data.status == '<? echo _('descartada');?>')
		html += '<div class="sneaker-status"><a target="_blank" href="'+base_url+'shakeit.php?meta=_discarded"><span class="sneaker-discarded">'+data.status+'<\/span><\/a><\/div>';
	else 
		html += '<div class="sneaker-status"><a target="_blank" href="'+base_url+'shakeit.php">'+data.status+'<\/a><\/div>';
	return html;
}


function check_user_ping(str) {
	if (user_login != '') {
		re = new RegExp('(^|[\\s:,\\?¿!¡;<>\\(\\)])'+user_login+'([\\s:,\\?¿!¡;<>\\(\\).]|$)', "i");
		return str.match(re);
	}
	return false;
}

function check_admin_ping(str) {
	re = new RegExp('(^|[\\s:,\\?¿!¡;<>\\(\\)])(admin|admins|administradora{0,1}|administrador[ae]s)([\\s:,\\?¿!¡;<>\\(\\).]|$)', "i");
	return str.match(re);
}

function to_hoygan(str) 
{
	str=str.replace(/á/gi, 'a');
	str=str.replace(/é/gi, 'e');
	str=str.replace(/í/gi, 'i');
	str=str.replace(/ó/gi, 'o');
	str=str.replace(/ú/gi, 'u');

	str=str.replace(/igo(\s|$)/gi, 'ijo$1');
	str=str.replace(/yo/gi, 'io');
	str=str.replace(/m([pb])/gi, 'n$1');
	str=str.replace(/qu([ei])/gi, 'k$1');
	str=str.replace(/ct/gi, 'st');
	str=str.replace(/cc/gi, 'cs');
	str=str.replace(/ll([aeou])/gi, 'y$1');
	str=str.replace(/ya/gi, 'ia');
	str=str.replace(/yo/gi, 'io');
	str=str.replace(/g([ei])/gi, 'j$1');
	str=str.replace(/^([aeiou][a-z]{3,})/gi, 'h$1');
	str=str.replace(/ ([aeiou][a-z]{3,})/gi, ' h$1');
	str=str.replace(/[zc]([ei])/gi, 's$1');
	str=str.replace(/z([aou])/gi, 's$1');
	str=str.replace(/c([aou])/gi, 'k$1');

	str=str.replace(/b([aeio])/gi, 'vvv;$1');
	str=str.replace(/v([aeio])/gi, 'bbb;$1');
	str=str.replace(/vvv;/gi, 'v');
	str=str.replace(/bbb;/gi, 'b');

	str=str.replace(/oi/gi, 'oy');
	str=str.replace(/xp([re])/gi, 'sp$1');
	str=str.replace(/es un/gi, 'esun');
	str=str.replace(/(^| )h([ae]) /gi, '$1$2 ');
	str=str.replace(/aho/gi, 'ao');
	str=str.replace(/a ver /gi, 'haber ');
	str=str.replace(/ por /gi, ' x ');
	str=str.replace(/ñ/gi, 'ny');
	str=str.replace(/buen/gi, 'GÜEN');

        // benjami
	str=str.replace(/windows/gi, 'güindous');
	str=str.replace(/we/gi, 'güe');
	// str=str.replace(/'. '/gi, '');
	str=str.replace(/,/gi, ' ');
	str=str.replace(/hola/gi, 'ola');
	str=str.replace(/ r([aeiou])/gi, ' rr$1');
	return str.toUpperCase();
}

// From http://www.revfad.com/flip.html
function flipString(aString) {
	aString = aString.toLowerCase();
	var last = aString.length - 1;
	var result = "";
	for (var i = last; i >= 0; --i) {
		result += flipChar(aString.charAt(i))
	}
	return result;
}

function flipChar(c) {
	switch (c) {
	case 'á':
	case 'a':
	case 'à':
		return '\u0250';
	case 'b':
		return 'q';
	case 'c':
		return '\u0254'; //Open o -- copied from pne
	case 'd':
		return 'p';
	case 'e':
	case 'é':
		return '\u01DD';
	case 'f':
		return '\u025F'; //Copied from pne -- 
		//LATIN SMALL LETTER DOTLESS J WITH STROKE
	case 'g':
		return 'b';
	case 'h':
		return '\u0265';
	case 'i':
	case 'í':
		return '\u0131'; //'\u0131\u0323' //copied from pne
	case 'j':
		return '\u0638';
	case 'k':
		return '\u029E';
	case 'l':
		return '1';
	case 'm':
		return '\u026F';
	case 'n':
	case 'ñ':
		return 'u';
	case 'ó':
	case 'o':
		return 'o';
	case 'p':
		return 'd';
	case 'q':
		return 'b';
	case 'r':
		return '\u0279';
	case 's':
		return 's';
	case 't':
		return '\u0287';
	case 'u':
		return 'n';
	case 'v':
		return '\u028C';
	case 'w':
		return '\u028D';
	case 'x':
		return 'x';
	case 'y':
		return '\u028E';
	case 'z':
		return 'z';
	case '[':
		return ']';
	case ']':
		return '[';
	case '(':
		return ')';
	case ')':
		return '(';
	case '{':
		return '}';
	case '}':
		return '{';
	case '?':
		return '\u00BF'; //From pne
	case '\u00BF':
		return '?';
	case '!':
		return '\u00A1';
	case "\'":
		return ',';
	case ',':
		return "\'";
	}
	return c;
}

//]]>
</script>
<script type="text/javascript" src="http://<? echo get_server_name().$globals['base_url']; ?>js/sneak14.js.php" charset="utf-8"></script>
<?


// Check the tab options and set corresponging JS variables
if ($current_user->user_id > 0) {
	if (!empty($_REQUEST['friends'])) {
		$taboption = 2;
		echo '<script type="text/javascript">global_options.show_friends = true;</script>';
	} elseif (!empty($_REQUEST['admin']) && $current_user->user_id > 0 && ($current_user->admin)) {
		$taboption = 3;
		echo '<script type="text/javascript">global_options.show_admin = true;</script>';
	} else {
		$taboption = 1;
	}
	print_sneak_tabs($taboption);
}
//////


echo '<div class="sneaker">';
echo '<div class="sneaker-legend" onmouseout="tooltip.clear(event);" onmouseover="tooltip.clear(event);">';
echo '<form action="" class="sneaker-control" id="sneaker-control" name="sneaker-control">';
echo '<img id="play-pause-img" onclick="play_pause()" src="'.$globals['base_static'].'img/common/sneak-pause01.png" alt="play/pause" title="play/pause" />&nbsp;&nbsp;&nbsp;';
echo '<label><input type="checkbox" checked="checked" name="sneak-pubvotes" id="pubvotes-status" onclick="toggle_control(\'pubvotes\')" /><img src="'.$globals['base_static'].'img/common/sneak-vote-published01.png" width="21" height="17" title="'._('votos de publicadas').'" alt="'._('votos de publicadas').'" /></label>';
echo '<label><input type="checkbox" checked="checked" name="sneak-vote" id="vote-status" onclick="toggle_control(\'vote\')" /><img src="'.$globals['base_static'].'img/common/sneak-vote01.png" width="21" height="17" title="'._('meneos').'" alt="'._('meneos').'" /></label>';
echo '<label><input type="checkbox" checked="checked" name="sneak-problem" id="problem-status" onclick="toggle_control(\'problem\')" /><img src="'.$globals['base_static'].'img/common/sneak-problem01.png" width="21" height="17" alt="'._('problema').'" title="'._('problema').'"/></label>';
echo '<label><input type="checkbox" checked="checked" name="sneak-comment" id="comment-status" onclick="toggle_control(\'comment\')" /><img src="'.$globals['base_static'].'img/common/sneak-comment01.png" width="21" height="17" alt="'._('comentario').'" title="'._('comentario').'"/></label>';
echo '<label><input type="checkbox" checked="checked" name="sneak-new" id="new-status" onclick="toggle_control(\'new\')" /><img src="'.$globals['base_static'].'img/common/sneak-new01.png" width="21" height="17" alt="'._('nueva').'" title="'._('nueva').'"/></label>';
echo '<label><input type="checkbox" checked="checked" name="sneak-published" id="published-status" onclick="toggle_control(\'published\')" /><img src="'.$globals['base_static'].'img/common/sneak-published01.png" width="21" height="17" alt="'._('publicada').'" title="'._('publicada').'"/></label>';

// Only registered users can see the chat messages
if ($current_user->user_id > 0) {
	$chat_checked = 'checked="checked"';
	echo '<label><input type="checkbox" '.$chat_checked.' name="sneak-chat" id="chat-status" onclick="toggle_control(\'chat\')" /><img src="'.$globals['base_static'].'img/common/sneak-chat01.png" width="21" height="17" alt="'._('mensaje').'" title="'._('mensaje').'"/></label>';
}
echo '<label><input type="checkbox" checked="checked" name="sneak-post" id="post-status" onclick="toggle_control(\'post\')" /><img src="'.$globals['base_static'].'img/common/sneak-newnotame01.png" width="21" height="17" alt="'._('nótame').'" title="'._('nótame').'"/></label>';


echo '<abbr title="'._('total&nbsp;(registrados+jabber+anónimos)').'">'._('fisgonas').'</abbr>: <strong><span id="ccnt"> </span></strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
echo '<abbr title="'._('tiempo medio en milisegundos para procesar cada petición al servidor').'">ping</abbr>: <span id="ping">---</span>';
echo "</form>\n";
if ($current_user->user_id > 0) {
	echo '<form name="chat_form" action="" onsubmit="return send_chat(this);">';
	echo _('mensaje') . ': <input type="text" name="comment" id="comment-input" value="" size="90" maxlength="230" autocomplete="off" />&nbsp;<input type="submit" value="'._('enviar').'" class="button"/>';
	echo '</form>';
}

echo '</div>' . "\n";

echo '<div id="singlewrap">' . "\n";

echo '<div class="sneaker-item">';
echo '<div class="sneaker-title">';
echo '<div class="sneaker-ts"><strong>'._('hora').'</strong></div>';
echo '<div class="sneaker-type"><strong>'._('acción').'</strong></div>';
echo '<div class="sneaker-votes"><strong><abbr title="'._('meneos').'">me</abbr>/<abbr title="'._('comentarios').'">co</abbr></strong></div>';
echo '<div class="sneaker-story">&nbsp;<strong>'._('noticia').'</strong></div>';
echo '<div class="sneaker-who">&nbsp;<strong>'._('quién/qué').'</strong></div>';
echo '<div class="sneaker-status"><strong>'._('estado').'</strong></div>';
echo "</div>\n";
echo "</div>\n";


echo '<div id="items'.$i.'">';
for ($i=0; $i<$max_items;$i++) {
	echo '<div class="sneaker-item">&nbsp;</div>';
}
echo "</div>\n";
echo '</div>';
echo "</div>\n";

do_footer();

function print_sneak_tabs($option) {
	global $current_user, $globals;
	$active = array();
	$active[$option] = ' class="tabmain-this"';
	echo '<ul class="tabmain">' . "\n";

	echo '<li'.$active[1].'><a href="'.$globals['base_url'].'sneak.php">'._('todos').'</a></li>' . "\n";
	echo '<li'.$active[2].'><a href="'.$globals['base_url'].'sneak.php?friends=1">'._('amigos').'</a></li>' . "\n";
	if ($current_user->user_id > 0 && $current_user->admin) {
		echo '<li'.$active[3].'><a href="'.$globals['base_url'].'sneak.php?admin=1">'._('admin').'</a></li>' . "\n";
	}
	echo '<li><a href="'.$globals['base_url'].'telnet.php">&nbsp;<img src="'.$globals['base_static'].'img/common/konsole.png" alt="telnet"/>&nbsp;</a></li>' . "\n";

	echo '</ul>' . "\n";
}

?>
