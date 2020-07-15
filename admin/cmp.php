<?php

include "../config.php";
include "../functions.php";

IsUserConnect();

$show = base64_decode($_GET['show']);
$other = base64_decode($_GET['other']);
$que1 = GetLocalFileKey("../uofusers/waiting-list/$show.uofuser",'que1');
$que2 = GetLocalFileKey("../uofusers/waiting-list/$show.uofuser",'que2');
$que3 = GetLocalFileKey("../uofusers/waiting-list/$show.uofuser",'que3');
$que4 = GetLocalFileKey("../uofusers/waiting-list/$show.uofuser",'que4');

echo "<html><head>";
echo "<title>Inifnity RolePlay - Vgames</title>";
echo "<link rel='stylesheet' type='text/css' href='../css/chat_style.css' />";
echo "</head>";
echo "<center><table border='1'><tr><td>Username</td><td>Answer 1</td><td>Answer 2</td><td>Answer 3</td><td>Answer 4</td><td>Type</td></tr>";
echo "<tr><td><b>$show</b></td><td><b>$que1</b></td><td><b>$que2</b></td><td><b>$que3</b></td><td><b>$que4</b></td><td>Current</td></tr>";
$split = split(" | ",$other);

foreach($split as $user) {
	if ($user !== "|") {
		if (file_exists("../users/$user.TBCPUser")) { $dir = "users"; $ext = "TBCPUser"; $type = "Official"; }// Is he a registred user?
		elseif (file_exists("../uofusers/waiting-list/$user.uofuser")) { $dir = "uofusers/waiting-list"; $ext = "uofuser"; $type = "WFA"; }// Is he a WFA user?

		if (strtotime(date('m/d/Y')) - 14 <= strtotime(date('m/d/Y',filemtime("../$dir/$user.$ext")))) {
			echo "<tr><td>$user</td><td>",GetLocalFileKey("../$dir/$user.$ext","que1"),"</td><td>",GetLocalFileKey("../$dir/$user.$ext","que2"),"</td><td>",GetLocalFileKey("../$dir/$user.$ext","que3"),"</td><td>",GetLocalFileKey("../$dir/$user.$ext","que4"),"</td><td>$type</td></tr>";
		}
	}
}
echo "</table>
echo "<a href='#' onclick='window.close()'>Close</a>";
</center>";

?>
