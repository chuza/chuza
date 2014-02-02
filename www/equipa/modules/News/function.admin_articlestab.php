<?php

$smarty->assign('formstart',$this->CreateFormStart($id,'defaultadmin'));  
	
$curcategory = (isset($params['curcategory'])?$params['curcategory']:'');
$allcategories = (isset($params['allcategories'])?$params['allcategories']:'no');
$newcategory = $curcategory;

if (isset($params['submit_massdelete']) )
  {
    if (!$this->CheckPermission('Delete News'))
      {
	echo $this->ShowErrors($this->Lang('needpermission', array('Modify News')));
      }
    else if( isset($params['sel']) && is_array($params['sel']) &&
	count($params['sel']) > 0 )
      {
        foreach( $params['sel'] as $news_id )
	  {
	    $this->delete_article( $news_id );
	  }
      }
  }
else if (isset($params['submit_reassign']) )
  {
    if( isset($params['sel']) && is_array($params['sel']) &&
	count($params['sel']) > 0 )
      {
	$tmp = str_repeat('?,',count($params['sel']));
	$tmp = substr($tmp,0,strlen($tmp)-1);
	$query = 'UPDATE '.cms_db_prefix().'module_news SET news_category_id = ? WHERE news_id IN ('.$tmp.')';
	$parms = array($params['category']);
	foreach( $params['sel']  as $p ) $parms[] = $p;
	$db->Execute($query,$parms);
      }
    else
      {
	echo $this->ShowErrors($this->Lang('error_noarticlesselected'));
      }
  }

if (isset($params['submitfilter']))
  {
    $newcategory = (isset($params['newcategory'])?$params['newcategory']:$newcategory);
  }
	
$curcategory = $newcategory;
$categorylist = array();
$categorylist[$this->Lang('allcategories')] = '';
$query = "SELECT * FROM ".cms_db_prefix()."module_news_categories ORDER BY hierarchy";
$dbresult = $db->Execute($query);
while ($dbresult && $row = $dbresult->FetchRow())
  {
    $categorylist[$row['long_name']] = $row['long_name'];
  }

if( isset( $params['sortby'] ) )
  {
    $this->SetPreference('article_sortby',
			 str_replace("'",'_',$params['sortby']));
  }
if( isset( $params['pagelimit'] ) )
  {
    $this->SetPreference('article_pagelimit',(int)$params['pagelimit']);
  }
$pagelimit = $this->GetPreference('article_pagelimit',25);
$pagenumber = 1;
if( isset( $params['pagenumber'] ) )
  {
    $pagenumber = $params['pagenumber'];
  }
$startelement = ($pagenumber-1) * $pagelimit;
$sortby = $this->GetPreference('article_sortby','news_date DESC');
$sortlist = array();
$sortlist[$this->Lang('post_date_desc')]='news_date DESC';
$sortlist[$this->Lang('post_date_asc')]='news_date ASC';
$sortlist[$this->Lang('expiry_date_desc')]='end_time DESC';
$sortlist[$this->Lang('expiry_date_asc')]='end_time ASC';
$sortlist[$this->Lang('title_asc')] = 'news_title ASC';
$sortlist[$this->Lang('title_desc')] = 'news_title DESC';
$sortlist[$this->Lang('status_asc')] = 'status ASC';
$sortlist[$this->Lang('status_desc')] = 'status DESC';

$smarty->assign('prompt_category',$this->Lang('category'));
$smarty->assign('input_category',
		$this->CreateInputDropdown($id,'newcategory',$categorylist,-1,$newcategory));
$smarty->assign('prompt_showchildcategories',
		$this->Lang('showchildcategories'));
$smarty->assign('input_allcategories',
		$this->CreateInputCheckbox($id,'allcategories','yes',$allcategories));
$smarty->assign('prompt_sorting',
		$this->Lang('prompt_sorting'));
$smarty->assign('input_sorting',
		$this->CreateInputDropdown($id,'sortby',$sortlist,-1,$sortby));
$smarty->assign('submitfilter',
		$this->CreateInputSubmit($id,'submitfilter',$this->Lang('submit')));
$smarty->assign('prompt_pagelimit',
		$this->Lang('prompt_pagelimit'));
