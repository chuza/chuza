<?php


$cabeceira = file_get_contents('http://www.chuza.gl/api/cabeceira.php');
$pe = file_get_contents('http://www.chuza.gl/api/pe.php');




$orig_memory = (function_exists('memory_get_usage')?memory_get_usage():0);
$dirname = dirname(__FILE__);
require_once($dirname.'/fileloc.php');

/**
 * Entry point for all non-admin pages
 *
 * @package CMS
 */	

$starttime = microtime();
clearstatcache();


if (!isset($_SERVER['REQUEST_URI']) && isset($_SERVER['QUERY_STRING']))
{
	$_SERVER['REQUEST_URI'] = $_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING'];
}

if (!file_exists(CONFIG_FILE_LOCATION) || filesize(CONFIG_FILE_LOCATION) < 800)
{
    require_once($dirname.'/lib/misc.functions.php');
    if (FALSE == is_file($dirname.'/install/index.php')) {
        die ('There is no config.php file or install/index.php please correct one these errors!');
    } else {
        redirect('install/');
    }
}
else if (file_exists(TMP_CACHE_LOCATION.'/SITEDOWN'))
{
	echo "<html><head><title>Maintenance</title></head><body><p>Site down for maintenance.</p></body></html>";
	exit;
}

if (!is_writable(TMP_TEMPLATES_C_LOCATION) || !is_writable(TMP_CACHE_LOCATION))
{
	echo '<html><title>Error</title></head><body>';
	echo '<p>The following directories must be writable by the web server:<br />';
	echo 'tmp/cache<br />';
	echo 'tmp/templates_c<br /></p>';
	echo '<p>Please correct by executing:<br /><em>chmod 777 tmp/cache<br />chmod 777 tmp/templates_c</em><br />or the equivilent for your platform before continuing.</p>';
	echo '</body></html>';
	exit;
}

require_once($dirname.'/include.php'); 
// optionally enable output compression (as long as debug mode isn't on)
if( isset($config['output_compression']) && ($config['output_compression']) && $config['debug'] != true )
  {
    @ob_start('ob_gzhandler');
  }
else
  {
    @ob_start();
  }


$params = array_merge($_GET, $_POST);

$smarty = &$gCms->smarty;
$smarty->params = $params;

$page = get_pageid_or_alias_from_url();

$smarty->assign('cabeceira', $cabeceira);
$smarty->assign('pe', $pe);

$pageinfo = '';
if( $page == '__CMS_PREVIEW_PAGE__' && isset($_SESSION['cms_preview']) ) // temporary
  {
    $tpl_name = trim($_SESSION['cms_preview']);
    $fname = '';
    if (is_writable($config["previews_path"]))
      {
	$fname = cms_join_path($config["previews_path"] , $tpl_name);
      }
    else
      {
	$fname = cms_join_path(TMP_CACHE_LOCATION , $tpl_name);
      }
    $fname = $tpl_name;
    if( !file_exists($fname) )
      {
	die('error preview temp file not found: '.$fname);
	return false;
      }

    // build pageinfo
    $fh = fopen($fname,'r');
    $_SESSION['cms_preview_data'] = unserialize(fread($fh,filesize($fname)));
    fclose($fh);
    unset($_SESSION['cms_preview']);

    $pageinfo = PageInfoOperations::LoadPageInfoFromSerializedData($_SESSION['cms_preview_data']);
    $pageinfo->content_id = '__CMS_PREVIEW_PAGE__';
  }

if( !is_object($pageinfo) )
  {
    $pageinfo = PageInfoOperations::LoadPageInfoByContentAlias($page);
  }

// $page cannot be empty here
if (isset($pageinfo) && $pageinfo !== FALSE)
{
	$gCms->variables['pageinfo'] =& $pageinfo;

	if( isset($pageinfo->template_encoding) && 
	    $pageinfo->template_encoding != '' )
	{
	  set_encoding($pageinfo->template_encoding);
	}

	if($pageinfo->content_id > 0)
	{
		$manager =& $gCms->GetHierarchyManager();
		$node =& $manager->sureGetNodeById($pageinfo->content_id);
		if(is_object($node))
		{
		  $contentobj =& $node->GetContent(true,true,false);
		  if( !$contentobj->IsViewable() )
		    {
		      $url = $contentobj->GetURL();
		      if( $url != '' && $url != '#' )
			{
			  redirect($url);
			}
		    }
		  if( is_object($contentobj) )
		    {
		      $smarty->assign('content_obj',$contentobj);
		    }
		}
	}

	$gCms->variables['content_id'] = $pageinfo->content_id;
	$gCms->variables['page'] = $page;
	$gCms->variables['page_id'] = $page;

	$gCms->variables['page_name'] = $pageinfo->content_alias;
	$gCms->variables['position'] = $pageinfo->content_hierarchy;
	global $gCms;
	$contentops =& $gCms->GetContentOperations();
	$gCms->variables['friendly_position'] = $contentops->CreateFriendlyHierarchyPosition($pageinfo->content_hierarchy);

	$smarty->assign('content_id', $pageinfo->content_id);
	$smarty->assign('page', $page);
	$smarty->assign('page_id', $page);
	$smarty->assign('page_name', $pageinfo->content_alias);
	$smarty->assign('page_alias', $pageinfo->content_alias);
	$smarty->assign('position', $pageinfo->content_hierarchy);
	$smarty->assign('friendly_position', $gCms->variables['friendly_position']);
}
else
// else if (get_site_preference('enablecustom404') == '' || get_site_preference('enablecustom404') == "0")
{
	ErrorHandler404();
	exit;
}

