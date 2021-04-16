<?php
include("include/session.php");

?>

<html>
<head>
<title>Login-System</title>
<link rel="stylesheet" type="text/css" href="css/style.css" />

<script src="js/jquery-3.3.1.js"></script>

<link rel="stylesheet" href="js/theme.metro-dark.css" />
	<script src="js/jquery.tablesorter.js"></script>
	<script src="js/jquery.tablesorter.widgets.js"></script>

	<!-- Tablesorter: optional -->
	<link rel="stylesheet" href="js/jquery.tablesorter.pager.css">
	<script src="js/jquery.tablesorter.pager.js"></script>

	<script id="js">$(function() {

	$("table")
		.tablesorter({
			theme: 'metro-dark',
			sortList: [[0,0],[1,0],[2,0]],
			widthFixed: true,
			widgets: ['zebra', 'columns', 'filter']
		})
		.tablesorterPager({
			// target the pager markup - see the HTML block below
			container: $(".pager"),
			output: '{startRow} to {endRow} ({totalRows})'
		});

});</script>



</head>

<body>

<?php
	function displayUsers() {
		global $database;
		$q = "SELECT *  FROM ".TBL_USERS." ORDER BY ulevel DESC, gdc_no";
		$result = $database->query($q);
		$num_rows = $result->num_rows;
		if(!$result || $num_rows < 0) {
			echo "Error displaying info";
			return;
		}

		if($num_rows == 0) {
			echo "<p class='grid_12'>Database table empty</p>";
			return;
		}


?>
<table id='tablesorter' class='tablesorter-metro-dark' >
		<thead>
		<tr class="dark-row"><th colspan="6" class="sorter-false"><h2 class="table-title"></h2></th></tr>
		<tr class="dark-row"><th class="sorter-false">Id</th><th class="sorter-false">First Name</th><th class="sorter-false">Last Name</th><th class="sorter-false">GDC Number</th><th class="sorter-false">User Level</th><th class="sorter-false">Last Access</th></tr>
		</thead>
		<tfoot>
			<tr class="dark-row"><th class="sorter-false">Id</th><th class="sorter-false">First Name</th><th class="sorter-false">Last Name</th><th class="sorter-false">GDC Number</th><th class="sorter-false">User Level</th><th class="sorter-false">Last Access</th></tr>
			<tr class="dark-row">
				<th colspan="6">
				<div class="pager">
				  <button type="button" class="first">&lt;&lt;</button>
				  <button type="button" class="prev">&lt;</button>
				  <span class="pagedisplay"></span>
				  <button type="button" class="next">&gt;</button>
				  <button type="button" class="last">&gt;&gt;</button>
				  <select class="pagesize" title="Select page size">
					<option value="10">10</option>
					<option value="15">15</option>
					<option value="20">20</option>
					<option value="25">25</option>
				  </select>
				  <select class="gotoPage" title="Select page number"></select>
				</div>
				</th>
			</tr>
		</tfoot>
		<tbody>

<?php

    for ($i = 0 ; $i < $num_rows ; ++$i)
        {
        $result->data_seek($i);
        $row = $result->fetch_array(MYSQLI_ASSOC);
        echo "<tr><td>".$row['id']."</td><td>".ucfirst($row['f_name'])."</td><td>".ucfirst($row['l_name'])."</td><td>".$row['gdc_no']."</td><td>".$row['ulevel']."</td><td>time</td></tr>";
        }
		echo "</table>";
	}

	function displayBannedUsers() {
		global $database;
		$q = "SELECT gdc_no, timestamp FROM ".TBL_BANNED_USERS." ORDER BY gdc_no";
		$result = $database->query($q);
		$num_rows = $result->num_rows;
		if(!$result || $num_rows < 0) {
			echo "Error displaying info";
			return;
		}

		if($num_rows == 0) {
			echo "<p class='grid_12'>Database table empty</p>";
			return;
		}




		echo "<table id='display' class='admin_tables' border>";
		echo "<tr class='title'><td colspan='2'>GDC Number</td><td colspan='2'>Time Banned</td></tr>";
		for($i=0; $i<$num_rows; ++$i) {
      $result->data_seek($i);
      $row = $result->fetch_array(MYSQLI_ASSOC);
			echo "<tr><td colspan='2'>".$row['gdc_no']."</td><td colspan ='2'>".$row['timestamp']."</td></tr>";
		}
		echo "</table>";
	}

	if(!$session->isAdmin()) {
		header("Location: ../index.php");
	}
	else {
?>

		<html>
		<head>
		<title>Login-System Admin</title>
		</head>

		<body>

		<div id="main" class="container_12">

		<p>Admin Center <b>::::::::::::::::::::::::::::::::::::::::::::::::</b> Logged in as <b><?php echo $session->gdc_no; ?></b><br /><br />
		Back to [<a href="../jpmaster77/login_slider.php">Main page</a>]<br /><br />

		<?php
			if($form->num_errors > 0) {
				echo "<font size=\"4\" color=\"#ff0000\">!*** Error with request, please fix</font><br /><br />";
			}

		?>
		

	<div class="login">

  		<form name="editUser" id="editUser" action="process.php" method="POST">
  		<fieldset>
  			<legend>Enter New User's Info</legend>
            <div class="tableContainer">
        <div class="tableRow">
        <label>First Name:</label>
  			<input type="text" name="fname" size="40" maxlength="30" required pattern="[a-z,A-Z]{1,30}" />
            </div>
            <div class="tableRow">
        <label>Last Name:</label>
  			<input type="text" name="lname" size="40"  maxlength="30" required pattern="[a-z,A-Z]{1,30}" />
            </div>
            <div class="tableRow">
  		<label>GDC Number:</label>
  			<input type="text" name="gdc_no" size="40" maxlength="30" autofocus required pattern="[0-9]{1,30}" />
            </div>
            <div class="tableRow">
        <label>Email:</label>
  			<input type="text" name="email" size="40" maxlength="30" autofocus required />
            </div>
            <div class="tableRow">
  		<label>Password:</label>
  			<input type="password" name="pass" size="40" id="password" maxlength="30" required pattern="[a-z,A-Z]{1,30}" />
            </div>
            <div class="tableRow">
        <label>Reenter Password:</label>
  			<input type="confirm_password" name="confirm_password" size="40" id="confirm_password" maxlength="30" required pattern="[a-z,A-Z]{1,30}" />
            </div>
  			<input type="hidden" name="subjoin" value="1" />
  		<input type="submit" value="Add New User" />
        </div>
  		</fieldset>
  		</form>

    </div>
	<div class="logintablesort">
        <h3>Users Table Contents:</h3>
		<?php
		displayUsers();
		?>
        </div>
<div class="clear"></div>
		<div class = "updateLeft">
			<h3>Update User Level</h3>
			<?php echo $form->error("upduser"); ?>
			<form name="form_register" action = "adminprocess.php" method = "POST">
				<fieldset>
				<label>GDC Number:</label>
				<p><input type = "text" name="upduser" maxlength = "30" value = "<?php echo $form->value("upduser"); ?>"></p>
				<label>Level:</label>
					<select name = "updlevel">
						<option value = "1">1</option>
						<option value = "5">5</option>
						<option value = "9">9</option>
					</select>

				<input type = "hidden" name = "subupdlevel" value = "1">
				<input type = "submit" value = "Update Level">
                </fieldset>
			</form>
		</div>
<div class="clear"></div>

		<div class = "updateLeft">
			<h3>Delete User</h3>
			<?php echo $form->error("deluser"); ?>
			<form name="form_register" action = "adminprocess.php" method = "POST">
                <fieldset>
				<p class = "grid_4">GDC Number: <input type = "text" name = "deluser" maxlength = "30" value = "<?php echo $form->value("deluser"); ?>"></p>

				<input type = "hidden" name = "subdeluser" value = "1">
				<input type = "submit" value = "Delete User">
                </fieldset>
			</form>
		</div>
<!--
<div class="clear"></div>
		<div class = "updateLeft">
			<h3>Delete Inactive Users</h3>
			<p>This will delete all users (not administrators), who have not logged in to the site<br />
			within a certain time period. You specify the days spent inactive.<br /><br />
			<form action = "adminprocess.php" method = "POST">
                <fieldset>
				<p class = "grid_2">Days:
					<select name = "inactdays">
						<option value = "7">7</option>
						<option value = "30">30</option>
						<option value = "100">100</option>
						<option value = "365">365</option>
					</select>
				</p>
            </fieldset>
				<input type = "hidden" name = "subdelinact" value = "1">
				<input type = "submit" value = "Delete All Inactive">
			</form>
		</div>

<!--
		<div class = "updateRight">
			<h3>Ban User</h3>
			<?php echo $form->error("banuser"); ?>
			<form action = "adminprocess.php" method = "POST">
                <fieldset>
				<p class = "grid_4">GDC Number: <input type = "text" name = "banuser" maxlength = "30" value = "<?php echo $form->value("banuser"); ?>"></p>
            </fieldset>
				<input type = "hidden" name = "subbanuser" value = "1">
				<input type = "submit" value = "Ban User">
			</form>
		</div>

<div class="clear"></div>
		<h3>Banned Users Table Contents:</h3>
		<?php
		displayBannedUsers();
		?>
		<hr />

		<div class = "updateLeft">
			<h3>Delete Banned User</h3>
			<?php echo $form->error("delbanuser"); ?>
			<form action = "adminprocess.php" method = "POST">
				<p class = "grid_4">GDC Number: <input type = "text" name = "delbanuser" maxlength = "30" value = "<?php echo $form->value("delbanuser"); ?>"></p>
				<input type = "hidden" name = "subdelbanned" value = "1">
				<input type = "submit" value = "Delete Banned User">
			</form>
		</div>
		<hr />
*/
		Back to [<a href = "login_slider.php">Main Page</a>]<br /><br />

		</div>
		</body>
		</html>
	<?php
	}
	?>
