<?php
if (!isset($gCms)) exit;

if( !$this->CheckPermission( 'Modify Site Preferences' ) )
{
  return;
}

$this->SetPreference('default_category', $params['default_category']);
$this->SetPreference('formsubmit_emailaddress', $params['formsubmit_emailaddress']);
$this->SetPreference('email_subject',$params['email_subject']);
$this->SetTemplate('email_template',$params['email_template']);
$this->SetPreference('allowed_upload_types',
		     $params['allowed_upload_types']);
$this->SetPreference('hide_summary_field',
		     (isset($params['hide_summary_field'])?'1':'0'));
$this->SetPreference('allow_summary_wysiwyg',
		     (isset($params['allow_summary_wysiwyg'])?'1':'0'));
$this->SetPreference('expired_searchable',
		     (isset($params['expired_searchable'])?'1':'0'));
$this->SetPreference('expiry_interval', $params['expiry_interval']);
$this->SetPreference('fesubmit_status', $params['fesubmit_status']);
$this->SetPreference('fesubmit_redirect', trim($params['fesubmit_redirect']));

$params = array('tab_message'=> 'optionsupdated', 'active_tab' => 'options');
$this->Redirect($id, 'defaultadmin', '', $params);
?>
