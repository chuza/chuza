<?
// The Meneame source code is Free Software, Copyright (C) 2005-2009 by
// Ricardo Galli <gallir at gmail dot com> and Menéame Comunicacions S.L.
//
// This program is free software: you can redistribute it and/or modify
// it under the terms of the GNU Affero General Public License as
// published by the Free Software Foundation, either version 3 of the
// License, or (at your option) any later version.
// 
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU Affero General Public License for more details.

// You should have received a copy of the GNU Affero General Public License
// along with this program.  If not, see <http://www.gnu.org/licenses/>.

// It's licensed under the AFFERO GENERAL PUBLIC LICENSE unless stated otherwise.
// You can get copies of the licenses here:
//      http://www.affero.org/oagpl.html
// AFFERO GENERAL PUBLIC LICENSE is also included in the file called "COPYING".

include('config.php');
include(mnminclude.'html1.php');

mobile_redirect();

array_push($globals['cache-control'], 'max-age=3');

if (!isset($_REQUEST['id']) && !empty($_SERVER['PATH_INFO'])) {
	$url_args = preg_split('/\/+/', $_SERVER['PATH_INFO']);
	array_shift($url_args); // The first element is always a "/"

	// If the first argument are only numbers, redirect to the story with that id
	if (is_numeric($url_args[0]) && $url_args[0] > 0) {
			$link = Link::from_db(intval($url_args[0]));
			if ($link) {
				header('Location: ' . $link->get_permalink());
				die;
			}
	}

	$link = Link::from_db($db->escape($url_args[0]));
	if (! $link ) {
		do_error(_('noticia no encontrada'), 404);
	}
} else {
	$url_args = preg_split('/\/+/', $_REQUEST['id']);
	if(is_numeric($url_args[0]) && $url_args[0] > 0 && ($link = Link::from_db(intval($url_args[0]))) ) {
		// Redirect to the right URL if the link has a "semantic" uri
		if (!empty($link->uri) && !empty($globals['base_story_url'])) {
			header ('HTTP/1.1 301 Moved Permanently');
			if (!empty($url_args[1])) $extra_url = '/' . urlencode($url_args[1]);
			header('Location: ' . $link->get_permalink(). $extra_url);
			die;
		}
	} else {
		do_error(_('argumentos no reconocidos'), 404);
	}
}


if ($link->is_discarded()) {
	// Dont allow indexing of discarded links
	if ($globals['bot']) not_found();
} else {
	//Only shows ads in non discarded images
	$globals['ads'] = true;
}


// Check for a page number which has to come to the end, i.e. ?id=xxx/P or /story/uri/P
$last_arg = count($url_args)-1;
if ($last_arg > 0) {
	// Dirty trick to redirect to a comment' page
	if (preg_match('/^000/', $url_args[$last_arg])) {
		header ('HTTP/1.1 301 Moved Permanently');
		if ($url_args[$last_arg] > 0) {
			header('Location: ' . $link->get_permalink().get_comment_page_suffix($globals['comments_page_size'], (int) $url_args[$last_arg], $link->comments).'#c-'.(int) $url_args[$last_arg]);
		} else {
			header('Location: ' . $link->get_permalink());
		}
		die;
	}
	if ($url_args[$last_arg] > 0) {
		$requested_page = $current_page =  (int) $url_args[$last_arg];
		array_pop($url_args);
	}
}

// Change to a min_value is times is changed for the current link_status
if ($globals['time_enabled_comments_status'][$link->status]) {
	$globals['time_enabled_comments'] = min($globals['time_enabled_comments_status'][$link->status], 
											$globals['time_enabled_comments']);
}

// Check for comment post
if ($_POST['process']=='newcomment') {
	$new_comment_error = Comment::save_from_post($link);
}

