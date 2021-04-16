<?php
include("database.php");

include("form.php");

class Session
	{
	var $gdc_no;
	var $lname;
	var $userid;
	var $userlevel;
	var $time;
	var $logged_in;
	var $userinfo = array();
	var $url;
	var $referrer;

		function __construct() {
			$this->time = time();
			$this->startSession();
		}

		function startSession() {
			global $database;
			session_start();

			$this->logged_in = $this->checkLogin();

			if(!$this->logged_in) {
				$this->gdc_no = $_SESSION['gdc_no'] = GUEST_NAME;
				$this->userlevel = GUEST_LEVEL;
				$database->addActiveGuest($_SERVER['REMOTE_ADDR'], $this->time);
			}
			else {
				$database->addActiveUser($this->gdc_no, $this->time);
			}

			$database->removeInactiveUsers();
			$database->removeInactiveGuests();

			if(isset($_SESSION['url'])) {
				$this->referrer = $_SESSION['url'];
			}
			else {
				$this->referrer = "/";
			}

			$this->url = $_SESSION['url'] = $_SERVER['PHP_SELF'];
		}

		function checkLogin() {
			global $database;
			if(isset($_COOKIE['cookname']) && isset($_COOKIE['cookid'])) {
				$this->gdc_no = $_SESSION['gdc_no'] = $_COOKIE['cookname'];
				$this->userid = $_SESSION['userid'] = $_COOKIE['cookid'];
			}

			if(isset($_SESSION['gdc_no']) && isset($_SESSION['userid']) && $_SESSION['gdc_no'] != GUEST_NAME) {
				if($database->confirmUserID($_SESSION['gdc_no'], $_SESSION['userid']) != 0) {
					unset($_SESSION['gdc_no']);
					unset($_SESSION['userid']);
					return false;
				}
				$this->userinfo = $database->getUserInfo($_SESSION['gdc_no']);
				$this->gdc_no = $this->userinfo['gdc_no'];
				$this->userid = $this->userinfo['userid'];
				$this->userlevel = $this->userinfo['ulevel'];
				$this->lname = $this->userinfo['l_name'];

				return true;
			}
			else {
				return false;
			}
		}

		function login($subgdc_no, $subpass, $subremember) {
			global $database, $form;

			$field = "gdc_no";
				$q = "SELECT valid FROM ".TBL_USERS." WHERE gdc_no = '$subgdc_no'";
				$valid = $database->query($q);
//				$valid = mysqli_fetch_array($valid, MYSQLI_ASSOC);
//                $valid = $valid->fetch_assoc;
                $valid = mysqli_fetch_assoc($valid);

			if(!$subgdc_no || strlen($subgdc_no = trim($subgdc_no)) == 0) {
				$form->setError($field, "* Username not entered");
			}
			else {
				if(!ctype_alnum($subgdc_no)) {
					$form->setError($field, "* Username not alphanumeric");
				}
			}

			$field = "pass";
			if(!$subpass) {
				$form->setError($field, "* Password not entered");
			}

			if($form->num_errors > 0) {
				return false;
			}

			$subgdc_no = stripslashes($subgdc_no);
			$result = $database->confirmUserPass($subgdc_no, md5($subpass));
			if($result == 1) {
				$field = "gdc_no";
				$form->setError($field, "* Username not found");
			}
			else if($result == 2) {
				$field = "pass";
				$form->setError($field, "* Invalid password");
			}

			if($form->num_errors > 0) {
				return false;
			}

			$this->userinfo = $database->getUserInfo($subgdc_no);
//  echo "<hr />session line 120 - userinfo<br />";
//  var_dump($this->userinfo);
//  echo "<hr />";
			$this->gdc_no = $_SESSION['gdc_no'] = $this->userinfo['gdc_no'];
			$this->userid = $_SESSION['userid'] = $this->generateRandID();
var_dump($_SESSION);
			$this->userlevel = $this->userinfo['ulevel'];

			$database->updateUserField($this->gdc_no, "userid", $this->userid);
			$database->addActiveUser($this->gdc_no, $this->time);
			$database->removeActiveGuest($_SERVER['REMOTE_ADDR']);

			if($subremember) {
				setcookie("cookname", $this->gdc_no, time()+COOKIE_EXPIRE, COOKIE_PATH);
				setcookie("cookid", $this->userid, time()+COOKIE_EXPIRE, COOKIE_PATH);
			}

			return true;
		}

		function logout() {
			global $database;

			if(isset($_COOKIE['cookname']) && isset($_COOKIE['cookid'])) {
				setcookie("cookname", "", time()-COOKIE_EXPIRE, COOKIE_PATH);
				setcookie("cookid", "", time()-COOKIE_EXPIRE, COOKIE_PATH);
			}

			unset($_SESSION['gdc_no']);
			unset($_SESSION['userid']);

			$this->logged_in = false;

			$database->removeActiveUser($this->gdc_no);
			$database->addActiveGuest($_SERVER['REMOTE_ADDR'], $this->time);

			$this->gdc_no = GUEST_NAME;
			$this->userlevel = GUEST_LEVEL;
		}

		function register($subfname, $sublname, $subgdc_no, $subpass) {
			global $database, $form;
			$field = "gdc_no";
			if(!$subgdc_no || strlen($subgdc_no = trim($subgdc_no)) == 0) {
				$form->setError($field, "* Username not entered");
			}
			else {
				$subgdc_no = stripslashes($subgdc_no);
				if(strlen($subgdc_no) < 5) {
					$form->setError($field, "* Username below 5 characters");
				}
				else if(strlen($subgdc_no) > 30) {
					$form->setError($field, "* Username above 30 characters");
				}
				else if(!ctype_alnum($subgdc_no)) {
					$form->setError($field, "* Username not alphanumeric");
				}
				else if(strcasecmp($subgdc_no, GUEST_NAME) == 0) {
					$form->setError($field, "* Username reserved word");
				}
				else if($database->gdc_noTaken($subgdc_no)) {
					$form->setError($field, "* Username already taken");
				}
				else if($database->gdc_noBanned($subgdc_no)) {
					$form->setError($field, "* Username Banned");
				}
			}

			$field = "pass";
			if(!$subpass) {
				$form->setError($field, "* Password not entered");
			}
			else {
				$subpass = stripslashes($subpass);
				if(strlen($subpass) < 4) {
					$form->setError($field, "* Password too short");
				}
				else if(!ctype_alnum(($subpass = trim($subpass)))) {
					$form->setError($field, "* Password not alphanumeric");
				}
			}

			$field = "fname";
			if(!$subfname || strlen($subfname = trim($subfname)) == 0) {
				$form->setError($field, "* Name not entered");
			}
			else {
				$subfname = stripslashes($subfname);
			}

			$field = "lname";
			if(!$sublname || strlen($sublname = trim($sublname)) == 0) {
				$form->setError($field, "* Name not entered");
			}
			else {
				$sublname = stripslashes($sublname);
			}

			$randid = $this->generateRandID();

			if($form->num_errors > 0) {
				return 1;
			}
			else {
				if($database->addNewUser($subfname, $sublname, $subgdc_no, md5($subpass), $randid)) {
					return 0;
				}
				else {
					return 2;
				}
			}

		}

		function editAccount($subcurpass, $subnewpass, $sublname) {
			global $database, $form;

			if($subnewpass) {
				$field = "curpass";
				if(!$subcurpass) {
					$form->setError($field, "* Current password not entered");
				}
				else {
					$subcurpass = stripslashes($subcurpass);
					if(strlen($subcurpass) < 4) {
						$form->setError($field, "* Current password too short");
					}
					else if(!ctype_alnum(($subcurpass = trim($subcurpass)))) {
						$form->setError($field, "* Current password not alphanumeric");
					}

					if($database->confirmUserPass($this->gdc_no, md5($subcurpass)) != 0) {
						$form->setError($field, "* Current password does not match password in database");
					}
				}

				$field="newpass";
				$subpass = stripslashes($subnewpass);
				if(strlen($subnewpass) < 4) {
					$form->setError($field, "* New password too short");
				}
				else if(!ctype_alnum(($subnewpass = trim($subnewpass)))) {
					$form->setError($field, "* New password not alphanumeric");
				}
			}
			else if($subcurpass) {
				$field="newpass";
				$form->setError($field, "* New password not entered");
			}

			$field = "lname";
			if(!$sublname || strlen($sublname = trim($sublname)) == 0) {
				$form->setError($field, "* Name not entered");
			}
			else {
				$sublname = stripslashes($sublname);
			}

			if($form->num_errors > 0) {
				return false;
			}

			if($subcurpass && $subnewpass) {
				$database->updateUserField($this->gdc_no, "password", md5($subnewpass));
			}

			if($sublname) {
				$database->updateUserField($this->gdc_no, "name", $sublname);
			}

			return true;
		}

		function isAdmin() {
			return($this->userlevel == ADMIN_LEVEL || $this->gdc_no == ADMIN_NAME);
		}

		function isAuthor() {
			return($this->userlevel == AUTHOR_LEVEL || $this->lname == AUTHOR_NAME);
		}

		function generateRandID() {
			return md5($this->generateRandStr(16));
		}

		function generateRandStr($length) {
			$randstr = "";
			for($i=0; $i<$length; $i++) {
				$randnum = mt_rand(0, 61);
				if($randnum < 10) {
					$randstr .=chr($randnum+48);
				}
				else if($randnum < 36) {
					$randstr .=chr($randnum+55);
				}
				else {
					$randstr .= chr($randnum+61);
				}
			}
			return $randstr;
		}

		function cleanInput($post = array()) {
			foreach($post as $k =>$v) {
				$post[$k] = trim(htmlspecialchars($v));
			}
			return $post;
		}
	};

	$session = new Session;

	$form = new Form;
