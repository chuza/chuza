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
#$Id$

/**
 * Methods for modules to do form related functions; included in the module class when needed
 * @see CMSModule
 * @since		1.0
 * @package		CMS
 * @license GPL
 */

/**
 * @access private
 */
function cms_module_CreateFormStart(&$modinstance, $id, $action='default', $returnid='', $method='post', $enctype='', $inline=false, $idsuffix='', $params = array(), $extra='')
{
	global $gCms;

	$formcount = 1;
	$variables = &$gCms->variables;

	if (isset($variables['formcount']))
		$formcount = $variables['formcount'];

	$id = cms_htmlentities($id);
	$action = cms_htmlentities($action);
	$returnid = cms_htmlentities($returnid);
	$method = cms_htmlentities($method);
	$enctype = cms_htmlentities($enctype);
	$idsuffix = cms_htmlentities($idsuffix);

	if ($idsuffix == '')
		$idsuffix = $formcount;

	$goto = 'moduleinterface.php';
	if( $returnid != '' )
	{
	  $hm =& $gCms->GetHierarchyManager();
	  $node =& $hm->sureGetNodeById($returnid);
	  if( $node )
	    {
	      $content_obj =& $node->getContent();
	      if( $content_obj )
		$goto = $content_obj->GetURL();
	    }
	}
	if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on" && strpos($goto,':') !== FALSE )
	  {
	    $goto = str_replace('http:','https:',$goto);
	  }
	$goto = ' action="'.$goto.'"';
	
	$text = '<form id="'.$id.'moduleform_'.$idsuffix.'" method="'.$method.'"'.$goto;
	$text .= ' class="cms_form"';
	if ($enctype != '')
	{
		$text .= ' enctype="'.$enctype.'"';
	}
	if ($extra != '')
	{
		$text .= ' '.$extra;
	}
	$text .= '>'."\n".'<div class="hidden">'."\n".'<input type="hidden" name="mact" value="'.$modinstance->GetName().','.$id.','.$action.','.($inline == true?1:0).'" />'."\n";
	if ($returnid != '')
	{
		$text .= '<input type="hidden" name="'.$id.'returnid" value="'.$returnid.'" />'."\n";
		if ($inline)
		{
			$text .= '<input type="hidden" name="'.$modinstance->cms->config['query_var'].'" value="'.$returnid.'" />'."\n";
		}
	}
	else
	  {
	    $text .= '<input type="hidden" name="'.CMS_SECURE_PARAM_NAME.'" value="'.$_SESSION[CMS_USER_KEY].'" />'."\n";
	  }
	foreach ($params as $key=>$value)
	{
	  $value = cms_htmlentities($value);
	  if ($key != 'module' && $key != 'action' && $key != 'id')
	    $text .= '<input type="hidden" name="'.$id.$key.'" value="'.$value.'" />'."\n";
	}
	$text .= "</div>\n";

	$formcount = $formcount + 1;
	$variables['formcount'] = $formcount;

	return $text;
}

/**
 * @access private
 */
function cms_module_CreateLabelForInput(&$modinstance, $id, $name, $labeltext='', $addttext='')
{
  $text = '<label class="cms_label" for="'.cms_htmlentities($id.$name).'"';
  if ($addttext != '')
    {
      $text .= ' ' . $addttext;
    }
  $text .= '>'.$labeltext.'</label>'."\n";
  return $text;

}

/**
 * @access private
 */
function cms_module_CreateInputText(&$modinstance, $id, $name, $value='', $size='10', $maxlength='255', $addttext='')
{
  $value = cms_htmlentities($value);
  $id = cms_htmlentities($id);
  $name = cms_htmlentities($name);
  $size = cms_htmlentities($size);
  $maxlength = cms_htmlentities($maxlength);

  $value = str_replace('"', '&quot;', $value);
  
  $text = '<input type="text" class="cms_textfield" name="'.$id.$name.'" id="'.$id.$name.'" value="'.$value.'" size="'.$size.'" maxlength="'.$maxlength.'"';
  if ($addttext != '')
    {
      $text .= ' ' . $addttext;
    }
  $text .= " />\n";
  return $text;
}

/**
 * @access private
 */
function cms_module_CreateInputTextWithLabel(&$modinstance, $id, $name, $value='', $size='10', $maxlength='255', $addttext='', $label='', $labeladdtext='')
{
  $id = cms_htmlentities($id);
  $name = cms_htmlentities($name);
  $value = cms_htmlentities($value);
  $size = cms_htmlentities($size);
  $maxlength = cms_htmlentities($maxlength);

        if ($label == '') {
	  $label = $name;
	}
	$text = '<label class="cms_label" for="'.$id.$name.'" '.$labeladdtext.'>'.$label.'</label>'."\n";
	$text .= $modinstance->CreateInputText($id, $name, $value, $size, $maxlength, $addttext);
	$text .= "\n";
	return $text;
}

