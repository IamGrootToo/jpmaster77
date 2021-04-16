<?php
include("include/session.php");
//  print "<hr>";
//  print_r($session);
//  echo "<br />session before<hr />SESSION after<br />";
//  print_r($_SESSION);
//  print "<hr>";
$page = "index.php";
?>

<html>
<head>
<title>Login-System</title>

<link rel="stylesheet" type="text/css" href="css/style.css" />
</head>

<body>

<div id="main" class="container_12">

<?php
if($session->logged_in) {
?>
<h1 class="clear">Logged In</h1>
<p>Welcome<b><?php echo $session->gdc_no; ?></b>, you are logged in.</p>
<p>[<a href="userinfo.php?gdc_no=<?php echo $session->gdc_no; ?>">My Account</a>]&nbsp;[<a href="useredit.php">Edit Account</a>]
<?php
if($session->isAdmin()) {
	echo "[<a href=\"admin.php\">Admin Center</a>]&nbsp;";
	}
	echo "[<a href=\"process.php\">Logout</a>]";?></p>
	<?php
	}
	else {
	?>

	<div class="login">
	<h1>Login</h1>
	<?php
	if($form->num_errors > 0) {
		echo "<font size=\"2\" color=\"#ff0000\">".$form->num_errors." error(s) found</font>";
		}
		?>

		<form name="login" id="login" action="process.php" method="POST">
			<label>GDC Number:</label>
			<p><input type="text" name="gdc_no" maxlength="30" autofocus value="<?php echo $form->value("gdc_no");?>" /><?php echo $form->error("gdc_no");?></p>
			<label>Password: </label>
			<p><input type="password" name="pass" maxlength="30" value="<?php echo $form->value("pass");?>" /><?php echo $form->error("pass");?></p>
			<div class="login_row">
			<p><input type="checkbox" name="remember" <?php if($form->value("remember") !="") {echo "checked"; }?> />
			<label>Remember me next time</label>
            </p>
			</div>
			<input type="hidden" name="sublogin" value="1" />
			<input type="submit" value="Login" />
			<p>Not Registered? <a href="register.php">Sign Up!</a></p>
		</form>
	</div><!-- class login -->
	<?php
	}
	?>

	</div><!-- #main -->
	</body>
	</html>
