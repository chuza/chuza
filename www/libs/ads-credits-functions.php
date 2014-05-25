<?php
// The source code packaged with this file is Free Software, Copyright (C) 2005 by
// Ricardo Galli <gallir at uib dot es>.
// It's licensed under the AFFERO GENERAL PUBLIC LICENSE unless stated otherwise.
// You can get copies of the licenses here:
// 		http://www.affero.org/oagpl.html
// AFFERO GENERAL PUBLIC LICENSE is also included in the file called "COPYING".



/*****
// banners and credits funcions: FUNCTIONS TO ADAPT TO YOUR CONTRACTED ADS AND CREDITS
*****/


if (preg_match('/meneame.net$/', get_server_name())) {
	$globals['is_meneame']  = true;
}

function do_banner_top () { // top banner
	global $globals, $dblang, $current_user;
//
// WARNING!
//
// IMPORTANT! adapt this section to your contracted banners!!
//
	if($globals['external_ads'] && $globals['ads']) {
		@include('ads/top.inc');
	} else {
		echo '<div class="banner-top">' . "\n";
		@include('ads/meneame-01.inc');
		echo '</div>' . "\n";
	}
}


function do_banner_top_mobile () { 
	global $globals, $dblang;
//
// WARNING!
//
// IMPORTANT! adapt this section to your contracted banners!!
//
	if($globals['ads']) {
		@include('ads/mobile-01.inc');
	}
}

function do_cms_content($section, $subsection) {
       	global $db, $current_user, $globals;

	if ($globals["CMS"]) {
		if(($results = $db->get_results("SELECT * FROM cms WHERE (cms_section='$section' OR cms_section='ALL') and (cms_subsection='$subsection' OR cms_subsection='ALL') ORDER BY cms_order"))) {
			foreach ($results as $result) {
				echo $result->cms_content;
			}
		}
	}
}

function do_banner_right() { // side banner A
	global $globals, $current_user;
//
// WARNING!
//
// IMPORTANT! adapt this section to your contracted banners!!
//
	if($globals['external_ads'] && $globals['ads']) {
		//Banner riotorto
		$hoxe 		= date("Ymd");
		$dataLimite1 = '20130422';
		$dataLimite2 = '20130522';
		if ($hoxe < $dataLimite1)
		{
			@include('ads/riotorto1.inc');
		} 
		
		if ($hoxe >= $dataLimite1 and $hoxe < $dataLimite2){
			@include('ads/riotorto2.inc');
		}
		
		
		//Afiliación
		@include('ads/right.inc');
	}
	

	
	
}

function do_banner_promotions() { 
	global $globals;
	if(! $globals['mobile'] && $globals['external_ads'] && $globals['ads']) {
		@include('ads/promotions.inc');
	}
}

function do_banner_top_news() {
	global $globals;
	@include('ads/top-news.inc');
}

function do_banner_story() {
	global $globals, $current_user;
	if ($globals['external_ads'] && $globals['ads'] && $globals['link'] && ! $current_user->user_id) {
		@include('ads/adsense-middle.inc');
	}
	if ($globals['link'] && $globals['kalooga_categories'] 
			&& in_array($globals['link']->category, $globals['kalooga_categories']) ) {
		@include('ads/kalooga.inc');
	}
}

function do_legal($legal_name, $target = '', $show_abuse = true) {
	global $globals;
	// IMPORTANT: legal note only for our servers, CHANGE IT!!
	if ($globals['is_meneame']) {
		echo '<a href="'.$globals['legal'].'" '.$target.'>'.$legal_name.'</a>';
	} else {
		echo 'legal conditions link here';
	}
	// IMPORTANT: read above
}

function do_footer_help() {
	global $globals;
	if (! $globals['is_meneame_help']) return;
	echo '<h5>ayuda</h5>'."\n";
	echo '<ul id="helplist">'."\n";
	echo '<li><a href="'.$globals['base_url'].'faq-es.php">'._('faq').'</a></li>'."\n";
	echo '<li><a href="http://meneame.wikispaces.com/Ayuda">'._('ayuda').'</a></li>'."\n";
	echo '<li><a href="http://meneame.wikispaces.com/">'._('wiki').'</a></li>'."\n";
	echo '<li><a href="http://meneame.wikispaces.com/Bugs">'._('avisar errores').'</a></li>'."\n";
	echo '<li><a href="'.$globals['legal'].'#contact">'._('avisar abusos').'</a></li>'."\n";
	echo '</ul>'."\n";
}

