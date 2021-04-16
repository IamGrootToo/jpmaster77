<?php
include("include/session.php");
//	echo "<hr>";
//	print_r($session);
//	echo "<hr>";
//	print_r($form);
//	echo "<hr />";
$page = "useredit.php";
?>

<html>
<head>
<title>Login-System</title>

<link rel="stylesheet" type="text/css" href="css/style.css" />
</head>

<body>
<div id="main" class="container_12">
	<?php
		if(isset($_SESSION['useredit'])) {
			unset($_SESSION['useredit']);
			
			echo "<h1>User Account Edit Success!</h1>";
			echo "<p><b>$session->gdc_no</b>, your account has been successfully updated. <a href=\"login_slider.php\">Main Page</a></p>";
		}
		else {
			if($session->logged_in) {
	?>
				<h1>User Account Edit: <?php echo $session->gdc_no; ?></h1>
	<?php
				if($form->num_errors > 0) {
					echo"<td><font size=\"2\" color=\"#ff0000\">".$form->num_errors." error(s) found</font></td>";
				}
	?>		
				<div id="userupdate">
					<form action="process.php" method="POST">
						<label>Last Name: </label>
						<p class="left">
							<input class="left" type="text" name="lname" maxlength="50" value="<?php if(!$form->value("lname")) {echo ucfirst($session->userinfo["l_name"]); }
				else {
							echo $form->value("lname"); 
				} 
				?>" />
							<?php echo $form->error("lname"); ?>
						</p>
						
						<div class="clear"></div>
						<p class="grid_2">Current Password: </p>
						<p class="left">
							<input type="password" name="curpass" maxlength="30" value="<?php echo $form->value("curpass"); ?>" />
							<?php echo $form->error("curpass"); ?>
						</p>
						
						<div class="clear"></div>
						<p class="grid_2">New Password: </p>
						<p class="left">
							<input class="left" type="password" name="newpass" maxlength="30" value="<?php echo $form->value("newpass"); ?>" />
							<?php echo $form->error("newpass"); ?>
						</p>
						<div class="clear"></div>
						<p>
							<input type="hidden" name="subedit" value="1" />
							<input type="submit" value="Edit Account" />
						</p>
					</form>
				</div>
				
				<?php
					echo "[<a href=\"login_slider.php\">Main</a>]&nbsp;";
					echo "[<a href=\"userinfo.php?gdc_no=$session->gdc_no\">My Account</a>]&nbsp;";
				
			}
		}
				?>
</div>
</body>
</html>