$smarty->assign('input_pagelimit',
		$this->CreateInputDropdown($id,'pagelimit',
					   array('5'=>5,'25'=>25,'50'=>50,
						 '100'=>100,'500'=>500,'1000'=>1000,$this->Lang('unlimited')=>999999999),-1,$pagelimit));
$smarty->assign('hidden',
		$this->CreateInputHidden($id,'curcategory',$curcategory));
	
$smarty->assign('formend',$this->CreateFormEnd());
	
//Load the current articles
$entryarray = array();

$dbresult = '';

$query1 = "SELECT n.*, nc.long_name FROM ".cms_db_prefix()."module_news n LEFT OUTER JOIN ".cms_db_prefix()."module_news_categories nc ON n.news_category_id = nc.news_category_id ";
$query2 = "SELECT count(n.news_id) AS count FROM ".cms_db_prefix()."module_news n LEFT OUTER JOIN ".cms_db_prefix()."module_news_categories nc ON n.news_category_id = nc.news_category_id ";
$parms = array();
if ($curcategory != '')
  {
    $query1 .= " WHERE nc.long_name LIKE ?";
    $query2 .= " WHERE nc.long_name LIKE ?";
    if( $allcategories == 'yes' )
      {
	$parms[] = $curcategory.'%';
      }
    else
      {
	$parms[] = $curcategory;
      }
  }
$query1 .= ' ORDER by '.$sortby;
//$query1 .= " LIMIT $pagelimit OFFSET $startelement";

// if is done to help adodb.
$numrows = -1;
if( count($parms) )
  {
    $dbresult = $db->SelectLimit( $query1, $pagelimit, $startelement, $parms);
    //$dbresult = $db->Execute($query1,$parms);
    $row = $db->GetRow($query2,$parms);
    $numrows = $row['count'];
  }
else
  {
    $dbresult = $db->SelectLimit( $query1, $pagelimit, $startelement);
    //$dbresult = $db->Execute($query1);
    $row = $db->GetRow($query2);
    $numrows = $row['count'];
  }

$pagecount = (int)($numrows/$pagelimit);
if( ($numrows % $pagelimit) != 0 ) $pagecount++;
// some pagination variables to smarty.
if( $pagenumber == 1 )
  {
    $smarty->assign('prevpage','<');
    $smarty->assign('firstpage','<<');
  }
else
  {
    $smarty->assign('prevpage',
		    $this->CreateLink($id,'defaultadmin',
				      $returnid,'<',
				      array('pagenumber'=>$pagenumber-1,
					    'active_tab'=>'articles')));
    $smarty->assign('firstpage',
		    $this->CreateLink($id,'defaultadmin',
				      $returnid,'<<',
				      array('pagenumber'=>1,
					    'active_tab'=>'articles')));
  }
if( $pagenumber >= $pagecount )
  {
    $smarty->assign('nextpage','>');
    $smarty->assign('lastpage','>>');
  }
else
  {
    $smarty->assign('nextpage',
		    $this->CreateLink($id,'defaultadmin',
				      $returnid,'>',
				      array('pagenumber'=>$pagenumber+1,
					    'active_tab'=>'articles')));
    $smarty->assign('lastpage',
		    $this->CreateLink($id,'defaultadmin',
				      $returnid,'>>',
				      array('pagenumber'=>$pagecount,
					    'active_tab'=>'articles')));
  }
$smarty->assign('pagenumber',$pagenumber);
$smarty->assign('pagecount',$pagecount);
$smarty->assign('oftext',$this->Lang('prompt_of'));

$rowclass = 'row1';