switch ($url_args[1]) {
	case '':
		$tab_option = 1;	
		$order_field = 'comment_order';

		// Geo check
		// Don't show it if it's a mobile browser
		if(!$globals['mobile'] && $globals['google_maps_api']) {
			$link->geo = true;
			$link->latlng = $link->get_latlng();
			if ($link->latlng) {
				geo_init('geo_coder_load', $link->latlng, 5, $link->status);
			} elseif ($link->is_map_editable()) {
				geo_init(null, null);
			}
		}
		if ($globals['comments_page_size'] && $link->comments > $globals['comments_page_size']*$globals['comments_page_threshold']) {
			if (!$current_page) $current_page = ceil($link->comments/$globals['comments_page_size']);
			$offset=($current_page-1)*$globals['comments_page_size'];
			$limit = "LIMIT $offset,".$globals['comments_page_size'];
		} 
		break;
	case 'best-comments':
		$tab_option = 2;
		if ($globals['comments_page_size'] > 0 ) $limit = 'LIMIT ' . $globals['comments_page_size'];
		$order_field = 'comment_karma desc, comment_id asc';
		break;
	case 'voters':
		$tab_option = 3;
		break;
	case 'log':
		$tab_option = 4;
		break;
	case 'sneak':
		$tab_option = 5;
		break;
	case 'favorites':
		$tab_option = 6;
		break;
	case 'trackbacks':
		$tab_option = 7;
		break;
	default:
		do_error(_('página inexistente'), 404);
}

// Set globals
$globals['link'] = $link;
$globals['link_id'] = $link->id;
$globals['link_permalink'] = $globals['link']->get_permalink();

// to avoid search engines penalisation
if ($tab_option != 1 || $link->status == 'discard') {
	$globals['noindex'] = true;
}

do_modified_headers($link->modified, $current_user->user_id.'-'.$globals['link_id'].'-'.$link->comments.'-'.$link->modified);

// Enable user AdSense
// do_user_ad: 0 = noad, > 0: probability n/100
if ($link->status == 'published' && $link->user_karma > 7 && !empty($link->user_adcode)) {
	$globals['do_user_ad'] = $link->user_karma;
	$globals['user_adcode'] = $link->user_adcode;
	$globals['user_adchannel'] = $user->adchannel;
}

// update ChuzaMail
if ($current_user->user_id > 0) {

    $maxCommentForLink = $db->get_row("SELECT max(comment_id) as max_comment_id FROM comments WHERE comment_link_id=".$link->id);
    if ($maxCommentForLink && $maxCommentForLink->max_comment_id) {
        $db->query("UPDATE chuzamail SET chm_viewed=".(int)$maxCommentForLink->max_comment_id." WHERE chm_link_id = $link->id AND chm_user_id = $current_user->user_id ");
    }
}

if ($link->status != 'published') 
	$globals['do_vote_queue']=true;
if (!empty($link->tags))
	$globals['tags']=$link->tags;

// Add canonical address
$globals['extra_head'] = '<link rel="canonical" href="'.$globals['link_permalink'].'" />'."\n";

// add also a rel to the comments rss
$globals['extra_head'] .= '<link rel="alternate" type="application/rss+xml" title="'._('comentarios esta noticia').'" href="http://'.get_server_name().$globals['base_url'].'comments_rss2.php?id='.$link->id.'" />'."\n";

$globals['thumbnail'] = $link->has_thumb();

$globals['description'] = _('Autor') . ": $link->username, " . _('Resumen') . ': '. text_to_summary($link->content, 250);

do_header($link->title, 'post');

// Show the error if the comment couldn't be inserted
if (!empty($new_comment_error)) {
	echo '<script type="text/javascript">';
	echo '$(function(){alert(\''._('Aviso'). ": $new_comment_error".'\')});';
	echo '</script>';
}

