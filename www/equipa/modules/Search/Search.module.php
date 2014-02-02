<?php
#CMS - CMS Made Simple
#(c)2004 by Ted Kulp (wishy@users.sf.net)
#This project's homepage is: http://cmsmadesimple.sf.net
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
#$Id: News.module.php 2114 2005-11-04 21:51:13Z wishy $

include_once(dirname(__FILE__) . '/PorterStemmer.class.php');

define( "NON_INDEXABLE_CONTENT", "<!-- pageAttribute: NotSearchable -->" );

class Search extends CMSModule
{
  var $_tools_loaded;

  function __construct()
  {
    parent::__construct();
    $this->_tools_loaded = false;
  }

  function load_tools()
  {
    if( !$this->_tools_loaded )
      {
	$fn = dirname(__FILE__).'/search.tools.php';
	include_once($fn);
	$this->_tools_loaded = true;
      }
  }

  function GetName()
  {
    return 'Search';
  }

  function GetFriendlyName()
  {
    return $this->Lang('search');
  }

  function IsPluginModule()
  {
    return true;
  }

  function HasAdmin()
  {
    return true;
  }

  /*---------------------------------------------------------
   HandlesEvents()
   ---------------------------------------------------------*/
  function HandlesEvents ()
  {
    return true;
  }

  function GetVersion()
  {
    return '1.6.5';
  }

  function MinimumCMSVersion()
  {
    return '1.8-beta1';
  }

  function GetAdminDescription()
  {
    return $this->Lang('description');
  }

  function VisibleToAdminUser()
  {
    return $this->CheckPermission('Modify Site Preferences') ||
      $this->CheckPermission('Modify Templates');
  }

  function SetParameters()
  {
    // This module does not restrict unknown parameters
    // due to the wildcard/regular expression matching stuff of the
    // passthru_* parameters.
    $this->RestrictUnknownParams();
    $this->CreateParameter('inline','false',$this->Lang('param_inline'));
    $this->SetParameterType('inline',CLEAN_STRING);

    $this->CreateParameter('passthru_*','null',$this->Lang('param_passthru'));
    $this->SetParameterType(CLEAN_REGEXP.'/passthru_.*/',CLEAN_STRING);

    $this->CreateParameter('modules','null',$this->Lang('param_modules'));
    $this->SetParameterType('modules',CLEAN_STRING);

    $this->CreateParameter('resultpage', 'null', $this->Lang('param_resultpage'));
    $this->SetParameterType('resultpage',CLEAN_STRING);
    $this->CreateParameter('searchtext','null',$this->Lang('param_searchtext'));

    $this->SetParameterType('detailpage',CLEAN_STRING);
    $this->CreateParameter('detailpage','null',$this->Lang('param_detailpage'));

    $this->SetParameterType('searchtext',CLEAN_STRING);
    $this->SetParameterType('searchinput',CLEAN_STRING);

    $this->CreateParameter('submit',$this->Lang('searchsubmit'),
			   $this->Lang('param_submit'));
    $this->SetParameterType('submit',CLEAN_STRING);
    $this->SetParameterType('origreturnid',CLEAN_INT);

    $this->CreateParameter('action','default',$this->Lang('param_action'));
    $this->CreateParameter('pageid','null',$this->Lang('param_pageid'));
    $this->SetParameterType('pageid',CLEAN_INT);
    $this->CreateParameter('count','null',$this->Lang('param_count'));
    $this->SetParameterType('count',CLEAN_INT);
    
    $this->CreateParameter('search_method','get',$this->Lang('search_method'));
    $this->SetParameterType('search_method',CLEAN_STRING);
}

  function GetSearchHtmlTemplate()
  {
    return '{$startform}

    <label for="{$search_actionid}searchinput">{$searchprompt}:&nbsp;</label><input type="text" class="search-input" id="{$search_actionid}searchinput" name="{$search_actionid}searchinput" size="20" maxlength="50" value="{$searchtext}" {$hogan}/><input class="search-button" name="submit" value="{$submittext}" type="submit" />
{if isset($hidden)}{$hidden}{/if}

{$endform}';
  }
	