/**
 * @access private
 */
function cms_module_CreateInputFile(&$modinstance, $id, $name, $accept='', $size='10',$addttext='')
{
  $id = cms_htmlentities($id);
  $name = cms_htmlentities($name);
  $accept = cms_htmlentities($accept);
  $size = cms_htmlentities($size);

	$text='<input type="file" class="cms_browse" name="'.$id.$name.'" size="'.$size.'"';
	if ($accept != '')
	{
		$text .= ' accept="' . $accept.'"';
	}
	if ($addttext != '')
	{
		$text .= ' ' . $addttext;
	}
	$text .= " />\n";
	return $text;
}

/**
 * @access private
 */
function cms_module_CreateInputPassword(&$modinstance, $id, $name, $value='', $size='10', $maxlength='255', $addttext='')
{
  $id = cms_htmlentities($id);
  $name = cms_htmlentities($name);
  $value = cms_htmlentities($value);
  $size = cms_htmlentities($size);
  $maxlength = cms_htmlentities($maxlength);

	$value = str_replace('"', '&quot;', $value);
	$text = '<input type="password" class="cms_password" name="'.$id.$name.'" value="'.$value.'" size="'.$size.'" maxlength="'.$maxlength.'"';
	if ($addttext != '')
	{
		$text .= ' ' . $addttext;
	}
	$text .= " />\n";
	return $text;
}

/**
 * @access private
 */
function cms_module_CreateInputHidden(&$modinstance, $id, $name, $value='', $addttext='')
{
  $id = cms_htmlentities($id);
  $name = cms_htmlentities($name);
  $value = cms_htmlentities($value);

	$value = str_replace('"', '&quot;', $value);
	$text = '<input type="hidden" name="'.$id.$name.'" value="'.$value.'"';
	if ($addttext != '')
	{
		$text .= ' '.$addttext;
	}
	$text .= " />\n";
	return $text;
}

/**
 * @access private
 */
function cms_module_CreateInputCheckbox(&$modinstance, $id, $name, $value='', $selectedvalue='', $addttext='')
{
  $id = cms_htmlentities($id);
  $name = cms_htmlentities($name);
  $value = cms_htmlentities($value);
  $selectedvalue = cms_htmlentities($selectedvalue);

	$text = '<input type="checkbox" class="cms_checkbox" name="'.$id.$name.'" value="'.$value.'"';
	if ($selectedvalue == $value)
	{
		$text .= ' ' . 'checked="checked"';
	}
	if ($addttext != '')
	{
		$text .= ' '.$addttext;
	}
	$text .= " />\n";
	return $text;
}

/**
 * @access private
 */
function cms_module_CreateInputSubmit(&$modinstance, $id, $name, $value='', $addttext='', $image='', $confirmtext='')
{
  $id = cms_htmlentities($id);
  $name = cms_htmlentities($name);
  $image = cms_htmlentities($image);

	global $gCms;
	$config =& $gCms->GetConfig();

	$text = '<input class="cms_submit" name="'.$id.$name.'" id="'.$id.$name.'" value="'.$value.'" type=';

	if ($image != '')
	{
		$text .= '"image"';
		$img = $config['root_url'] . '/' . $image;
		$text .= ' src="'.$img.'"';
	}
	else
	{
		$text .= '"submit"';
	}
	if ($confirmtext != '' )
	  {
		$text .= ' onclick="return confirm(\''.$confirmtext.'\');"';
	  }
	if ($addttext != '')
	{
		$text .= ' '.$addttext;
	}

	$text .= ' />';

	return $text . "\n";
}

/**
 * @access private
 */
function cms_module_CreateInputReset(&$modinstance, $id, $name, $value='Reset', $addttext='')
{
  $id = cms_htmlentities($id);
  $name = cms_htmlentities($name);

  $text = '<input type="reset" class="cms_reset" name="'.$id.$name.'" value="'.$value.'"';
  if ($addttext != '')
    {
      $text .= ' '.$addttext;
    }
  $text .= ' />';
  return $text . "\n";
}

/**
 * @access private
 */
function cms_module_CreateFileUploadInput(&$modinstance, $id, $name, $addttext='', $size='10',
					  $maxlength='255')
{
  $id = cms_htmlentities($id);
  $name = cms_htmlentities($name);

	$text = '<input type="file" class="cms_browse" name="'.$id.$name.'" size="'.$size.'" maxlength="'.$maxlength.'"';
	if ($addttext != '')
	{
		$text .= ' '.$addttext;
	}
	$text .= ' />';
	return $text . "\n";
}

