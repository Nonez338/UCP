<?php

include "config.php";
include "functions.php";

IsUserConnect();

header("refresh: 12; url=?"); 
echo "<html><head>
	<title>Inifnity RolePlay - Vgames</title>
	<link rel='stylesheet' type='text/css' href='css/chat_style.css' />
	</head>";

$file = "shout.txt";
$length = 40;
$lines = 6;

$step = $_GET['step'];

$username = GetNameByCookie();
if (GetAdminLevel($ftp_con,$username) > 0) $color = "red";
if (GetAdminLevel($ftp_con,$username) > 9) $color = "green";
else $color = "black";

switch($step) {

	case "1":

		$c = $_POST['c'];
		$c = preg_replace('/</','&lt;',$c);
		$c = preg_replace('/>/','&gt;',$c); 
		$c = TBSecure($c);
		$comfile = file($file);

		if ($c != "") {
			if (strlen($c) <= $length) {
				$open = fopen ($file, "w");
				$c = stripslashes($c);
				fwrite ($open, "<div class='content'>>> <i><font color='$color'>$username</font></i>: $c</div>\n");
				for ($i = 0; $i <= $lines; $i++) {
					fwrite ($open, $comfile[$i]);
				}
			}
			fclose($open);
		}

		Header("Location: ?");

	break;

	case "2":
		if (GetAdminLevel($ftp_con,$username) < 1) header("location: ?");
		else {
		$open = fopen ($file, "w");
		fclose($open);
		header("location: ?");
		}
	break;


	default:

	echo "<body><center><table>";
	echo "<tr><td>";
	include("shout.txt");
	echo "</td></tr>";
	echo "<tr><td>";
	echo "<form method='POST' action='?step=1'>";
	echo "<center><input id='c' size='40' maxlength='40' type='text' name='c'>";
	echo "<input type='submit' value='Go'></center>";
	echo "</form>";
	echo "</td></tr></table>";
	echo "<script>document.getElementById('c').focus();</script>";
	if (GetAdminLevel($ftp_con,$username) > 0) echo "AA: <a href='?step=2'>Clear Chat</a><br />";
	echo "<a href='javascript:location.reload(true)'>Refresh</a><br /><a href='#' onclick='window.close()'>Close</a></center>";

	break;
}


?>
