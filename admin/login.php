<?php

session_start();

$step = $_GET['step'];
$true_pass = GetLocalFileKey("../inc/config.inc","ACPP");
$password = $_POST['password'];

if (isset($_SESSION['global_pass']) && $_SESSION['global_pass'] == md5($true_pass)) header("location: index.php");

switch($step) {

	case "1":
		echo "<form method='POST' action='index.php?act=login&step=2'><table><tr><td>Password</td><td><input type='password' name='password' /></td></tr></table><input type='submit' value='Login'></form>";
	break;

	case "2":
		if ($password != $true_pass) print_error("Wrong password");
		else {
			$_SESSION['global_pass'] = md5($true_pass);
			print_completed("You logged in","index.php");
		}
	break;

	case "3":
	session_unset(); 
	header("location: ../index.php");
	break;

	default:
	header("location: index.php?act=login&step=1");
	break;

}

?>