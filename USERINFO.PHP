<?php
include("include/session.php");

?>

<html>
<head>
<title>Login-System</title>
<link rel="stylesheet" type="text/css" href="css/960/reset.css" />
<link rel="stylesheet" type="text/css" href="css/960/960.css" />
<link rel="stylesheet" type="text/css" href="css/960/text.css" />
<link rel="stylesheet" type="text/css" href="css/style.css" />
</head>

<body>
<div id="main" class="container_12">
	<?php
		$reg_user = trim($_GET['gdc_no']);
		if(!$reg_user || strlen($reg_user) == 0 || !$database->gdc_noTaken($reg_user)) {
			die("Username not registered");
		}
		
	if(strcmp($session->gdc_no, $reg_user) == 0) {
		echo "<h1>My Account</h1>";
	}
	else {
		echo "<h1>User Info</h1>";
	}
	
	$reg_user_info = $database->getUserInfo($reg_user);
	
	echo "<p><b>Last name: ".$reg_user_info['l_name']."</b></p><br />";
	
	echo "<p><b>GDC Number: ".$reg_user_info['gdc_no']."</b></p><br />";
	
	if(strcmp($session->gdc_no,$reg_user) == 0) {
		echo "<a href=\"useredit.php\">Edit Account Information</a><br /><br />";
	}
	
	echo "[<a href=\"login_slider.php\">Main Page</a>]";
	
	if($session->isAdmin()) {
		echo "[<a href=\"admin.php\">Admin Center</a>]&nbsp;";
	}
	
	?>
	</div>
	</body>
	</html>