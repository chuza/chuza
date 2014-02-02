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
#$Id: Link.inc.php 6447 2010-07-02 06:40:08Z sjg $

/**
 * Define the link content type
 * @package CMS
 * @license GPL
 */

/**
 * Class for CMS Made Simple link content type
 *
 * @package CMS
 * @version $Revision$
 * @license GPL
 */
class Link extends ContentBase
{

    function IsCopyable()
    {
        return TRUE;
    }

    function IsViewable()
    {
      return FALSE;
    }

    function FriendlyName()
    {
      return lang('contenttype_link');
    }

    function SetProperties()
    {
      parent::SetProperties();
      $this->RemoveProperty('secure',0);
      $this->RemoveProperty('cachable',true);
      $this->AddContentProperty('url',10,1);
    }

    function FillParams($params)
    {
	parent::FillParams($params);

	if (isset($params))
	{
	  $parameters = array('url');
	  foreach ($parameters as $oneparam)
	    {
	      if (isset($params[$oneparam]))
		{
		  $this->SetPropertyValue($oneparam, $params[$oneparam]);
		}
	    }

	  if (isset($params['file_url']))
	    {
	    	$this->SetPropertyValue('url', $params['file_url']);
            } 
	}
    }

    function ValidateData()
    {
      $errors = parent::ValidateData();
      if( $errors === FALSE )
	{
	  $errors = array();
	}

      if ($this->GetPropertyValue('url') == '')
	{
	  $errors[]= lang('nofieldgiven',array(lang('url')));
	  $result = false;
	}

      return (count($errors) > 0?$errors:FALSE);
    }

    function TabNames()
    {
      $res = array(lang('main'));
      if( check_permission(get_userid(),'Manage All Content') )
	{
	  $res[] = lang('options');
	}
      return $res;
    }

    function display_single_element($one,$adding)
    {
      switch($one) {
	case 'url':
	  {
	    return array(lang('url').':','<input type="text" name="url" size="80" value="'.cms_htmlentities($this->GetPropertyValue('url')).'" />');
	  }
	  break;

      default:
	return parent::display_single_element($one,$adding);
      }
    }

    function EditAsArray($adding = false, $tab = 0, $showadmin = false)
    {
      global $gCms;

      switch($tab)
	{
	case '0':
	  return $this->display_attributes($adding);
	  break;
	case '1':
	  return $this->display_attributes($adding,1);
	  break;
	}
    }

    function GetURL($rewrite = true)
    {
	return cms_htmlentities($this->GetPropertyValue('url'));
    }
}

# vim:ts=4 sw=4 noet
?>
