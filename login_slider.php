<?php
include("include/session.php");
//  print "<hr>";
//  print_r($session);
//  echo "<br />session before<hr />SESSION after<br />";
//  print_r($_SESSION);
//  print "<hr>";
$page = "index.php";
?>

<!DOCTYPE html>
<html lang = "en-US">
<head>
<title>Form Login Slide In</title>
<meta charset="UTF-8">
<link rel="stylesheet" type="text/css" href="css/style.css" />
<link rel="stylesheet" type="text/css" href="css/lt500style.css" />

<link href="../js/jquery-ui-themes-1.12.1/themes/dark-hive/jquery-ui.css" rel="stylesheet">
<link href="../js/jquery-ui-themes-1.12.1/themes/dark-hive/theme.css" rel="stylesheet">
<script src = "../js/js/jquery-3.3.1.js"></script>
<script src = "../js/jquery-ui-1.12.1.custom/jquery-ui.js"></script>
<script src = "../js/jQuery_easing_plugin/jquery.easing.1.3.js"></script>

<script src="../js/jquery-validation-1.19.0/dist/jquery.validate.js"></script>
<script src="../js/jquery-validation-1.19.0/dist/additional-methods.js"></script>



<script>
$(document).ready(function() {
  $('#open').click(function(evt) {
  	 evt.preventDefault();
	 $('#login form').slideToggle(300);
	 $('#signup form').hide(300);
	 $(this).toggleClass('close');
	 $('#open').text("Click here to login or register");
  }); // end click
}); // end ready

$(document).ready(function() {
  $('#register').click(function(evt) {
  	 evt.preventDefault();
	 console.log("create");
	 $('#login form').slideToggle(300);
	 $('#signup form').slideToggle(300);
	 $('#open').text("Enter Registration Information");
	 
	 $('#signup').validate({
   rules: {
     email: {
        required: true,
        email: true
     },
     password: {
        required: true,
        rangelength:[8,16]
     },
     confirm_password: {
		 equalTo:'#password'
	 },
   }, //end rules
   messages: {
      email: {
         required: "Please supply an e-mail address.",
         email: "This is not a valid email address."
       },
      password: {
        required: 'Please type a password',
        rangelength: 'Password must be between 8 and 16 characters long.'
      },
      confirm_password: {
        equalTo: 'The two passwords do not match.'
      }
   },
   errorPlacement: function(error, element) {
       if ( element.is(":radio") || element.is(":checkbox")) {
          error.appendTo( element.parent());
        } else {
          error.insertAfter(element);
        }
    }

  });
  
  
  }); // end click
}); // end ready
</script>

</head>

<body>
  <div class="wrapper">
    <header>
      JAVASCRIPT <span class="amp">&amp;</span> jQUERY
    </header>
  <div class="content">


<!-- from HERE to -->
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




	<div class="loginX"><!-- container for login and signup  -->
	<a href="form.html"><div id="open">Click here to login or register</div></a>
	<?php
	if($form->num_errors > 0) {
		echo "<font size=\"2\" color=\"#ff0000\">".$form->num_errors." error(s) found</font>";
		}
		?>

<div id="login">
<form action="process.php" id='signup' method="POST">
	<div id="labelClear"></div>
		<label for="gdc_no">Enter gdc number:</label>
		<input type="text" name="gdc_no" id="gdc_no" autofocus >
        <div id="labelClear"></div>
		<label for="password">Password: </label>
		<input type="password" name="pass" id="login_password">
<div id="labelClear"></div>
  <input type="hidden" name="sublogin" value="1" />
	<p class="button">
		<input type="submit" name="button" id="button" value="Submit" >
	</p>
	<div id="labelClear"></div>
	<div id="register"><a href="register.html">Click here to create a new account</a></div>

</form>
    </div><!-- end of div id="login"  -->


    <div id="signup">
	<form action="form_data_dump.php" method="POST" name="signup" >
    <fieldset>
				<legend>Sign up</legend>
<div id="labelClear"></div>
		<label for="fname">First Name: </label>
			<input type="text" name="fname" id="fname" required autofocus placeholder="Enter your first name" maxlength="30" value="<?php echo $form->value("fname"); ?>" /><?php echo $form->error("fname"); ?>
<div id="labelClear"></div>
		<label for="lname">Last Name: </label>
			<input type="text" name="lname" id="lname" required placeholder="Enter your last name" maxlength="30" value="<?php echo $form->value("lname"); ?>" /><?php echo $form->error("lname"); ?>
<div id="labelClear"></div>            
		<label for="gdc_no">GDC Number: </label>
			<input type="text" name="gdc_no" id="gdc_no" required placeholder="Enter a gdc number" />
<div id="labelClear"></div>
		<label for="password">Password: </label>
			<input type="password" name="pass" id="password"  required placeholder="Enter a password"  maxlength="30" value="<?php echo $form->value("pass"); ?>" /><?php echo $form->error("pass"); ?>
<div id="labelClear"></div>
		<label for="confirm_password" class="label">Reenter Password: </label>
			<input type="password" name="confirm_password" id="confirm_password" />
<!--
	<div id="labelClear"></div>
		<label for="email" class="label">Email: </label>
			<input type="email" name="email" id="email" required placeholder="Enter a valid email address" />
 -->
 <div id="labelClear"></div>
		<p class="button"> <input type="hidden" name="subjoin" value="1">
		<input type="submit" name="button" id="button" value="Submit" >
		</p>

        </fieldset>
 
	</form>
    </div>
    

    
  
</div> <!-- end of LoginX div  -->


	<?php
	}
	?>

</div>
<!--   HERE  -->
<div id="para">Hypertext Markup Language (HTML) in computer science, the standard text-formatting language since 1989 for documents on the interconnected computing network known as the World Wide Web. HTML documents are text files that contain two parts: content that is meant to be rendered on a computer screen; and markup or tags, encoded information that directs the text format on the screen and is generally hidden from the user. HTML is a subset of a broader language called Standard Generalized Markup Language (SGML), which is a system for encoding and formatting documents, whether for output to a computer screen or to paper.

Some tags in an HTML document determine the way certain text, such as titles, will be formatted. Other tags cue the computer to respond to the user's actions on the keyboard or mouse. For instance, the user might click on an icon (a picture that represents a specific command), and that action might call another piece of software to display a graphic, play a recording, or run a short movie. Another important tag is a link, which may contain the Uniform Resource Locator (URL) of another document. The URL can be compared to an address where a particular document resides. The document may be stored on the same computer as the parent document or on any computer connected to the World Wide Web. The user can navigate from document to document simply by clicking on these links. HTML also includes markups for forms, that let the user fill out information and electronically send, or e-mail, the data to the document author, initiate sophisticated searches of information on the Internet, or order goods and services.</div>


</div>
</body>
</html>
