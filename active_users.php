<?php
	if(!defined('TBL_ACTIVE_USERS')) {
		die("Error processing page");
	}
	
	$q = "SELECT username FROM ".TBL_ACTIVE_USERS." ORDER BY timestamp DESC, username";
	$result = $database->query($q);
	$num_rows = mysql_num_rows($result);
	if(!$result || $num_rows < 0)) {
		echo "Error displaying info";
	}
	else {
		echo "<table align=\"left\" border=\"1\" cellspacing=\"0\" cellpadding=\"3\">\n";
		echo "<tr><td><font size=\"2\">/n";
		for($i=0; $i<$num_rows; $i++) {
			$uname = mysql_result($result, $i, "username");
			
			echo "<a href=\"userinfo.php?user=$uname\">$uname</a> /";
		}
		echo "</font></td></tr></table><br />\n";
	}
	?>