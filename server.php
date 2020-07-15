<?php

include 'header.php';
include 'SampQueryAPI.php';

$server = new SampQueryAPI('213.8.254.139','1777');
if (!$server->isOnline()) echo "הסרבר לא פעיל";
else {
$get_details = $server->getInfo();
$online_players = $server->getDetailedPlayers();

echo "<table><tr>";
echo $get_details['players'], " / ", $get_details['maxplayers'];
echo "</tr>";
echo "<tr><td>איידי</td><td>שם</td><td>רמה</td><td>פינג</td></tr>";
foreach($online_players as $player) {
echo "<tr>";
echo "<td>",$player['playerid'],"</td>";
echo "<td>",$player['nickname'],"</td>";
echo "<td>",$player['score'],"</td>";
echo "<td>",$player['ping'],"</td>";
echo "</tr>";
}
echo "</table>";
}
?>