/**
 * @access private
 */
function cms_module_CreateInputDropdown(&$modinstance, $id, $name, $items, $selectedindex, $selectedvalue, $addttext)
{
  $id = cms_htmlentities($id);
  $name = cms_htmlentities($name);
  $selectedindex = cms_htmlentities($selectedindex);
  $selectedvalue = cms_htmlentities($selectedvalue);

	$text = '<select class="cms_dropdown" name="'.$id.$name.'"';
	if ($addttext != '')
	{
		$text .= ' ' . $addttext;
	}
	$text .= '>';
	$count = 0;
	if (is_array($items) && count($items) > 0)
	{
		foreach ($items as $key=>$value)
		{
		  //		  $value = cms_htmlentities($value);
		$text .= '<option value="'.$value.'"';
			if ($selectedindex == $count || $selectedvalue == $value)
			{
				$text .= ' ' . 'selected="selected"';
			}
			$text .= '>';
			$text .= $key;
			$text .= '</option>';
			$count++;
		}
	}
	$text .= '</select>'."\n";

	return $text;
}

/**
 * @access private
 */
function cms_module_CreateInputSelectList(&$modinstance, $id, $name, $items, $selecteditems=array(), $size=3, $addttext='', $multiple = true)
{
  $id = cms_htmlentities($id);
  $name = cms_htmlentities($name);
  $size = cms_htmlentities($size);
  $multiple = cms_htmlentities($multiple);

  if( strstr($name,'[]') === FALSE && $multiple === true )
    {
      $name.='[]';
    }
  $text = '<select class="cms_select" name="'.$id.$name.'"';
	if ($addttext != '')
	{
		$text .= ' ' . $addttext;
	}
	if( $multiple )
	  {
		$text .= ' multiple="multiple" ';
	  }
	$text .= 'size="'.$size.'">';
	$count = 0;
	foreach ($items as $key=>$value)
	{
	  $value = cms_htmlentities($value);

		$text .= '<option value="'.$value.'"';
		if (in_array($value, $selecteditems))
		{
			$text .= ' ' . 'selected="selected"';
		}
		$text .= '>';
		$text .= $key;
		$text .= '</option>';
		$count++;
	}
	$text .= '</select>'."\n";

	return $text;
}

/**
 * @access private
 */
function cms_module_CreateInputRadioGroup(&$modinstance, $id, $name, $items, $selectedvalue='', $addttext='', $delimiter='')
{
  $id = cms_htmlentities($id);
  $name = cms_htmlentities($name);
  $selectedvalue = cms_htmlentities($selectedvalue);
  
  //$delimiter = cms_htmlentities($delimiter); //Doesn't work with stuff like <br/>!

	$text = '';
	$counter = 0;
	foreach ($items as $key=>$value)
	{
	  $value = cms_htmlentities($value);

		$counter = $counter + 1;
		$text .= '<input class="cms_radio" type="radio" name="'.$id.$name.'" id="'.$id.$name.$counter.'" value="'.$value.'"';
		if ($addttext != '')
		{
			$text .= ' ' . $addttext;
		}
		if ($selectedvalue == $value)
		{
			$text .= ' ' . 'checked="checked"';
		}
		$text .= ' />';
		$text .= '<label class="cms_label" for="'.$id.$name.$counter.'">'.$key .'</label>' . $delimiter;
	}

	return $text;
}

/**
 * @access private
 */
