<?php

include('../config.php');
include(mnminclude.'ban.php');
include(mnminclude.'html1.php');

// only for logged users
if ($current_user->user_id <= 0) {
	force_authentication();
	die;
}

echo '<LINK href="/customcss/static/customcss.css?'.time().'" rel="stylesheet" type="text/css">';

do_header(_('Colabora no dese&ntilde;o da web'));

/*** SIDEBAR ****/
echo '<div id="sidebar">';
do_banner_right();
//do_best_stories();
//do_best_comments();
do_vertical_tags('published');
echo '</div>' . "\n";
/*** END SIDEBAR ***/

echo '<div id="newswrap" class="newswrap" >'."\n";

echo '<div class="topheading"><h2>'._("Colabora facendo esta web un pouco m&aacute;is fermosa!").'</h2></div>';

echo '<div style="width:950px;">';

echo '<div class="estilosHeader" >';
echo '<h3>Os teus estilos</h3>';
	
echo "<ul id='userStyles' class='userStyles' >";
echo "</ul>";

echo '</div>';

echo '<div style="width:700px;">';

echo '<form id="css_form" action="/customcss/process.php" method="POST" autocomplete="OFF" >';
echo '<br />';
echo _('T&iacute;tulo do estilo').':&nbsp;<input type="text" name="css_name" id="css_name" />';
echo '&nbsp;<input type="submit" value="Enviar">';
echo '<br />';
echo _('Podes empregar como referencia o estilo orixinal de Chuza, ainda que non &eacute; o recomendado deixar regras CSS xa presentes no resultado final.');
echo '<br />';
echo '<br />';
echo '<input type="button" value="Limpar" id="cleanIt" title="'.
	_("Borra o contido da area de texto").
	'" >&nbsp;';
echo '<input type="button" value="Estilo orixinal" id="originalIt">';
echo '<textarea id="css_text" cols="100" rows="100" name="css_text" style="">'.
	_('// Pega aqu&iacute; o texto do teu CSS para usares no Chuza!').
	'</textarea>';
echo '<br />';

$randkey = rand(10000,10000000);
echo '<input type="hidden" name="key" value="'.md5($randkey.$current_user->user_id.$current_user->user_email.$site_key.get_server_name()).'" />'."\n";
echo '<input type="hidden" name="randkey" value="'.$randkey.'" />';
echo '</form>';


echo '</div>';

echo '</div>';
?>
<script type="text/javascript" src="/customcss/static/customcss.js"></script>
