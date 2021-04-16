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
		if($session->logged_in) {
			echo "<h1>Registered</h1>";
			echo "<p>We're sorry <b>$session->name</b>, but you've already registered. "."<a href=\"index.php\">Main</a>.</p>";
		}
		else if(isset($_SESSION['regsuccess'])) {
			if($_SESSION['regsuccess']) {
				echo "<h1>Registered!</h1>";
				echo "<p>Thank you <b>".$_SESSION['reguname']."</b>, your information has been added to the database,"."you may now <a href=\"index.php\">log in</a>.</p>";
			}
			else {
				echo "<h1>Registration Failed</h1>";
				echo "<p>We're sorry, but an error has occurred and your registration for the username <b>".$_SESSION['reguname']."</b>, "."could not be completed.<br /> Please try again.</p>";
			}
			unset($_SESSION['regsuccess']);
			unset($_SESSION['reguname']);
		}
		else {
	?>
	
	<h1>Register</h1>
	<?php
		if($form->num_errors > 0) {
			echo "<td><font size=\"2\" color=\"#ff0000\">".$form->num_errors." error(s) found</font></td>";
		}
	?>
	<div id="register" class="register">
		<form name="form_register" id="form_register" action="process.php" method="POST">
			<fieldset>
				<legend>Account Details</legend>
				<label>First name</label>
				<p><input type="text" name="fname" maxlength="30" value="<?php echo $form->value("fname"); ?>" /><?php echo $form->error("fname"); ?></p>
				<label>Last name</label>
				<p><input type="text" name="lname" maxlength="30" value="<?php echo $form->value("lname"); ?>" /><?php echo $form->error("lname"); ?></p>
				
				<label>GDC Number:</label>
				<p><input type="text" name="gdc_no" maxlength="30" value="<?php echo $form->value("gdc_no"); ?>" /><?php echo $form->error("gdc_no"); ?></p>
				
			<label>Password</label>	
			<p><input type="password" name="pass" maxlength="30" value="<?php echo $form->value("pass"); ?>" /><?php echo $form->error("pass"); ?></p>
			</fieldset>
			
			<p class="textinput"><input type="hidden" name="subjoin" value="1"><input type="submit" value="Join!"></p>
		</form>
	</div>
	<?php
	}
	?>
	</div>
	</body>
	</html>
			
			
			
			