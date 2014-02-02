<?php
$lang['admin']['invalidemail'] = 'L\'adressa d\'e-mail endatada n\'è betg valaivla.';
$lang['admin']['info_deletepages'] = 'Note: due to permission restrictions, some of the pages you selected for deletion may not be listed below';
$lang['admin']['info_pagealias'] = 'Specify a unique alias for this page.';
$lang['admin']['info_autoalias'] = 'If this field is empty, an alias will be created automatically.';
$lang['admin']['invalidparent'] = 'You must select a parent page (contact your administrator if you do not see this option).';
$lang['admin']['forgotpwprompt'] = 'Enter your admin username.  An email will then be sent to the email address associated with that username with new login information';
$lang['admin']['info_basic_attributes'] = 'This field allows you to specify which content properties that users without the "Manage All Content" permission are allowed to edit.';
$lang['admin']['basic_attributes'] = 'Basic Properties';
$lang['admin']['no_permission'] = 'You have not permission to perform that function.';
$lang['admin']['bulk_success'] = 'Bulk operation was successfully updated.';
$lang['admin']['no_bulk_performed'] = 'No bulk operation performed.';
$lang['admin']['info_preview_notice'] = 'Warning: This preview panel behaves much like a browser window allowing you to navigate away from the initially previewed page. However, if you do that, you may experience unexpected behaviour. If you navigate away from the initial display and return, you may not see the un-committed content until you make a change to the content in the main tab, and then reload this tab. When adding content, if you navigate away from this page, you will be unable to return, and must refresh this panel.';
$lang['admin']['sitedownexcludes'] = 'Exclude these Addresses from Sitedown Messages';
$lang['admin']['info_sitedownexcludes'] = 'This parameter allows listing a comma separated list of ip addresses or networks that should not be subject to the sitedown mechanism.  This allows administrators to work on a site whilst anonymous visitors receive a sitedown message.<br/><br/>Addresses can be specified in the following formats:<br/>
1. xxx.xxx.xxx.xxx -- (exact IP address)<br/>
2. xxx.xxx.xxx.[yyy-zzz] -- (IP address range)<br/>
3. xxx.xxx.xxx.xxx/nn -- (nnn = number of bits, cisco style.  i.e:  192.168.0.100/24 = entire 192.168.0 class C subnet)';
$lang['admin']['setup'] = 'Advanced Setup';
$lang['admin']['handle_404'] = 'Custom 404 Handling';
$lang['admin']['sitedown_settings'] = 'Sitedown Settings';
$lang['admin']['general_settings'] = 'General Settings';
$lang['admin']['help_function_page_attr'] = '<h3>What does this do?</h3>
<p>This tag can be used to return the value of the attributes of a certain page.</p>
<h3>How do I use it?</h3>
<p>Insert the tag into the template like: <code>{page_attr key="extra1"}</code>.</p>
<h3>What parameters does it take?</h3>
<ul>
  <li><strong>key [required]</strong> The key to return the attribute of.</li>
</ul>';
$lang['admin']['forge'] = 'Forge';
$lang['admin']['disable_wysiwyg'] = 'Disable WYSIWYG editor on this page (regardless of template or user settings)';
$lang['admin']['help_function_page_image'] = '<h3>What does this do?</h3>
<p>This tag can be used to return the value of the image or thumbnail fields of a certain page.</p>
<h3>How do I use it?</h3>
<p>Insert the tag into the template like: <code>{page_image}</code>.</p>
<h3>What parameters does it take?</h3>
<ul>
  <li>thumbnail - Optionally display the value of the thumbnail property instead of the image property.</li>
</ul>';
$lang['admin']['pagelink_circular'] = 'A page link cannot list another page link as its destination';
$lang['admin']['destinationnotfound'] = 'The selected page could not be found or is invalid';
$lang['admin']['help_function_dump'] = '<h3>What does this do?</h3>
  <p>This tag can be used to dump the contents of any smarty variable in a more readable format.  This is useful for debugging, and editing templates, to know the format and types of data available.</p>