function cms_module_CreateLink(&$modinstance, $id, $action, $returnid='', $contents='', $params=array(), $warn_message='', $onlyhref=false, $inline=false, $addttext='', $targetcontentonly=false, $prettyurl='')
{
  if( !is_array($params) && $params == '' ) $params = array();
  $id = cms_htmlentities($id);
  $action = cms_htmlentities($action);
  $returnid = cms_htmlentities($returnid);
  $prettyurl = cms_htmlentities($prettyurl);

	global $gCms;
	$config =& $gCms->GetConfig();

	$class = (isset($params['class'])?cms_htmlentities($params['class']):'');

	if ($prettyurl != '' && $config['url_rewriting'] == 'mod_rewrite')
	{
		$text = $config['root_url'] . '/' . $prettyurl . $config['page_extension'];
	}
	else if ($prettyurl != '' && $config['url_rewriting'] == 'internal')
	{
		$text = $config['root_url'] . '/index.php/' . $prettyurl . $config['page_extension'];
	}
	else
	{
		$text = '';
		if ($targetcontentonly || ($returnid != '' && !$inline))
		{
			$id = 'cntnt01';
		}
		$goto = 'index.php';
		if ($returnid == '')
		{
			$goto = 'moduleinterface.php';
		}
		if (!$onlyhref)
		{
		}
		$text .= $config['root_url'];
		if (!($returnid != '' && $returnid > -1))
		{
			$text .= '/'.$config['admin_dir'];
		}

		$secureparam = '';
		if( $returnid == '' )
		  {
		    $secureparam='&amp;'.CMS_SECURE_PARAM_NAME.'='.$_SESSION[CMS_USER_KEY];
		  }
		#$text .= '/'.$goto.'?module='.$modinstance->GetName().'&amp;id='.$id.'&amp;'.$id.'action='.$action.$secureparam;
		$text .= '/'.$goto.'?mact='.$modinstance->GetName().','.$id.','.$action.','.($inline == true?1:0).$secureparam;

		foreach ($params as $key=>$value)
		{
		  $key = cms_htmlentities($key);
		  $value = cms_htmlentities($value);
			if ($key != 'module' && $key != 'action' && $key != 'id')
				$text .= '&amp;'.$id.$key.'='.rawurlencode($value);
		}
		if ($returnid != '')
		{
			$text .= '&amp;'.$id.'returnid='.$returnid;
			if ($inline)
			{
				$text .= '&amp;'.$config['query_var'].'='.$returnid;
			}
		}
	}

	if (!$onlyhref)
	{
		$beginning = '<a';
		if ($class != '')
		{
			$beginning .= ' class="'.$class.'"';
		}
		$beginning .= ' href="';
		$text = $beginning . $text . "\"";
		if ($warn_message != '')
		{
			$text .= ' onclick="return confirm(\''.$warn_message.'\');"';
		}

		if ($addttext != '')
		{
			$text .= ' ' . $addttext;
		}

		$text .= '>'.$contents.'</a>';
	}
	return $text;
}

/**
 * @access private
 */
function cms_module_CreateContentLink(&$modinstance, $pageid, $contents='')
{
  $pageid = cms_htmlentities($pageid);
  $contents = cms_htmlentities($contents);

	global $gCms;
	$config = &$gCms->GetConfig();
	$text = '<a href="';
	if ($config["url_rewriting"] == 'mod_rewrite')
	{
		# mod_rewrite
		$contentops =& $gCms->GetContentOperations();
		$alias = $contentops->GetPageAliasFromID( $pageid );
		if( $alias == false )
		{
			return '<!-- ERROR: could not get an alias for pageid='.$pageid.'-->';
		}
		else
		{
			$text .= $config["root_url"]."/".$alias.
			(isset($config['page_extension'])?$config['page_extension']:'.shtml');
		}
	}
	else
	{
		# not mod rewrite
		$text .= $config["root_url"]."/index.php?".$config["query_var"]."=".$pageid;
	}
	$text .= '">'.$contents.'</a>';
	return $text;
}

/**
 * @access private
 */
function cms_module_CreateReturnLink(&$modinstance, $id, $returnid, $contents='', $params=array(), $onlyhref=false)
{
  $id = cms_htmlentities($id);
  $returnid = cms_htmlentities($returnid);
  $contents = $contents;

	$text = '';
	global $gCms;
	$config = &$gCms->GetConfig();
	$manager =& $gCms->GetHierarchyManager();
	$node =& $manager->sureGetNodeById($returnid);
	if (isset($node))
	{
		$content =& $node->GetContent();

		if (isset($content))
		{
			if ($content->GetURL() != '')
			{
				if (!$onlyhref)
				{
					$text .= '<a href="';
				}
				$text .= $content->GetURL();

				$count = 0;
				foreach ($params as $key=>$value)
				{
				  $key = cms_htmlentities($key);
				  $value = cms_htmlentities($value);
					if ($count > 0)
					{
						if ($config["url_rewriting"] == 'mod_rewrite' && $rewrite == true)
							$text .= '?';
						else
							$text .= '&amp;';
					}
					else
					{
						$text .= '&amp;';
					}
					$text .= $id.$key.'='.$value;
					$count++;
				}
				if (!$onlyhref)
				{
					$text .= "\"";
					$text .= '>'.$contents.'</a>';
				}
			}
		}
	}

	return $text;
}

/**
 * @access private
 */
function cms_module_CreateFieldsetStart(&$modinstance, $id, $name, $legend_text='', $addtext='', $addtext_legend='')
{
  $id = cms_htmlentities($id);
  $name = cms_htmlentities($name);
  $legend_text = cms_htmlentities($legend_text);

  $text = '<fieldset class="cms_fieldset" '. $addtext. '>'."\n";
  $text .= '<legend class="cms_legend" '. $addtext_legend .'>'."\n";
  $text .= $legend_text;
  $text .= '</legend>';
  return $text;
}

?>
