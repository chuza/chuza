<?php
if (!isset($gCms)) exit;
if (!$this->CheckPermission("Modify Files") && !$this->AdvancedAccessAllowed()) exit;


$messages="";
$errors="";
if(!isset($params["selectedaction"]) || !isset($params["path"])) {
	$this->Redirect($id, 'defaultadmin');
}

if ($this->IntruderCheck($params["path"])) {
	$this->Redirect($id, 'defaultadmin',$returnid,array("module_error"=>$this->Lang("fileoutsideuploads")));
}

$somethingselected=false;
foreach ($params as $key=>$value) {
	if (substr($key,0,5)=="file_") {
		$somethingselected=true;
		break;
	}
}

if (!$somethingselected) {
	$this->Redirect($id,"defaultadmin",$returnid,array("path"=>$params["path"],"module_error"=>$this->Lang("nofilesselected")));
}

$returntomain=true;
$config =& $gCms->GetConfig();
switch ($params["selectedaction"]) {
	case "deleteselected" : {
		if (isset($params["confirmed"]) && $params["confirmed"]=="ayesir") {
			if (isset($params["cancel"])) {
				$this->Redirect($id,"defaultadmin",$returnid,array("path"=>$params["path"],"module_message"=>$this->Lang("deleteselectedcancelled")));
			}
			foreach ($params as $key=>$value) { //Cannot use directly $params as spaces/dots are translated to _
				if (substr($key,0,5)=="file_") {
					$filename=substr($key,5);
					$filename=base64_decode($filename);
					//$errors.=$filename;
					$fullname=$this->Slash($params["path"],$filename);
					$fullname=$this->Slash($config["root_path"],$fullname);
					//$errors.=$fullname."<br/>";
						
					if (@unlink($fullname)) $messages.="<span class='fm-messages'>".$filename." ".$this->Lang("filedeletesuccess")."</span>";
					else $errors.="<span class='fm-messages'>".$filename." ".$this->Lang("filedeletefail")."</span>";
				}
			}
		} else {
				
			$this->smarty->assign('startform', $this->CreateFormStart($id, 'filesform', $returnid,'post', '',false, '', $params));
			$this->smarty->assign('confirmed', $this->CreateInputHidden($id,"confirmed","ayesir"));
			if (isset($params["dirname"])) {
				$this->smarty->assign('dirname', $this->CreateInputHidden($id,"dirname",$params["dirname"]));
			} else {
				$this->smarty->assign('dirname', $this->CreateInputHidden($id,"dirname",""));
			}
			$this->smarty->assign('path', $this->CreateInputHidden($id,"path",$params["path"]));
			$this->smarty->assign('endform', $this->CreateFormEnd());
			$this->smarty->assign('dirnotempty', $this->Lang("confirmdeleteselected"));
			$this->smarty->assign('sure', $this->CreateInputSubmit($id, 'submit', $this->Lang('imsure')));
			$this->smarty->assign('cancel', $this->CreateInputSubmit($id, 'cancel', $this->Lang('cancel')));
			echo $this->ProcessTemplate('confirmdeltree.tpl');
			$returntomain=false;
		}
		break;
	}
	case "chmodselected" : {
		if (isset($params["newmode"])) {
			if (!$this->ConfirmModeSanity($newmode)) $this->Redirect($id, 'defaultadmin');
			foreach ($params as $key=>$value) { //Cannot use directly $params as spaces/dots are translated to _
				if (substr($key,0,5)=="file_") {
					$filename=substr($key,5);
					$filename=base64_decode($filename);
					//$errors.=$filename;
					$fullname=$this->Slash($params["path"],$filename);
					$fullname=$this->Slash($config["root_path"],$fullname);
					//$errors.=$fullname."<br/>";
					//if (@unlink($fullname)) $messages.=$filename." ".$this->Lang("filedeletesuccess")."<br/>"; else $errors.=$filename." ".$this->Lang("filedeletefail")."<br/>";
				}
			}
		} else {

		}
		break;
	}
	case "copyselected" :
	case "moveselected" : {
		if ($this->IntruderCheck($params["targetdir"])) {
	    $this->Redirect($id, 'defaultadmin',$returnid,array("module_error"=>$this->Lang("fileoutsideuploads")));
		}
		foreach ($params as $key=>$value) { //Cannot use $params as spaces/dots are translated to _
			if (substr($key,0,5)=="file_") {

				$filename=substr($key,5);
				$filename=base64_decode($filename);
				//$errors.=$filename;
				$fullname=$this->Slash($params["path"],$filename);

				$fullname=$this->Slash($config["root_path"],$fullname);
				//$fullname=str_replace('//','/',$fullname);
				//echo $fullname;die();
				if($params["targetdir"]!='-') {
					$newpathfullname = $this->Slash($params["targetdir"],$filename);
					$newpathfullname=$this->Slash($config["root_path"],$newpathfullname);
					//$newpathfullname=str_replace('//','/',$newpathfullname);
					//echo $fullname." - ".$newpathfullname;die();
						
					if ($params["selectedaction"]=="moveselected") {
						if(@rename($fullname,$newpathfullname)) {
							$messages.="<span class='fm-messages'>".$this->Slashes($filename)." ".$this->Lang('movedto')." ".str_replace($config['root_path'],'',$this->Slashes($newpathfullname)).'</span>';
						} else {
							$errors.="<span class='fm-messages'>".$this->Slashes($filename)." ".$this->Lang('couldnotmove').'</span>';
						}
					} else {
						if(@copy($fullname,$newpathfullname)) {
							$messages.="<span class='fm-messages'>".$this->Slashes( $filename)." ".$this->Lang('copiedto')." ".str_replace($config['root_path'],'',$this->Slashes($newpathfullname))."</span>";
						} else {
							$errors.="<span class='fm-messages'>".$this->Slashes($filename)." ".$this->Lang('couldnotcopy').'</span>';
						}
					}
				}
				//$errors.=$fullname."<br/>";

			}
		}
		break;
	}
}


if ($returntomain) {
	$this->Redirect($id,"defaultadmin",$returnid,array("path"=>$params["path"],"module_message"=>$messages,"module_error"=>$errors));
}
?>
