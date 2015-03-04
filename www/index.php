<?php
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
// 		http://www.affero.org/oagpl.html
// AFFERO GENERAL PUBLIC LICENSE is also included in the file called "COPYING".

//ini_set("error_reporting","on");
//error_reporting(E_ALL); // only on debug
include('config.php');
include(mnminclude.'html1.php');

meta_get_current();

if (isset($_REQUEST['chuzamail']) && $globals["chuzamail"]) {
    $chuzamail = true;
}

$page_size = 15;
$page = get_current_page();
$offset=($page-1)*$page_size;
$globals['ads'] = true;

$cat=$_REQUEST['category'];


do_header(_('Chuza!'));
if ($chuzamail) {
    do_tabs('main','chuzamail');
} else {
    do_tabs('main','published');
}

// Are u a spammer?
if ($_REQUEST['uspammer']) {
  echo "<script>alert('"._("Tes que ter unha actividade recente en Chuza para poder enviar noticias")."');</script>";
}

if ($globals['meta_current'] > 0) { 

    $from_where = "FROM links WHERE link_status='published' and link_category in (".$globals['meta_categories'].") ";
	print_index_tabs(); // No other view

} elseif (($current_user->user_id > 0) && $chuzamail) {

    $cm = Comment::getChuzaMail($current_user->user_id, true);
    if ($cm) {
        $link_list = implode(",", $cm);
        if (strlen($link_list) > 0) {
            $from_where = "FROM links WHERE link_id IN ($link_list) ";
        } else {
            $from_where = "FROM links WHERE 0 "; // do not show any links (this should never occur but..."
        }
    }

} elseif ($current_user->user_id > 0) { // Check authenticated users

	switch ($globals['meta']) {
		case '_personal':
			$from_time = '"'.date("Y-m-d H:00:00", $globals['now'] - $globals['time_enabled_comments']).'"';
			$from_where = "FROM links WHERE link_date > $from_time and link_status='published' and link_category in (".$globals['meta_categories'].") ";
			//$from_where = "FROM links WHERE link_status='published' and link_category in (".$globals['meta_categories'].") ";
			print_index_tabs(7); // Show "personal" as default
			break;
		case '_friends':
			$from_time = '"'.date("Y-m-d H:00:00", $globals['now'] - 86400*4).'"';
			$from_where = "FROM links, friends WHERE link_date >  $from_time and link_status='published' and friend_type='manual' and friend_from = $current_user->user_id and friend_to=link_author and friend_value > 0";
			print_index_tabs(1); // Friends
		break;
		default:
			print_index_tabs(0); // All
			$rows = Link::count('published');
			$from_where = "FROM links WHERE link_status='published' ";
	}
} else {
	print_index_tabs(0); // No other view
	$from_where = "FROM links WHERE link_status='published' ";
}

do_mnu_categories_horizontal($_REQUEST['category']);

/*** SIDEBAR ****/
echo '<div id="sidebar">';

do_cms_content("FRONT", "SIDEBAR");


do_banner_right();
do_banner_promotions();

//if (($current_user->user_id > 0) {
if ($globals['CUSTOMCSS']) {
	$s="SELECT * FROM customcss WHERE 1=1";
	$results = $db->get_results($s);

	echo "<div class='sidebox'>";
	echo "<div class='header'><h4>"._("Estilos")."</h4></div>";
	echo "<div class='cell' style='border-bottom:1px solid #669933;'><a href='/customcss'><h3>Crea o teu estilo</h3></a></div>";
	echo "<div class='cell' style='border-bottom:1px solid #669933;'>";
	echo "<select name='customcss' id='customcss' style='width:180px;'>";
	echo "<option>"._("...")."</option>";
	$current_id = $_REQUEST['customcss'] or $_COOKIE['customcss'];
	foreach($results as $result) {
		echo "<option value='".$result->css_id."'>"
			.$result->css_name
			.($_current_id && $current_id==$result->css_id? 'selected="selected"':'') 
			."</option>";
	}
	echo "</select>";
	echo "<input type='button' id='chooseCustomCss' value='".
		_("Escoller").
		"' style=\"margin-left:18px;\" />";
	echo "</div>";
	echo "</div>";
}
//}

echo "<div class='sidebox'>";
echo "<div class='header'><h4>"._("Asociaci&oacute;n Cultural Chuza!")."</h4></div>";

echo "<div class='cell' style='border-bottom:1px solid #669933;'><a href='http://chuza.org/equipa/index.php?page=o-novo-chuza'><h3>Colabora</h3></a></div>";

echo "<div class='cell' style='border-bottom:1px solid #669933;'><a href='http://chuza.org/equipa/index.php?page=afiliate'><h3>Asociate!</h3></a></div>";

echo "<div class='cell' style='border-bottom:1px solid #669933;'><a href='http://chuza.org/equipa/index.php?page=proxectos-da-asociacion'><h3>Proxectos de chuza!</h3></a></div>";