$html = '';
$cached = '';
$showtemplate = true;

if ((isset($_REQUEST['showtemplate']) && $_REQUEST['showtemplate'] == 'false') ||
    (isset($smarty->id) && $smarty->id != '' && isset($_REQUEST[$smarty->id.'showtemplate']) && $_REQUEST[$smarty->id.'showtemplate'] == 'false'))
{
  $showtemplate = false;
}


if (isset($_GET["print"]))
{
	($smarty->is_cached('print:'.$page, '', $pageinfo->template_id)?$cached="":$cached="not ");
	$html = $smarty->fetch('print:'.$page, '', $pageinfo->template_id) . "\n";
}
else
{
	#If this is a case where a module doesn't want a template to be shown, just disable caching
        if( !$showtemplate )
	{
		$html = $smarty->fetch('template:notemplate') . "\n";
	}
	else
	{
		$smarty->caching = false;
		$smarty->compile_check = true;
		($smarty->is_cached('template:'.$pageinfo->template_id)?$cached="":$cached="not ");

		// we allow backward compatibility (for a while)
		// for people that have hacks for setting page title
		// or header variables by capturing a modules output
		// to a smarty variable, and then displaying it later.
		if( isset($config['process_whole_template']) && $config['process_whole_template'] === false )
		  {
		    $top  = $smarty->fetch('tpl_top:'.$pageinfo->template_id);
		    $body = $smarty->fetch('tpl_body:'.$pageinfo->template_id);
		    $head = $smarty->fetch('tpl_head:'.$pageinfo->template_id);
		    $html = $top.$head.$body;
		  }
		else
		  {
		    $html = $smarty->fetch('template:'.$pageinfo->template_id);
		  }
	}
}

#if ((get_site_preference('enablecustom404') == '' || get_site_preference('enablecustom404') == "0") && (!$config['debug']))
#{
#	set_error_handler($old_error_handler);
#}

#if (!$cached)
#{
	#Perform the content postrendernoncached callback
#	reset($gCms->modules);
#	while (list($key) = each($gCms->modules))
#	{
#		$value =& $gCms->modules[$key];
#		if ($gCms->modules[$key]['installed'] == true &&
#			$gCms->modules[$key]['active'] == true)
#		{
#			$gCms->modules[$key]['object']->ContentPostRenderNonCached($html);
#		}
#	}
  // this event doesn't exist in 1.7.x
	//Events::SendEvent('Core', 'ContentPostRenderNonCached', array(&$html));
#}

#Perform the content postrender callback
#reset($gCms->modules);
#while (list($key) = each($gCms->modules))
#{
#	$value =& $gCms->modules[$key];
#	if ( isset($gCms->modules[$key]['installed']) &&
#	     $gCms->modules[$key]['installed'] == true &&
#		$gCms->modules[$key]['active'] == true)
#	{
#		$gCms->modules[$key]['object']->ContentPostRender($html);
#	}
#}

Events::SendEvent('Core', 'ContentPostRender', array('content' => &$html));

header("Content-Type: " . $gCms->variables['content-type'] . "; charset=" . (isset($pageinfo->template_encoding) && $pageinfo->template_encoding != ''?$pageinfo->template_encoding:get_encoding()));

echo $html;

@ob_flush();

$endtime = microtime();

$db =& $gCms->GetDb();

$memory = (function_exists('memory_get_usage')?memory_get_usage():0);
$memory = $memory - $orig_memory;
$memory_peak = (function_exists('memory_get_peak_usage')?memory_get_peak_usage():0);
if ( !is_sitedown() && $config["debug"] == true)
{
  echo "<p>Generated in ".microtime_diff($starttime,$endtime)." seconds by CMS Made Simple using ".(isset($db->query_count)?$db->query_count:'')." SQL queries and {$memory} bytes of memory (peak memory usage was {$memory_peak})</p>";
}
else if( isset($config['show_performance_info']) && ($showtemplate == true) )
{
echo "<!-- ".microtime_diff($starttime,$endtime)." / ".(isset($db->query_count)?$db->query_count:'')." / {$memory} / {$memory_peak} -->\n";

}

if( is_sitedown() || $config['debug'] == true)
{
	$smarty->clear_compiled_tpl();
	#$smarty->clear_all_cache();
}

if ( !is_sitedown() && $config["debug"] == true)
{
	#$db->LogSQL(false); // turn off logging
	
	# output summary of SQL logging results
	#$perf = NewPerfMonitor($db);
	#echo $perf->SuspiciousSQL();
	#echo $perf->ExpensiveSQL();

	#echo $sql_queries;
	foreach ($gCms->errors as $error)
	{
		echo $error;
	}
}

if( $page == '__CMS_PREVIEW_PAGE__' && isset($_SESSION['cms_preview']) ) // temporary
  {
    unset($_SESSION['cms_preview']);
  }
# vim:ts=4 sw=4 noet
?>
