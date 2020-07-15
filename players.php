<?php

include "functions.php";
include "config.php";

include 'SampQueryAPI.php';
$server = new SampQueryAPI('213.8.254.139','1777');
if (!$server->isOnline()) echo "Server Offline";
else {

// FTP get Admins file
ftp_chdir($ftp_con,"server1/scriptfiles/NTRP/Other");
$file = 'Admins.NTRP';
$tempfile = 'tempfile.txt';
$handle = fopen($tempfile,"w+");
ftp_get($ftp_con,$tempfile,$file,FTP_ASCII);
$read = fread($handle,filesize($tempfile));
fclose($handle);


$get_details = $server->getInfo();
$online_players = $server->getDetailedPlayers();

echo "<head>
	<title>Inifnity RolePlay - Vgames</title>
	<link rel='stylesheet' type='text/css' href='css/style.css' />
</head>";
echo "<body>";
echo "<center>";
echo "<div class='players'>";
echo "Online Players: {$get_details['players']} / {$get_details['maxplayers']}<br />";
$counter = 0;
foreach($online_players as $player) { if (strpos($read,$player['nickname'])) $counter++; }
echo "<b>Online Admins : $counter</b>";
echo "<table border='1'><tr><td>ID</td><td>Name</td><td>Level</td><td>Ping</td></tr>";
foreach($online_players as $player) {
echo "<tr>";
echo "<td>",$player['playerid'],"</td>";
echo strpos($read,$player['nickname']) ? "<td><b>[A][".GetAdminLevel($ftp_con,$player['nickname'])."]</b> {$player['nickname']}</td>" : "<td>{$player['nickname']}</td>";
echo "<td>",$player['score'],"</td>";
echo "<td>",$player['ping'],"</td>";
echo "</tr>";
}
echo "</table>";
echo "<a href='#' onclick='window.close()'>Close</a>";
echo "</div>";
echo "</center>";
echo "</body>";
}
?>