<?php

if (basename($_SERVER['PHP_SELF']) != "index.php") header("location: index.php");

session_start();

$step = $_GET['step'];
$username = trim($_POST['username']);
$userpassword = trim($_POST['userpassword']);
$login = $_POST['login'];

if (isset($_COOKIE['TBCP'])) header('location: index.php');

switch($step) {

	case '1':
		if (isset($_COOKIE['TBCP_Blocked'])) print_error("Your computer blocked for 10 mintues, for 3 bad logins");
		else {
			echo" 
			<form method='post' action='?a=login&step=2'>
			<table>
			<tr><td>Username:</td><td><input type='text' name='username'></td></tr>
			<tr><td>Password:</td><td><input type='password' name='userpassword'></td></tr>
			</table>
			<input type='submit' value='Login'>
			</form>
			";
		}

	break;

	case '2':
		if (isset($_COOKIE['TBCP_Blocked'])) print_error('Your computer blocked for 10 mintues, for 3 bad logins');
		else {

		if (!isset($username) || !isset($userpassword)) header('location: ?a=login');

		if (file_exists('users/'.$username.'.TBCPUser') && GetLocalFileKey("users/$username.TBCPUser",'Password') == strtoupper(md5($userpassword))) {
			if (GetServerFileKey($ftp_con,USERSDIR,$username."NTUser","Bans") > 0) print_error("Your user banned");
			else {
				$split = split("_",$username);
				$encode_cookie = base64_encode("$split[0]_$split[1]_$userpassword");
				setcookie("TBCP", "$encode_cookie",time()+2592000); // Month
				print_completed("You logged in.","index.php");
			}
		}

		elseif (file_exists('uofusers/'.$username.'.uofuser') && GetLocalFileKey('uofusers/'.$username.'.uofuser','password') == strtoupper(md5($userpassword))) {
		$_SESSION['username'] = $username;
		$_SESSION['userpassword'] = $userpassword;
		Header('location: ?a=official');
		}

		elseif (file_exists('uofusers/waiting-list/'.$username.'.uofuser') && GetLocalFileKey('uofusers/waiting-list/'.$username.'.uofuser','password') == strtoupper(md5($userpassword))) {
		print_error("Your user is in the waiting list. Please wait until approving.");
		}

		else {
			if (!isset($_SESSION['TBCP_lognum'])) $_SESSION['TBCP_lognum'] = 0;
			if ($_SESSION['TBCP_lognum'] < 3) {
				$_SESSION['TBCP_lognum']++;
			}
		else {
			setcookie('TBCP_Blocked', 'User_Blocked', time()+600);
			header("location: index.php?act=login");
		}
		switch ($_SESSION['TBCP_lognum']) {
		case "1": $text="first"; break;
		case "2": $text="second"; break;
		case "3": $text="thired"; break;
		}
		print_error("You have wrote your account name \ password wrong.");
		}
		}
	break;

	case '3':
		setcookie('TBCP', $encode_cookie,time()-1);
		header("location: index.php");
	break;

	default: header("location: ?a=login&step=1");
	break;

}
?>