function loginDialog() {
  echo "
<div id='loginDialog' style='font-weight:bold; background-color:white; color:#245b03; display:none;'>
  <div style='height:300px;'>
    <div style='padding:12px;text-align:center;'>
      "._('Precisas facer LOGIN ou rexistrarte para poder faceres iso')."
    </div>
  <div style='width:298px;height:200px;padding-top:20px;float:left;border-width:0px 1px 0px 0px;border-style:solid;border-color:gray;'>
    <div style='text-align:center; padding-top:60px;'>
      <a href='#' style='color:#245b03'>"._('CREA UNHA NOVA CONTA')."</a>
    </div>
  </div>

  <div style='float:left; padding:20px; '>
  <div style='padding: 0px 10px 0px 10px; width:40px; background-color:#245b03;color:white;border-radius:3px;' >
  ".('Login')."
  </div>
  <br />
  <br />
<form action='#' >
  "._('Usuario ou email').":<br />
  <input type=text size=12 ><br />
  "._('Contrasinal').":<br/>
  <input type=password size=12 ><br />
  <input type='checkbox' > "._('Lémbrame')."<br />
  <input type='button' value='Login' />
</form>
  </div>
</div>
  </div>
    ";

}

loginDialog();


do_tabs("main",_('noticia'), true);
print_story_tabs($tab_option);

/*** SIDEBAR ****/
echo '<div id="sidebar">';
do_banner_right();
// GEO
if ($link->latlng) {
	echo '<div id="map" style="width:300px;height:200px;margin-bottom:25px;">&nbsp;</div>'."\n";
}
if ($link->comments > 5) {
	do_best_story_comments($link);
}
if (! $current_user->user_id) {
	do_best_stories();
}
do_rss_box();
do_banner_promotions();
echo '</div>' . "\n";
/*** END SIDEBAR ***/

echo '<div id="newswrap">'."\n";
$link->print_summary();

