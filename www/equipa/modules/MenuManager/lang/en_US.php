<?php
$lang['help_childrenof'] = 'This option will have the menu only display items that are descendants of the selected page id or alias.  i.e: <code>{menu childrenof=$page_alias}</code> will only display the children of the current page.';
$lang['usage'] = 'Usage';
$lang['help_loadprops'] = 'Use this parameter when NOT using advanced properties in your menu manager template. This parameter will disable the loading of all content properties for each node (such as extra1, image, thumbnail, etc). This will dramatically decrease the number of queries required to build a menu, and increase memory requirements, but will remove the possibility for much more advanced menus';
$lang['readonly'] = 'read only';
$lang['error_templatename'] = 'You cannot specify a template name ending with .tpl';
$lang['this_is_default'] = 'Default menu template';
$lang['set_as_default'] = 'Set as default menu template';
$lang['default'] = 'Default';
$lang['templates'] = 'Templates';
$lang['addtemplate'] = 'Add Template';
$lang['areyousure'] = 'Are you sure you want to delete this?';
$lang['changelog'] = <<<EOF
	<ul>
<li>1.6.3 - Adds usage column.</li>
<li>1.6.2 - Can no longer delete default template, fix problem with default database templates.</li>
<li>1.6.1 - Add created and modified entries on each node.</li>
<li>1.6 - Re-design admin interface, allow setting the default menu manager template.</li>
        <li>1.5.4 - Minor bugfix, now require CMS 1.5.3.</li>
        <li>1.5.3 - Support for syntax hilighter.</li>
        <li>1.5.2 - Added more fields available in each node in the template.</li>
        <li>1.5 - Bump version to be compatible with 1.1 only, and add the SetParameterTypes calls</li>
	<li>1.4.1 -- Fix a problem where menus would not show if includeprefix was not specified.
	<li>1.4 -- Accept a comma separated list of includeprefixes or excludeprefixes</li>
	<li>1.3 -- Added includeprefix and excludeprefix params</li>
	<li>1.1 -- Added handling of target parameter, mainly for the Link content type</li>
	<li>1.0 -- Initial Release</li>
	</ul> 
