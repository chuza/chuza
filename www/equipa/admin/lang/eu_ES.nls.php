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

#NLS (National Language System) array.

#The basic idea and values was taken from then Horde Framework (http://horde.org)
#The original filename was horde/config/nls.php.
#The modifications to fit it for Gallery were made by Jens Tkotz
#(http://gallery.meanalto.com) 

#Ideas from Gallery's implementation made to CMS by Ted Kulp

#Created by: Alayn Gortazar (Zurti) < zutoin [at] gmail [dot] com >
#Maintained by: Alayn Gortazar (Zurti) < zutoin [at] gmail [dot] com >
#and : Mikel Etxeberria (Mikel)  < mikel [at]  abartiateam [dot] com >

#Native language name
$nls['language']['eu_ES'] = 'Euskara';
$nls['englishlang']['eu_ES'] = 'Basque';

#Possible aliases for language
$nls['alias']['eu'] = 'eu_ES';
$nls['alias']['basque'] = 'eu_ES' ;
$nls['alias']['baq'] = 'eu_ES' ;
$nls['alias']['eus'] = 'eu_ES' ;
$nls['alias']['eu_ES'] = 'eu_ES' ;
$nls['alias']['eu_ES.ISO8859-1'] = 'eu_ES' ;

#Encoding of the language
$nls['encoding']['eu_ES'] = 'UTF-8';

#Location of the file(s)
$nls['file']['eu_ES'] = array(dirname(__FILE__).'/eu_ES/admin.inc.php');

#Language setting for HTML area
$nls['htmlarea']['eu_ES'] = 'en';

?>