switch ($tab_option) {
case 1:
case 2:
	echo '<div class="comments">';

	if($tab_option == 1) do_comment_pages($link->comments, $current_page);

	$comments = $db->get_col("SELECT comment_id FROM comments WHERE comment_link_id=$link->id ORDER BY $order_field $limit");

  if (!$comments) {

    // Do nothing if no comments

  } elseif ($link->sent_date < strtotime('2011-07-24')) { // Nested comments deploy date

    foreach($comments as $comment_id) {
      $comment = Comment::from_db($comment_id);
      $comment->print_summary($link, 2500, true, true);
    }

  } else {

    if ($current_user->comment_options['korder']) {
      $options['key_sort'] = 'karma';
      $options['key_order'] = 'arsort';
    } else {
      $options['key_sort'] = 'date';
      $options['key_order'] = 'asort';
    }

    $sorted_comments = Array();
    $unsorted_comments = Array();
    $comments_by_id = Array();


    foreach($comments as $comment_id) {
      if (($comment = Comment::from_db($comment_id))) {
        $unsorted_comments[$comment_id] = $comment;
      }
    }


    function sort_comment(&$sorted_comments,&$unsorted_comments, &$comments_by_id) {
        foreach($sorted_comments as $sorted_comment) {
            if (!is_array($sorted_comment->children))
                $sorted_comment->children = Array();

            foreach($unsorted_comments as $unsorted_comment) {
                if ($unsorted_comment->parent == $sorted_comment->id) {
                    $sorted_comment->children[] = $unsorted_comment;
                    $comments_by_id[$unsorted_comment->id] = $unsorted_comment;
                }
            }
            sort_comment($sorted_comment->children,$unsorted_comments,$comments_by_id);
        }
    }

    $s = new Comment;
    $s->id = 0;
    $sorted_comments = Array($s);
    $comments_by_id[0] = $s;

    sort_comment($sorted_comments,$unsorted_comments,&$comments_by_id);

		echo '<ol class="comments-list">';

    function traverse_sorted(&$options, $level, &$sorted_comments, &$comments_by_id) {
        $level++;

        $resorted_comments = Array();
        foreach($sorted_comments as &$comment) {
            $resorted_comments[$comment->id] = $comment->$options['key_sort']; // options were previously defined
        }

        $options['key_order']($resorted_comments);

        foreach($resorted_comments as $kay => $val) {

            $comment = $comments_by_id[$kay];
            $comment->padding_level= $level;
            if ($comment->id != 0) $comment->print_summary($link, 2500, true);

            if (!empty($comments_by_id[$kay]->children)) {
                traverse_sorted($options, $level,$comments_by_id[$kay]->children,&$comments_by_id);
            }

            if ($comment->id != 0) $comment->print_summary_end();
        }
    }

    traverse_sorted($options,-2, $sorted_comments, &$comments_by_id);

    echo '</ol>';
	}

	if($tab_option == 1) do_comment_pages($link->comments, $current_page);
	Comment::print_form($link);
	echo '</div>' . "\n";

	// Highlight a comment if it is referenced by the URL.
	// currently double border, width must be 3 at least
	echo '<script type="text/javascript">';
	echo 'if(location.href.match(/#(c-\d+)$/)){$("#"+RegExp.$1+">:first").css("border-style","solid").css("border-width","1px")}';
	echo "</script>\n";
	break;

case 3:
	// Show voters
	echo '<div class="voters" id="voters">';

	echo '<div id="voters-container" style="padding: 10px;">';
	if ($globals['link']->sent_date < $globals['now'] - 60*86400) { // older than 60 days
		echo _('Noticia antigua, datos de votos archivados');
	} else {
		include(mnmpath.'/backend/meneos.php');
	}
	echo '</div><br />';
	echo '</div>';
	break;

case 6:
	// Show favorited by
	echo '<div class="voters" id="voters">';

	echo '<fieldset>';
	echo '<div id="voters-container">';
	include(mnmpath.'/backend/get_link_favorites.php');
	echo '</div><br />';
	echo '</fieldset>';
	echo '</div>';
	break;

case 4:
	// Show logs
	echo '<div class="voters" id="voters">';

	echo '<fieldset><legend>'._('registro de eventos de la noticia').'</legend>';

	echo '<div id="voters-container">';
	$logs = $db->get_results("select logs.*, UNIX_TIMESTAMP(logs.log_date) as ts, user_id, user_login, user_level, user_avatar from logs, users where log_type in ('link_new', 'link_publish', 'link_discard', 'link_edit', 'link_geo_edit', 'link_depublished') and log_ref_id=$link->id and user_id= log_user_id order by log_date desc");
	if ($logs) {
		foreach ($logs as $log) {
			echo '<div style="width:100%; display: block; clear: both; border-bottom: 1px solid #FFE2C5;">';
			echo '<div style="width:30%; float: left;padding: 4px 0 4px 0;">'.get_date_time($log->ts).'</div>';
			echo '<div style="width:24%; float: left;padding: 4px 0 4px 0;"><strong>'.$log->log_type.'</strong></div>';
			echo '<div style="width:45%; float: left;padding: 4px 0 4px 0;">';
			if ($link->author != $log->user_id  && ($log->user_level == 'admin' || $log->user_level == 'god')) { 
				// It was edited by an admin
				echo '<img src="'.get_no_avatar_url(20).'" width="20" height="20" alt="'.$log->user_login.'"/>&nbsp;';
				echo ('admin');
				if ($current_user->admin) {
					echo '&nbsp;('.$log->user_login.')';
				}
			} else {
				echo '<a href="'.get_user_uri($log->user_login).'" title="'.$log->date.'">';
				echo '<img src="'.get_avatar_url($log->log_user_id, $log->user_avatar, 20).'" width="20" height="20" alt="'.$log->user_login.'"/>&nbsp;';
				echo $log->user_login;
				echo '</a>';
			}
			echo '</div>';
			echo '</div>';

		}
	} else {
		echo _('no hay registros');
	}
	echo '</div>';
	echo '</fieldset>';
	echo '</div>';


	// Show karma logs from annotations
	if ( ($array = $link->read_annotation("link-karma")) != false ) {

		echo '<script type="text/javascript">'."\n//<!--\n";
		echo 'var k_coef = new Array(); var k_old = new Array(); var k_annotation = new Array();'."\n";
		foreach ($array as $log) {
			// To make clear "javascript lines"
			$k_time = $log['time']; $k_coef = $log['coef']; $k_old = intval($log['old_karma']); $k_annotation = $log['annotation'];
			// Generate arrays that will be used for the tooltip
			echo "k_coef[$k_time] = $k_coef; k_old[$k_time] = $k_old;\n";
			echo "if (typeof k_annotation[$k_time] == 'undefined')  k_annotation[$k_time] = '$k_annotation';";
			echo "else k_annotation[$k_time] = k_annotation[$k_time] + '$k_annotation';\n";

		}
		echo "//-->\n</script>\n";

		echo '<div class="voters">';
		echo '<fieldset><legend>'._('registro de cálculos de karma').'</legend>';

		// Call to generate HMTL and javascript for the Flot chart
		echo '<script src="'.$globals['base_static'].'js/jquery.flot.min.js" type="text/javascript"></script>'."\n";
		echo '<div id="flot" style="width:100%;height:250px;"></div>'."\n";
		@include (mnminclude.'foreign/chart_link_karma_history.js');
		echo '</fieldset>';
		echo '</div>';
	}


	break;
case 5:
	// Micro sneaker
	echo '<div class="mini-sneaker">';

	echo '<fieldset>';
	include(mnmpath.'/libs/link_sneak.php');
	echo '</fieldset>';
	echo '</div>';
	echo '<script type="text/javascript">$(function(){start_link_sneak()});</script>' . "\n";
	break;
case 7:
	// Show trackback
	echo '<div class="voters" id="voters">';

	echo '<a href="'.$link->get_trackback().'" title="'._('URI para trackbacks').'" class="tab-trackback-url"><img src="'.$globals['base_static'].'img/common/permalink.gif" alt="'._('enlace trackback').'" width="16" height="9"/> '._('dirección de trackback').'</a>' . "\n";

	echo '<fieldset><legend>'._('lugares que enlazan esta noticia').'</legend>';
	echo '<ul class="tab-trackback">';

	$trackbacks = $db->get_col("SELECT SQL_CACHE trackback_id FROM trackbacks WHERE trackback_link_id=$link->id AND trackback_type='in' and trackback_status = 'ok' ORDER BY trackback_date DESC limit 50");
	if ($trackbacks) {
		$trackback = new Trackback;
		foreach($trackbacks as $trackback_id) {
			$trackback->id=$trackback_id;
			$trackback->read();
			echo '<li class="tab-trackback-entry"><a href="'.$trackback->url.'" rel="nofollow">'.$trackback->title.'</a> ['.preg_replace('/https*:\/\/([^\/]+).*/', "$1", $trackback->url).']</li>' . "\n";
		}
	}
	echo '<li class="tab-trackback-technorati"><a href="http://technorati.com/search/'.urlencode($globals['link_permalink']).'">Technorati</a></li>' . "\n";
	echo '<li class="tab-trackback-google"><a href="http://blogsearch.google.com/blogsearch?hl=es&amp;q=link%3A'.urlencode($globals['link_permalink']).'">Google</a></li>' . "\n";
	echo '<li class="tab-trackback-askcom"><a href="http://es.ask.com/blogsearch?q='.urlencode($globals['link_permalink']).'&amp;t=a&amp;search=Buscar&amp;qsrc=2101&amp;bql=any">Ask.com</a></li>' . "\n";

	echo '</ul>';
	echo '</fieldset>';
	echo '</div>';
	break;
}
echo '</div>';