function do_footer_plus_meneame() {
	global $globals;
	if (! $globals['is_meneame']) return;
	echo '<h5>+chuza</h5>'."\n";
	echo '<ul id="moremenelist">'."\n";
	echo '<li><a href="http://m.chuza.gl/">'._('versión móbil').'</a></li>'."\n";
	//echo '<li><a href="http://tv.chuza.net/">'._('menéame TV').'</a></li>'."\n";
	echo '<li><a href="http://twitter.com/chuza">'._('síguenos en twitter').'</a></li>'."\n";
	//echo '<li><a href="http://meneame.jaiku.com/">'._('síguenos en jaiku').'</a></li>'."\n";
	echo '<li><a href="/chios/">'._('nótame').'</a></li>'."\n";
	echo '<li><a href="http://chuza.gl/blog">'._('blog').'</a></li>'."\n";
	echo '<li><a href="http://chuza.gl/wiki">'._('wiki').'</a></li>'."\n";
	echo '<li><a href="http://reduggy.net">'._('reduggy.net').'</a></li>'."\n";
	echo '</ul>'."\n";
}

function do_footer_shop() {
	global $globals;
	if (! $globals['is_meneame']) return;
	echo '<h5>tienda</h5>'."\n";
	echo '<ul id="shoplift">'."\n";
	echo '<li><a href="http://meneame.wikispaces.com/menechandising">'._('camisetas').'</a></li>'."\n";
    echo '<li><a href="http://www.socialmediasl.com/">'._('publicidad').'</a></li>'."\n";
	echo '</ul>'."\n";

}
function do_credits_mobile() {
	global $dblang, $globals;

	echo '<div id="footthingy">';
	echo '<a href="http://chuza.gl" title="chuza.gl"><img src="http://chuza.gl/img/mnm/meneito.png" alt="Chuza!"/></a>';
	/*
	echo '<ul id="stdcompliance">';
	echo '<li><a href="http://validator.w3.org/check?uri=referer"><img style="border:0;width:80px;height:15px" src="'.$globals['base_url'].'img/common/valid-xhtml10.gif" alt="Valid XHTML 1.0 Transitional" /></a></li>';
	echo '<li><a href="http://jigsaw.w3.org/css-validator/check/referer?profile=css3"><img style="border:0;width:80px;height:15px" src="'.$globals['base_url'].'img/common/valid-css.gif" alt="Valid CSS" /></a></li>';
	echo '</ul>';
	*/
	echo '</div>'."\n";
}

function do_credits() {
	global $dblang, $globals;

	echo '<div id="footthingy">';
	echo '<p>Chuza</p>';
	echo '<ul id="legalese">';

	// IMPORTANT: links change in every installation, CHANGE IT!!
	// contact info
	if (!$globals['is_meneame']) {	
		echo '<li>Copyleft <b>Asociación Cultural Chuza</b></li>';
		echo '<li><a href="mailto:chuza.gl@gmail.com">chuza.gl@gmail.com</a></li>';
		echo '<li><a href="http://chuzar.gl/equipa/index.php?page=legal">'._('condiciones legales').'</a> ';
		echo '<a href="http://chuzar.gl/equipa/index.php?page=legal#tos">'._('y de uso').'</a></li>';
		echo '<li><a href="http://chuzar.gl/equipa/index.php?page=quen-somos">'._('quiénes somos').'</a></li>';
		echo '<li>'._('licencias').':&nbsp;';
		echo '<a href="'.$globals['base_url'].'COPYING">'._('código').'</a>,&nbsp;';
		echo '<a href="http://creativecommons.org/licenses/by-sa/2.5/">'._('gráficos').'</a>,&nbsp;';
		echo '<a href="http://creativecommons.org/licenses/by/2.5/es/">'._('contenido').'</a></li>';
		echo '<li><a href="http://websvn.meneame.net/listing.php?repname=meneame&amp;path=/branches/version3/">'._('descargar código').'</a></li>';
		echo '<li><a href="http://chuzar.gl/equipa/index.php?page=chuza-r--etiqueta">Chuza-etiqueta</a></li>';
	}
	echo '</ul>'."\n";

    echo '<div id="dhlink" style="padding-top:10px;text-align:center;" ><a style="color:#669933 !important;" href="https://dinahosting.com/gz/cloud-hosting" >'._("Esta web está aloxada na nube de <b>DINAHOSTING</b>")."</a></div>";

	echo '<ul id="stdcompliance">';
	echo '<li><a href="http://validator.w3.org/check?uri=referer"><img style="border:0;width:80px;height:15px" src="'.$globals['base_static'].'img/common/valid-xhtml10.gif" alt="Valid XHTML 1.0 Transitional" /></a></li>';
	//echo '<li><a href="http://jigsaw.w3.org/css-validator/check/referer?profile=css3"><img style="border:0;width:80px;height:15px" src="'.$globals['base_static'].'img/common/valid-css.gif" alt="Valid CSS" /></a></li>';
	echo '<li><a href="http://feedvalidator.org/check.cgi?url=http://'.get_server_name().'/rss2.php?local"><img style="border:0;width:80px;height:15px" src="'.$globals['base_static'].'img/common/valid-rss.gif" alt="Valid RSS" title="Validate my RSS feed" /></a></li>';
	echo '</ul>';
	echo '</div>'."\n";

}
?>
