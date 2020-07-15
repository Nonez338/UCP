<?php

if (basename($_SERVER['PHP_SELF']) != "index.php") header("location: index.php");

header('Content-Type: text/html; charset=windows-1255');
$step = $_GET['step'];

switch($step) {

	case "1":
		echo "<form method='POST' action='index.php?act=ban_info&step=2'><table>";
		echo "<tr><td>Username</td><td><input type='text' name='username'></td></tr></table>";
		echo "<input type='submit' value='Check'></form>";
	break;

	case "2":
		$username = $_POST['username'];
		if ($username == '') header("location: index.php?act=ban_info&step=1");
		elseif (GetServerFileKey($ftp_con,USERSDIR,"$username.NTUser","Bans") == "0") print_error("User don't in ban");
		else {
			$type = GetServerFileKey($ftp_con,USERSDIR,"$username.NTUser","Bans");
			$reason = GetServerFileKey($ftp_con,USERSDIR,"$username.NTUser","BReason");
			$date = GetServerFileKey($ftp_con,USERSDIR,"$username.NTUser","BDate");
			$time = GetServerFileKey($ftp_con,USERSDIR,"$username.NTUser","BTime");
			$give = GetServerFileKey($ftp_con,USERSDIR,"$username.NTUser","BGive");

			switch($type) {
			case "1":
			$type = "Regular ban";
			break;
			case "3":
			$type = "Character Kill";
			break;
			}

			echo "<table>";
			echo "<tr><td>Username</td><td>$username</td></tr>";
			echo "<tr><td>Ban type</td><td>$type</td></tr>";
			echo "<tr><td>Reason</td><td>$reason</td></tr>";
			echo "<tr><td>Date</td><td>$date</td></tr>";
			echo "<tr><td>Time</td><td>$time</td></tr>";
			echo "<tr><td>Admin (who banned)</td><td>$give</td></tr>";
			echo "</table>";
			echo "<a href='index.php?act=unban&step=1&name=".base64_encode($username)."'>Unban this user</a>";

		}
	break;

	default:
	header("location: index.php?act=ban_info&step=1");
	break;
}

?>