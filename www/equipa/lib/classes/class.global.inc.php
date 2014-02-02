<?php // -*- mode:php; tab-width:4; indent-tabs-mode:t; c-basic-offset:4; -*-
#CMS - CMS Made Simple
#(c)2004-2010 by Ted Kulp (ted@cmsmadesimple.org)
#This project's homepage is: http://cmsmadesimple.org
#
#This program is free software; you can redistribute it and/or modify
#it under the terms of the GNU General Public License as published by
#the Free Software Foundation; either version 2 of the License, or
#(at your option) any later version.
#
#This program is distributed in the hope that it will be useful,
#but WITHOUT ANY WARRANTY; without even the implied warranty of
#MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
#GNU General Public License for more details.
#You should have received a copy of the GNU General Public License
#along with this program; if not, write to the Free Software
#Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
#
#$Id: class.global.inc.php 6433 2010-07-02 02:59:39Z calguy1000 $

/**
 * Global class for easy access to all important variables.
 *
 * @package CMS
 */

/**
 * Simple global object to hold references to other objects
 *
 * Global object that holds references to various data structures
 * needed by classes/functions in CMS.  Initialized in include.php
 * as $gCms for use in every page.
 *
 * @package CMS
 * @since 0.5
 */
class CmsObject {

	/**
	 * Config object - hash containing variables from config.php
	 *	@access private
	 */
	var $config;

	/**
	 * Database object - adodb reference to the current database
	 *	@access private
	 */
	var $db;

	/**
	 * Variables object - various objects and strings needing to be passed 
	 *	@access private
	 */
	var $variables;

	/**
	 * Modules object - holds references to all registered modules
	 *	@access private
	 */
	var $cmsmodules;

	/**
	 * System Modules - a list (hardcoded) of all system modules
	 *	@access private
	 */
	var $cmssystemmodules;

	/**
	 * Plugins object - holds list of all registered plugins 
	 *	@access private
	 */
	var $cmsplugins;

	/**
	 * User Plugins object - holds list and function pointers of all registered user plugins
	 *	@access private
	 */
	var $userplugins;

	/**
	 * BBCode object - for use in bbcode parsing
	 *	@access private
	 */
	var $bbcodeparser;

	/**
	 * Site Preferences object - holds all current site preferences so they're only loaded once
	 *	@access private
	 */
	var $siteprefs;

	/**
	 * User Preferences object - holds user preferences as they're loaded so they're only loaded once
	 *	@access private
	 */
	var $userprefs;

	/**
	 * Smarty object - holds reference to the current smarty object -- will not be set in the admin
	 *	@access private
	 */
	var $smarty;

	/**
	 * Internal error array - So functions/modules can store up debug info and spit it all out at once
	 *	@access private
	 */
	var $errors;

	/**
     * nls array - This holds all of the nls information for different languages
	 *	@access private
	 */
	var $nls;

	/**
     * template cache array - If something's called LoadTemplateByID, we keep a copy around
	 *	@access private
	 */
	var $TemplateCache;

	/**
     * template cache array - If something's called LoadTemplateByID, we keep a copy around
	 *	@access private
	 */
	var $StylesheetCache;

	/**
     * html blob cache array - If something's called LoadHtmlBlobByID, we keep a copy around
	 *	@access private
	 */
	var $HtmlBlobCache;
	
	/**
	 * content types array - List of available content types
	 *	@access private
	 */
	var $contenttypes;

	/**
	 * Constructor
	 */
	function CmsObject()
	{
		$this->cmssystemmodules = 
		  array( 'FileManager','nuSOAP', 'MenuManager', 'ModuleManager', 'Search', 'CMSMailer', 'News', 'TinyMCE', 'Printing', 'ThemeManager' );
		$this->modules = array();
		$this->errors = array();
		$this->nls = array();
		$this->contenttypes = array();
		$this->TemplateCache = array();
		$this->StylesheetCache = array();
		$this->variables['content-type'] = 'text/html';
		$this->variables['modulenum'] = 1;
		$this->variables['routes'] = array();
		
		#Setup hash for storing all modules and plugins
		$this->cmsmodules          = array();
		$this->userplugins         = array();
		$this->userpluginfunctions = array();
		$this->cmsplugins          = array();
		$this->siteprefs           = array();

		register_shutdown_function(array(&$this, 'dbshutdown'));
	}

	/**
	* Get a handle to the ADODB database object. You can then use this
	* to perform all kinds of database operations.
	*
	* @link http://phplens.com/lens/adodb/docs-adodb.htm
	* @final
	* @return ADOConnection a handle to the ADODB database object
	*/
	function & GetDb()
	{
		global $DONT_LOAD_DB;

		/* Check to see if we have a valid instance.
		 * If not, build the connection */
		if (!isset($this->db) && !isset($DONT_LOAD_DB))
		{
			$this->db =& adodb_connect();
		}
		
		$db =& $this->db;
		return ($db);
	}

