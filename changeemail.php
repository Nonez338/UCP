<?php

if (basename($_SERVER['PHP_SELF']) != "index.php") header("location: index.php");

IsUserConnect();

$step = $_GET['step'];
$username = GetNameByCookie();
$file = $username.".TBCPUser";
$userpassword = TBSecure($_POST['userpassword']);
$newemail = $_POST['newemail'];
$vnewemail = $_POST['vnewemail'];
$accept = $_POST['accept'];

switch($step) {

	case "1":
		if (GetLocalFileKey("users/$file","Denyemail") != "1") $checked = "checked";
		echo "<form method='POST' action='?a=changeemail&step=2'>
		<table><tr><td>Current password:</td><td><input type='text' name='userpassword'></td></tr>
		<tr><td>Current email address:</td><td><input type='text' name='useremail' value='",GetLocalFileKey("users/$file","Email"),"' readonly></td></tr>
		<tr><td>New email address:</td><td><input type='text' name='newemail'></td></tr>
		<tr><td>Confirm email address:</td><td><input type='text' name='vnewemail'></td></tr>
		<tr><td>Accept admin's emails:</td><td><input type='checkbox'name='accept' value='accept' $checked></td></tr>
		</table>
		<input type='submit' value='Change' />
		</form>";
	break;

	case "2":
		if ($userpassword == '') header("location: ?a=changeemail&step=1");
		else {
			if (strtoupper(md5($userpassword)) == GetLocalFileKey("users/$file","Password")) {
				if ($newemail != '' && $vnewemail != '') {
					if ($newemail != $vnewemail) print_error("New emails doesn't match");
					else {
						SetLocalFileKey("users/$file","Email",$newemail);
						SetLocalFileKey("mails.phplist",$username,$newemail);
						print_completed("Details changed","?a=control");
					}
				}
				if ($accept != '') SetLocalFileKey("users/$file","Denyemail","0");
				else SetLocalFileKey("users/$file","Denyemail","1");
				print_completed("Details changed","?a=control");
			}
			else print_error("Wrong password");
		}
	break;

	default:
	header("location: ?a=changeemail&step=1");
	break;
}
?>