echo '<!--'."\n".'<rdf:RDF xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"'."\n";
echo '	xmlns:dc="http://purl.org/dc/elements/1.1/"' . "\n";
echo '	xmlns:trackback="http://madskills.com/public/xml/rss/module/trackback/">'."\n";
echo '	<rdf:Description rdf:about="'.$globals['link_permalink'].'"'."\n";
echo '		dc:identifier="'.$globals['link_permalink'].'"'."\n";
echo '		dc:title="'.$link->title.'"'."\n";
echo '	trackback:ping="'.$link->get_trackback().'" />'."\n";
echo '</rdf:RDF>'."\n".'-->'."\n";


$globals['tag_status'] = $globals['link']->status;
do_footer();


function print_story_tabs($option) {
	global $globals, $db, $link;

	$active = array();
	$active[$option] = ' class="selected"';

	echo '<ul class="subheader">'."\n";
	echo '<li'.$active[1].'><a href="'.$globals['link_permalink'].'">'._('comentarios'). '</a></li>'."\n";
	echo '<li'.$active[2].'><a href="'.$globals['link_permalink'].'/best-comments">'._('+ valorados'). '</a></li>'."\n";
	if (!$globals['bot']) { // Don't show "empty" pages to bots, Google can penalize too
		if ($globals['link']->sent_date > $globals['now'] - 86400*60) { // newer than 60 days
			echo '<li'.$active[3].'><a href="'.$globals['link_permalink'].'/voters">'._('votos'). '</a></li>'."\n";
		}
		if ($globals['link']->sent_date > $globals['now'] - 86400*30) { // newer than 30 days
			echo '<li'.$active[4].'><a href="'.$globals['link_permalink'].'/log">'._('registros'). '</a></li>'."\n";
		}
		if ($globals['link']->date > $globals['now'] - $globals['time_enabled_comments']) {
			echo '<li'.$active[5].'><a href="'.$globals['link_permalink'].'/sneak">&micro;&nbsp;'._('fisgona'). '</a></li>'."\n";
		}

	}
	if (($c = $db->get_var("SELECT count(*) FROM favorites WHERE favorite_type = 'link' and favorite_link_id=$link->id")) > 0) {
		echo '<li'.$active[6].'><a href="'.$globals['link_permalink'].'/favorites">'._('favoritos')."&nbsp;($c)</a></li>\n";
	}
	if (($c = $db->get_var("SELECT count(*) FROM trackbacks WHERE trackback_link_id=$link->id AND trackback_type='in' and trackback_status = 'ok'")) > 0) {
		echo '<li'.$active[7].'><a href="'.$globals['link_permalink'].'/trackbacks">'._('trackbacks'). "&nbsp;($c)</a></li>\n";
	}
	echo '</ul>'."\n";
}

