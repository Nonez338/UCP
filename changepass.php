<?php

if (basename($_SERVER['PHP_SELF']) != "index.php") header("location: index.php");

IsUserConnect();

$step = $_GET['step'];
$username = GetNameByCookie();
$file = $username.".TBCPUser";
$userpassword = TBSecure($_POST['userpassword']);
$newpassword = TBSecure($_POST['newpassword']);
$vnewpassword = TBSecure($_POST['vnewpassword']);

switch($step) {

	case "1":
		echo "<form method='POST' action='?a=changepass&step=2'>
		<table><tr><td>Current password:</td><td><input type='text' name='userpassword'></td></tr>
		<tr><td>New password:</td><td><input type='text' name='newpassword'></td></tr>
		<tr><td>Confirm password:</td><td><input type='text' name='vnewpassword'></td></tr>
		</table>
		<input type='submit' value='Change' />
		</form>";
	break;

	case "2":

		if ($userpassword == "" || $newpassword == "" || $vnewpassword == "") header("location: ?a=changepass&step=1");
		elseif (strtoupper(md5($userpassword)) != GetLocalFileKey("users/$file","Password")) print_error("Wrong old password");
		elseif ($newpassword != $vnewpassword) print_error("New password doesn't match");
		else {
		SetLocalFileKey("users/$file","Password",strtoupper(md5($newpassword)));
		$useremail = GetLocalFileKey("users/$file","Email");
		$text = "<font face='tahoma'>Your password has been changed successfully.<br />Your new password is: $newpassword</font>";
		TB_mail($useremail,"password change",$text);
		print_completed("Password changed","?a=control");
		}

	break;

	default:
	header("location: ?a=changepass&step=1");
	break;
}
?>