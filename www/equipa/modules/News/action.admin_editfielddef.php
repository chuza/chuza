<?php
#CMS - CMS Made Simple
#(c)2004-6 by Ted Kulp (ted@cmsmadesimple.org)
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

if (!isset($gCms)) exit;

if (!$this->CheckPermission('Modify News'))
{
  echo $this->ShowErrors($this->Lang('needpermission', array('Modify News')));
  return;
}

if (isset($params['cancel']))
  {
    $params = array('active_tab' => 'customfields');
    $this->Redirect($id, 'defaultadmin', $returnid, $params);
  }

$fdid = '';
if (isset($params['fdid']))
  {
    $fdid = $params['fdid'];
  }

$name = '';
if (isset($params['name']))
  {
    $name = $params['name'];
  }

$type = '';
if (isset($params['type']))
  {
    $type = $params['type'];
  }

$max_length = 255;
if (isset($params['max_length']))
  {
    $max_length = (int)$params['max_length'];
  }

$origname = '';
if (isset($params['origname']))
  {
    $origname = $params['origname'];
  }

$public = 0;
if( isset($params['public']) )
  {
    $public = (int)$params['public'];
  }

if (isset($params['submit']))
  {
    if ($name != '')
      {
	if (is_numeric($max_length))
	  {
	    $query = 'SELECT id FROM '.cms_db_prefix().'module_news_fielddefs
                       WHERE name = ? AND id != ?';
	    $tmp = $db->GetOne($query,array($name,$fdid));
	    if( $tmp )
	      {
		echo $this->ShowErrors($this->Lang('nameexists'));
	      }
	    else
	      {
		$query = 'UPDATE '.cms_db_prefix().'module_news_fielddefs SET name = ?, type = ?, max_length = ?, modified_date = '.$db->DBTimeStamp(time()).', public = ? WHERE id = ?';
		$res = $db->Execute($query, 
				    array($name, $type, $max_length, $public, $fdid));
		
		if( !$res ) die( $db->ErrorMsg() );
		$params = array('tab_message'=> 'fielddefupdated', 'active_tab' => 'customfields');
		$this->Redirect($id, 'defaultadmin', $returnid, $params);
	      }
	  }
	else
	  {
	    echo $this->ShowErrors($this->Lang('notanumber'));
	  }
      }
    else
      {
	echo $this->ShowErrors($this->Lang('nonamegiven'));
      }
  }
 else
   {
     $query = 'SELECT * FROM '.cms_db_prefix().'module_news_fielddefs WHERE id = ?';
     $row = $db->GetRow($query, array($fdid));

     if ($row)
       {
	 $name = $row['name'];
	 $type = $row['type'];
	 $max_length = $row['max_length'];
	 $origname = $row['name'];
	 $public = $row['public'];
       }
   }

#Display template
$smarty->assign('title',$this->Lang('editfielddef'));
$smarty->assign('startform', $this->CreateFormStart($id, 'admin_editfielddef', $returnid));
$smarty->assign('endform', $this->CreateFormEnd());
$smarty->assign('nametext', $this->Lang('name'));
$smarty->assign('typetext', $this->Lang('type'));
$smarty->assign('maxlengthtext', $this->Lang('maxlength'));
$smarty->assign('inputname', $this->CreateInputText($id, 'name', $name, 20, 255));
$smarty->assign('showinputtype', false);
$smarty->assign('inputtype', $this->CreateInputHidden($id, 'type', $type));
$smarty->assign('inputmaxlength', $this->CreateInputText($id, 'max_length', $max_length, 20, 255));
$smarty->assign('userviewtext',$this->Lang('public'));
$smarty->assign('input_userview',
		$this->CreateInputcheckbox($id, 'public', 1, $public));

$smarty->assign('hidden', 
		$this->CreateInputHidden($id, 'fdid', $fdid).
		$this->CreateInputHidden($id, 'origname', $origname));
$smarty->assign('submit', $this->CreateInputSubmit($id, 'submit', lang('submit')));
$smarty->assign('cancel', $this->CreateInputSubmit($id, 'cancel', lang('cancel')));
echo $this->ProcessTemplate('editfielddef.tpl');
?>