$admintheme =& $gCms->variables['admintheme'];
while ($dbresult && $row = $dbresult->FetchRow())
  {
    $onerow = new stdClass();
    
    $onerow->id = $row['news_id'];
    $onerow->title = $this->CreateLink($id, 'editarticle', $returnid, $row['news_title'], array('articleid'=>$row['news_id']));
    $onerow->data = $row['news_data'];
    $onerow->expired = 0;
    if( ($row['end_time'] != '') && 
	($db->UnixTimeStamp($row['end_time']) < time()) )
      {
	$onerow->expired = 1;
      }
    $onerow->postdate = $row['news_date'];
    $onerow->startdate = $row['start_time'];
    $onerow->enddate = $row['end_time'];
    $onerow->u_postdate = $db->UnixTimeStamp($row['news_date']);
    $onerow->u_startdate = $db->UnixTimeStamp($row['start_time']);
    $onerow->u_enddate = $db->UnixTimeStamp($row['end_time']);
    $onerow->status = $this->Lang($row['status']);
    if( $this->CheckPermission('Approve News') )
      {
	if( $row['status'] == 'published' )
	  {
	    $onerow->approve_link = $this->CreateLink($id,'approvearticle',
						    $returnid,
						    $admintheme->DisplayImage('icons/system/true.gif',$this->Lang('revert'),'','','systemicon'),array('approve'=>0,'articleid'=>$row['news_id']));
	  }
	else
	  {
	    $onerow->approve_link = $this->CreateLink($id,'approvearticle',
						    $returnid,
						    $admintheme->DisplayImage('icons/system/false.gif',$this->Lang('approve'),'','','systemicon'),array('approve'=>1,'articleid'=>$row['news_id']));
	  }
      }
    $onerow->category = $row['long_name'];

    $onerow->rowclass = $rowclass;
    
    $onerow->select = $this->CreateInputCheckbox($id,'sel[]',$row['news_id']);
    if( $this->CheckPermission('Modify News') )
      {
	$onerow->editlink = $this->CreateLink($id, 'editarticle', $returnid, $gCms->variables['admintheme']->DisplayImage('icons/system/edit.gif', $this->Lang('edit'),'','','systemicon'), array('articleid'=>$row['news_id']));
      }
    if( $this->CheckPermission('Delete News') )
      {
	$onerow->deletelink = $this->CreateLink($id, 'deletearticle', $returnid, $gCms->variables['admintheme']->DisplayImage('icons/system/delete.gif', $this->Lang('delete'),'','','systemicon'), array('articleid'=>$row['news_id']), $this->Lang('areyousure'));
      }
    
    $entryarray[] = $onerow;
    
    ($rowclass=="row1"?$rowclass="row2":$rowclass="row1");
  }

$smarty->assign_by_ref('items', $entryarray);
$smarty->assign('itemcount', count($entryarray));

$smarty->assign('addlink', $this->CreateLink($id, 'addarticle', $returnid, $gCms->variables['admintheme']->DisplayImage('icons/system/newobject.gif', $this->Lang('addarticle'),'','','systemicon'), array(), '', false, false, '') .' '. $this->CreateLink($id, 'addarticle', $returnid, $this->Lang('addarticle'), array(), '', false, false, 'class="pageoptions"'));

$smarty->assign('form2start',$this->CreateFormStart($id,'defaultadmin',$returnid));
$smarty->assign('form2end',$this->CreateFormEnd());
$smarty->assign('submit_reassign',$this->CreateInputSubmit($id,'submit_reassign',$this->Lang('submit')));
$categorylist = $this->get_category_list();
$smarty->assign('categoryinput',$this->CreateInputDropdown($id,'category',$categorylist));
if( $this->CheckPermission('Delete News') )
  {
    $smarty->assign('submit_massdelete',
		    $this->CreateInputSubmit($id,'submit_massdelete',$this->Lang('delete_selected'),
					     '','',$this->Lang('areyousure_deletemultiple')));
  }

$smarty->assign('reassigntext',$this->Lang('reassign_category'));
$smarty->assign('selecttext',$this->Lang('select'));
$smarty->assign('filtertext',$this->Lang('title_filter'));
$smarty->assign('statustext',$this->Lang('status'));
$smarty->assign('startdatetext',$this->Lang('startdate'));
$smarty->assign('enddatetext',$this->Lang('enddate'));
$smarty->assign('statetext',$this->Lang('state'));
$smarty->assign('titletext', $this->Lang('title'));
$smarty->assign('postdatetext', $this->Lang('postdate'));
$smarty->assign('categorytext', $this->Lang('category'));

global $gCms;
$theme =& $gCms->variables['admintheme'];
$config =& $this->GetConfig();
$themedir = $config['root_url'].'/'.$config['admin_dir'].'/themes/'.$theme->themeName.'/images/icons/system';

$smarty->assign('iconurl',$themedir);

#Display template
echo $this->ProcessTemplate('articlelist.tpl');

// EOF
?>