<h3>How do I use it?</h3>
<p>Insert the tag in the template like <code>{dump item=\'the_smarty_variable_to_dump\'}</code>.</p>
<h3>What parameters does it take?</h3>
<ul>
<li><strong>item (required)</strong> - The smarty variable to dump the contents of.</li>
<li>maxlevel - The maximum number of levels to recurse (applicable only if recurse is also supplied.  The default value for this parameter is 3</li>
<li>nomethods - Skip output of methods from objects.</li>
<li>novars - Skip output of object members.</li>
<li>recurse - Recurse a maximum number of levels through the objects providing verbose output for each item until the maximum number of levels is reached.</li>
</ul>';
$lang['admin']['sqlerror'] = 'Sbagl da SQL en %s';
$lang['admin']['image'] = 'Maletg';
$lang['admin']['thumbnail'] = 'Thumbnail ';
$lang['admin']['searchable'] = 'En il cuntegn da questa pagina pon ins tschertgar';
$lang['admin']['help_function_content_image'] = '<h3>What does this do?</h3>
<p>This plugin allows template designers to prompt users to select an image file when editing the content of a page. It behaves similarly to the content plugin, for additional content blocks.</p>
<h3>How do I use it?</h3>
<p>Just insert the tag into your page template like: <code>{content_image block=\'image1\'}</code>.</p>
<h3>What parameters does it take?</h3>
<ul>
  <li><strong>(required)</strong> block - The name for this additional content block.
  <p>Example:</p>
  <pre>{content_image block=\'image1\'}</pre><br/>
  </li>

  <li><em>(optional)</em> label - A label or prompt for this content block in the edit content page.  If not specified, the block name will be used.</li>
 
  <li><em>(optional)</em> dir - The name of a directory (relative to the uploads directory, from which to select image files. If not specified, the uploads directory will be used.
  <p>Example: use images from the uploads/image directory.</p>
  <pre>{content_image block=\'image1\' dir=\'images\'}</pre><br/>
  </li>

  <li><em>(optional)</em> class - The css class name to use on the img tag in frontend display.</li>

  <li><em>(optional)</em> id - The id name to use on the img tag in frontend display.</li> 

  <li><em>(optional)</em> name - The tag name to use on the img tag in frontend display.</li> 

  <li><em>(optional)</em> width - The desired width of the image.</li>

  <li><em>(optional)</em> height - The desired height of the image.</li>

  <li><em>(optional)</em> alt - Alternative text if the image cannot be found.</li>


</ul>';
$lang['admin']['error_udt_name_chars'] = 'A valid UDT name starts with a letter or underscore, followed by any number of letters, numbers, or underscores.';
$lang['admin']['errorupdatetemplateallpages'] = 'Il template n\'è betg activs';
$lang['admin']['hidefrommenu'] = 'Zuppar en il menu';
$lang['admin']['settemplate'] = 'Set Template';
$lang['admin']['text_settemplate'] = 'Set Selected Pages to a different Template';
$lang['admin']['cachable'] = 'Cachable';
$lang['admin']['noncachable'] = 'Non Cachable';
$lang['admin']['copy_from'] = 'Copiar da';
$lang['admin']['copy_to'] = 'Copiar a';
$lang['admin']['copycontent'] = 'Copiar in element dal cuntegn';
$lang['admin']['md5_function'] = 'Funcziun da md5';
$lang['admin']['tempnam_function'] = 'tempnam function';
$lang['admin']['register_globals'] = 'PHP register_globals';
$lang['admin']['output_buffering'] = 'PHP output_buffering';
$lang['admin']['disable_functions'] = 'disable_functions in PHP';
$lang['admin']['xml_function'] = 'Basic XML (expat) support';
$lang['admin']['magic_quotes_gpc'] = 'Magic quotes for Get/Post/Cookie';
$lang['admin']['magic_quotes_gpc_on'] = 'Single-quote, double quote and backslash are escaped automatically. You can to have problems in save templates';
$lang['admin']['magic_quotes_runtime'] = 'Magic quotes in runtime';
$lang['admin']['magic_quotes_runtime_on'] = 'Most functions that return data will have quotes escaped with a backslash. You can to have problems';
$lang['admin']['file_get_contents'] = 'Test file_get_contents';
$lang['admin']['check_ini_set'] = 'Test ini_set';
$lang['admin']['check_ini_set_off'] = 'You may have difficulty with some functionality without this capability. This test may fail if safe_mode is enabled';
$lang['admin']['file_uploads'] = 'File uploads';
$lang['admin']['test_remote_url'] = 'Test for remote URL';
$lang['admin']['test_remote_url_failed'] = 'You will probably not be able to open a file on a remote web server.';
$lang['admin']['test_allow_url_fopen_failed'] = 'When allow url fopen is disabled you will not be able to accessing URL object like file using the ftp or http protocol.';
$lang['admin']['connection_error'] = 'Outgoing http connections do not appear to work! There is a firewall or some ACL for external connections?. This will result in module manager, and potentially other functionality failing.';
$lang['admin']['remote_connection_timeout'] = 'Connection Timed Out!';
$lang['admin']['search_string_find'] = 'Connexiun ok!';
$lang['admin']['connection_failed'] = 'Sbagl tar la connexiun';
$lang['admin']['remote_response_ok'] = 'Remote response: ok!';
$lang['admin']['remote_response_404'] = 'Remote response: not found!';
$lang['admin']['remote_response_error'] = 'Remote response: error!';
$lang['admin']['notifications_to_handle'] = 'You have <b>%d</b> unhandled notifications';
$lang['admin']['notification_to_handle'] = 'You have <b>%d</b> unhandled notification';
$lang['admin']['notifications'] = 'Notifications';
$lang['admin']['dashboard'] = 'View Dashboard';
$lang['admin']['ignorenotificationsfrommodules'] = 'Ignore notifications from these modules';
$lang['admin']['admin_enablenotifications'] = 'Allow users to view notifications<br/><em>(notifications will be displayed on all admin pages)</em>';
$lang['admin']['enablenotifications'] = 'Enable user notifications in the admin section';
$lang['admin']['test_check_open_basedir_failed'] = 'Open basedir restrictions are in effect. You may have difficulty with some addon functionality with this restriction';
$lang['admin']['config_writable'] = 'config.php writable. It is more safe if you change permission to read-only';
$lang['admin']['caution'] = 'Attenziun';
$lang['admin']['create_dir_and_file'] = 'Checking if the httpd process can create a file inside of a directory it created';
$lang['admin']['os_session_save_path'] = 'No check because OS path';
$lang['admin']['unlimited'] = 'Illimità';
$lang['admin']['open_basedir'] = 'PHP Open Basedir';
$lang['admin']['open_basedir_active'] = 'No check because open basedir active';
$lang['admin']['invalid'] = 'Nunvalid';
$lang['admin']['checksum_passed'] = 'All checksums match those in the uploaded file';
$lang['admin']['error_retrieving_file_list'] = 'Errur durant dumandar la glista da datotecas';
$lang['admin']['files_checksum_failed'] = 'Files could not be checksummed';
$lang['admin']['failure'] = 'Errur';
$lang['admin']['help_function_process_pagedata'] = '<h3>What does this do?</h3>
<p>This plugin will process the data in the "pagedata" block of content pages through smarty.  It allows you to specify page specific data to smarty without changing the template for each page.</p>
<h3>How do I use it?</h3>
<ol>
  <li>Insert smarty assign variables and other smarty logic into the pagedata field of some of your content pages.</li>
  <li>Insert the <code>{process_pagedata}</code> tag into the very top of your page template.</li>
</ol>
<br/>
<h3>What parameters does it take?</h3>
<p>None at this time</p>';
$lang['admin']['page_metadata'] = 'Page Specific Metadata';
$lang['admin']['pagedata_codeblock'] = 'Smarty data or logic that is specific to this page';
$lang['admin']['error_uploadproblem'] = 'In sbagl è capità cun chargiar si';
$lang['admin']['error_nofileuploaded'] = 'Nagina datoteca è vegnida chargiada si';
$lang['admin']['files_failed'] = 'Files failed md5sum check';
$lang['admin']['files_not_found'] = 'Betg chattà las datotecas';
$lang['admin']['info_generate_cksum_file'] = 'This function will allow you to generate a checksum file and save it on your local computer for later validation.  This should be done just prior to rolling out the website, and/or after any upgrades, or major modifications.';
$lang['admin']['info_validation'] = 'This function will compare the checksums found in the uploaded file with the files on the current installation.  It can assist in finding problems with uploads, or exactly what files were modified if your system has been hacked.  A checksum file is generated for each release of CMS Made simple from version 1.4 on.';
$lang['admin']['download_cksum_file'] = 'Download Checksum File';
$lang['admin']['perform_validation'] = 'Perform Validation';
$lang['admin']['upload_cksum_file'] = 'Upload Checksum File';
$lang['admin']['checksumdescription'] = 'Validate the integrity of CMS files by comparing against known checksums';
$lang['admin']['system_verification'] = 'System Verification';
$lang['admin']['extra1'] = 'Extra Page Attribute 1';
$lang['admin']['extra2'] = 'Extra Page Attribute 2';
$lang['admin']['extra3'] = 'Extra Page Attribute 3';
$lang['admin']['start_upgrade_process'] = 'Start Upgrade Process';
$lang['admin']['warning_upgrade'] = '<em><strong>Warning:</strong></em> CMSMS is in need of an upgrade.';
$lang['admin']['warning_upgrade_info1'] = 'You are now running schema version %s. and you need to be upgraded to version %s';
$lang['admin']['warning_upgrade_info2'] = 'Please click the following link: %s.';
$lang['admin']['warning_mail_settings'] = 'Your mail settings have not been configured.  This could interfere with the ability of your website to send email messages.  You should go to <a href="moduleinterface.php?module=CMSMailer">Extensions >> CMSMailer</a> and configure the mail settings with the information provided by your host.';
$lang['admin']['view_page'] = 'Guardar questa pagina en ina nova fanestra';
$lang['admin']['off'] = 'Off';
$lang['admin']['on'] = 'On';
$lang['admin']['invalid_test'] = 'Invalid test param value!';
$lang['admin']['copy_paste_forum'] = 'View Text Report <em>(suitable for copying into forum posts)</em>';
$lang['admin']['permission_information'] = 'Infurmaziuns d\'autorisaziun';
$lang['admin']['server_os'] = 'Server Operating System';
$lang['admin']['server_api'] = 'Server API';
$lang['admin']['server_software'] = 'Server Software';
$lang['admin']['server_information'] = 'Infurmaziuns dal server ';
$lang['admin']['session_save_path'] = 'Session Save Path';
$lang['admin']['max_execution_time'] = 'Maximum Execution Time';
$lang['admin']['gd_version'] = 'GD version';
$lang['admin']['upload_max_filesize'] = 'Maximum Upload Size';
$lang['admin']['post_max_size'] = 'Maximum Post Size';
$lang['admin']['memory_limit'] = 'PHP Effective Memory Limit';
$lang['admin']['server_db_type'] = 'Server Database';
$lang['admin']['server_db_version'] = 'Server Database Version';
$lang['admin']['phpversion'] = 'Current PHP Version';
$lang['admin']['safe_mode'] = 'PHP Safe Mode';
$lang['admin']['php_information'] = 'PHP Information';
$lang['admin']['cms_install_information'] = 'Infurmaziuns da l\'installaziun dal CMS';
$lang['admin']['cms_version'] = 'Versiun dal CMS';
$lang['admin']['installed_modules'] = 'Moduls installads';
$lang['admin']['config_information'] = 'Infurmaziuns config';
$lang['admin']['systeminfo_copy_paste'] = 'Please copy and paste this selected text into your forum posting';
$lang['admin']['help_systeminformation'] = 'The information displayed below is collected from a variety of locations, and summarized here so that you may be able to conveniently find some of the information required when trying to diagnose a problem or request help with your CMS Made Simple installation.';
$lang['admin']['systeminfo'] = 'Infurmaziuns dal sistem';
$lang['admin']['systeminfodescription'] = 'Display various pieces of information about your system that may be useful in diagnosing problems';
$lang['admin']['welcome_user'] = 'Bainvegni';
$lang['admin']['itsbeensincelogin'] = 'Igl è passà %s dapi tia davosa annunzai';
$lang['admin']['days'] = 'dis';
$lang['admin']['day'] = 'di';
$lang['admin']['hours'] = 'uras';
$lang['admin']['hour'] = 'ura';
$lang['admin']['minutes'] = 'minutas';
$lang['admin']['minute'] = 'minuta';
$lang['admin']['help_css_max_age'] = 'This parameter should be set relatively high for static sites, and should be set to 0 for site development';
$lang['admin']['css_max_age'] = 'Maximum amount of time (seconds) stylesheets can be cached in the browser';
$lang['admin']['error'] = 'Sbagl';
$lang['admin']['clear_version_check_cache'] = 'Clear any cached version check information on submit';
$lang['admin']['new_version_available'] = '<em>Notice:</em> A new version of CMS Made Simple is available.  Please notify your administrator.';
$lang['admin']['info_urlcheckversion'] = 'If this url is the word "none" no checks will be made.<br/>An empty string will result in a default URL being used.';
$lang['admin']['urlcheckversion'] = 'Tschertgar novas versiuns dal CMS cun questa URL';
$lang['admin']['master_admintheme'] = 'Theme d\'administraziun da standard (per la pagina d\'annunzia e novs utilisaders)';
$lang['admin']['contenttype_separator'] = 'Separatur';
$lang['admin']['contenttype_sectionheader'] = 'Titel d\'ina secziun';
$lang['admin']['contenttype_link'] = 'Colliaziun externa';
$lang['admin']['contenttype_content'] = 'Cuntegn';
$lang['admin']['contenttype_pagelink'] = 'Colliaziun interna';
$lang['admin']['nogcbwysiwyg'] = 'Disallow WYSIWYG editors on global content blocks';
$lang['admin']['destination_page'] = 'Destination Page';
$lang['admin']['additional_params'] = 'Additional Parameters';
$lang['admin']['help_function_current_date'] = '	<h3>What does this do?</h3>
	<p>Prints the current date and time.  If no format is given, it will default to a format similar to \'Jan 01, 2004\'.</p>
	<h3>How do I use it?</h3>
	<p>Just insert the tag into your template/page like: <code>{current_date format="%A %d-%b-%y %T %Z"}</code></p>
	<h3>What parameters does it take?</h3>
	<ul>
		<li><em>(optional)</em>format - Date/Time format using parameters from php\'s strftime function.  See <a href="http://php.net/strftime" target="_blank">here</a> for a parameter list and information.</li>
		<li><em>(optional)</em>ucword - If true return uppercase the first character of each word.</li>
	</ul>
	</p>';
$lang['admin']['help_function_valid_xhtml'] = '<h3>What does this do?</h3>
<p>Returns a link to the w3c HTML validator.</p>
<h3>How do I use it?</h3>
<p>Just insert the tag into your template/page like: <code>{valid_xhtml}</code></p>
<h3>What parameters does it take?</h3>
<p>
    <ul>
	<li><em>(optional)</em> url         (string)     - The URL used for validation, if none is given http://validator.w3.org/check/referer is used.</li>
	<li><em>(optional)</em> class       (string)     - If set, this will be used as class attribute for the link (a) element</li>
	<li><em>(optional)</em> target      (string)     - If set, this will be used as target attribute for the link (a) element</li>
	<li><em>(optional)</em> image       (true/false) - If set to false, a text link will be used instead of an image/icon.</li>
	<li><em>(optional)</em> text        (string)     - If set, this will be used for the link text or alternate text for the image. Default is \'valid XHTML 1.0 Transitional\'.<br /> When an image is used, the given string will also be used for the image alt attribute (by default, this can be overridden by using the \'alt\' parameter).</li>
	<li><em>(optional)</em> image_class (string)     - Only if \'image\' is not set to false. If set, this will be used as class attribute for the image (img) element</li>
	<li><em>(optional)</em> src         (string)     - Only if \'image\' is not set to false. The icon to show. Default is http://www.w3.org/Icons/valid-xhtml10</li>
	<li><em>(optional)</em> width       (string)     - Only if \'image\' is not set to false. The image width. Default is 88 (width of http://www.w3.org/Icons/valid-xhtml10)</li>
	<li><em>(optional)</em> height      (string)     - Only if \'image\' is not set to false. The image height. Default is 31 (height of http://www.w3.org/Icons/valid-xhtml10)</li>
	<li><em>(optional)</em> alt         (string)     - Only if \'image\' is not set to false. The alternate text (\'alt\' attribute) for the image (element). If none is given the link text will be used.</li>
    </ul>
</p>';
$lang['admin']['help_function_valid_css'] = '<h3>What does this do?</h3>
<p>Returns a link to the w3c CSS validator.</p>
<h3>How do I use it?</h3>
<p>Just insert the tag into your template/page like: <code>{valid_css}</code></p>
<h3>What parameters does it take?</h3>
<p>
    <ul>
        <li><em>(optional)</em> url         (string)     - The URL used for validation, if none is given http://jigsaw.w3.org/css-validator/check/referer is used.</li>
	<li><em>(optional)</em> class       (string)     - If set, this will be used as class attribute for the link (a) element</li>
	<li><em>(optional)</em> target      (string)     - If set, this will be used as target attribute for the link (a) element</li>
	<li><em>(optional)</em> image       (true/false) - If set to false, a text link will be used instead of an image/icon.</li>
	<li><em>(optional)</em> text        (string)     - If set, this will be used for the link text or alternate text for the image. Default is \'Valid CSS 2.1\'.<br /> When an image is used, the given string will also be used for the image alt attribute (by default, this can be overridden by using the \'alt\' parameter).</li>
	<li><em>(optional)</em> image_class (string)     - Only if \'image\' is not set to false. If set, this will be used as class attribute for the image (img) element</li>
        <li><em>(optional)</em> src         (string)     - Only if \'image\' is not set to false. The icon to show. Default is http://jigsaw.w3.org/css-validator/images/vcss</li>
        <li><em>(optional)</em> width       (string)     - Only if \'image\' is not set to false. The image width. Default is 88 (width of http://jigsaw.w3.org/css-validator/images/vcss)</li>
        <li><em>(optional)</em> height      (string)     - Only if \'image\' is not set to false. The image height. Default is 31 (height of http://jigsaw.w3.org/css-validator/images/vcss)</li>
	<li><em>(optional)</em> alt         (string)     - Only if \'image\' is not set to false. The alternate text (\'alt\' attribute) for the image (element). If none is given the link text will be used.</li>
    </ul>
</p>';
$lang['admin']['help_function_title'] = '	<h3>What does this do?</h3>
	<p>Prints the title of the page.</p>
	<h3>How do I use it?</h3>
	<p>Just insert the tag into your template/page like: <code>{title}</code></p>
	<h3>What parameters does it take?</h3>
	<p><em>(optional)</em> assign (string) - Assign the results to a smarty variable with that name.</p>';
$lang['admin']['help_function_stylesheet'] = '	<h3>What does this do?</h3>
	<p>Gets stylesheet information from the system.  By default, it grabs all of the stylesheets attached to the current template.</p>
	<h3>How do I use it?</h3>
	<p>Just insert the tag into your template/page\'s head section like: <code>{stylesheet}</code></p>
	<h3>What parameters does it take?</h3>
	<ul>
		<li><em>(optional)</em>name - Instead of getting all stylesheets for the given page, it will only get one spefically named one, whether it\'s attached to the current template or not.</li>
		<li><em>(optional)</em>media - If name is defined, this allows you set a different media type for that stylesheet.</li>
	</ul>
	</p>';
$lang['admin']['help_function_stopexpandcollapse'] = '	<h3>What does this do?</h3>
	<p>Enables content to be expandable and collapsable. Like the following:<br />
	<a href="#expand1" onClick="expandcontent(\'expand1\')" style="cursor:hand; cursor:pointer">Click here for more info</a><span id="expand1" class="expand"><a name="help"></a> - Here is all the info you will ever need...</a></span></p>

	<h3>How do I use it?</h3>
	<p>Just insert the tag into your template/page like:<br />
	<br />
	<code>{startExpandCollapse id="name" title="Click Here"}<br />
	This is all the content the user will see when they click the title "Click Here" above. It will display all the content that is between the {startExpandCollapse} and {stopExpandCollapse} when clicked.<br />
	{stopExpandCollapse}
	</code>
	<br />
	<br />
	Note: If you intend to use this multiple times on a single page each startExpandCollapse tag must have a unique id.</p>
	<h3>What if I want to change the look of the title?</h3>
	<p>The look of the title can be changed via css. The title is wrapped in a div with the id you specify.</p>

	<h3>What parameters does it take?</h3>
	<p>
	<i>startExpandCollapse takes the following parameters</i><br />
	&nbsp; &nbsp;id - A unique id for the expand/collapse section.<br />
	&nbsp; &nbsp;title - The text that will be displayed to expand/collapse the content.<br />
	<i>stopExpandCollapse takes no parameters</i><br />
	</p>';
$lang['admin']['help_function_startexpandcollapse'] = '	<h3>What does this do?</h3>
	<p>Enables content to be expandable and collapsable. Like the following:<br />
	<a href="#expand1" onClick="expandcontent(\'expand1\')" style="cursor:hand; cursor:pointer">Click here for more info</a><span id="expand1" class="expand"><a name="help"></a> - Here is all the info you will ever need...</a></span></p>

	<h3>How do I use it?</h3>
	<p>Just insert the tag into your template/page like: <code>{startExpandCollapse id="name" title="Click Here"}</code>. Also, you must use the {stopExpandCollapse} at the end of the collapseable content. Here is an example:<br />
	<br />
	<code>{startExpandCollapse id="name" title="Click Here"}<br />
	This is all the content the user will see when they click the title "Click Here" above. It will display all the content that is between the {startExpandCollapse} and {stopExpandCollapse} when clicked.<br />
	{stopExpandCollapse}
	</code>
	<br />
	<br />
	Note: If you intend to use this multiple times on a single page each startExpandCollapse tag must have a unique id.</p>
	<h3>What if I want to change the look of the title?</h3>
	<p>The look of the title can be changed via css. The title is wrapped in a div with the id you specify.</p>

	<h3>What parameters does it take?</h3>
	<p>
	<i>startExpandCollapse takes the following parameters</i><br />
	&nbsp; &nbsp;id - A unique id for the expand/collapse section.<br />
	&nbsp; &nbsp;title - The text that will be displayed to expand/collapse the content.<br />
	<i>stopExpandCollapse takes no parameters</i><br />
	</p>';
$lang['admin']['help_function_sitemap'] = '    <h3>Notice</h3>
    <p>This plugin is deprecated.  Users should now see the <code>{site_mapper}</code> plugin.</p>
    <h3>What does this do?</h3>
    <p>Prints out a sitemap.</p>
    <h3>How do I use it?</h3>
    <p>Just insert the tag into your template/page like: <code>{sitemap}</code></p>
    <h3>What parameters does it take?</h3>
    <p>
        <ul>
            <li><em>(optional)</em> <tt>class</tt> - A css_class for the ul-tag which includes the complete sitemap.</li>
            <li><em>(optional)</em> <tt>start_element</tt> - The hierarchy of your element (ie : 1.2 or 3.5.1 for example). This parameter sets the root of the menu. You can use the page alias instead of hierarchy.</li>
            <li><em>(optional)</em> <tt>number_of_levels</tt> - An integer, the number of levels you want to show in your menu. Should be set to 2 using a delimiter.</li>
            <li><em>(optional)</em> <tt>delimiter</tt> - Text to separate entries not on depth 1 of the sitemap (i.e. 1.1, 1.2). This is helpful for showing entries on depth 2 beside each other (using css display:inline).</li>
            <li><em>(optional)</em> <tt>initial 1/0</tt> - If set to 1, begin also the first entries not on depth 1 with a delimiter (i.e. 1.1, 2.1).</li>
            <li><em>(optional)</em> <tt>relative 1/0</tt> - We are not going to show current page (with the sitemap) - we\'ll show only his childs.</li>
            <li><em>(optional)</em> <tt>showall 1/0</tt> - We are going to show all pages if showall is enabled, else we\'ll only show pages with active menu entries.</li>
            <li><em>(optional)</em> <tt>add_elements</tt> - A comma separated list of alias names which will be added to the shown pages with active menu entries (showall not enabled).</li>
        </ul>
        </p>';
$lang['admin']['help_function_adsense'] = '	<h3>What does this do?</h3>
	<p>Google adsense is a popular advertising program for websites.  This tag will take the basic parameters that would be provided by the adsense program and puts them in a easy to use tag that makes your templates look much cleaner.  See <a href="http://www.google.com/adsense" target="_blank">here</a> for more details on adsense.</p>
	<h3>How do I use it?</h3>
	<p>First, sign up for a google adsense account and get the parameters for your ad.  Then just use the tag in your page/template like so: <code>{adsense ad_client="pub-random#" ad_width="120" ad_height="600" ad_format="120x600_as"}</code>
	<h3>What parameters does it take?</h3>
	<p>All parameters are optional, though skipping one might not necessarily made the ad work right.  Options are:
	<ul>
		<li>ad_client - This would be the pub_random# id that would represent your adsense account number</li>
		<li>ad_width - width of the ad</li>
		<li>ad_height - height of the ad</li>
		<li>ad_format - "format" of the ad <em>e.g. 120x600_as</em></li>
		<li>ad_channel - channels are an advanced feature of adsense.  Put it here if you use it.</li>
		<li>ad_type - possible options are text, image or text_image.</li>
		<li>color_border - the color of the border. Use HEX color or type the color name (Ex. Red)</li>
		<li>color_link - the color of the linktext. Use HEX color or type the color name (Ex. Red)</li>
		<li>color_url - the color of the URL. Use HEX color or type the color name (Ex. Red)</li>
		<li>color_text - the color of the text. Use HEX color or type the color name (Ex. Red)</li>
	</ul>
	</p>';
$lang['admin']['help_function_sitename'] = '        <h3>What does this do?</h3>
        <p>Shows the name of the site.  This is defined during install and can be modified in the Global Settings section of the admin panel.</p>
        <h3>How do I use it?</h3>
        <p>Just insert the tag into your template/page like: <code>{sitename}</code></p>
        <h3>What parameters does it take?</h3>
	<p><em>(optional)</em> assign (string) - Assign the results to a smarty variable with that name.</p>';
$lang['admin']['help_function_search'] = '	<h3>What does this do?</h3>
	<p>This is actually just a wrapper tag for the <a href="listmodules.php?action=showmodulehelp&module=Search">Search module</a> to make the tag syntax easier. 
	Instead of having to use <code>{cms_module module=\'Search\'}</code> you can now just use <code>{search}</code> to insert the module in a template.
	</p>
	<h3>How do I use it?</h3>
	<p>Just put <code>{search}</code> in a template where you want the search input box to appear. For help about the Search module, please refer to the <a href="listmodules.php?action=showmodulehelp&module=Search">Search module help</a>.';
$lang['admin']['help_function_root_url'] = '	<h3>What does this do?</h3>
	<p>Prints the root url location for the site.</p>
	<h3>How do I use it?</h3>
	<p>Just insert the tag into your template/page like: <code>{root_url}</code></p>
	<h3>What parameters does it take?</h3>
	<p>None at this time.</p>';
$lang['admin']['help_function_repeat'] = '  <h3>What does this do?</h3>
  <p>Repeats a specified sequence of characters, a specified number of times</p>
  <h3>How do I use it?</h3>
  <p>Insert a tag similar to the following into your template/page, like this: <code>{repeat string=\'repeat this \' times=\'3\'}</code>
  <h3>What parameters does it take?</h3>
  <ul>
  <li>string=\'text\' - The string to repeat</li>
  <li>times=\'num\' - The number of times to repeat it.</li>
  </ul>';
$lang['admin']['help_function_recently_updated'] = '	<h3>What does this do?</h3>
	<p>Outputs a list of recently updated pages.</p>
	<h3>How do I use it?</h3>
	<p>Just insert the tag into your template/page like: <code>{recently_updated}</code></p>
	<h3>What parameters does it take?</h3>
	<ul>
	 <li><p><em>(optional)</em> number=\'10\' - Number of updated pages to show.</p><p>Example: <pre>{recently_updated number=\'15\'}</pre></p></li>
 	 <li><p><em>(optional)</em> leadin=\'Last changed\' - Text to show left of the modified date.</p><p>Example: <pre>{recently_updated leadin=\'Last Changed\'}</pre></p></li>
 	 <li><p><em>(optional)</em> showtitle=\'true\' - Shows the titleattribute if it exists as well (true|false).</p><p>Example: <pre>{recently_updated showtitle=\'true\'}</pre></p></li>											 	
	 <li><p><em>(optional)</em> css_class=\'some_name\' - Warp a div tag with this class around the list.</p><p>Example: <pre>{recently_updated css_class=\'some_name\'}</pre></p></li>											 	
	 <li><p><em>(optional)</em> dateformat=\'d.m.y h:m\' - default is d.m.y h:m , use the format you whish (php -date- format)</p><p>Example: <pre>{recently_updated dateformat=\'D M j G:i:s T Y\'}</pre></p></li>											 	
	</ul>
	<p>or combined:</p>
	<pre>{recently_updated number=\'15\' showtitle=\'false\' leadin=\'Last Change: \' css_class=\'my_changes\' dateformat=\'D M j G:i:s T Y\'}</pre>';
$lang['admin']['help_function_print'] = '	<h3>What does this do?</h3>
	<p>This is actually just a wrapper tag for the <a href="listmodules.php?action=showmodulehelp&module=Printing">Printing module</a> to make the tag syntax easier. 
	Instead of having to use <code>{cms_module module=\'Printing\'}</code> you can now just use <code>{print}</code> to insert the module on pages and templates.
	</p>
	<h3>How do I use it?</h3>
	<p>Just put <code>{print}</code> on a page or in a template. For help about the Printing module, what parameters it takes etc., please refer to the <a href="listmodules.php?action=showmodulehelp&module=Printing">Printing module help</a>.';
$lang['admin']['help_function_oldprint'] = '	<h3>What does this do?</h3>
	<p>Creates a link to only the content of the page.</p>
	<h3>How do I use it?</h3>
	<p>Just insert the tag into your template/page like: <code>{oldprint}</code><br></p>
        <h3>What parameters does it take?</h3>
        <ul>
                <li><em>(optional)</em> goback - Set to "true" to show a "Go Back" link on the page to print.</li>
                <li><em>(optional)</em> popup - Set to "true" and page for printing will by opened in new window.</li>
                <li><em>(optional)</em> script - Set to "true" and in print page will by used java script for run print of page.</li>
                <li><em>(optional)</em> showbutton - Set to "true" and will show a printer graphic instead of a text link.</li>
                <li><em>(optional)</em> class - class for the link, defaults to "noprint".</li>
                <li><em>(optional)</em> text - Text to use instead of "Print This Page" for the print link.
                <li><em>(optional)</em> title - Text to show for title attribute. If blank show text parameter.</li>
                <li><em>(optional)</em> more - Place additional options inside the <a> link.</li>
                <li><em>(optional)</em> src_img - Show this image file. Default images/cms/printbutton.gif.</li>
                <li><em>(optional)</em> class_img - Class of <img> tag if showbutton is sets.</li>

                    <p>Example:</p>
                     <pre>{oldprint text="Printable Page"}</pre>      
                     </li>
        </ul>';
$lang['admin']['login_info_title'] = 'Infurmaziuns';
$lang['admin']['login_info'] = 'From this point should take into consideration the following parameters';
$lang['admin']['login_info_params'] = '<ol> 
  <li>Cookies enabled in your browser</li> 
  <li>Javascript enabled in your browser </li> 
  <li>Windows popup active to the following address:</li> 
</ol>';
$lang['admin']['help_function_news'] = '	<h3>What does this do?</h3>
	<p>This is actually just a wrapper tag for the <a href="listmodules.php?action=showmodulehelp&module=News">News module</a> to make the tag syntax easier. 
	Instead of having to use <code>{cms_module module=\'News\'}</code> you can now just use <code>{news}</code> to insert the module on pages and templates.
	</p>
	<h3>How do I use it?</h3>
	<p>Just put <code>{news}</code> on a page or in a template. For help about the News module, what parameters it takes etc., please refer to the <a href="listmodules.php?action=showmodulehelp&module=News">News module help</a>.';
$lang['admin']['help_function_modified_date'] = '        <h3>What does this do?</h3>
        <p>Prints the date and time the page was last modified.  If no format is given, it will default to a format similar to \'Jan 01, 2004\'.</p>
        <h3>How do I use it?</h3>
        <p>Just insert the tag into your template/page like: <code>{modified_date format="%A %d-%b-%y %T %Z"}</code></p>
        <h3>What parameters does it take?</h3>
        <ul>
                <li><em>(optional)</em>format - Date/Time format using parameters from php\'s strftime function.  See <a href="http://php.net/strftime" target="_blank">here</a> for a parameter list and information.</li>
        </ul>';
$lang['admin']['help_function_metadata'] = '	<h3>What does this do?</h3>
	<p>Displays the metadata for this page. Both global metdata from the global settings page and metadata for each page will be shown.</p>
	<h3>How do I use it?</h3>
	<p>Just insert the tag into your template like: <code>{metadata}</code></p>
	<h3>What parameters does it take?</h3>
	<ul>
		<li><em>(optional)</em>showbase (true/false) - If set to false, the base tag will not be sent to the browser.  Defaults to true if use_hierarchy is set to true in config.php.</li>
	</ul>';
$lang['admin']['help_function_menu_text'] = '	<h3>What does this do?</h3>
	<p>Prints the menu text of the page.</p>
	<h3>How do I use it?</h3>
	<p>Just insert the tag into your template/page like: <code>{menu_text}</code></p>
	<h3>What parameters does it take?</h3>
	<p>None at this time.</p>';
$lang['admin']['help_function_menu'] = '	<h3>What does this do?</h3>
	<p>This is actually just a wrapper tag for the <a href="listmodules.php?action=showmodulehelp&module=MenuManager">Menu Manager module</a> to make the tag syntax easier. 
	Instead of having to use <code>{cms_module module=\'MenuManager\'}</code> you can now just use <code>{menu}</code> to insert the module on pages and templates.
	</p>
	<h3>How do I use it?</h3>
	<p>Just put <code>{menu}</code> on a page or in a template. For help about the Menu Manager module, what parameters it takes etc., please refer to the <a href="listmodules.php?action=showmodulehelp&module=MenuManager">Menu Manager module help</a>.';
$lang['admin']['help_function_last_modified_by'] = '        <h3>What does this do?</h3>
        <p>Prints last person that edited this page.  If no format is given, it will default to a ID number of user .</p>
        <h3>How do I use it?</h3>
        <p>Just insert the tag into your template/page like: <code>{last_modified_by format="fullname"}</code></p>
        <h3>What parameters does it take?</h3>
        <ul>
                <li><em>(optional)</em>format - id, username, fullname</li>
        </ul>';
$lang['admin']['help_function_image'] = '  <h3>What does this do?</h3>
  <p>Creates an image tag to an image stored within your images directory</p>
  <h3>How do I use it?</h3>
  <p>Just insert the tag into your template/page like: <code>{image src="something.jpg"}</code></p>
  <h3>What parameters does it take?</h3>
  <ul>
     <li><em>(required)</em>  <tt>src</tt> - Image filename within your images directory.</li>
     <li><em>(optional)</em>  <tt>width</tt> - Width of the image within the page. Defaults to true size.</li>
     <li><em>(optional)</em>  <tt>height</tt> - Height of the image within the page. Defaults to true size.</li>
     <li><em>(optional)</em>  <tt>alt</tt> - Alt text for the image -- needed for xhtml compliance. Defaults to filename.</li>
     <li><em>(optional)</em>  <tt>class</tt> - CSS class for the image.</li>
     <li><em>(optional)</em>  <tt>title</tt> - Mouse over text for the image. Defaults to Alt text.</li>
     <li><em>(optional)</em>  <tt>addtext</tt> - Additional text to put into the tag</li>
  </ul>';
$lang['admin']['help_function_imagegallery'] = '	<h3>What does this do?</h3>
	<p>Creates a gallery out of a folder of images (.gif, .jpg or .png). 
	You can click on a thumbnail image to view the bigger image. It can use 
	captions which are based on the image name, minus the file extension. It 
	follows web standards and uses CSS for formatting. There are classes 
	for various elements and for the surrounding \'div\'. Check out the CSS below for
	more information.</p>

	<h3>How do I use it?</h3>
	<p>Just insert the tag into your template or page like: </p>
	<code>{ImageGallery picFolder="uploads/images/yourfolder/"}</code>
	<p>Where picFolder is the folder where your images are stored.</p>
	
    <h3>What parameters does it take?</h3>
    <p>It can take quite a few parameters, but the example above is probably 
good for most people :) </p>
        <ol>
		<li><strong>picFolder e.g. picFolder="uploads/images/yourfolder/"</strong><br/>
		Is the path to the gallery (yourfolder) ending in\'/\'. So you can have 
		lots of directories and lots of galleries.</li>

		<li><strong>type e.g. type="click" or type="popup"</strong><br/>
		For the "popup" function to work you need to include the popup javascript into
		the head of your template e.g. "<head></head>". The javascript is at
		the bottom of this page! <em>The default is \'click\'.</em></li>

		<li><strong>divID e.g. divID ="imagegallery"</strong><br/>
		Sets the wrapping \'div id\' around your gallery so that you can have 
		different CSS for each gallery. <em>The default is \'imagegallery\'.</em></li>

		<li><strong>sortBy e.g. sortBy = "name" or sortBy = "date"</strong><br/>
		Sort images by \'name\' OR \'date\'. <em>No default.</em></li>

		<li><strong>sortByOrder e.g. sortByOrder = "asc" or sortByOrder = "desc"</strong><br/> 
		 <em>No default.</em>.</li>

		<li>This sets caption above the big (clicked on) image<br/>
		<strong>bigPicCaption = "name" </strong>(filename excluding extension)<em> or </em><br/>
		<strong>bigPicCaption = "file" </strong>(filename including extension)<em> or </em><br/>
		<strong>bigPicCaption = "number" </strong>(a number sequence)<em> or </em><br/>
		<strong>bigPicCaption = "none" </strong>(No caption)<br/>
		<em>The Default is "name". </em></li>

		<li>This sets the caption below the small thumbnail<br/>
		<strong>thumbPicCaption = "name"</strong> (filename excluding extension)<em> or </em><br/>
		<strong>thumbPicCaption = "file"</strong> (filename including extension)<em> or </em><br/>
		<strong>thumbPicCaption = "number" </strong>(a number sequence)<em> or </em><br/>
		<strong>thumbPicCaption = "none" </strong>(No caption)<br/>
		<em>The Default is "name".</em></li>

		<li>Sets the \'alt\' tag for the big image - compulsory.<br/>
		<strong>bigPicAltTag = "name" </strong>(filename excluding extension)<em> or </em><br/>
		<strong>bigPicAltTag = "file" </strong>(filename including extension)<em> or </em><br/>
		<strong>bigPicAltTag = "number" </strong>(a number sequence)<br/>
		<em>The Default is "name".</em></li>

		<li> Sets the \'title\' tag for the big image. <br/>
		<strong>bigPicTitleTag = "name" </strong>(filename excluding extension)<em> or </em><br/>
		<strong>bigPicTitleTag = "file" </strong>(filename including extension)<em> or </em><br/>
		<strong>bigPicTitleTag = "number" </strong>(a number sequence)<em> or </em><br/>
		<strong>bigPicTitleTag = "none" </strong>(No title)<br/>
		<em>The Default is "name".</em></li>

		<li><strong>thumbPicAltTag</strong><br/>
		<em>Is the same as bigPicAltTag, but for the small thumbnail images.<em></li>

		<li><strong>thumbPicTitleTag *</strong><br/>
		<em>Is the same as bigPicTitleTag but for the small thumbnail images.<br/>
		<strong>*Except that after the options you have \'... click for a bigger image\' 
		or if you do not set this option then you get the default of 
		\'Click for a bigger image...\'</em></strong></li>
        </ol>
  <p>A More Complex Example</p>
        <p>\'div id\' is \'cdcovers\', no Caption on big images, thumbs have default caption. 
        \'alt\' tags for the big image are set to the name of the image file without the extension 
        and the big image \'title\' tag is set to the same but with an extension. 
        The thumbs have the default \'alt\' and \'title\' tags. The default being the name 
        of the image file without the extension for \'alt\' and \'Click for a bigger image...\' for the \'title\',
		would be:</p>
		<code>{ImageGallery picFolder="uploads/images/cdcovers/" divID="cdcovers" bigPicCaption="none"  bigPicAltTag="name" bigPicTitleTag="file"}</code>
        <br/>
		<p>It\'s got lots of options but I wanted to keep it very flexible and you don\'t have to set them, the defaults are sensible.</p>
		
  <br/>
	<h4>Example CSS</h4>
<pre>
	/* Image Gallery - Small Thumbnail Images */
	.thumb {
		margin: 1em 1em 1.6em 0; /* Space between images */
		padding: 0;
		float: left;
		text-decoration: none;
		line-height: normal;
		text-align: left;
	}

	.thumb img, .thumb a img, .thumb a:link img{ /* Set link formatting*/
		width: 100px; /* Image width*/
		height: 100px; /* Image height*/
		display: inline;
		padding: 12px; /* Image padding to form photo frame */
		/* You can set the above to 0px = no frame - but no hover indication! Adjust other widths ot text!*/
		margin: 0;
		background-color: white; /*Background of photo */ 
		border-top: 1px solid #eee; /* Borders of photo frame */
		border-right: 2px solid #ccc;
		border-bottom: 2px solid #ccc;
		border-left: 1px solid #eee;
		text-decoration: none;
	}

	.thumb a:visited img {
		background-color: #eee; /*Background of photo on hover - sort of a light grey */
	}

	.thumb a:hover img {
		background-color: #dae6e4; /*Background of photo on hover - sort of light blue/green */
	}

	.thumbPicCaption {
		text-align: center;
		font-size: smaller;
		margin: 0 1px 0 0;
		padding: 0;
		width: 124px; /* Image width plus 2 x padding for image (photo frame) - to center text on image */
		/* display: none;  if you do not want to display this text */
	}

	/* Image Gallery - Big Images */
	.bigPic {
		margin: 10px 0 5px 0;
		padding: 0;
		line-height: normal;
	}

	.bigPicCaption { /*Big Image Name - above image above .bigpicImageFileName (Without extension) */
		text-align: center;
		font-weight: bold;
		font-variant: small-caps;
		font-weight: bold;
		margin: 0 1px 0 0;
		padding: 0;
		width: 386px; /* Image width plus 2 x padding for image (photo frame) - to center text on image */
		/* display: none;  if you do not want to display this text */
	}

	.bigPic img{ /* Big Image settings */
		width: 350px; /* Width of Big Image */
			height: auto;
		display: inline;
		padding: 18px; /* Image padding to form photo frame. */
		/* You can set the above to 0px = no frame - but no hover indication! Adjust other widths ot text!*/
		margin: 0;
		background-color: white; /* Background of photo */ 
		border-top: 1px solid #eee; /* Borders of photo frame */
		border-right: 2px solid #ccc; 
		border-bottom: 2px solid #ccc;
		border-left: 1px solid #eee;
		text-decoration: none; 
		text-align: left;
	}

	.bigPicNav { /* Big Image information: \'Image 1 of 4\' and gallery navigation */
		margin: 0;
		width: 386px; /* Image width plus 2 x padding for image (photo frame) - to center text on image */
		padding: 0;
		color: #000;
		font-size: smaller;
		line-height: normal;
		text-align: center;
		/* display: none;  if you do not want to display this text. Why? You Lose Navigation! */
	}

</pre>
<br/>

	<h4>The popup javascript is now included in plugin code and will be generated automatically if you still have javascript in your template please remove it.</h4>';
$lang['admin']['help_function_html_blob'] = '	<h3>What does this do?</h3>
	<p>See the help for global_content for a description.</p>';
$lang['admin']['help_function_googlepr'] = '	<h3>What does this do?</h3>
	<p>Display\'s a number that represents your google pagerank.</p>
	<h3>How do I use it?</h3>
	<p>Just insert the tag into your template/page like: <code>{googlepr}</code><br>
	<br>

	<h3>What parameters does it take?</h3>
	<ul>
		<li><em>(optional)</em> domain - The website to display the pagerank for.</li>
	</ul>
	</p>';
$lang['admin']['help_function_google_search'] = '	<h3>What does this do?</h3>
	<p>Search\'s your website using Google\'s search engine.</p>
	<h3>How do I use it?</h3>
	<p>Just insert the tag into your template/page like: <code>{google_search}</code><br>
	<br>
	Note: Google needs to have your website indexed for this to work. You can submit your website to google <a href="http://www.google.com/addurl.html">here</a>.</p>
	<h3>What if I want to change the look of the textbox or button?</h3>
	<p>The look of the textbox and button can be changed via css. The textbox is given an id of textSearch and the button is given an id of buttonSearch.</p>

	<h3>What parameters does it take?</h3>
	<ul>
		<li><em>(optional)</em> domain - This tells google the website domain to search. This script tries to determine this automatically.</li>
		<li><em>(optional)</em> buttonText - The text you want to display on the search button. The default is "Search Site".</li>
	</ul>
	</p>';
$lang['admin']['help_function_global_content'] = '	<h3>What does this do?</h3>
	<p>Inserts a global content block into your template or page.</p>
	<h3>How do I use it?</h3>
	<p>Just insert the tag into your template/page like: <code>{global_content name=\'myblob\'}</code>, where name is the name given to the block when it was created.</p>
	<h3>What parameters does it take?</h3>
	<ul>
  	  <li>name - The name of the global content block to display.</li>
          <li><em>(optional)</em> assign - The name of a smarty variable that the global content block should be assigned to.</li>
	</ul>';
$lang['admin']['help_function_get_template_vars'] = '	<h3>What does this do?</h3>
	<p>Dumps all the known smarty variables into your page</p>
	<h3>How do I use it?</h3>
	<p>Just insert the tag into your template/page like: <code>{get_template_vars}</code></p>
	<h3>What parameters does it take?</h3>
											  <p>None at this time</p>';
$lang['admin']['help_function_embed'] = '	<h3>What does this do?</h3>
	<p>Enable inclusion (embeding) of any other application into the CMS. The most usual use could be a forum. 
	This implementation is using IFRAMES so older browsers can have problems. Sorry bu this is the only known way 
	that works without modifing the embeded application.</p>
	<h3>How do I use it?</h3>
        <ul>
        <li>a) Add <code>{embed header=true}</code> into the head section of your page template, or into the metadata section in the options tab of a content page.  This will ensure that the required javascript gets included.   If you insert this tag into the metadata section in the options tab of a content page you must ensure that <code>{metadata}</code> is in your page template.</li>
        <li>b) Add <code>{embed url="http://www.google.com"}</code> into your page content or in the body of your page template.</li>
        </ul>
        <br/>
        <h4>Example to make the iframe larger</h4>
	<p>Add the following to your style sheet:</p>
        <pre>#myframe { height: 600px; }</pre>
        <br/>
        <h3>What parameters does it take?</h3>
        <ul>
            <li><em>(required)</em>url - the url to be included 
            <li><em>(required)</em>header=true - this will generate the header code for good resizing of the IFRAME.</li>
            <li>(optional)name - an optional name to use for the iframe (instead of myframe).<p>If this option is used, it must be used identically in both calls, i.e: {embed header=true name=foo} and {embed name=foo url=http://www.google.com} calls.</p>
        </ul>';
$lang['admin']['help_function_edit'] = '	<h3>What does this do?</h3>
	<p>Creates a link to edit the page</p>
	<h3>How do I use it?</h3>
	<p>Just insert the tag into your template/page like: <code>{edit}</code><br></p>
        <h3>What parameters does it take?</h3>
        <ul>
                <li><em>(optional)</em>showbutton - Set to "true" and will show a edit graphic instead of a text link.</li>
        </ul>';
$lang['admin']['help_function_description'] = '	<h3>What does this do?</h3>
	<p>Prints the description (title attribute) of the page.</p>
	<h3>How do I use it?</h3>
	<p>Just insert the tag into your template/page like: <code>{description}</code></p>
	<h3>What parameters does it take?</h3>
	<p>None at this time.</p>';
$lang['admin']['help_function_created_date'] = '        <h3>What does this do?</h3>
        <p>Prints the date and time the page was created.  If no format is given, it will default to a format similar to \'Jan 01, 2004\'.</p>
        <h3>How do I use it?</h3>
        <p>Just insert the tag into your template/page like: <code>{created_date format="%A %d-%b-%y %T %Z"}</code></p>
        <h3>What parameters does it take?</h3>
        <ul>
                <li><em>(optional)</em>format - Date/Time format using parameters from php\'s strftime function.  See <a href="http://php.net/strftime" target="_blank">here</a> for a parameter list and information.</li>
        </ul>';
$lang['admin']['help_function_content'] = '	<h3>What does this do?</h3>
	<p>This is where the content for your page will be displayed.  It\'s inserted into the template and changed based on the current page being displayed.</p>
	<h3>How do I use it?</h3>
	<p>Just insert the tag into your template like: <code>{content}</code>.</p>
	<h3>What parameters does it take?</h3>
	<ul>
		<li><em>(optional)</em>block - Allows you to have more than one content block per page.  When multiple content tags are put on a template, that number of edit boxes will be displayed when the page is edited.
<p>Example:</p>
<pre>{content block="Second Content Block"}</pre>
<p>Now, when you edit a page there will a textarea called "Second Content Block".</li>
		<li><em>(optional)</em>wysiwyg (true/false) - If set to false, then a wysiwyg will never be used while editing this block.  If true, then it acts as normal.  Only works when block parameter is used.</li>
		<li><em>(optional)</em>oneline (true/false) - If set to true, then only one edit line will be shown while editing this block.  If false, then it acts as normal.  Only works when block parameter is used.</li>
		<li><em>(optional)</em>default - Allows you to specify default content content for this content blocks (additional content blocks only).</li>
		<li><em>(optional)</em>assign - Assigns the content to a smarty parameter, which you can then use in other areas of the page, or use to test whether content exists in it or not.
<p>Example of passing page content to a User Defined Tag as a parameter:</p>
<pre>
         {content assign=pagecontent}
         {table_of_contents thepagecontent="$pagecontent"}
</pre>
</li>
	</ul>';
$lang['admin']['help_function_contact_form'] = '  <h2>NOTE: This plugin is deprecated</h2>
    <p>This smarty plugin is deprecated, and may not be included with further versions of CMS Made Simple.  We recommend you use the formbuilder module and it\'s included contact form.</p>
	<h3>What does this do?</h3>
	<p>Display\'s a contact form. This can be used to allow others to send an email message to the address specified.</p>
	<h3>How do I use it?</h3>
	<p>Just insert the tag into your template/page like: <code>{contact_form email="yourname@yourdomain.com"}</code><br>
	<br>
	If you would like to send an email to multiple adresses, seperate each address with a comma.</p>
	<h3>What parameters does it take?</h3>
	<ul>
		<li>email - The email address that the message will be sent to.</li>
		<li><em>(optional)</em>style - true/false, use the predefined styles. Default is true.</li>
		<li><em>(optional)</em>subject_get_var - string, allows you to specify which _GET var to use as the default value for subject.
               <p>Example:</p>
               <pre>{contact_form email="yourname@yourdomain.com" subject_get_var="subject"}</pre>
             <p>Then call the page with the form on it like this: /index.php?page=contact&subject=test+subject</p>
             <p>And the following will appear in the "Subject" box: "test subject"
           </li>
		<li><em>(optional)</em>captcha - true/false, use Captcha response test (Captcha module must be installed). Default is false.</li>
	</ul>
	</p>';
$lang['admin']['help_function_cms_versionname'] = '	<h3>What does this do?</h3>
	<p>This tag is used to insert the current version name of CMS into your template or page.  It doesn\'t display any extra besides the version name.</p>
	<h3>How do I use it?</h3>
	<p>This is just a basic tag plugin.  You would insert it into your template or page like so: <code>{cms_versionname}</code>
	<h3>What parameters does it take?</h3>
	<p>It takes no parameters.</p>';
$lang['admin']['help_function_cms_version'] = '	<h3>What does this do?</h3>
	<p>This tag is used to insert the current version number of CMS into your template or page.  It doesn\'t display any extra besides the version number.</p>
	<h3>How do I use it?</h3>
	<p>This is just a basic tag plugin.  You would insert it into your template or page like so: <code>{cms_version}</code>
	<h3>What parameters does it take?</h3>
	<p>It takes no parameters.</p>';
$lang['admin']['about_function_cms_selflink'] = '		<p>Author: Ted Kulp <tedkulp@users.sf.net></p>
		<p>Version: 1.1</p>
		<p>Modified: Martin B. Vestergaard <mbv@nospam.dk></p>
		<p>Version: 1.41</p>
		<p>Modified: Russ Baldwin</p>
		<p>Version: 1.42</p>
		<p>Modified: Marcus Bointon <coolbru@users.sf.net></p>
		<p>Version: 1.43</p>
		<p>Modified: Tatu Wikman <tsw@backspace.fi></p>
		<p>Version: 1.44</p>
		<p>Modified: Hans Mogren <http://hans.bymarken.net/></p>
		<p>Version: 1.45</p>

		<p>
		Change History:<br/>
		1.46 - Fixes a problem with too many queries when using the dir=start option.<br/>
		1.45 - Added a new option for "dir", "up", for links to the parent page e.g. dir="up" (Hans Mogren).<br />
		1.44 - Added new parameters "ext" and "ext_info" to allow external links with class="external" and info text after the link, ugly hack but works thinking about rewriting this(Tatu Wikman)<br />
		1.43 - Added new parameters "image" and "imageonly" to allow attachment of images to be used for page links, either instead of or in addition to text links. (Marcus Bointon)<br />
		1.42 - Added new parameter "anchorlink" and a new option for "dir" namely, "anchor", for internal page links. e.g. dir="anchor" anchorlink="internal_link". (Russ)<br />
		1.41 - added new parameter "href" (LeisureLarry)<br />
		1.4 - fixed bug next/prev linking to non-content pages. (Thanks Teemu Koistinen for this fix)<br />
		1.3 - added option "more"<br />
		1.2 - by Martin B. Vestergaard
		<ul>
		<li>changed default text to Page Name (was Page Alias)</li>
		<li>added option dir=next/prev to display next or previous item in the hirachy - thanks to 100rk</li>
		<li>added option class to add a class= statement to the a-tag.</li>
		<li>added option menu to display menu-text in sted of Page Name</li>
		<li>added option lang to display link-labels in different languages</li>
		</ul>
		1.1 - Changed to new content system<br />
		1.0 - Initial release
		</p>';
$lang['admin']['help_function_cms_selflink'] = '		<h3>What does this do?</h3>
		<p>Creates a link to another CMSMS content page inside your template or content. Can also be used for external links with the ext parameter.</p>
		<h3>How do I use it?</h3>
		<p>Just insert the tag into your template/page like: <code>{cms_selflink page="1"}</code> or  <code>{cms_selflink page="alias"}</code></p>
		<h3>What parameters does it take?</h3>
		<p>
		<ul>
		<li><em>(optional)</em> <tt>page</tt> - Page ID or alias to link to.</li>
		<li><em>(optional)</em> <tt>dir anchor (internal links)</tt> - New option for an internal page link. If this is used then <tt>anchorlink</tt> should be set to your link. </li> <!-- Russ - 25-04-2006 -->
		<li><em>(optional)</em> <tt>anchorlink</tt> - New paramater for an internal page link. If this is used then <tt>dir ="anchor"</tt> should also be set. No need to add the #, because it is added automatically.</li> <!-- Russ - 25-04-2006 -->
		<li><em>(optional)</em> <tt>urlparam</tt> - Specify additional parameters to the URL.  <strong>Do not use this in conjunction with the <em>anchorlink</em> parameter</em></strong>
		<li><em>(optional)</em> <tt>tabindex ="a value"</tt> - Set a tabindex for the link.</li> <!-- Russ - 22-06-2005 -->
		<li><em>(optional)</em> <tt>dir start/next/prev/up (previous)</tt> - Links to the default start page or the next or previous page, or the parent page (up). If this is used <tt>page</tt> should not be set.</li> <!-- mbv - 21-06-2005 -->
		<B>Note!</B> Only one of the above may be used in the same cms_selflink statement!!
		<li><em>(optional)</em> <tt>text</tt> - Text to show for the link.  If not given, the Page Name is used instead.</li>
		<li><em>(optional)</em> <tt>menu 1/0</tt> - If 1 the Menu Text is used for the link text instead of the Page Name</li> <!-- mbv - 21-06-2005 -->
		<li><em>(optional)</em> <tt>target</tt> - Optional target for the a link to point to.  Useful for frame and javascript situations.</li>
		<li><em>(optional)</em> <tt>class</tt> - Class for the <a> link. Useful for styling the link.</li> <!-- mbv - 21-06-2005 -->
		<li><em>(optional)</em> <tt>lang</tt> - Display link-labels  ("Next Page"/"Previous Page") in different languages (0 for no label.) Danish (dk), English (en) or French (fr), for now.</li> <!-- mbv - 21-06-2005 -->
		<li><em>(optional)</em> <tt>id</tt> - Optional css_id for the <a> link.</li> <!-- mbv - 29-06-2005 -->
		<li><em>(optional)</em> <tt>more</tt> - place additional options inside the <a> link.</li> <!-- mbv - 29-06-2005 -->
		<li><em>(optional)</em> <tt>label</tt> - Label to use in with the link if applicable.</li>
		<li><em>(optional)</em> <tt>label_side left/right</tt> - Side of link to place the label (defaults to "left").</li>
		<li><em>(optional)</em> <tt>title</tt> - Text to use in the title attribute.  If none is given, then the title of the page will be used for the title.</li>
		<li><em>(optional)</em> <tt>rellink 1/0</tt> - Make a relational link for accessible navigation.  Only works if the dir parameter is set and should only go in the head section of a template.</li>
		<li><em>(optional)</em> <tt>href</tt> - If href is used only the href value is generated (no other parameters possible). <strong>Example:</strong> <a href="{cms_selflink href="alias"}"><img src=""></a></li>
		<li><em>(optional)</em> <tt>image</tt> - A url of an image to use in the link. <strong>Example:</strong> {cms_selflink dir="next" image="next.png" text="Next"}</li>
		<li><em>(optional)</em> <tt>alt</tt> - Alternative text to be used with image (alt="" will be used if no alt parameter is given).</li>
		<li><em>(optional)</em> <tt>imageonly</tt> - If using an image, whether to suppress display of text links. If you want no text in the link at all, also set lang=0 to suppress the label. <B>Example:</B> {cms_selflink dir="next" image="next.png" text="Next" imageonly=1}</li>
		<li><em>(optional)</em> <tt>ext</tt> - For external links, will add class="external and info text. <strong>warning:</strong> only text, target and title parameters are compatible with this parameter</li>
		<li><em>(optional)</em> <tt>ext_info</tt> - Used together with "ext" defaults to (external link)</li>
		</ul>
		</p>';
$lang['admin']['about_function_cms_module'] = '	<p>Author: Ted Kulp<tedkulp@users.sf.net></p>
	<p>Version: 1.0</p>
	<p>
	Change History:<br/>
	None
	</p>';
$lang['admin']['help_function_cms_module'] = '	<h3>What does this do?</h3>
	<p>This tag is used to insert modules into your templates and pages.  If a module is created to be used as a tag plugin (check it\'s help for details), then you should be able to insert it with this tag.</p>
	<h3>How do I use it?</h3>
	<p>It\'s just a basic tag plugin.  You would insert it into your template or page like so: <code>{cms_module module="somemodulename"}</code>
	<h3>What parameters does it take?</h3>
	<p>There is only one required parameter.  All other parameters are passed on to the module.
	<ul>
		<li>module - Name of the module to insert.  This is not case sensitive.</li>
	</ul>
	</p>';
$lang['admin']['about_function_breadcrumbs'] = '<p>Author: Marcus Deglos <<a href="mailto:md@zioncore.com">md@zioncore.com</a>></p>
<p>Version: 1.7</p>
<p>
Change History:<br/>
1.1 - Modified to use new content rewrite (wishy)<br />
1.2 - Added parameters: delimiter, initial, and root (arl)<br />
1.3 - Added parameter: classid (tdh / perl4ever)<br />
1.4 - Added parameter currentclassid and fixed some bugs (arl)<br />
1.5 - Modified to use new hierarchy manager<br />
1.6 - Modified to skip any parents that are marked to be "not shown in menu" except for root<br />
1.7 - Added root_url parameter (elijahlofgren)<br />
</p>';
$lang['admin']['help_function_breadcrumbs'] = '<h3>What does this do?</h3>
<p>Prints a breadcrumb trail .</p>
<h3>How do I use it?</h3>
<p>Just insert the tag into your template/page like: <code>{breadcrumbs}</code></p>
<h3>What parameters does it take?</h3>
<p>
<ul>
<li><em>(optional)</em> <tt>delimiter</tt> - Text to seperate entries in the list (default ">>").</li>
<li><em>(optional)</em> <tt>initial</tt> - 1/0 If set to 1 start the breadcrumbs with a delimiter (default 0).</li>
<li><em>(optional)</em> <tt>root</tt> - Page alias of a page you want to always appear as the first page in
    the list. Can be used to make a page (e.g. the front page) appear to be the root of everything even though it is not.</li>
<li><em>(optional)</em> <tt>root_url</tt> - Override the URL of the root page. Useful for making link be to \'/\' instead of \'/home/\'. This requires that the root page be set as the default page.</li>
<li><em>(optional)</em> <tt>classid</tt> - The CSS class for the non current page names, i.e. the first n-1 pages in the list. If the name is a link it is added to the <a href> tags, otherwise it is added to the <span> tags.</li>
<li><em>(optional)</em> <tt>currentclassid</tt> - The CSS class for the <span> tag surrounding the current page name.</li>
<li><em>(optional)</em> <tt>starttext</tt> - Text to append to the front of the breadcrumbs list, something like "You are here".</li>
</ul>
</p>';
$lang['admin']['about_function_anchor'] = '	<p>Author: Ted Kulp<tedkulp@users.sf.net></p>
	<p>Version: 1.1</p>
	<p>
	Change History:<br/>
	<strong>Update to version 1.1 from 1.0</strong> <em>2006/07/19</em><br/>
	Russ added the means to insert a title, a tabindex and a class for the anchor link. Westis added accesskey and changed parameter names to not include \'anchorlink\'.<br/>
	</hr>
	</p>';
$lang['admin']['help_function_anchor'] = '	<h3>What does this do?</h3>
	<p>Makes a proper anchor link.</p>
	<h3>How do I use it?</h3>
	<p>Just insert the tag into your template/page like: <code>{anchor anchor=\'here\' text=\'Scroll Down\'}</code></p>
	<h3>What parameters does it take?</h3>
	<p>
	<ul>
	<li><tt>anchor</tt> - Where we are linking to.  The part after the #.</li>
	<li><tt>text</tt> - The text to display in the link.</li>
	<li><tt>class</tt> - The class for the link, if any</li>
	<li><tt>title</tt> - The title to display for the link, if any.</li>
	<li><tt>tabindex</tt> - The numeric tabindex for the link, if any.</li>
	<li><tt>accesskey</tt> - The accesskey for the link, if any.</li>
	<li><em>(optional)</em> <tt>onlyhref</tt> - Only display the href and not the entire link. No other options will work</li>
	</ul>
	</p>';
$lang['admin']['help_function_site_mapper'] = '<h3>What does this do?</h3>
  <p>This is actually just a wrapper tag for the <a href="listmodules.php?action=showmodulehelp&module=MenuManager">Menu Manager module</a> to make the tag syntax easier, and to simplify creating a sitemap.</p>
<h3>How do I use it?</h3>
  <p>Just put <code>{site_mapper}</code> on a page or in a template. For help about the Menu Manager module, what parameters it takes etc., please refer to the <a href="listmodules.php?action=showmodulehelp&module=MenuManager">Menu Manager module help</a>.</p>
  <p>By default, if no template option is specified the minimal_menu.tpl file will be used.</p>
  <p>Any parameters used in the tag are available in the menumanager template as <code>{$menuparams.paramname}</code></p>';
$lang['admin']['help_function_redirect_url'] = '<h3>What does this do?</h3>
  <p>This plugin allows you to easily redirect to a specified url.  It is handy inside of smarty conditional logic (for example, redirect to a splash page if the site is not live yet).</p>
<h3>How do I use it?</h3>
<p>Simply insert this tage into your page or template: <code>{redirect_url urle=\'www.cmsmadesimple.org\'}</code></p>';
$lang['admin']['help_function_redirect_page'] = '<h3>What does this do?</h3>
 <p>This plugin allows you to easily redirect to another page.  It is handy inside of smarty conditional logic (for example, redirect to a login page if the user is not logged in.)</p>
<h3>How do I use it?</h3>
<p>Simply insert this tage into your page or template: <code>{redirect_page page=\'some-page-alias\'}</code></p>';
$lang['admin']['of'] = 'da';
$lang['admin']['first'] = 'Emprim';
$lang['admin']['last'] = 'Davos';
$lang['admin']['adminspecialgroup'] = 'Attenziun: Utilisaders da questa gruppa han automaticamain tut las autorisaziuns';
$lang['admin']['disablesafemodewarning'] = 'Deactivar l\'avis per l\'administratur davart il \'safe mode\'';
$lang['admin']['allowparamcheckwarnings'] = 'Allow parameter checks to create warning messages';
$lang['admin']['date_format_string'] = 'String dal format da datas';
$lang['admin']['date_format_string_help'] = 'In string da data formatà tenor<em>strftime</em>. Tschertga en l\'internet \'strftime\' per retschaiver agid';
$lang['admin']['last_modified_at'] = 'Modifitgà l\'ultima giada ils';
$lang['admin']['last_modified_by'] = 'Modifitgà l\'ultima giada da';
$lang['admin']['read'] = 'Leger';
$lang['admin']['write'] = 'Scriver';
$lang['admin']['execute'] = 'Exequir';
$lang['admin']['group'] = 'Gruppa';
$lang['admin']['other'] = 'Auter';
$lang['admin']['event_desc_moduleupgraded'] = 'Sent after a module is upgraded';
$lang['admin']['event_desc_moduleinstalled'] = 'Sent after a module is installed';
$lang['admin']['event_desc_moduleuninstalled'] = 'Sent after a module is uninstalled';
$lang['admin']['event_desc_edituserdefinedtagpost'] = 'Sent after a user defined tag is updated';
$lang['admin']['event_desc_edituserdefinedtagpre'] = 'Sent prior to a user defined tag update';
$lang['admin']['event_desc_deleteuserdefinedtagpre'] = 'Sent prior to deleting a user defined tag';
$lang['admin']['event_desc_deleteuserdefinedtagpost'] = 'Sent after a user defined tag is deleted';
$lang['admin']['event_desc_adduserdefinedtagpost'] = 'Sent after a user defined tag is inserted';
$lang['admin']['event_desc_adduserdefinedtagpre'] = 'Sent prior to a user defined tag insert';
$lang['admin']['global_umask'] = 'File Creation Mask (umask)';
$lang['admin']['errorcantcreatefile'] = 'Could not create a file (permissions problem?)';
$lang['admin']['errormoduleversionincompatible'] = 'Module is incompatible with this version of CMS';
$lang['admin']['errormodulenotloaded'] = 'Internal error, the module has not been instantiated';
$lang['admin']['errormodulenotfound'] = 'Internal error, could not find the instance of a module';
$lang['admin']['errorinstallfailed'] = 'Module installation failed';
$lang['admin']['errormodulewontload'] = 'Problem instantiating an available module';
$lang['admin']['frontendlang'] = 'Default language for the frontend';
$lang['admin']['info_edituser_password'] = 'Change this field to change the user\'s password';
$lang['admin']['info_edituser_passwordagain'] = 'Change this field to change the user\'s password';
$lang['admin']['originator'] = 'Originator';
$lang['admin']['module_name'] = 'Num dal modul';
$lang['admin']['event_name'] = 'Event Name';
$lang['admin']['event_description'] = 'Event Description';
$lang['admin']['error_delete_default_parent'] = 'You cannot delete the parent of the default page.';
$lang['admin']['jsdisabled'] = 'Sorry, this function requires that you have Javascript enabled.';
$lang['admin']['order'] = 'Order';
$lang['admin']['reorderpages'] = 'Reorder Pages';
$lang['admin']['reorder'] = 'Reorder';
$lang['admin']['page_reordered'] = 'Page was successfully reordered.';
$lang['admin']['pages_reordered'] = 'Pages were successfully reordered';
$lang['admin']['sibling_duplicate_order'] = 'Two sibling pages can not have the same order. Pages were not reordered.';
$lang['admin']['no_orders_changed'] = 'You chose to reorder pages, but you did not change the order of any of them. Pages were not reordered.';
$lang['admin']['order_too_small'] = 'A page order cannot be zero. Pages were not reordered.';
$lang['admin']['order_too_large'] = 'A page order cannot be larger than the number of pages in that level. Pages were not reordered.';
$lang['admin']['user_tag'] = 'User Tag';
$lang['admin']['add'] = 'Agiuntar';
$lang['admin']['CSS'] = 'CSS ';
$lang['admin']['about'] = 'Davart';
$lang['admin']['action'] = 'Action';
$lang['admin']['actionstatus'] = 'Action/Status';
$lang['admin']['active'] = 'Activ';
$lang['admin']['addcontent'] = 'Agiuntar nov cuntegn';
$lang['admin']['cantremove'] = 'Cannot Remove';
$lang['admin']['changepermissions'] = 'Change Permissions';
$lang['admin']['changepermissionsconfirm'] = 'USE CAUTION\\n\\nThis action will attempt to ensure that all of the files making up the module are writable by the web server.\\nAre you sure you want to continue?';
$lang['admin']['contentadded'] = 'The content was successfully added to the database.';
$lang['admin']['contentupdated'] = 'The content was successfully updated.';
$lang['admin']['contentdeleted'] = 'The content was successfully removed from the database.';
$lang['admin']['success'] = 'Success ';
$lang['admin']['addcss'] = 'Agiuntar in stylesheet';
$lang['admin']['addgroup'] = 'Agiuntar ina nova gruppa';
$lang['admin']['additionaleditors'] = 'Additional Editors';
$lang['admin']['addtemplate'] = 'Agiuntar in nov template';
$lang['admin']['adduser'] = 'Agiuntar in nov utilisader';
$lang['admin']['addusertag'] = 'Agiuntar nov tag definì da l\'utilisader';
$lang['admin']['adminaccess'] = 'Access to login to admin';
$lang['admin']['adminlog'] = 'Log da l\'administratur';
$lang['admin']['adminlogcleared'] = 'Il log da l\'administratur è vegnì stidà cun success';
$lang['admin']['adminlogempty'] = 'Il log da l\'administratur è vid';
$lang['admin']['adminsystemtitle'] = 'Sistem d\'administraziun dal CMS';
$lang['admin']['adminpaneltitle'] = 'Consola d\'administraziun da CMS Made Simple';
$lang['admin']['advanced'] = 'Avanzà';
$lang['admin']['aliasalreadyused'] = 'Alias has already been used on another page. Change "Page Alias" in the "Options" tab to something else.';
$lang['admin']['aliasmustbelettersandnumbers'] = 'Alias must be all letters and numbers';
$lang['admin']['aliasnotaninteger'] = 'L\'alias na po betg esser ina cifra';
$lang['admin']['allpagesmodified'] = 'Tut las paginas èn vegnidas midadas!';
$lang['admin']['assignments'] = 'Assign Users';
$lang['admin']['associationexists'] = 'This association already exists';
$lang['admin']['autoinstallupgrade'] = 'Automatically install or upgrade';
$lang['admin']['back'] = 'Anavos al menu';
$lang['admin']['backtoplugins'] = 'Anavos a la glista da plug-ins';
$lang['admin']['cancel'] = 'Interrumper';
$lang['admin']['cantchmodfiles'] = 'Na pudevel betg midar l\'autorisaziun da tschertas datotecas';
$lang['admin']['cantremovefiles'] = 'Problem Removing Files (permissions?)';
$lang['admin']['confirmcancel'] = 'Are you sure you want to discard your changes? Click OK to discard all changes. Click Cancel to continue editing.';
$lang['admin']['canceldescription'] = 'Discard Changes';
$lang['admin']['clearadminlog'] = 'Stizzar il log da l\'administratur';
$lang['admin']['code'] = 'Code ';
$lang['admin']['confirmdefault'] = 'Are you sure you want to set - %s - as site\\\'s default page?';
$lang['admin']['confirmdeletedir'] = 'Are you sure you want to delete this dir and all of its contents?';
$lang['admin']['content'] = 'Cuntegn';
$lang['admin']['contentmanagement'] = 'Administraziun dal cuntegn';
$lang['admin']['contenttype'] = 'Tip dal cuntegn';
$lang['admin']['copy'] = 'Copiar';
$lang['admin']['copytemplate'] = 'Copiar il template';
$lang['admin']['create'] = 'Crear';
$lang['admin']['createnewfolder'] = 'Crear in nov ordinatur';
$lang['admin']['cssalreadyused'] = 'Num da CSS vegn fingia utilisà';
$lang['admin']['cssmanagement'] = 'Administraziun da CSS';
$lang['admin']['currentassociations'] = 'Current Associations';
$lang['admin']['currentdirectory'] = 'Ordinatur actual';
$lang['admin']['currentgroups'] = 'Current Groups';
$lang['admin']['currentpages'] = 'Current Pages';
$lang['admin']['currenttemplates'] = 'Current Templates';
$lang['admin']['currentusers'] = 'Current Users';
$lang['admin']['custom404'] = 'Custom 404 Error Message';
$lang['admin']['database'] = 'Banca da datas';
$lang['admin']['databaseprefix'] = 'Prefix da la banca da datas';
$lang['admin']['databasetype'] = 'Tip da la banca da datas';
$lang['admin']['date'] = 'Data';
$lang['admin']['default'] = 'Standard';
$lang['admin']['delete'] = 'Stizzar';
$lang['admin']['deleteconfirm'] = 'Es ti segir che ti vuls stizzar - %s - ?';
$lang['admin']['deleteassociationconfirm'] = 'Are you sure you want to delete association to - %s - ?';
$lang['admin']['deletecss'] = 'Stizzar CSS';
$lang['admin']['dependencies'] = 'Dependencies';
$lang['admin']['description'] = 'Descripziun';
$lang['admin']['directoryexists'] = 'Quest ordinatur exista gia.';
$lang['admin']['down'] = 'Engiu';
$lang['admin']['edit'] = 'Editar';
$lang['admin']['editconfiguration'] = 'Editar la configuraziun';
$lang['admin']['editcontent'] = 'Edidar il cuntegn';
$lang['admin']['editcss'] = 'Editar il stylesheet';
$lang['admin']['editcsssuccess'] = 'Actualisa il stylesheet';
$lang['admin']['editgroup'] = 'Editar la gruppa';
$lang['admin']['editpage'] = 'Editar la pagina';
$lang['admin']['edittemplate'] = 'Editar il template';
$lang['admin']['edittemplatesuccess'] = 'Actualisà il template';
$lang['admin']['edituser'] = 'Editar l\'utilisader';
$lang['admin']['editusertag'] = 'Editar il tag definì da l\'utilisader';
$lang['admin']['usertagadded'] = 'The User Defined Tag was successfully added.';
$lang['admin']['usertagupdated'] = 'The User Defined Tag was successfully updated.';
$lang['admin']['usertagdeleted'] = 'The User Defined Tag was successfully removed.';
$lang['admin']['email'] = 'Adressa d\'e-mail';
$lang['admin']['errorattempteddowngrade'] = 'Installing this module would result in a downgrade.  Operation aborted';
$lang['admin']['errorchildcontent'] = 'Content still contains child contents. Please remove them first.';
$lang['admin']['errorcopyingtemplate'] = 'Error Copying Template';
$lang['admin']['errorcouldnotparsexml'] = 'Error parsing XML file. Please make sure you are uploading a .xml file and not a .tar.gz or zip file.';
$lang['admin']['errorcreatingassociation'] = 'Error creating association';
$lang['admin']['errorcssinuse'] = 'This Stylesheet is still used by template or pages. Please remove those associations first.';
$lang['admin']['errordefaultpage'] = 'Can not delete the current default page. Please set a different one first.';
$lang['admin']['errordeletingassociation'] = 'Error deleting association';
$lang['admin']['errordeletingcss'] = 'Error deleteing css';
$lang['admin']['errordeletingdirectory'] = 'Could not delete directory. Permissions problem?';
$lang['admin']['errordeletingfile'] = 'Could not delete file. Permissions Problem?';
$lang['admin']['errordirectorynotwritable'] = 'No permission to write in directory.  This could be caused by file permissions and ownership.  Safe mode may also be in effect.';
$lang['admin']['errordtdmismatch'] = 'DTD Version missing or incompatible in the XML file';
$lang['admin']['errorgettingcssname'] = 'Error getting Stylesheet name';
$lang['admin']['errorgettingtemplatename'] = 'Error getting template name';
$lang['admin']['errorincompletexml'] = 'XML File is incomplete or invalid';
$lang['admin']['uploadxmlfile'] = 'Install module via XML file';
$lang['admin']['cachenotwritable'] = 'Cache folder is not writable. Clearing cache will not work. Please make the tmp/cache folder have full read/write/execute permissions (chmod 777).  You may also have to disable safe mode.';
$lang['admin']['modulesnotwritable'] = 'The modules folder is not writable, if you would like to install modules by uploading an XML file you need to make the modules folder have full read/write/execute permissions (chmod 777).  Safe mode may also be in effect.';
$lang['admin']['noxmlfileuploaded'] = 'No file was uploaded. To install a module via XML you must choose and upload an module .xml file from your computer.';
$lang['admin']['errorinsertingcss'] = 'Error inserting Stylesheet';
$lang['admin']['errorinsertinggroup'] = 'Error inserting group';
$lang['admin']['errorinsertingtag'] = 'Error inserting user tag';
$lang['admin']['errorinsertingtemplate'] = 'Error inserting template';
$lang['admin']['errorinsertinguser'] = 'Error inserting user';
$lang['admin']['errornofilesexported'] = 'Error exporting files to xml';
$lang['admin']['errorretrievingcss'] = 'Error retrieving Stylesheet';
$lang['admin']['errorretrievingtemplate'] = 'Error retrieving template';
$lang['admin']['errortemplateinuse'] = 'This template is still in use by a page. Please remove it first.';
$lang['admin']['errorupdatingcss'] = 'Error updating Stylesheet';
$lang['admin']['errorupdatinggroup'] = 'Error updating group';
$lang['admin']['errorupdatingpages'] = 'Error updating pages';
$lang['admin']['errorupdatingtemplate'] = 'Error updating template';
$lang['admin']['errorupdatinguser'] = 'Error updating user';
$lang['admin']['errorupdatingusertag'] = 'Error updating user tag';
$lang['admin']['erroruserinuse'] = 'This user still owns content pages. Please change ownership to another user before deleting.';
$lang['admin']['eventhandlers'] = 'Administraziun d\'eveniments';
$lang['admin']['editeventhandler'] = 'Edit Event Handler';
$lang['admin']['eventhandlerdescription'] = 'Associate user tags with events';
$lang['admin']['export'] = 'Exportar';
$lang['admin']['event'] = 'Eveniment';
$lang['admin']['false'] = 'Fauss';
$lang['admin']['settrue'] = 'Set True';
$lang['admin']['filecreatedirnodoubledot'] = 'Directory cannot contain \'..\'.';
$lang['admin']['filecreatedirnoname'] = 'Cannot create a directory with no name.';
$lang['admin']['filecreatedirnoslash'] = 'Directory cannot contain \'/\' or \'\\\'.';
$lang['admin']['filemanagement'] = 'Administraziun da datotecas';
$lang['admin']['filename'] = 'Num da la datoteca';
$lang['admin']['filenotuploaded'] = 'La datoteca na pudeva betg vegnir chargiada sin il server. Quai pudess esser in problem da dretgs da scriver u dal \'safe mode\'.';
$lang['admin']['filesize'] = 'Grondezza da la datoteca';
$lang['admin']['firstname'] = 'Prenum';
$lang['admin']['groupmanagement'] = 'Administraziun da gruppas';
$lang['admin']['grouppermissions'] = 'Autorisaziun da gruppas';
$lang['admin']['handler'] = 'Handler (user defined tag)';
$lang['admin']['headtags'] = 'Head Tags';
$lang['admin']['help'] = 'Agid';
$lang['admin']['new_window'] = 'nova fanestra';
$lang['admin']['helpwithsection'] = '%s agid';
$lang['admin']['helpaddtemplate'] = '<p>A template is what controls the look and feel of your site\'s content.</p><p>Create the layout here and also add your CSS in the Stylesheet section to control the look of your various elements.</p>';
$lang['admin']['helplisttemplate'] = '<p>This page allows you to edit, delete, and create templates.</p><p>To create a new template, click on the <u>Add New Template</u> button.</p><p>If you wish to set all content pages to use the same template, click on the <u>Set All Content</u> link.</p><p>If you wish to duplicate a template, click on the <u>Copy</u> icon and you will be prompted to name the new duplicate template.</p>';
$lang['admin']['home'] = 'Chasa';
$lang['admin']['homepage'] = 'Homepage ';
$lang['admin']['hostname'] = 'Hostname';
$lang['admin']['idnotvalid'] = 'L\'id surdada n\'è betg valida';
$lang['admin']['imagemanagement'] = 'Administraziun da maletgs';
$lang['admin']['informationmissing'] = 'Infurmaziuns mancan';
$lang['admin']['install'] = 'Installar';
$lang['admin']['invalidcode'] = 'Endatà conde betg valaivel. ';
$lang['admin']['illegalcharacters'] = 'Invalid characters in field %s.';
$lang['admin']['invalidcode_brace_missing'] = 'Uneven amount of braces';
$lang['admin']['invalidtemplate'] = 'The template is not valid';
$lang['admin']['itemid'] = 'Item ID';
$lang['admin']['itemname'] = 'Num da l\'element';
$lang['admin']['language'] = 'Lingua';
$lang['admin']['lastname'] = 'Num da famiglia';
$lang['admin']['logout'] = 'Sortir';
$lang['admin']['loginprompt'] = 'Enter a valid user credential to get access to the Admin Console.';
$lang['admin']['logintitle'] = 'S\'annunziar tar CMS Made Simple';
$lang['admin']['menutext'] = 'Text da menu';
$lang['admin']['missingparams'] = 'Some parameters were missing or invalid';
$lang['admin']['modifygroupassignments'] = 'Modify Group Assignments';
$lang['admin']['moduleabout'] = 'About the %s module';
$lang['admin']['modulehelp'] = 'Help for the %s module';
$lang['admin']['msg_defaultcontent'] = 'Add code here that should appear as the default content of all new pages';
$lang['admin']['msg_defaultmetadata'] = 'Add code here that should appear in the metadata section of all new pages';
$lang['admin']['wikihelp'] = 'Agid da la communitad';
$lang['admin']['moduleinstalled'] = 'Il modul è gia installà';
$lang['admin']['moduleinterface'] = '%s surfatscha';
$lang['admin']['modules'] = 'Moduls';
$lang['admin']['move'] = 'Spustar';
$lang['admin']['name'] = 'Num';
$lang['admin']['needpermissionto'] = 'You need the \'%s\' permission to perform that function.';
$lang['admin']['needupgrade'] = 'Dovra actualisaziun';
$lang['admin']['newtemplatename'] = 'Num dal nov template';
$lang['admin']['next'] = 'Enacant';
$lang['admin']['noaccessto'] = 'No Access to %s';
$lang['admin']['nocss'] = 'Nagin stylesheet';
$lang['admin']['noentries'] = 'Naginas endataziuns';
$lang['admin']['nofieldgiven'] = 'No %s given!';
$lang['admin']['nofiles'] = 'Naginas datotecas';
$lang['admin']['nopasswordmatch'] = 'Ils pleds-clav na correspundan betg';
$lang['admin']['norealdirectory'] = 'No real directory given';
$lang['admin']['norealfile'] = 'No real file given';
$lang['admin']['notinstalled'] = 'Betg installà';
$lang['admin']['overwritemodule'] = 'Remplazzar moduls existents';
$lang['admin']['owner'] = 'possessur';
$lang['admin']['pagealias'] = 'Alias da la pagina';
$lang['admin']['pagedefaults'] = 'Page Defaults';
$lang['admin']['pagedefaultsdescription'] = 'Set default values for new pages';
$lang['admin']['parent'] = 'Parent';
$lang['admin']['password'] = 'Pled-clav';
$lang['admin']['passwordagain'] = 'Pled-calv (repeter)';
$lang['admin']['permission'] = 'Autorisaziun';
$lang['admin']['permissions'] = 'Autorisaziuns';
$lang['admin']['permissionschanged'] = 'Las autorisaziuns èn vegnidas actualisadas';
$lang['admin']['pluginabout'] = 'Davart il tag da %s';
$lang['admin']['pluginhelp'] = 'Agid per il tag da %s';
$lang['admin']['pluginmanagement'] = 'Administrar plug-ins';
$lang['admin']['prefsupdated'] = 'Las opziuns èn vegnidas actualisadas';
$lang['admin']['preview'] = 'Prevista';
$lang['admin']['previewdescription'] = 'Prevista da las midadas';
$lang['admin']['previous'] = 'Previous';
$lang['admin']['remove'] = 'Allontanar';
$lang['admin']['removeconfirm'] = 'This action will permanently remove the files making up this module from this installation.\\nAre you sure you want to proceed?';
$lang['admin']['removecssassociation'] = 'Remove Stylesheet Assocation';
$lang['admin']['saveconfig'] = 'Memorisar la configuraziun';
$lang['admin']['send'] = 'Trametter';
$lang['admin']['setallcontent'] = 'Metter tut las paginas';
$lang['admin']['setallcontentconfirm'] = 'Es ti segirs che ti vuls utilisar quest template per tut las paginas?';
$lang['admin']['showinmenu'] = 'Mussar en il menu';
$lang['admin']['showsite'] = 'Mussar la pagina';
$lang['admin']['sitedownmessage'] = 'Messadi sche la pagina è offline';
$lang['admin']['siteprefs'] = 'Opziuns globalas';
$lang['admin']['status'] = 'Status ';
$lang['admin']['stylesheet'] = 'Stylesheet ';
$lang['admin']['submit'] = 'Trametter';
$lang['admin']['submitdescription'] = 'Memorisar las midadas';
$lang['admin']['tags'] = 'Tags ';
$lang['admin']['template'] = 'Template ';
$lang['admin']['templateexists'] = 'Il num da template exista gia';
$lang['admin']['templatemanagement'] = 'Administraziun da templates';
$lang['admin']['title'] = 'Titel';
$lang['admin']['tools'] = 'Funcziuns';
$lang['admin']['true'] = 'Gist';
$lang['admin']['setfalse'] = 'Metter fauss';
$lang['admin']['type'] = 'Tip';
$lang['admin']['typenotvalid'] = 'Tip n\'è betg valaivel';
$lang['admin']['uninstall'] = 'Deinstallar';
$lang['admin']['uninstallconfirm'] = 'Ès ti segir che ti vuls deinstallar quest modul? Num: ';
$lang['admin']['up'] = 'Ensi';
$lang['admin']['upgrade'] = 'Actualisar';
$lang['admin']['upgradeconfirm'] = 'Ès ti segir che ti vuls actualisar quai?';
$lang['admin']['uploadfile'] = 'Chargiar si datoteca';
$lang['admin']['url'] = 'URL ';
$lang['admin']['useadvancedcss'] = 'Utilisar l\'administraziun da stylesheets avanzada';
$lang['admin']['user'] = 'Utilisader';
$lang['admin']['userdefinedtags'] = 'Tags definids da l\'utilisader';
$lang['admin']['usermanagement'] = 'Administraziun d\'utilisaders';
$lang['admin']['username'] = 'Num d\'utilisader';
$lang['admin']['usernameincorrect'] = 'Num d\'utilisader u pled-clav betg correct';
$lang['admin']['userprefs'] = 'Preferenzas da l\'utilisader';
$lang['admin']['usersassignedtogroup'] = 'Users Assigned to Group %s';
$lang['admin']['usertagexists'] = 'A tag with this name already exists. Please choose another.';
$lang['admin']['usewysiwyg'] = 'Utilisar editur da WYSIWYG per il cuntegn';
$lang['admin']['version'] = 'Versiun';
$lang['admin']['view'] = 'Guardar';
$lang['admin']['welcomemsg'] = 'Bainvegni %s';
$lang['admin']['directoryabove'] = 'directory above current level';
$lang['admin']['nodefault'] = 'Tschernì nagin standard';
$lang['admin']['blobexists'] = 'Global Content Block name already exists';
$lang['admin']['blobmanagement'] = 'Global Content Block Management';
$lang['admin']['errorinsertingblob'] = 'There was an error inserting the Global Content Block';
$lang['admin']['addhtmlblob'] = 'Add Global Content Block';
$lang['admin']['edithtmlblob'] = 'Edit Global Content Block';
$lang['admin']['edithtmlblobsuccess'] = 'Global content block updated';
$lang['admin']['tagtousegcb'] = 'Tag to Use this Block';
$lang['admin']['gcb_wysiwyg'] = 'Enable GCB WYSIWYG';
$lang['admin']['gcb_wysiwyg_help'] = 'Enable the WYSIWYG editor while editing Global Content Blocks';
$lang['admin']['filemanager'] = 'Administraziun da datotecas';
$lang['admin']['imagemanager'] = 'Administraziun da maletgs';
$lang['admin']['encoding'] = 'Codaziun';
$lang['admin']['clearcache'] = 'Stizzar il cache';
$lang['admin']['clear'] = 'Stizzar';
$lang['admin']['cachecleared'] = 'Stidà il cache';
$lang['admin']['apply'] = 'Apply';
$lang['admin']['applydescription'] = 'Memorisar las midadas ed continuar dad editar';
$lang['admin']['none'] = 'nagin';
$lang['admin']['wysiwygtouse'] = 'Tscherna in WYSIWYG per utilisar';
$lang['admin']['syntaxhighlightertouse'] = 'Tscherna in \'syntay highlighter\' per utilisar.';
$lang['admin']['hasdependents'] = 'Has Dependents';
$lang['admin']['missingdependency'] = 'Missing Dependency';
$lang['admin']['minimumversion'] = 'Versiun minimala';
$lang['admin']['minimumversionrequired'] = 'Versiun minimala da CMSMS necessaria';
$lang['admin']['maximumversion'] = 'Versiun maximala';
$lang['admin']['maximumversionsupported'] = 'Versiun maximala da CMSMS sustegnida';
$lang['admin']['depsformodule'] = 'Dependencies for %s Module';
$lang['admin']['installed'] = 'Installà';
$lang['admin']['author'] = 'Autur';
$lang['admin']['changehistory'] = 'Change History';
$lang['admin']['moduleerrormessage'] = 'Error Message for %s Module';
$lang['admin']['moduleupgradeerror'] = 'There was an error upgrading the module.';
$lang['admin']['moduleinstallmessage'] = 'Install Message for %s Module';
$lang['admin']['moduleuninstallmessage'] = 'Uninstall Message for %s Module';
$lang['admin']['admintheme'] = 'Theme d\'administraziun';
$lang['admin']['addstylesheet'] = 'Agiuntar in stylesheet';
$lang['admin']['editstylesheet'] = 'Editar il stylesheet';
$lang['admin']['addcssassociation'] = 'Add Stylesheet Association';
$lang['admin']['attachstylesheet'] = 'Attach This Stylesheet';
$lang['admin']['attachtemplate'] = 'Attach to this Template';
$lang['admin']['main'] = 'Main';
$lang['admin']['pages'] = 'Pages';
$lang['admin']['page'] = 'Page';
$lang['admin']['files'] = 'Datotecas';
$lang['admin']['layout'] = 'Layout ';
$lang['admin']['usersgroups'] = 'Users & Groups';
$lang['admin']['extensions'] = 'Extensiuns';
$lang['admin']['preferences'] = 'Preferenzas';
$lang['admin']['admin'] = 'Site Admin';
$lang['admin']['viewsite'] = 'Guardar la pagina';
$lang['admin']['templatecss'] = 'Assign Templates to Stylesheet';
$lang['admin']['plugins'] = 'Plug-ins';
$lang['admin']['movecontent'] = 'Move Pages';
$lang['admin']['module'] = 'Modul';
$lang['admin']['usertags'] = 'Tags definids da l\'utilisader';
$lang['admin']['htmlblobs'] = 'Global Content Blocks';
$lang['admin']['adminhome'] = 'Administration Home';
$lang['admin']['liststylesheets'] = 'Style Sheets';
$lang['admin']['preferencesdescription'] = 'This is where you set various site-wide preferences.';
$lang['admin']['adminlogdescription'] = 'Shows a log of who did what in the admin.';
$lang['admin']['mainmenu'] = 'Menu prinzipal';
$lang['admin']['users'] = 'Utilisaders';
$lang['admin']['usersdescription'] = 'Quai è nua che ti pos administrar ils utilisaders';
$lang['admin']['groups'] = 'Gruppas';
$lang['admin']['groupsdescription'] = 'Quai è nua che ti pos administrar las gruppas';
$lang['admin']['groupassignments'] = 'Group Assignments';
$lang['admin']['groupassignmentdescription'] = 'Here you can assign users to groups.';
$lang['admin']['groupperms'] = 'Group Permissions';
$lang['admin']['grouppermsdescription'] = 'Set permissions and access levels for groups';
$lang['admin']['pagesdescription'] = 'This is where we add and edit pages and other content.';
$lang['admin']['htmlblobdescription'] = 'Global Content Blocks are chunks of content you can place in your pages or templates.';
$lang['admin']['templates'] = 'Templates ';
$lang['admin']['templatesdescription'] = 'This is where we add and edit templates. Templates define the look and feel of your site.';
$lang['admin']['stylesheets'] = 'Stylesheets ';
$lang['admin']['stylesheetsdescription'] = 'Stylesheet management is an advanced way to handle cascading Stylesheets (CSS) separately from templates.';
$lang['admin']['filemanagerdescription'] = 'Chargiar si ed administrar datotecas';
$lang['admin']['imagemanagerdescription'] = 'Upload/edit and remove images.';
$lang['admin']['moduledescription'] = 'Modules extend CMS Made Simple to provide all kinds of custom functionality.';
$lang['admin']['tagdescription'] = 'Tags are little bits of functionality that can be added to your content and/or templates.';
$lang['admin']['usertagdescription'] = 'Tags that you can create and modify yourself to perform specific tasks, right from your browser.';
$lang['admin']['installdirwarning'] = '<em><strong>Warning:</strong></em> install directory still exists. Please remove it completely.';
$lang['admin']['subitems'] = 'Subitems';
$lang['admin']['extensionsdescription'] = 'Modules, tags, and other assorted fun.';
$lang['admin']['usersgroupsdescription'] = 'User and Group related items.';
$lang['admin']['layoutdescription'] = 'Site layout options.';
$lang['admin']['admindescription'] = 'Site Administration functions.';
$lang['admin']['contentdescription'] = 'This is where we add and edit content.';
$lang['admin']['enablecustom404'] = 'Enable Custom 404 Message';
$lang['admin']['enablesitedown'] = 'Enable Site Down Message';
$lang['admin']['bookmarks'] = 'Shortcuts';
$lang['admin']['user_created'] = 'Custom Shortcuts';
$lang['admin']['forums'] = 'Forums';
$lang['admin']['wiki'] = 'Wiki';
$lang['admin']['irc'] = 'IRC';
$lang['admin']['module_help'] = 'Module Help';
$lang['admin']['managebookmarks'] = 'Manage Shortcuts';
$lang['admin']['editbookmark'] = 'Edit Shortcut';
$lang['admin']['addbookmark'] = 'Add Shortcut';
$lang['admin']['recentpages'] = 'Recent Pages';
$lang['admin']['groupname'] = 'Num da la gruppa';
$lang['admin']['selectgroup'] = 'Tscherner gruppa';
$lang['admin']['updateperm'] = 'Update Permissions';
$lang['admin']['admincallout'] = 'Administration Shortcuts';
$lang['admin']['showbookmarks'] = 'Show Admin Shortcuts';
$lang['admin']['hide_help_links'] = 'Hide help links';
$lang['admin']['hide_help_links_help'] = 'Check this box to disable the wiki and module help links in page headers.';
$lang['admin']['showrecent'] = 'Show Recently Used Pages';
$lang['admin']['attachtotemplate'] = 'Attach Stylesheet to Template';
$lang['admin']['attachstylesheets'] = 'Attach Stylesheets';
$lang['admin']['indent'] = 'Indent Pagelist to Emphasize Hierarchy';
$lang['admin']['adminindent'] = 'Content Display';
$lang['admin']['contract'] = 'Collapse Section';
$lang['admin']['expand'] = 'Expand Section';
$lang['admin']['expandall'] = 'Expand All Sections';
$lang['admin']['contractall'] = 'Collapse All Sections';
$lang['admin']['menu_bookmarks'] = '[+]';
$lang['admin']['globalconfig'] = 'Global Settings';
$lang['admin']['adminpaging'] = 'Number of Content Items to show per/page in Page List';
$lang['admin']['nopaging'] = 'Show All Items';
$lang['admin']['myprefs'] = 'My Preferences';
$lang['admin']['myprefsdescription'] = 'This is where you can customize the site admin area to work the way you want.';
$lang['admin']['myaccount'] = 'My Account';
$lang['admin']['myaccountdescription'] = 'This is where you can update your personal account details.';
$lang['admin']['adminprefs'] = 'User Preferences';
$lang['admin']['adminprefsdescription'] = 'This is where you set your specific preferences for site administration.';
$lang['admin']['managebookmarksdescription'] = 'This is where you can manage your administration shortcuts.';
$lang['admin']['options'] = 'Options';
$lang['admin']['langparam'] = 'Parameter is used to specify what language to use for display on the frontend. Not all modules support or need this.';
$lang['admin']['parameters'] = 'Parameters ';
$lang['admin']['mediatype'] = 'Media Type';
$lang['admin']['mediatype_'] = 'None set : will affect everywhere ';
$lang['admin']['mediatype_all'] = 'all : Suitable for all devices.';
$lang['admin']['mediatype_aural'] = 'aural : Intended for speech synthesizers.';
$lang['admin']['mediatype_braille'] = 'braille : Intended for braille tactile feedback devices.';
$lang['admin']['mediatype_embossed'] = 'embossed : Intended for paged braille printers.';
$lang['admin']['mediatype_handheld'] = 'handheld : Intended for handheld devices';
$lang['admin']['mediatype_print'] = 'print : Intended for paged, opaque material and for documents viewed on screen in print preview mode.';
$lang['admin']['mediatype_projection'] = 'projection : Intended for projected presentations, for example projectors or print to transparencies.';
$lang['admin']['mediatype_screen'] = 'screen : Intended primarily for color computer screens.';
$lang['admin']['mediatype_tty'] = 'tty : Intended for media using a fixed-pitch character grid, such as teletypes and terminals.';
$lang['admin']['mediatype_tv'] = 'tv : Intended for television-type devices.';
$lang['admin']['assignmentchanged'] = 'Group Assignments have been updated.';
$lang['admin']['stylesheetexists'] = 'Stylesheet Exists';
$lang['admin']['errorcopyingstylesheet'] = 'Error Copying Stylesheet';
$lang['admin']['copystylesheet'] = 'Copy Stylesheet';
$lang['admin']['newstylesheetname'] = 'New Stylesheet Name';
$lang['admin']['target'] = 'Target';
$lang['admin']['xml'] = 'XML';
$lang['admin']['xmlmodulerepository'] = 'URL of ModuleRepository soap server';
$lang['admin']['metadata'] = 'Metadata';
$lang['admin']['globalmetadata'] = 'Global Metadata';
$lang['admin']['titleattribute'] = 'Description (title attribute)';
$lang['admin']['tabindex'] = 'Tab Index';
$lang['admin']['accesskey'] = 'Access Key';
$lang['admin']['sitedownwarning'] = '<strong>Warning:</strong> Your site is currently showing a "Site Down for Maintenence" message.  Remove the %s file to resolve this.';
$lang['admin']['deletecontent'] = 'Delete Content';
$lang['admin']['deletepages'] = 'Delete these pages?';
$lang['admin']['selectall'] = 'Select All';
$lang['admin']['selecteditems'] = 'With Selected';
$lang['admin']['inactive'] = 'Inactive';
$lang['admin']['deletetemplates'] = 'Delete Templates';
$lang['admin']['templatestodelete'] = 'These templates will be deleted';
$lang['admin']['wontdeletetemplateinuse'] = 'These templates are in use and will not be deleted';
$lang['admin']['deletetemplate'] = 'Stizzar stylesheets';
$lang['admin']['stylesheetstodelete'] = 'Quests stylesheets vegnan stizzads';
$lang['admin']['sitename'] = 'Num da la pagina';
$lang['admin']['siteadmin'] = 'Administratur da la pagina';
$lang['admin']['images'] = 'Administraziun da maletgs';
$lang['admin']['blobs'] = 'Global Content Blocks';
$lang['admin']['groupmembers'] = 'Group Assignments';
$lang['admin']['troubleshooting'] = '(Troubleshooting)';
$lang['admin']['event_desc_loginpost'] = 'Sent after a user logs into the admin panel';
$lang['admin']['event_desc_logoutpost'] = 'Sent after a user logs out of the admin panel';
$lang['admin']['event_desc_adduserpre'] = 'Sent before a new user is created';
$lang['admin']['event_desc_adduserpost'] = 'Sent after a new user is created';
$lang['admin']['event_desc_edituserpre'] = 'Sent before edits to a user are saved';
$lang['admin']['event_desc_edituserpost'] = 'Sent after edits to a user are saved';
$lang['admin']['event_desc_deleteuserpre'] = 'Sent before a user is deleted from the system';
$lang['admin']['event_desc_deleteuserpost'] = 'Sent after a user is deleted from the system';
$lang['admin']['event_desc_addgrouppre'] = 'Sent before a new group is created';
$lang['admin']['event_desc_addgrouppost'] = 'Sent after a new group is created';
$lang['admin']['event_desc_changegroupassignpre'] = 'Sent before group assignments are saved';
$lang['admin']['event_desc_changegroupassignpost'] = 'Sent after group assignments are saved';
$lang['admin']['event_desc_editgrouppre'] = 'Sent before edits to a group are saved';
$lang['admin']['event_desc_editgrouppost'] = 'Sent after edits to a group are saved';
$lang['admin']['event_desc_deletegrouppre'] = 'Sent before a group is deleted from the system';
$lang['admin']['event_desc_deletegrouppost'] = 'Sent after a group is deleted from the system';
$lang['admin']['event_desc_addstylesheetpre'] = 'Sent before a new stylesheet is created';
$lang['admin']['event_desc_addstylesheetpost'] = 'Sent after a new stylesheet is created';
$lang['admin']['event_desc_editstylesheetpre'] = 'Sent before edits to a stylesheet are saved';
$lang['admin']['event_desc_editstylesheetpost'] = 'Sent after edits to a stylesheet are saved';
$lang['admin']['event_desc_deletestylesheetpre'] = 'Sent before a stylesheet is deleted from the system';
$lang['admin']['event_desc_deletestylesheetpost'] = 'Sent after a stylesheet is deleted from the system';
$lang['admin']['event_desc_addtemplatepre'] = 'Sent before a new template is created';
$lang['admin']['event_desc_addtemplatepost'] = 'Sent after a new template is created';
$lang['admin']['event_desc_edittemplatepre'] = 'Sent before edits to a template are saved';
$lang['admin']['event_desc_edittemplatepost'] = 'Sent after edits to a template are saved';
$lang['admin']['event_desc_deletetemplatepre'] = 'Sent before a template is deleted from the system';
$lang['admin']['event_desc_deletetemplatepost'] = 'Sent after a template is deleted from the system';
$lang['admin']['event_desc_templateprecompile'] = 'Sent before a template is sent to smarty for processing';
$lang['admin']['event_desc_templatepostcompile'] = 'Sent after a template has been processed by smarty';
$lang['admin']['event_desc_addglobalcontentpre'] = 'Sent before a new global content block is created';
$lang['admin']['event_desc_addglobalcontentpost'] = 'Sent after a new global content block is created';
$lang['admin']['event_desc_editglobalcontentpre'] = 'Sent before edits to a global content block are saved';
$lang['admin']['event_desc_editglobalcontentpost'] = 'Sent after edits to a global content block are saved';
$lang['admin']['event_desc_deleteglobalcontentpre'] = 'Sent before a global content block is deleted from the system';
$lang['admin']['event_desc_deleteglobalcontentpost'] = 'Sent after a global content block is deleted from the system';
$lang['admin']['event_desc_globalcontentprecompile'] = 'Sent before a global content block is sent to smarty for processing';
$lang['admin']['event_desc_globalcontentpostcompile'] = 'Sent after a global content block has been processed by smarty';
$lang['admin']['event_desc_contenteditpre'] = 'Sent before edits to content are saved';
$lang['admin']['event_desc_contenteditpost'] = 'Sent after edits to content are saved';
$lang['admin']['event_desc_contentdeletepre'] = 'Sent before content is deleted from the system';
$lang['admin']['event_desc_contentdeletepost'] = 'Sent after content is deleted from the system';
$lang['admin']['event_desc_contentstylesheet'] = 'Sent before the sytlesheet is sent to the browser';
$lang['admin']['event_desc_contentprecompile'] = 'Sent before content is sent to smarty for processing';
$lang['admin']['event_desc_contentpostcompile'] = 'Sent after content has been processed by smarty';
$lang['admin']['event_desc_contentpostrender'] = 'Sent before the combined html is sent to the browser';
$lang['admin']['event_desc_smartyprecompile'] = 'Sent before any content destined for smarty is sent to for processing';
$lang['admin']['event_desc_smartypostcompile'] = 'Sent after any content destined for smarty has been processed';
$lang['admin']['event_help_loginpost'] = '<p>Sent after a user logs into the admin panel.</p>
<h4>Parameters</h4>
<ul>
<li>\'user\' - Reference to the affected user object.</li>
</ul>
';
$lang['admin']['event_help_logoutpost'] = '<p>Sent after a user logs out of the admin panel.</p>
<h4>Parameters</h4>
<ul>
<li>\'user\' - Reference to the affected user object.</li>
</ul>
';
$lang['admin']['event_help_adduserpre'] = '<p>Sent before a new user is created.</p>
<h4>Parameters</h4>
<ul>
<li>\'user\' - Reference to the affected user object.</li>
</ul>
';
$lang['admin']['event_help_adduserpost'] = '<p>Sent after a new user is created.</p>
<h4>Parameters</h4>
<ul>
<li>\'user\' - Reference to the affected user object.</li>
</ul>
';
$lang['admin']['event_help_edituserpre'] = '<p>Sent before edits to a user are saved.</p>
<h4>Parameters</h4>
<ul>
<li>\'user\' - Reference to the affected user object.</li>
</ul>
';
$lang['admin']['event_help_edituserpost'] = '<p>Sent after edits to a user are saved.</p>
<h4>Parameters</h4>
<ul>
<li>\'user\' - Reference to the affected user object.</li>
</ul>
';
$lang['admin']['event_help_deleteuserpre'] = '<p>Sent before a user is deleted from the system.</p>
<h4>Parameters</h4>
<ul>
<li>\'user\' - Reference to the affected user object.</li>
</ul>
';
$lang['admin']['event_help_deleteuserpost'] = '<p>Sent after a user is deleted from the system.</p>
<h4>Parameters</h4>
<ul>
<li>\'user\' - Reference to the affected user object.</li>
</ul>
';
$lang['admin']['event_help_addgrouppre'] = '<p>Sent before a new group is created.</p>
<h4>Parameters</h4>
<ul>
<li>\'group\' - Reference to the affected group object.</li>
</ul>
';
$lang['admin']['event_help_addgrouppost'] = '<p>Sent after a new group is created.</p>
<h4>Parameters</h4>
<ul>
<li>\'group\' - Reference to the affected group object.</li>
</ul>
';
$lang['admin']['event_help_changegroupassignpre'] = '<p>Sent before group assignments are saved.</p>
<h4>Parameters></h4>
<ul>
<li>\'group\' - Reference to the group object.</li>
<li>\'users\' - Array of references to user objects belonging to the group.</li>
';
$lang['admin']['event_help_changegroupassignpost'] = '<p>Sent after group assignments are saved.</p>
<h4>Parameters></h4>
<ul>
<li>\'group\' - Reference to the affected group object.</li>
<li>\'users\' - Array of references to user objects now belonging to the affected group.</li>
';
$lang['admin']['event_help_editgrouppre'] = '<p>Sent before edits to a group are saved.</p>
<h4>Parameters</h4>
<ul>
<li>\'group\' - Reference to the affected group object.</li>
</ul>
';
$lang['admin']['event_help_editgrouppost'] = '<p>Sent after edits to a group are saved.</p>
<h4>Parameters</h4>
<ul>
<li>\'group\' - Reference to the affected group object.</li>
</ul>
';
$lang['admin']['event_help_deletegrouppre'] = '<p>Sent before a group is deleted from the system.</p>
<h4>Parameters</h4>
<ul>
<li>\'group\' - Reference to the affected group object.</li>
</ul>
';
$lang['admin']['event_help_deletegrouppost'] = '<p>Sent after a group is deleted from the system.</p>
<h4>Parameters</h4>
<ul>
<li>\'group\' - Reference to the affected group object.</li>
</ul>
';
$lang['admin']['event_help_addstylesheetpre'] = '<p>Sent before a new stylesheet is created.</p>
<h4>Parameters</h4>
<ul>
<li>\'stylesheet\' - Reference to the affected stylesheet object.</li>
</ul>
';
$lang['admin']['event_help_addstylesheetpost'] = '<p>Sent after a new stylesheet is created.</p>
<h4>Parameters</h4>
<ul>
<li>\'stylesheet\' - Reference to the affected stylesheet object.</li>
</ul>
';
$lang['admin']['event_help_editstylesheetpre'] = '<p>Sent before edits to a stylesheet are saved.</p>
<h4>Parameters</h4>
<ul>
<li>\'stylesheet\' - Reference to the affected stylesheet object.</li>
</ul>
';
$lang['admin']['event_help_editstylesheetpost'] = '<p>Sent after edits to a stylesheet are saved.</p>
<h4>Parameters</h4>
<ul>
<li>\'stylesheet\' - Reference to the affected stylesheet object.</li>
</ul>
';
$lang['admin']['event_help_deletestylesheetpre'] = '<p>Sent before a stylesheet is deleted from the system.</p>
<h4>Parameters</h4>
<ul>
<li>\'stylesheet\' - Reference to the affected stylesheet object.</li>
</ul>
';
$lang['admin']['event_help_deletestylesheetpost'] = '<p>Sent after a stylesheet is deleted from the system.</p>
<h4>Parameters</h4>
<ul>
<li>\'stylesheet\' - Reference to the affected stylesheet object.</li>
</ul>
';
$lang['admin']['event_help_addtemplatepre'] = '<p>Sent before a new template is created.</p>
<h4>Parameters</h4>
<ul>
<li>\'template\' - Reference to the affected template object.</li>
</ul>
';
$lang['admin']['event_help_addtemplatepost'] = '<p>Sent after a new template is created.</p>
<h4>Parameters</h4>
<ul>
<li>\'template\' - Reference to the affected template object.</li>
</ul>
';
$lang['admin']['event_help_edittemplatepre'] = '<p>Sent before edits to a template are saved.</p>
<h4>Parameters</h4>
<ul>
<li>\'template\' - Reference to the affected template object.</li>
</ul>
';
$lang['admin']['event_help_edittemplatepost'] = '<p>Sent after edits to a template are saved.</p>
<h4>Parameters</h4>
<ul>
<li>\'template\' - Reference to the affected template object.</li>
</ul>
';
$lang['admin']['event_help_deletetemplatepre'] = '<p>Sent before a template is deleted from the system.</p>
<h4>Parameters</h4>
<ul>
<li>\'template\' - Reference to the affected template object.</li>
</ul>
';
$lang['admin']['event_help_deletetemplatepost'] = '<p>Sent after a template is deleted from the system.</p>
<h4>Parameters</h4>
<ul>
<li>\'template\' - Reference to the affected template object.</li>
</ul>
';
$lang['admin']['event_help_templateprecompile'] = '<p>Sent before a template is sent to smarty for processing.</p>
<h4>Parameters</h4>
<ul>
<li>\'template\' - Reference to the affected template text.</li>
</ul>
';
$lang['admin']['event_help_templatepostcompile'] = '<p>Sent after a template has been processed by smarty.</p>
<h4>Parameters</h4>
<ul>
<li>\'template\' - Reference to the affected template text.</li>
</ul>
';
$lang['admin']['event_help_addglobalcontentpre'] = '<p>Sent before a new global content block is created.</p>
<h4>Parameters</h4>
<ul>
<li>\'global_content\' - Reference to the affected global content block object.</li>
</ul>
';
$lang['admin']['event_help_addglobalcontentpost'] = '<p>Sent after a new global content block is created.</p>
<h4>Parameters</h4>
<ul>
<li>\'global_content\' - Reference to the affected global content block object.</li>
</ul>
';
$lang['admin']['event_help_editglobalcontentpre'] = '<p>Sent before edits to a global content block are saved.</p>
<h4>Parameters</h4>
<ul>
<li>\'global_content\' - Reference to the affected global content block object.</li>
</ul>
';
$lang['admin']['event_help_editglobalcontentpost'] = '<p>Sent after edits to a global content block are saved.</p>
<h4>Parameters</h4>
<ul>
<li>\'global_content\' - Reference to the affected global content block object.</li>
</ul>
';
$lang['admin']['event_help_deleteglobalcontentpre'] = '<p>Sent before a global content block is deleted from the system.</p>
<h4>Parameters</h4>
<ul>
<li>\'global_content\' - Reference to the affected global content block object.</li>
</ul>
';
$lang['admin']['event_help_deleteglobalcontentpost'] = '<p>Sent after a global content block is deleted from the system.</p>
<h4>Parameters</h4>
<ul>
<li>\'global_content\' - Reference to the affected global content block object.</li>
</ul>
';
$lang['admin']['event_help_globalcontentprecompile'] = '<p>Sent before a global content block is sent to smarty for processing.</p>
<h4>Parameters</h4>
<ul>
<li>\'global_content\' - Reference to the affected global content block text.</li>
</ul>
';
$lang['admin']['event_help_globalcontentpostcompile'] = '<p>Sent after a global content block has been processed by smarty.</p>
<h4>Parameters</h4>
<ul>
<li>\'global_content\' - Reference to the affected global content block text.</li>
</ul>
';
$lang['admin']['event_help_contenteditpre'] = '<p>Sent before edits to content are saved.</p>
<h4>Parameters</h4>
<ul>
<li>\'global_content\' - Reference to the affected content object.</li>
</ul>
';
$lang['admin']['event_help_contenteditpost'] = '<p>Sent after edits to content are saved.</p>
<h4>Parameters</h4>
<ul>
<li>\'content\' - Reference to the affected content object.</li>
</ul>
';
$lang['admin']['event_help_contentdeletepre'] = '<p>Sent before content is deleted from the system.</p>
<h4>Parameters</h4>
<ul>
<li>\'content\' - Reference to the affected content object.</li>
</ul>
';
$lang['admin']['event_help_contentdeletepost'] = '<p>Sent after content is deleted from the system.</p>
<h4>Parameters</h4>
<ul>
<li>\'content\' - Reference to the affected content object.</li>
</ul>
';
$lang['admin']['event_help_contentstylesheet'] = '<p>Sent before the sytlesheet is sent to the browser.</p>
<h4>Parameters</h4>
<ul>
<li>\'content\' - Reference to the affected stylesheet text.</li>
</ul>
';
$lang['admin']['event_help_contentprecompile'] = '<p>Sent before content is sent to smarty for processing.</p>
<h4>Parameters</h4>
<ul>
<li>\'content\' - Reference to the affected content text.</li>
</ul>
';
$lang['admin']['event_help_contentpostcompile'] = '<p>Sent after content has been processed by smarty.</p>
<h4>Parameters</h4>
<ul>
<li>\'content\' - Reference to the affected content text.</li>
</ul>
';
$lang['admin']['event_help_contentpostrender'] = '<p>Sent before the combined html is sent to the browser.</p>
<h4>Parameters</h4>
<ul>
<li>\'content\' - Reference to the html text.</li>
</ul>
';
$lang['admin']['event_help_smartyprecompile'] = '<p>Sent before any content destined for smarty is sent to for processing.</p>
<h4>Parameters</h4>
<ul>
<li>\'content\' - Reference to the affected text.</li>
</ul>
';
$lang['admin']['event_help_smartypostcompile'] = '<p>Sent after any content destined for smarty has been processed.</p>
<h4>Parameters</h4>
<ul>
<li>\'content\' - Reference to the affected text.</li>
</ul>
';
$lang['admin']['filterbymodule'] = 'Filter By Module';
$lang['admin']['showall'] = 'Mussar tuts';
$lang['admin']['core'] = 'Core';
$lang['admin']['defaultpagecontent'] = 'Default Page Content';
$lang['admin']['file_url'] = 'Link to file (instead of URL)';
$lang['admin']['no_file_url'] = 'None (Use URL Above)';
$lang['admin']['defaultparentpage'] = 'Default Parent Page';
$lang['admin']['error_udt_name_whitespace'] = 'Error: User Defined Tags cannot have spaces in their name.';
$lang['admin']['warning_safe_mode'] = '<strong><em>WARNING:</em></strong> PHP Safe mode is enabled.  This will cause difficulty with files uploaded via the web browser interface, including images, theme and module XML packages.  You are advised to contact your site administrator to see about disabling safe mode.';
$lang['admin']['test'] = 'Test';
$lang['admin']['results'] = 'Resultats';
$lang['admin']['untested'] = 'Betg testà';
$lang['admin']['unknown'] = 'Nunenconuschent';
$lang['admin']['download'] = 'Telechargiar';
$lang['admin']['frontendwysiwygtouse'] = 'Frontend wysiwyg';
$lang['admin']['all_groups'] = 'Tut las gruppas';
$lang['admin']['error_type'] = 'Tip da sbagls';
$lang['admin']['contenttype_errorpage'] = 'Pagina da sbagls';
$lang['admin']['errorpagealreadyinuse'] = 'I exista gia ina pagina d\'errur per quest sbagl';
$lang['admin']['404description'] = 'Betg chattà la pagina';
$lang['admin']['usernotfound'] = 'Betg chattà l\'utilisader';
$lang['admin']['passwordchange'] = 'Please, provide the new password';
$lang['admin']['recoveryemailsent'] = 'Email sent to recorded address.  Please check your inbox for further instructions.';
$lang['admin']['errorsendingemail'] = 'There was an error sending the email.  Contact your administrator.';
$lang['admin']['passwordchangedlogin'] = 'Password changed.  Please log in using the new credentials.';
$lang['admin']['nopasswordforrecovery'] = 'No email address set for this user.  Password recovery is not possible.  Please contact your administrator.';
$lang['admin']['lostpw'] = 'Emblidà tes pled-clav?';
$lang['admin']['lostpwemailsubject'] = '[%s] Password Recovery';
$lang['admin']['lostpwemail'] = 'You are recieving this e-mail because a request has been made to change the (%s) password associated with this user account (%s).  If you would like to reset the password for this account simply click on the link below or paste it into the url field on your favorite browser:
%s

If you feel this is incorrect or made in error, simply ignore the email and nothing will change.';
$lang['admin']['utma'] = '156861353.3070486175908553000.1244269983.1245694155.1245699630.24';
$lang['admin']['utmz'] = '156861353.1245699630.24.24.utmcsr=blog.cmsmadesimple.org|utmccn=(referral)|utmcmd=referral|utmcct=/2009/06/22/announcing-cms-made-simple-16/';
$lang['admin']['utmc'] = '156861353';
$lang['admin']['utmb'] = '156861353.1.10.1245699630';
?>