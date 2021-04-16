<?php
include("constants.php");


	class MySQLDB
	{
    public $connection;
		public $num_active_users;
		public $num_active_guests;
		public $num_members;



		function __construct() {
			$this->connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS) or die(mysql_error());
			mysqli_select_db($this->connection, DB_NAME) or die(mysqli_error());

			$this->num_members = -1;
			if(TRACK_VISITORS) {
				$this->calcNumActiveUsers();
				$this->calcNumActiveGuests();
			}
		}

		function confirmUserPass($gdc_no, $password) {
			if(!get_magic_quotes_gpc()) {
				$gdc_no = addslashes($gdc_no);
			}
//echo "<hr />db line 27gdc = ".$gdc_no." password = ".$password."<br />";
//echo "database line 27 in confirmUserPass<hr />";
			$q = sprintf("SELECT password FROM ".TBL_USERS." WHERE gdc_no = '%s'",
				mysqli_real_escape_string($this->connection, $gdc_no));
				$result = mysqli_query($this->connection, $q);
				if(!$result || ($result->num_rows < 1)) {
					return 1;
				}

//			$dbarray = mysqli_fetch_array($result, MYSQLI_ASSOC);
            $dbarray = $result->fetch_assoc();
//echo "database line 38";
//var_dump($dbarray);
//echo "<hr />";
			$dbarray['password'] = stripslashes($dbarray['password']);
			$password = stripslashes($password);
//echo "line 43";
//echo "password = ".$password." and dbarray password = ".$dbarray['password'];
//echo "<br />".gettype($password)."<hr />";

			if($password == $dbarray['password']) {
				return 0;
			}
			else {
				return 2;
			}
		}

		function confirmUserID($gdc_no, $userid) {
			if(!get_magic_quotes_gpc()) {
				$gdc_no = addslashes($gdc_no);
			}

			$q = sprintf("SELECT userid FROM ".TBL_USERS." WHERE gdc_no = '%s'",
				mysqli_real_escape_string($this->connection, $gdc_no));
				$result = mysqli_query($this->connection, $q);
				if(!$result || $result->num_rows < 1) {
				return 1;
			}

			$dbarray = mysqli_fetch_array($result);
			$dbarray['userid'] = stripslashes($dbarray['userid']);
			$userid = stripslashes($userid);

			if($userid == $dbarray['userid']) {
				return 0;
			}
			else {
				return 2;
			}
		}

		function gdc_noTaken($gdc_no) {
			if(!get_magic_quotes_gpc()) {
				$gdc_no = addslashes($gdc_no);
			}

			$q = sprintf("SELECT gdc_no FROM ".TBL_USERS." WHERE gdc_no = '%s'",
				mysqli_real_escape_string($this->connection, $gdc_no));
				$result = mysqli_query($this->connection, $q);
				return ($result->num_rows > 0);
		}

		function gdc_noBanned($gdc_no) {
			if(!get_magic_quotes_gpc()) {
				$gdc_no = addslashes($gdc_no);
			}

			$q = sprintf("SELECT lname FROM ".TBL_BANNED_USERS." WHERE gdc_no = '%s'",
				mysqli_real_escape_string($this->connection, $gdc_no));
				$result = mysqli_query($this->connection, $q);
                if($result) {
				return ($result->num_rows > 0);
                }
		}

		function addNewUser($fname, $lname, $gdc_no, $password, $userid) {
			$time = time();

			if(strcasecmp($lname, ADMIN_NAME) == 0) {
				$ulevel = ADMIN_LEVEL;
			}
			else {
				$ulevel = USER_LEVEL;
			}

			$q = sprintf("INSERT INTO ".TBL_USERS." VALUES( null, '%s', '%s', '%s', '%s', '%s', '%s', '1', '$time')",
				mysqli_real_escape_string($this->connection, $fname),
				mysqli_real_escape_string($this->connection, $lname),
				mysqli_real_escape_string($this->connection, $gdc_no),
				mysqli_real_escape_string($this->connection, $password),
				mysqli_real_escape_string($this->connection, $userid),
				mysqli_real_escape_string($this->connection, $ulevel));
			return mysqli_query($this->connection, $q);
		}

		function updateUserField($gdc_no, $field, $value) {
			$q = sprintf("UPDATE ".TBL_USERS." SET %s = '%s' WHERE gdc_no = '%s'",
				mysqli_real_escape_string($this->connection, $field),
				mysqli_real_escape_string($this->connection, $value),
				mysqli_real_escape_string($this->connection, $gdc_no));
			return mysqli_query($this->connection, $q);
		}

		function getUserInfo($gdc_no) {
			$q = sprintf("SELECT * FROM ".TBL_USERS." WHERE gdc_no = '%s'",
				mysqli_real_escape_string($this->connection, $gdc_no));
			$result = mysqli_query($this->connection, $q);
			if(!$result || $result->num_rows < 1) {
				return NULL;
			}

			$dbarray = mysqli_fetch_array($result);
			return $dbarray;
		}

		function getNummembers() {
			if($this->num_members > 0) {
				$result = mysqli_query($this->connection, $q);
				$this->num_members = $result->num_rows;;
			}
			return $this->num_members;
		}

		function calcNumActiveUsers() {
			$q = "SELECT * FROM ".TBL_ACTIVE_USERS;
			$result = mysqli_query($this->connection, $q);
			$this->num_active_users = $result->num_rows;
		}

		function calcNumActiveGuests() {
			$q = "SELECT * FROM ".TBL_ACTIVE_GUESTS;
			$result = mysqli_query($this->connection, $q);
			$this->num_active_guests = $result->num_rows;
		}

		function addActiveUser($gdc_no, $time) {
			$q = sprintf("UPDATE ".TBL_USERS." SET timestamp = null WHERE gdc_no = '%s'",
				mysqli_real_escape_string($this->connection, $gdc_no));
			mysqli_query($this->connection, $q);

			if(!TRACK_VISITORS) return;
			$q = sprintf("REPLACE INTO ".TBL_ACTIVE_USERS." VALUES ('%s', null)",
				mysqli_real_escape_string($this->connection, $gdc_no));
			mysqli_query($this->connection, $q);
			$this->calcNumActiveUsers();
		}

		function addActiveGuest($ip, $time) {
			if(!TRACK_VISITORS) return;
				$q = sprintf("REPLACE INTO ".TBL_ACTIVE_GUESTS." VALUES ('%s', null)",
					mysqli_real_escape_string($this->connection, $ip));
				mysqli_query($this->connection, $q);
				$this->calcNumActiveGuests();
		}

		function removeActiveUser($gdc_no) {
			if(!TRACK_VISITORS) return;
				$q = sprintf("DELETE FROM ".TBL_ACTIVE_USERS." WHERE gdc_no = '%s'",
					mysqli_real_escape_string($this->connection, $gdc_no));
				mysqli_query($this->connection, $q);
				$this->calcNumActiveUsers();
		}

			function removeActiveGuest($ip) {
			if(!TRACK_VISITORS) return;
				$q = sprintf("DELETE FROM ".TBL_ACTIVE_GUESTS." WHERE ip = '$ip'",
					mysqli_real_escape_string($this->connection, $ip));
				mysqli_query($this->connection, $q);
				$this->calcNumActiveGuests();
		}

		function removeInactiveUsers() {
			if(!TRACK_VISITORS) return;
				$timeout = time()-USER_TIMEOUT*60;
				$q = sprintf("DELETE FROM ".TBL_ACTIVE_USERS." WHERE timestamp < %s",
					mysqli_real_escape_string($this->connection, $timeout));
				mysqli_query($this->connection, $q);
				$this->calcNumActiveUsers();
		}

		function removeInactiveGuests() {
			if(!TRACK_VISITORS) return;
				$timeout = time()-GUEST_TIMEOUT*60;
				$q = sprintf("DELETE FROM ".TBL_ACTIVE_GUESTS." WHERE timestamp < %s",
					mysqli_real_escape_string($this->connection, $timeout));
				mysqli_query($this->connection, $q);
				$this->calcNumActiveGuests();
		}

		function query($query) {
			return mysqli_query($this->connection, $query);
		}
	};

	$database = new MySQLDB;
?>
