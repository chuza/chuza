<?php
#BEGIN_LICENSE
#-------------------------------------------------------------------------
# Module: ModuleManager (c) 2008 by Robert Campbell 
#         (calguy1000@cmsmadesimple.org)
#  An addon module for CMS Made Simple to allow browsing remotely stored
#  modules, viewing information about them, and downloading or upgrading
# 
#-------------------------------------------------------------------------
# CMS - CMS Made Simple is (c) 2005 by Ted Kulp (wishy@cmsmadesimple.org)
# This project's homepage is: http://www.cmsmadesimple.org
#
#-------------------------------------------------------------------------
#
# This program is free software; you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 of the License, or
# (at your option) any later version.
#
# However, as a special exception to the GPL, this software is distributed
# as an addon module to CMS Made Simple.  You may not use this software
# in any Non GPL version of CMS Made simple, or in any version of CMS
# Made simple that does not indicate clearly and obviously in its admin 
# section that the site was built with CMS Made simple.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
# You should have received a copy of the GNU General Public License
# along with this program; if not, write to the Free Software
# Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
# Or read it online: http://www.gnu.org/licenses/licenses.html#GPL
#
#-------------------------------------------------------------------------
#END_LICENSE
{
  echo '<div class="pagewarning">'."\n";
  echo '<h3>'.$this->Lang('notice')."</h3>\n";
  $link = '<a target="_blank" href="http://dev.cmsmadesimple.org">forge</a>';
  echo '<p>'.$this->Lang('general_notice',$link,$link)."</p>\n";
  echo '<h3>'.$this->Lang('use_at_your_own_risk')."</h3>\n";
  echo '<p>'.$this->Lang('compatibility_disclaimer')."</p></div>\n";

  $active_tab = -1;
  if( isset($params['active_tab']))
    {
      $active_tab = $params['active_tab'];
	  $_SESSION['mm_active_tab'] = $active_tab;
    }
  else if (isset($_SESSION['mm_active_tab']))
	{
	  $active_tab = $_SESSION['mm_active_tab'];
	}
  
  echo $this->StartTabHeaders();
  if( $this->CheckPermission('Modify Modules') )
    {
      echo $this->SetTabHeader('newversions',$this->Lang('newversions'),
			  $active_tab == 'newversions' );
      echo $this->SetTabHeader('modules',$this->Lang('availmodules'),
			  $active_tab == 'modules' );
    }
  if( $this->CheckPermission('Modify Site Preferences') )
    {
      echo $this->SetTabHeader('prefs',$this->Lang('preferences'),
			  $active_tab == 'prefs' );
    }
  echo $this->EndTabHeaders();

  echo $this->StartTabContent();
  if( $this->CheckPermission('Modify Modules') )
    {
      echo $this->StartTab('newversions');
      include(dirname(__FILE__).'/function.newversionstab.php');
      echo $this->EndTab();

      echo $this->StartTab('modules');
      $this->_DisplayAdminModulesTab( $id, $params, $returnid );
      echo $this->EndTab();
    }
  if( $this->CheckPermission('Modify Site Preferences') )
    {
      echo $this->StartTab('prefs');
      $this->_DisplayAdminPrefsTab( $id, $params, $returnid );
      echo $this->EndTab();
    }
  echo $this->EndTabContent();
}
?>