	/**
	* Get a handle to the global CMS config. This is mostly values that are
	* defined in config.php
	*
	* @final
	* @return mixed an associative array of configuration values
	*/
	function & GetConfig()
	{
        if (!isset($this->config))
		{
			$configinstance = cms_config_load(true);
			$this->config = &$configinstance;
		}

		return $this->config;
	}
	
	/**
	* Get a handle to the CMS ModuleLoader object. If it does not yet,
	* exist, this method will instantiate it.
	*
	* @final
	* @see ModuleLoader
	* @return ModuleLoader handle to the ModuleLoader object
	*/
	function & GetModuleLoader()
	{
        if (!isset($this->moduleloader))
		{
			require_once(cms_join_path(dirname(__FILE__), 'class.moduleloader.inc.php'));
			$moduleloader = new ModuleLoader();
			$this->moduleloader = &$moduleloader;
		}

		return $this->moduleloader;
	}
	
	/**
	* Get a handle to the CMS ModuleOperations object. If it does not yet
	* exist, this method will instantiate it.
	*
	* @final
	* @see ModuleOperations
	* @return ModuleOperations handle to the ModuleOperations object
	*/
	function & GetModuleOperations()
	{
        if (!isset($this->moduleoperations))
		{
			require_once(cms_join_path(dirname(__FILE__), 'class.moduleoperations.inc.php'));
			$moduleoperations = new ModuleOperations();
			$this->moduleoperations = &$moduleoperations;
		}

		return $this->moduleoperations;
	}
	
	/**
	* Get a handle to the CMS UserOperations object. If it does not yet
	* exist, this method will instantiate it.
	*
	* @final
	* @see UserOperations
	* @return UserOperations handle to the UserOperations object
	*/
	function & GetUserOperations()
	{
        if (!isset($this->useroperations))
		{
			require_once(cms_join_path(dirname(__FILE__), 'class.useroperations.inc.php'));
			$useroperations = new UserOperations();
			$this->useroperations = &$useroperations;
		}

		return $this->useroperations;
	}
	
	/**
	* Get a handle to the CMS ContentOperations object. If it does not yet
	* exist, this method will instantiate it. To disambiguate, this is a globally-available
	* object with methods for dealing with Content -- it should not to be confused with
	* the GlobalContentOperations object.
	*
	* @final
	* @see ContentOperations
	* @return ContentOperations handle to the ContentOperations object
	*/
	function & GetContentOperations()
	{
        if (!isset($this->contentoperations))
		{
			debug_buffer('', 'Load Content Operations');
			require_once(cms_join_path(dirname(__FILE__), 'class.contentoperations.inc.php'));
			$contentoperations = new ContentOperations();
			$this->contentoperations = &$contentoperations;
			debug_buffer('', 'End Load Content Operations');
		}

		return $this->contentoperations;
	}

	/**
	* Get a handle to the CMS Admin BookmarkOperations object. If it does not yet
	* exist, this method will instantiate it.
	*
	* @final
	* @see BookmarkOperations
	* @return BookmarkOperations handle to the BookmarkOperations object, useful only in the admin
	*/	
	function & GetBookmarkOperations()
	{
        if (!isset($this->bookmarkoperations))
		{
			require_once(cms_join_path(dirname(__FILE__), 'class.bookmarkoperations.inc.php'));
			$bookmarkoperations = new BookmarkOperations();
			$this->bookmarkoperations = &$bookmarkoperations;
		}

		return $this->bookmarkoperations;
	}
	
	/**
	* Get a handle to the CMS TemplateOperations object. If it does not yet
	* exist, this method will instantiate it.
	*
	* @final
	* @see TemplateOperations
	* @return TemplateOperations handle to the TemplateOperations object
	*/
	function & GetTemplateOperations()
	{
        if (!isset($this->templateoperations))
		{
			require_once(cms_join_path(dirname(__FILE__), 'class.templateoperations.inc.php'));
			$templateoperations = new TemplateOperations();
			$this->templateoperations = &$templateoperations;
		}

		return $this->templateoperations;
	}

	/**
	* Get a handle to the CMS StylesheetOperations object. If it does not yet
	* exist, this method will instantiate it.
	*
	* @final
	* @see StylesheetOperations
	* @return StylesheetOperations handle to the StylesheetOperations object
	*/	
	function & GetStylesheetOperations()
	{
        if (!isset($this->stylesheetoperations))
		{
			require_once(cms_join_path(dirname(__FILE__), 'class.stylesheetoperations.inc.php'));
			$stylesheetoperations = new StylesheetOperations();
			$this->stylesheetoperations = &$stylesheetoperations;
		}

		return $this->stylesheetoperations;
	}
	
