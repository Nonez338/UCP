<?php

if (basename($_SERVER['PHP_SELF']) != "index.php") header("location: index.php");

IsUserConnect();

$get_details = $server->getInfo();
$online_players = $server->getDetailedPlayers();

echo "<table border='1'><tr>";
echo "<td>#ID</td><td>Name</td><td>Admin Level</td>";
echo "</tr>";
ftp_chdir($ftp_con,"server1/scriptfiles/NTRP/Other");
$file = 'Admins.NTRP';
$tempfile = 'tempfile.txt';
$handle = fopen($tempfile,"w+");
ftp_get($ftp_con,$tempfile,$file,FTP_ASCII);
$read = fread($handle,filesize($tempfile));
fclose($handle);
$split = split("\n",trim($read));
foreach($split as $split2) {
$sub_split = split("=",$split2);
foreach($online_players as $player) {
if ($sub_split[0] == $player['nickname']) {
echo "<tr>";
echo "<td><font color='green'>",$player['playerid'],"</font></td>";
echo "<td><font color='green'>",$player['nickname'],"</font></td>";
echo "<td><font color='green'>",$sub_split[1],"</font></td>";
echo "</tr>";
$connected_admins[] = $sub_split[0];
}
}
if (!in_array($sub_split[0],$connected_admins)) {
if ($sub_split != '') {
echo "<tr>";
echo "<td>-</td>";
echo "<td>",$sub_split[0],"</td>";
echo "<td>",$sub_split[1],"</td>";
echo "</tr>";
}
}
}

echo "</table>";

?>