<?php
     include("include/session.php");

// print "on session.php page <br>";
// print_r($_POST);

class PROCESS
	{

		/* Class Constructor */
		function __construct() {
			global $session;
			if(isset($_POST['sublogin'])) {
				$this->procLogin();
			}
			else if(isset($_POST['subjoin'])) {

				$this->procRegister();
			}
			else if(isset($_POST['subedit'])) {
				$this->procEditAccount();
			}
			else if($session->logged_in) {
				$this->procLogout();
			}
			else {

			}
		}

		function procLogin() {
			global $session, $form;
			$_POST = $session->cleanInput($_POST);
			$retval = $session->login($_POST['gdc_no'], $_POST['pass'], isset($_POST['remember']));

			if($retval) {
/*  *********************************************** */
//				header("Location: ".$session->referrer);
                header("Location: login_slider.php");
/* ************************************************** */
			}
			else {
				$_SESSION['value_array'] = $_POST;
				$_SESSION['error_array'] = $form->getErrorArray();
//				header("Location: ".$session->referrer);
                header("Location: login_slider.php");
			}
		}

		function procLogout() {
			global $session;
			$retval = $session->logout();
			header("Location: login_slider.php");
		}

		function procRegister() {
			global $session, $form;
			$_POST= $session->cleanInput($_POST);
			if(ALL_LOWERCASE) {
				$_POST['gdc_no'] = strtolower($_POST['gdc_no']);
			}

			$retval = $session->register($_POST['fname'], $_POST['lname'], $_POST['gdc_no'], $_POST['pass']);

			if($retval == 0) {
				$_SESSION['reguname'] = $_POST['gdc_no'];
				$_SESSION['regsuccess'] = true;
//				header("Location: ".$session->referrer);
//                header("Location: login_slider.php");
                $this->procLogin($_POST['gdc_no'], $_POST['pass'], isset($_POST['remember']));
			}
			else if($retval == 1) {
				$_SESSION['value_array'] = $_POST;
				$_SESSION['error_array'] = $form->getErrorArray();
				header("Location: ".$session->referrer);
			}
			else if($retval == 2) {
				$_SESSION['reguname'] = $_POST['gdc_no'];
				$_SESSION['regsuccess'] = false;
				header("Location: ".$session->referrer);
			}
		}

		function procEditAccount() {
			global $session, $form;
			$_POST = $session->cleanInput($_POST);
			$retval = $session->editAccount($_POST['curpass'], $_POST['newpass'], $_POST['lname']);

			if($retval) {
				$_SESSION['useredit'] = true;
				header("Location: ".$session->referrer);
			}
			else {
				$_SESSION['value_array'] = $_POST;
				$_SESSION['error_array'] = $form->getErrorArray();
				header("Location: ".$session->referrer);
			}
		}
	};

	$process = new PROCESS;

?>