echo "</div>";


if ($globals['show_popular_published']) do_best_stories();

if ($globals['show_gzradio']) do_gzradio();

do_most_commented();

if ($page < 2) {
	do_best_comments();
}
// Depreted: Sidebar calendar
//if ($globals['show_calendar']) do_calendar();
if ($globals['show_bottom_sidebar_banner']) do_bottom_sidebar_banner();

do_categories_cloud('published');
do_vertical_tags('published');

if ($globals['do_reduggy']) {
    do_siblings_sites();
}

function do_siblings_sites() {
    $output .= '<div id="reduggyBox" class="sidebox" style="padding-bottom:0px;" ><div class="header sibling" style="cursor:pointer" ><h4><a href="http://reduggy.net" >'._('REDUGGY.NET').'</a></h4></div><div class="mainsites" ><ul id="reduggyBoxContent" >'."\n";
    $output .= '</ul>';
    $output .= '</div>';
    $output .= '</div>';

    echo $output;
}

//do_standard();

echo '</div>' . "\n";
/*** END SIDEBAR ***/

echo '<div id="newswrap">'."\n";


do_banner_top_news();

if($cat) {
	$from_where .= " AND link_category=$cat ";
}
$order_by = " ORDER BY link_date DESC ";

if (!$rows) $rows = $db->get_var("SELECT SQL_CACHE count(*) $from_where");

$links = $db->get_col("SELECT SQL_CACHE link_id $from_where $order_by LIMIT $offset,$page_size");
if ($links) {
	foreach($links as $link_id) {
		$link = Link::from_db($link_id);
		$link->print_summary();
	}
}

do_pages($rows, $page_size);
echo '</div>'."\n";

do_footer_menu();
do_footer();

function print_index_tabs($option=-1) {
	global $globals, $db, $current_user;

	$toggler = get_toggler_plusminus('topcatlist', $_REQUEST['category']);
	$active = array();
	$toggle_active = array();
	if ($option >= 0) {
		$active[$option] = 'class="selected"';
		$toggle_active[$option] = &$toggler;
	}

	echo '<ul class="subheader">'."\n";



	if ($current_user->has_personal) {
		echo '<li '.$active[7].'><span><a href="'.$globals['base_url'].'">'._('personal'). '</a>'.$toggle_active[7].'</span></li>'."\n";
	}
	echo '<li '.$active[0].'><span><a href="'.$globals['base_url'].$globals['meta_skip'].'">'._('todas'). '</a>'.$toggle_active[0].'</span></li>'."\n";
	// Do metacategories list
  //print_r($globals['standards'][$current_user->standard]['trans_code']);
  //print_r($current_user->standard);
  //print_r($globals['standards']);
	//$metas = $db->get_results("SELECT SQL_CACHE category_id, category_name, category_uri FROM categories WHERE category_parent = 0 AND category_lang LIKE '".$db->escape($globals['standards'][$current_user->standard]['trans_code'])."'  ORDER BY category_id ASC");
	$metas = $db->get_results("SELECT SQL_CACHE category_id, category_name, category_uri FROM categories WHERE category_parent = 0 ORDER BY category_id ASC");
	if ($metas) {
		foreach ($metas as $meta) {
			if ($meta->category_id == $globals['meta_current']) {
				$active_meta = 'class="selected"';
				$globals['meta_current_name'] = $meta->category_name;
				$toggle = &$toggler;
			} else {
				$active_meta = '';
				$toggle = '';
			}
			echo '<li '.$active_meta.'><span><a href="'.$globals['base_url'].'?meta='.$meta->category_uri.'">'.$meta->category_name. '</a>'.$toggle.'</span></li>'."\n";
		}
	}

	if ($current_user->user_id > 0) {
		echo '<li '.$active[1].'><span><a href="'.$globals['base_url'].'?meta=_friends">'._('amigos'). '</a>'.$toggle_active[1].'</span></li>'."\n";
	}

	// Print RSS teasers
	switch ($option) {
		case 0: // All, published
			echo '<li class="icon"><a href="'.$globals['base_url'].'rss2.php" rel="rss"><img src="'.$globals['base_static'].'img/common/feed-icon-001.png" width="18" height="18" alt="rss2"/></a></li>';
			break;
		case 7: // Personalised, published
			echo '<li class="icon"><a href="'.$globals['base_url'].'rss2.php?personal='.$current_user->user_id.'" rel="rss" title="'._('categorías personalizadas').'"><img src="'.$globals['base_static'].'img/common/feed-icon-001.png" width="18" height="18" alt="rss2"/></a></li>';
			break;
		default:
			echo '<li class="icon"><a href="'.$globals['base_url'].'rss2.php?meta='.$globals['meta_current'].'" rel="rss"><img src="'.$globals['base_static'].'img/common/feed-icon-001.png" width="18" height="18" alt="rss2"/></a></li>';
	}

	echo '</ul>'."\n";
}

?>