EOF;
$lang['dbtemplates'] = 'Database Templates';
$lang['description'] = 'Manage menu templates to display menus in any way imaginable.';
$lang['deletetemplate'] = 'Delete Template';
$lang['edittemplate'] = 'Edit Template';
$lang['filename'] = 'Filename';
$lang['filetemplates'] = 'File Templates';
$lang['help_includeprefix'] = 'Include only those items who\'s page alias matches one of the specified (comma separated) prefixes.  This parameter cannot be combined with the excludeprefix parameter.';
$lang['help_excludeprefix'] = 'Exclude all items (and their children) who\'s page alias matches one of the specified (comma separated) prefixes.  This parameter must not be used in conjunction with the includeprefix parameter.';
$lang['help_collapse'] = 'Turn on (set to 1) to have the menu hide items not related to the current selected page.';
$lang['help_items'] = 'Use this item to select a list of pages that this menu should display.  The value should be a list of page aliases separated with commas.';
$lang['help_number_of_levels'] = 'This setting will only allow the menu to only display a certain number of levels deep.';
$lang['help_show_all'] = 'This option will cause the menu to show all nodes even if they are set to not show in the menu. It will still not display inactive pages however.';
$lang['help_show_root_siblings'] = 'This option only becomes useful if start_element or start_page are used.  It basically will display the siblings along side of the selected start_page/element.';
$lang['help_start_level'] = 'This option will have the menu only display items starting a the given level.  An easy example would be if you had one menu on the page with number_of_levels=\'1\'.  Then as a second menu, you have start_level=\'2\'.  Now, your second menu will show items based on what is selected in the first menu.';
$lang['help_start_element'] = 'Starts the menu displaying at the given start_element and showing that element and it\'s children only.  Takes a hierarchy position (e.g. 5.1.2).';
$lang['help_start_page'] = 'Starts the menu displaying at the given start_page and showing that element and it\'s children only.  Takes a page alias.';
$lang['help_template'] = 'The template to use for displaying the menu.  Templates will come from the database templates unless the template name ends with .tpl, in which case it will come from a file in the MenuManager templates directory (defaults to simple_navigation.tpl)';
$lang['help'] = <<<EOF
	<h3>What does this do?</h3>
	<p>Menu Manager is a module for abstracting menus into a system that's easily usable and customizable.  It abstracts the display portion of menus into smarty templates that can be easily modified to suit the user's needs. That is, the menu manager itself is just an engine that feeds the template. By customizing templates, or make your own ones, you can create virtually any menu you can think of.</p>
	<h3>How do I use it?</h3>
	<p>Just insert the tag into your template/page like: <code>{menu}</code>.  The parameters that it can accept are listed below.</p>
	<h3>Why do I care about templates?</h3>
	<p>Menu Manager uses templates for display logic.  It comes with three default templates called cssmenu.tpl, minimal_menu.tpl and simple_navigation.tpl. They all basically create a simple unordered list of pages, using different classes and ID's for styling with CSS.</p>
	<p>Note that you style the look of the menus with CSS. Stylesheets are not included with Menu Manager, but must be attached to the page template separately. For the cssmenu.tpl template to work in IE you must also insert a link to the JavaScript in the head section of the page template, which is necessary for the hover effect to work in IE.</p>
	<p>If you would like to make a specialized version of a template, you can easily import into the database and then edit it directly inside the CMSMS admin.  To do this:
		<ol>
			<li>Click on the Menu Manager admin.</li>
			<li>Click on the File Templates tab, and click the Import Template to Database button next to i.e. simple_navigation.tpl.</li>
			<li>Give the template copy a name.  We'll call it "Test Template".</li>
			<li>You should now see the "Test Template" in your list of Database Templates.</li>
		</ol>
	</p>
	<p>Now you can easily modify the template to your needs for this site.  Put in classes, id's and other tags so that the formatting is exactly what you want.  Now, you can insert it into your site with {menu template='Test Template'}. Note that the .tpl extension must be included if a file template is used.</p>
	<p>The parameters for the \$node object used in the template are as follows:
		<ul>
			<li>\$node->id -- Content ID</li>
			<li>\$node->url -- URL of the Content</li>
			<li>\$node->accesskey -- Access Key, if defined</li>
			<li>\$node->tabindex -- Tab Index, if defined</li>
			<li>\$node->titleattribute -- Description or Title Attribute (title), if defined</li>
			<li>\$node->hierarchy -- Hierarchy position, (e.g. 1.3.3)</li>
			<li>\$node->depth -- Depth (level) of this node in the current menu</li>
			<li>\$node->prevdepth -- Depth (level) of the node that was right before this one</li>
			<li>\$node->haschildren -- Returns true if this node has child nodes to be displayed</li>
			<li>\$node->menutext -- Menu Text</li>
			<li>\$node->raw_menutext -- Menu Text without having html entities converted</li>
			<li>\$node->alias -- Page alias</li>
			<li>\$node->extra1 -- This field contains the value of the extra1 page property, unless the loadprops-parameter is set to NOT load the properties.</li>
			<li>\$node->extra2 -- This field contains the value of the extra2 page property, unless the loadprops-parameter is set to NOT load the properties.</li>
			<li>\$node->extra3 -- This field contains the value of the extra3 page property, unless the loadprops-parameter is set to NOT load the properties.</li>
			<li>\$node->image -- This field contains the value of the image page property (if non empty), unless the loadprops-parameter is set to NOT load the properties.</li>
			<li>\$node->thumbnail -- This field contains the value of the thumbnail page property (if non empty), unless the loadprops-parameter is set to NOT load the properties.</li>
			<li>\$node->target -- This field contains Target for the link (if non empty), unless the loadprops-parameter is set to NOT load the properties.</li>
			<li>\$node->created -- Item creation date</li>
			<li>\$node->modified -- Item modified date</li>
			<li>\$node->index -- Count of this node in the whole menu</li>
			<li>\$node->parent -- True if this node is a parent of the currently selected page</li>
		</ul>
	</p>
EOF;
$lang['importtemplate'] = 'Import Template to Database';
$lang['menumanager'] = 'Menu Manager';
$lang['newtemplate'] = 'New Template Name';
$lang['nocontent'] = 'No content given';
$lang['notemplatefiles'] = 'No file templates in %s';
$lang['notemplatename'] = 'No template name given.';
$lang['templatecontent'] = 'Template Content';
$lang['templatenameexists'] = 'A template with this name already exists';
?>
