<?php

if (basename($_SERVER['PHP_SELF']) != "index.php") header("location: index.php");

$step = $_GET['step'];
$show = $_GET['show'];

switch ($step) {
	case "1":
		switch($show) {
			case "ucp-enters": $type = "local"; $file = "../logs/enters.TBLog"; break;
			case "ucp-say": $type = "local"; $file = "../logs/say.TBLog"; break;
			case "ucp-users": $type = "local"; $file = "../logs/users.TBLog"; break;
			case "server-JWB": $type = "server"; $file = "server1/scriptfiles/NTRP/logs/name.NTLog"; break;
		}
		if ($type == "local") {
			$open = fopen($file,"r");
			$read = fread($open,filesize($file));
		}
		elseif ($type == "server") {
			$read = "Server logs will be updated soon";
		}
		else $read = "Wrong use";

		echo "<textarea cols='85' rows='15'>$read</textarea>";
	break;

	default:
	echo "<a href='?act=logs&step=1&show=ucp-enters'>[UCP] Enters</a><br />";
	echo "<a href='?act=logs&step=1&show=ucp-say'>[UCP] Say</a><br />";
	echo "<a href='?act=logs&step=1&show=ucp-users'>[UCP] Users</a><br />";

	echo "<a href='?act=logs&step=1&show=server-JWB'>[SERVER] Users</a><br />";
	break;
}



?>