	/**
	* Get a handle to the CMS GroupOperations object. If it does not yet
	* exist, this method will instantiate it.
	*
	* @final
	* @see GroupOperations
	* @return GroupOperations handle to the GroupOperations object
	*/
	function & GetGroupOperations()
	{
        if (!isset($this->groupoperations))
		{
			require_once(cms_join_path(dirname(__FILE__), 'class.groupoperations.inc.php'));
			$groupoperations = new GroupOperations();
			$this->groupoperations = &$groupoperations;
		}

		return $this->groupoperations;
	}
	
	/**
	* Get a handle to the CMS GlobalContentOperations object. If it does not yet
	* exist, this method will instantiate it. To disambiguate, this object has methods
	* for dealing with "Global Content Blocks," not to be confused with the ContentOperations
	* object available on a global basis from this class.
	*
	* @final
	* @see GlobalContentOperations
	* @return GlobalContentOperations handle to the GlobalContentOperations object
	*/
	function & GetGlobalContentOperations()
	{
        if (!isset($this->globalcontentoperations))
		{
			require_once(cms_join_path(dirname(__FILE__), 'class.globalcontentoperations.inc.php'));
			$globalcontentoperations = new GlobalContentOperations();
			$this->globalcontentoperations = &$globalcontentoperations;
		}

		return $this->globalcontentoperations;
	}
	
	/**
	* Get a handle to the CMS UserTagOperations object. If it does not yet
	* exist, this method will instantiate it.
	*
	* @final
	* @see UserTagOperations
	* @return UserTagOperations handle to the UserTagOperations object
	*/
	function & GetUserTagOperations()
	{
        if (!isset($this->usertagoperations))
		{
			require_once(cms_join_path(dirname(__FILE__), 'class.usertagoperations.inc.php'));
			$usertagoperations = new UserTagOperations();
			$this->usertagoperations = &$usertagoperations;
		}

		return $this->usertagoperations;
	}

	/**
	* Get a handle to the CMS Smarty object. If it does not yet
	* exist, this method will instantiate it. As of version 1.8,
	* CMS Made Simple uses version 2.6.25 of Smarty.
	*
	* @final
	* @see Smarty_CMS
	* @link http://www.smarty.net/manual/en/
	* @return Smarty_CMS handle to the Smarty object
	*/
	function & GetSmarty()
	{
		/* Check to see if a Smarty object has been instantiated yet,
		  and, if not, go ahead an create the instance. */
		if (!isset($this->smarty))
		{
			$conf =& $this->GetConfig();

			if (!defined('SMARTY_DIR'))
			{
				define('SMARTY_DIR', cms_join_path($dirname,'lib','smarty') . DIRECTORY_SEPARATOR);
			}

			$this->smarty = new Smarty_CMS($conf);
		}

        return $this->smarty;
	}

	/**
	* Get a handle to the CMS HierarchyManager object. If it does not yet
	* exist, this method will instantiate it.
	*
	* @final
	* @see HierarchyManager
	* @return HierarchyManager handle to the HierarchyManager object
	*/
	function & GetHierarchyManager()
	{
		/* Check to see if a HierarchyManager has been instantiated yet,
		  and, if not, go ahead an create the instance. */
        if (!isset($this->hrinstance))
		{
			debug_buffer('', 'Start Loading Hierarchy Manager');
			$contentops =& $this->GetContentOperations();
			$this->hrinstance =& $contentops->GetAllContentAsHierarchy(false, array());
			debug_buffer('', 'End Loading Hierarchy Manager');
		}

        return $this->hrinstance;
	}

	/**
	* Disconnect from the database.
	*
	* @final
	* @access private
	*/
	function dbshutdown()
	{
		if (isset($this->db))
		{
			$db =& $this->db;
			if ($db->IsConnected())
				$db->Close();
		}
	}


	/**
	* Clear out cached files from the CMS tmp/cache and tmp/templates_c
	* directories.
	*
	* @final
	* @access private
	*/
	function clear_cached_files($age_days = -100)
	{
	  $the_time = time() - $age_days * 24*60*60;

	  $dirs = array(TMP_CACHE_LOCATION,TMP_TEMPLATES_C_LOCATION);
	  foreach( $dirs as $start_dir )
	    {
	      $dirIterator = new RecursiveDirectoryIterator($start_dir);
 	      $dirContents = new RecursiveIteratorIterator($dirIterator);
	      foreach( $dirContents as $one )
		{
		  if( $one->isFile() && $one->getMTime() <= $the_time )
		    {
 		      @unlink($one->getPathname());
		    }
		}
	    }
	}
}

/**
 * Simple global convenience object to hold CMS route information.
 * 
 * @package CMS
 */
class CmsRoute
{
	var $module;
	var $regex;
	var $defaults;
}

/**
 * Simple global convenience object to hold CMS Content Type structure.
 *
 * @package CMS
 */
class CmsContentTypePlaceholder
{
	var $type;
	var $filename;
	var $friendlyname;
	var $loaded;
}

# vim:ts=4 sw=4 noet
?>
