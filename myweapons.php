<?php

include 'header.php';
IsUserConnect();

$file = GetNameByCookie().".NTUser";
$gun3 = GetServerFileKey($ftp_con,"server1/scriptfiles/NTRP/Users",$file,"Gun3"); // Silend Pistol
$gun4 = GetServerFileKey($ftp_con,"server1/scriptfiles/NTRP/Users",$file,"Gun4"); // Deagle
$gun5 = GetServerFileKey($ftp_con,"server1/scriptfiles/NTRP/Users",$file,"Gun5"); // Shotgun
$gun6 = GetServerFileKey($ftp_con,"server1/scriptfiles/NTRP/Users",$file,"Gun6"); // MP5 / SMG
$gun7 = GetServerFileKey($ftp_con,"server1/scriptfiles/NTRP/Users",$file,"Gun7"); // AK47
$gun8 = GetServerFileKey($ftp_con,"server1/scriptfiles/NTRP/Users",$file,"Gun8"); // Sniper

echo "<table border='1'><tr>";
echo "<td><img src='http://wiki.sa-mp.com/w/images2/2/2b/Weapon-23.gif'><br>Silenced 9mm</td>";
echo "<td><img src='http://wiki.sa-mp.com/w/images2/9/96/Weapon-24.gif'><br>Desert Eagle</td>";
echo "<td><img src='http://wiki.sa-mp.com/w/images2/0/05/Weapon-25.gif'><br>Shotgun</td>";
echo "<td><img src='http://wiki.sa-mp.com/w/images2/0/0a/Weapon-29.gif'><br>MP5 / SMG</td>";
echo "<td><img src='http://wiki.sa-mp.com/w/images2/a/ad/Weapon-30.gif'><br>AK47</td>";
echo "<td><img src='http://wiki.sa-mp.com/w/images2/8/8c/Weapon-34.gif'><br>Sniper Rifle</td>";
echo "</tr><tr>";
echo "<td>{$gun3}</td>";
echo "<td>{$gun4}</td>";
echo "<td>{$gun5}</td>";
echo "<td>{$gun6}</td>";
echo "<td>{$gun7}</td>";
echo "<td>{$gun8}</td>";
echo "</tr></table>";

?>