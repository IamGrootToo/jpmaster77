<?php
include("include/session.php");
print_r($_POST);
	class AdminProcess
	{
		function __construct() {
			global $session;
			If(!$session->isAdmin()){
                header("Location: index.php");
				return;
			}

			if(isset($_POST['subupdlevel'])) {
				$this->procUpdateLevel();
			}
			else if(isset($_POST['subdeluser'])) {
				$this->procDeleteUser();
			}
			else if(isset($_POST['subdelinact'])) {
				$this->procDeleteInactive();
			}
			else if(isset($_POST['subbanuser'])) {
				$this->procbanUser();
			}
			else if(isset($_POST['subdelbanned'])) {
				$this->procDeleteBannedUser();
			}
			else {
				header("Location: ../index.php");
			}
		}

		function procUpdateLevel() {
			global $session, $database, $form;
            $upduser = $_POST['upduser'];
//			      $subuser = $this->checkUsername($upduser);
            $subuser = $upduser;

			if($form->num_errors > 0) {
				$_SESSION['value_array'] = $_POST;
				$_SESSION['error_array'] = $form->getErrorArray();
				header("Location: ".$session->referrer);
			}
			else {
				$database->updateUserField($subuser, "ulevel", (int)$_POST['updlevel']);
				header("Location: ".$session->referrer);
			}
		}

		function procDeleteUser() {
			global $session, $database, $form;
      $upduser = $_POST['deluser'];
//			$subuser = $this->checkUsername("deluser");
      $subuser = $upduser;

			if($form->num_errors > 0) {
				$_SESSION['value_array'] = $_POST;
				$_SESSION['error_array'] = $form->getErrorArray();
				header("Location: ".$session->referrer);
			}
			else {
				$q = "DELETE FROM ".TBL_USERS." WHERE gdc_no = '$subuser'";
				$database->query($q);
				header("Location: ".$session->referrer);
			}
		}

		function procDeleteInactive() {
			global $session, $database;
			$inact_time = $session->time - $_POST['inactdays']*24*60*60;
			$q = "DELETE FROM ".TBL_USERS." WHERE timestamp < $inact_time AND ulevel != ".ADMIN_LEVEL;
			$database->query($q);
			header("Location: ".$session->referrer);
		}

		function procBanUser() {
			global $session, $database, $form;
      $upduser = $_POST['banuser'];
//			$subuser = $this->checkUsername("banuser");
      $subuser = $upduser;

			if($form->num_errors > 0) {
				$_SESSION['value_array'] = $_POST;
				$_SESSION['error_array'] = $form->getErrorArray();
				header("Location: ".$session->referrer);
			}
			else {
				$q = "DELETE FROM ".TBL_USERS." WHERE gdc_no = '$subuser'";
				$database->query($q);

				$q = "INSERT INTO ".TBL_BANNED_USERS." VALUES('$subuser', $session->time)";
				$database->query($q);
				header("Location: ".$session->referrer);
			}
		}

		function procDeleteBannedUser() {
			global $session, $database, $form;
      $upduser = $_POST['delbanuser'];
//			$subuser = $this->checkUsername("delbanuser", true);
      $subuser = $upduser;

			if($form->num_errors > 0) {
				$_SESSION['value_array'] = $_POST;
				$_SESSION['error_array'] = $form->getErrorArray();
				header("Location: ".$session->referrer);
			}
			else {
				$q = "DELETE FROM ".TBL_BANNED_USERS." WHERE gdc_no = '$subuser'";
				$database->query($q);
				header("Location: ".$session->referrer);
			}
		}

		function checkUsername($subuser) {
			global $session, $database, $form;
//			$subuser = $_POST['upduser'];
			$field = "upduser";
			if(!$subuser || strlen($subuser = trim($subuser)) == 0) {
				$form->setError($field, "* Username not entered<br />");
			}
			else {
				$subuser = stripslashes($subuser);
				if(strlen($subuser) < 4 || strlen($subuser > 30) || !preg_match("/^([0-9a-z])+$/i", $subuser) || ( !$database->gdc_noTaken($subuser))) {
					$form->setError($field, "* Username does not exist<br />");
				}
			}
			return $subuser;
		}
	};

	$adminprocess = new AdminProcess;

?>
