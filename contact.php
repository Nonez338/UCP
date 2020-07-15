<?php

if (basename($_SERVER['PHP_SELF']) != "index.php") header("location: index.php");

session_start();

$step = $_GET['step'];
$username = GetNameByCookie();
$file = "$username.TBCPUser";



$username_text = "Username";
$username = GetNameByCookie();

switch($step) {
	case "1":
		if (isset($_COOKIE['TBUCP_Contact'])) print_error("You already sent a message on this hour.");
		else {
		echo "<form method='post' action='?a=contact&step=2'><table>";
		if (isset($_COOKIE['TBCP'])) {
			echo "<tr><td>Username:</td><td><input type='text' name='username' value='$username' readonly /></td></tr>";
		}
		else {
			echo "<tr><td>Name:</td><td><input type='text' name='username' value='{$_SESSION['username']}' /></td></tr>";
		}
		echo "<tr><td>Subject:</td><td><select name='reference'><option value='0'><option value='1'>IRP Team (Admins)</option><option value='2'>IRP Team (High Managment)</option><option value='3'>Bugs</option><option value='4'>Factions</option><option value='5'>Players</option><option value='6'>Other</option></select></td></tr>";
		if (isset($_COOKIE['TBCP'])) {
			echo "<tr><td>Your Email:</td><td><input type='text' name='email' value='",GetLocalFileKey('users/'.$file,'Email'),"' readonly /></td></tr>";
		}
		else {
			echo "<tr><td>Your Email:</td><td><input type='text' name='email' value='{$_SESSION['email']}'/></td></tr>";
		}
			echo "<tr><td>Content:</td><td><textarea cols='60' rows='10' name='text'/>{$_SESSION['text']}</textarea></td></tr>";
			echo "</table><input type='submit' value='Send' /></form>";
		}
	break;
	case "2":
		$username = $_POST['username'];

		if (isset($_COOKIE['TBUCP_Contact'])) header("location: ?a=contact&step=1");
		elseif (!isset($_COOKIE['TBCP']) && file_exists("users/$username.TBCPUser")) print_error("Username exists, please login.");
		else {
			$reference = $_POST['reference'];
			$email = $_POST['email'];
			$start = "<u>From</u>: <br />Username: $username<br />Email: $email<br /><br />";
			$text = $_POST['text'];
			$end = "</font>";

			$emails = array(1=>"amir.k92@Gmail.com, talbeno.IRP@Gmail.com",2=>"gil@VGames.co.il,BoXeR@VGames.co.il",3=>"eliranvg@Gmail.com",4=>"sinsen2@gmail.com",5=>"Support.InfinityRolePlay@Gmail.com",6=>"Support.InfinityRolePlay@Gmail.com");

			if (!isset($username) || $reference == "0" || !isset($email) || !isset($text)) {
				$_SESSION['username'] = $username;
				$_SESSION['email'] = $email;
				$_SESSION['text'] = $text;
				header ("location: index.php?a=contact&step=1");
			}
			else {
				setcookie('TBUCP_Contact','hour',time()+3600);
				TB_mail($emails[$reference],"UCP contact message ('".substr($text,0,15)."...')",$start.nl2br($text).$end);
				print_completed("Message sent","index.php");
			}
		}
	break;

	default:
	header("location: ?a=contact&step=1");
	break;
}
?>