  function GetResultsHtmlTemplate()
  {
    $text = <<<EOT
<h3>{\$searchresultsfor} &quot;{\$phrase}&quot;</h3>
{if \$itemcount > 0}
<ul>
  {foreach from=\$results item=entry}
  <li>{\$entry->title} - <a href="{\$entry->url}">{\$entry->urltxt}</a> ({\$entry->weight}%)</li>
  {* 
     You can also instantiate custom behaviour on a module by module basis by looking at
     the \$entry->module and \$entry->modulerecord fields in \$entry 
      ie: {if \$entry->module == 'News'}{News action='detail' article_id=\$entry->modulerecord detailpage='News'} 
  *}
  {/foreach}
</ul>

<p>{\$timetaken}: {\$timetook}</p>
{else}
  <p><strong>{\$noresultsfound}</strong></p>
{/if}
EOT;
    return $text;
  }
	
  function DefaultStopWords()
  {
    return 'i, me, my, myself, we, our, ours, ourselves, you, your, yours, 
yourself, yourselves, he, him, his, himself, she, her, hers, 
herself, it, its, itself, they, them, their, theirs, themselves, 
what, which, who, whom, this, that, these, those, am, is, are, 
was, were, be, been, being, have, has, had, having, do, does, 
did, doing, a, an, the, and, but, if, or, because, as, until, 
while, of, at, by, for, with, about, against, between, into, 
through, during, before, after, above, below, to, from, up, down, 
in, out, on, off, over, under, again, further, then, once, here, 
there, when, where, why, how, all, any, both, each, few, more, 
most, other, some, such, no, nor, not, only, own, same, so, 
than, too, very';
  }

  function RemoveStopWordsFromArray($words)
  {
    $stop_words = preg_split("/[\s,]+/", $this->GetPreference('stopwords', $this->DefaultStopWords()));
    return array_diff($words, $stop_words);
  }

  function StemPhrase($phrase)
  {
    $this->load_tools();
    return search_StemPhrase($this,$phrase);
  }

  function AddWords($module = 'Search', $id = -1, $attr = '', $content = '', $expires = NULL)
  {
    $this->load_tools();
    return search_AddWords($this,$module,$id,$attr,$content,$expires);
  }

  function DeleteWords($module = 'Search', $id = -1, $attr = '')
  {
    $this->load_tools();
    return search_DeleteWords($this,$module,$id,$attr);
  }
	
  function DeleteAllWords($module = 'Search', $id = -1, $attr = '')
  {
    $db =& $this->GetDb();
    $db->Execute('DELETE FROM '.cms_db_prefix().'module_search_index');
    $db->Execute('DELETE FROM '.cms_db_prefix().'module_search_items');
		
    @$this->SendEvent('SearchAllItemsDeleted',array($module, $id, $attr));
  }

  function GetHelp($lang='en_US')
  {
    return $this->Lang('help');
  }

  function GetAuthor()
  {
    return 'Ted Kulp';
  }

  function GetAuthorEmail()
  {
    return 'ted@cmsmadesimple.org';
  }

  function GetChangeLog()
  {
    return @file_get_contents(dirname(__FILE__).'/changelog.inc');
  }
	
  function RegisterEvents()
  {
    $this->AddEventHandler( 'Core', 'ContentEditPost', false );
    $this->AddEventHandler( 'Core', 'ContentDeletePost', false );
    $this->AddEventHandler( 'Core', 'AddTemplatePost', false );
    $this->AddEventHandler( 'Core', 'EditTemplatePost', false );
    $this->AddEventHandler( 'Core', 'DeleteTemplatePost', false );
    $this->AddEventHandler( 'Core', 'AddGlobalContentPost', false );
    $this->AddEventHandler( 'Core', 'EditGlobalContentPost', false );
    $this->AddEventHandler( 'Core', 'DeleteGlobalContentPost', false );
    $this->AddEventHandler( 'Core', 'ModuleUninstalled', false );
  }

  function Reindex()
  {
    $this->load_tools();
    return search_Reindex($this);
  }

  function GetEventDescription( $eventname )
  {
    return $this->lang('eventdesc-' . $eventname);
  }

  function GetEventHelp( $eventname )
  {
    return $this->lang('eventhelp-' . $eventname);
  }
	

  function DoEvent($originator,$eventname,&$params)
  {
    $this->load_tools();
    return search_DoEvent($this, $originator, $eventname, $params);
  }
}

# vim:ts=4 sw=4 noet
?>
