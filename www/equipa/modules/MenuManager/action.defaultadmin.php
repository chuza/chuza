<?php
if (!isset($gCms)) exit;
if (!$this->CheckPermission('Manage Menu')) exit;

$admintheme =& $gCms->variables['admintheme'];
$default_template = $this->GetPreference('default_template','simple_navigation.tpl');

/*****************************************
 * Handle the Database Tab
 ****************************************/
$entryarray = array();

$templates = $this->ListTemplates();
foreach ($templates as $onetemplate)
{
  $onerow = new stdClass();

  $onerow->templatename = $onetemplate;
  $onerow->templatelink = $this->CreateLink($id, 'edittemplate', $returnid, $onetemplate, array('tplname' => $onetemplate));
  
  $onerow->editlink = $this->CreateLink($id, 'edittemplate', $returnid, $gCms->variables['admintheme']->DisplayImage('icons/system/edit.gif', $this->Lang('edittemplate'),'','','systemicon'), array('tplname' => $onetemplate));

  if( $default_template != $onetemplate )
    {
      $onerow->setdefault_link = $this->CreateLink($id,'setdefault',$returnid,
						   $admintheme->DisplayImage('icons/system/false.gif',
									     $this->Lang('set_as_default'),'','','systemicon'),array('template'=>$onetemplate));

      $onerow->deletelink = $this->CreateLink($id, 'deletetemplate', $returnid, $gCms->variables['admintheme']->DisplayImage('icons/system/delete.gif', $this->Lang('deletetemplate'),'','','systemicon'), array('tplname' => $onetemplate), $this->Lang('areyousure'));
    }
  $entryarray[] = $onerow;
}





/*****************************************
 * Handle the File Tab
 ****************************************/
$dir = dirname(__FILE__) . '/templates';
$dh  = opendir($dir);
$files = array();
while (false !== ($filename = readdir($dh)))
{
	$files[] = $filename;
}
if (isset($dh))
	closedir($dh);

$badfiles = array('filetpllist.tpl', 'dbtpllist.tpl', 'edittemplate.tpl', 'importtemplate.tpl');
foreach ($files as $onefile)
{
  //If this is not a .tpl file, skip it
  if (!endswith($onefile, '.tpl')) continue;
  
  //If this is in badfiles, skip it
  if (in_array($onefile, $badfiles)) continue;
  
  $onerow = new stdClass();
  
  $onerow->templatename = $onefile;
  $onerow->importlink = $this->CreateLink($id, 'importtemplate', $returnid, $gCms->variables['admintheme']->DisplayImage('icons/system/import.gif', $this->Lang('importtemplate'),'','','systemicon'), array('tplname' => $onefile));
  
  if( $default_template != $onefile )
    {
      $onerow->setdefault_link = $this->CreateLink($id,'setdefault',$returnid,
						   $admintheme->DisplayImage('icons/system/false.gif',
									     $this->Lang('set_as_default'),'','','systemicon'),array('template'=>$onefile));
    }
  $entryarray[] = $onerow;
}

$this->smarty->assign_by_ref('items', $entryarray);
$this->smarty->assign('itemcount', count($entryarray));

$smarty->assign('default_template',$default_template);
$this->smarty->assign('filenametext', $this->Lang('filename'));
$this->smarty->assign('nofilestext', $this->Lang('notemplatefiles', dirname(__FILE__) . '/templates'));
$this->smarty->assign('addlink', $this->CreateLink($id, 'addtemplate', $returnid, $gCms->variables['admintheme']->DisplayImage('icons/system/newobject.gif', $this->Lang('addtemplate'),'','','systemicon'), array(), '', false, false, '') .' '. $this->CreateLink($id, 'addtemplate', $returnid, $this->Lang('addtemplate'), array(), '', false, false, 'class="pageoptions"'));
$this->smarty->assign('templatetext', $this->Lang('templates'));
$smarty->assign('usagetext',$this->Lang('usage'));
$smarty->assign('defaulttext',$this->Lang('default'));
$smarty->assign('yesimg',$admintheme->DisplayImage('icons/system/true.gif',$this->Lang('this_is_default'),'','','systemicon'));
$smarty->assign('readonlytext',$this->Lang('readonly'));


#Display template
echo $this->ProcessTemplate('dbtpllist.tpl');

/*****************************************
 * Finished File Tab
 ****************************************/

echo $this->EndTabContent();
?>
