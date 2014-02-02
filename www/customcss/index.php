<?php

include('../config.php');
include(mnminclude.'html1.php');

// only for logged users
if ($current_user->user_id < 0) {
	header('Location: '.$globals['base_url']);
	die;
}

do_header(_('Colabora no dese&ntilde;o da web'));

/*** SIDEBAR ****/
echo '<div id="sidebar">';
do_banner_right();
//do_best_stories();
//do_best_comments();
do_vertical_tags('published');
echo '</div>' . "\n";
/*** END SIDEBAR ***/

echo '<div id="newswrap">'."\n";

echo '<div class="topheading"><h2>'._("Colabora facendo esta web un pouco m&aacute;is fermosa!").'</h2></div>';

echo '<form id="css_form" action="/customcss/process.php" method="POST" >';
echo '<input type="submit" value="Enviar">';
echo '<br />';
echo 'Nome do novo estilo:&nbsp;<input type="text" name="css_name"/>';
echo '<br />';
echo '<textarea id="css_text" cols="100" rows="100" name="css_text">'.
	_('// Pega aqu&iacute; o texto do teu css para a web').
	'</textarea>';
echo '<br />';
echo '<input type="submit" value="Enviar">';
$randkey = rand(10000,10000000);
echo '<input type="hidden" name="key" value="'.md5($randkey.$current_user->user_id.$current_user->user_email.$site_key.get_server_name()).'" />'."\n";
echo '<input type="hidden" name="randkey" value="'.$randkey.'" />';
echo '</form>';

echo '</div>'
?>
<script type="text/javascript">
$(document).ready( function() {
  $("#css_form").submit(function(e) {
	e.preventDefault();
	$.post('/customcss/process.php',
	  $(this).serializeArray(),
	  function(d) {
		  var response = $.parseJSON(d);
		  if (response.error) {
			  alert(response.error);
		  } else {
			  $("#css_form").hide()
				  .parent()
				  .append("<h3>" + response.success + "</h3>");
		  }
	  }, function(d) {
		  console.log(arguments);
	  } 
	);  
});
});
</script>

