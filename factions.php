<?php

include 'header.php';

IsUserConnect();

$faction = $_GET['faction'];


$factions = array("LSPD","LSFD","LSES","FBI","Mechanic","News","Transportation");
 $factions['LSPD'] = array(1 => "Chief", 	2 => "Deputy Chief",	3=> "Captain",	4=> "Lieutenant",	5=> "Detective",	6=> "Sergeant",	7=> "Corporal",	8=> "Officer",	9=> "Cadet",	10=> "Trainee");
$factions['LSFD'] = array(1 => "Captain",	8 => "FireFighter");
$factions['LSES'] = array(1 => "Manager",	3 => "Doctor",	4 => "Paramedic", 5 => "Medic", 8 => "Trainee");
$factions['FBI'] = array(1 => "Director",		2 => "Senior Agent",	13 => "Agent",	14 => "Trainee");
$factions['Mechanic'] = array(6 => "Manager",	12 => "Mechanic");
$factions['News'] = array(6 => "Manager",	8 => "Editor",	9 => "Reporter");
$factions['Transportation'] = array(6 => "Manager",	3 => "Dispatcher",	7 => "BusD", 8 => "TaxiD");




if (in_array($faction,$factions)) {

echo "<table border='1'><tr>";
echo "<td>Name</td><td>Rank</td>";
echo "</tr>";

$file = $faction.".NTFile";
ftp_chdir($ftp_con,"server1/scriptfiles/NTRP/Jobs");
$tempfile = 'tempfile.txt';
$handle = fopen($tempfile,"w+");
ftp_get($ftp_con,$tempfile,$file,FTP_ASCII);
$read = fread($handle,filesize($tempfile));
fclose($handle);
$split = split("\n",$read);
foreach($split as $split2) {

$sub_split = split("=",$split2);
echo "<tr>";
echo "<td>$sub_split[0]</td><td>{$factions[$faction][$sub_split[1]]}</td>";
echo "</tr>";

}
echo "</table>";
ftp_up($ftp_con,4);
if ($faction == "FBI") if (GetAdminLevel($ftp_con,GetNameByCookie()) < 1) header('location: ?');
}
else {
echo "Factions List:<br>";
echo "<a href='?faction=LSPD'>Los Santos Police Department</a><br />";
echo "<a href='?faction=LSES'>Los Santos Emergency Service</a><br />";
echo "<a href='?faction=LSFD'>Los Santos Fire Department</a><br />";
if (GetAdminLevel($ftp_con,GetNameByCookie()) > 0) echo "<a href='?faction=FBI'>Federal Bureau of Investigation</a> [AA-Admin.Access]<br />";
echo "<a href='?faction=Mechanic'>Los Santos Mechanic</a><br />";
echo "<a href='?faction=News'>Los Santos News</a><br />";
echo "<a href='?faction=Transportation'>Los Santos Transportation</a><br />";
}
?>