function do_comment_pages($total, $current, $reverse = true) {
	global $db, $globals;

	if ( ! $globals['comments_page_size'] || $total <= $globals['comments_page_size']*$globals['comments_page_threshold']) return;
	
	if ( ! empty($globals['base_story_url'])) {
		$query = $globals['link_permalink'];
	} else {
		$query=preg_replace('/\/[0-9]+(#.*)*$/', '', $_SERVER['QUERY_STRING']);
		if(!empty($query)) {
			$query = htmlspecialchars($query);
			$query = "?$query";
		}
	}

	$total_pages=ceil($total/$globals['comments_page_size']);
	if (! $current) {
		if ($reverse) $current = $total_pages;
		else $current = 1;
	}
	
	echo '<div class="pages">';

	if($current==1) {
		echo '<span class="nextprev">&#171; '._('anterior'). '</span>';
	} else {
		$i = $current-1;
		echo '<a href="'.get_comment_page_url($i, $total_pages, $query).'">&#171; '._('anterior').'</a>';
	}



	$dots_before = $dots_after = false;
	for ($i=1;$i<=$total_pages;$i++) {
		if($i==$current) {
			echo '<span class="current">'.$i.'</span>';
		} else {
			if ($total_pages < 7 || abs($i-$current) < 3 || $i < 3 || abs($i-$total_pages) < 2) {
				echo '<a href="'.get_comment_page_url($i, $total_pages, $query).'" title="'._('ir a página')." $i".'">'.$i.'</a>';
			} else {
				if ($i<$current && !$dots_before) {
					$dots_before = true;
					echo '<span>...</span>';
				} elseif ($i>$current && !$dots_after) {
					$dots_after = true;
					echo '<span>...</span>';
				}
			}
		}
	}
	


	if($current<$total_pages) {
		$i = $current+1;
		echo '<a href="'.get_comment_page_url($i, $total_pages, $query).'">&#187; '._('siguiente').'</a>';
	} else {
		echo '<span class="nextprev">&#187; '._('siguiente'). '</span>';
	}
	echo "</div>\n";

}

function get_comment_page_url($i, $total, $query) {
	global $globals;
	if ($i == $total) return $query;
	else return $query.'/'.$i;
}
?>
