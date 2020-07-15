<?php

if (basename($_SERVER['PHP_SELF']) != "index.php") header("location: index.php");

include "inc/jobs.inc";
include 'js/functions.js';
IsUserConnect();
$username = GetNameByCookie();
$file = "$username.NTUser";

echo "<u><b>Account Details</b></u><br />";
echo "- <u>User name</u>: ",GetNameByCookie(),"<br />";
echo "- <u>Email</u>: ",GetLocalFileKey("users/$username.TBCPUser","Email"),"<br />";
if (GetLocalFileKey("users/$username.TBCPUser","Denyemail") == "0") $deny_email = "Yes"; else $deny_email = "No";
echo "- <u>Accept admins emails</u>: ",$deny_email,"<br />";
echo "<br />";
echo "<u><b>Player Details</b></u><br />";
echo "- <u>Level</u>: ",GetServerFileKey($ftp_con,"server1/scriptfiles/NTRP/Users",$file,"Level"),"<br />";
$exp_for_next_level = (GetServerFileKey($ftp_con,"server1/scriptfiles/NTRP/Users",$file,"Level") + 1) * 4;
echo "- <u>Experience</u>: ",GetServerFileKey($ftp_con,"server1/scriptfiles/NTRP/Users",$file,"Exp")," / $exp_for_next_level<br />";
if (GetServerFileKey($ftp_con,"server1/scriptfiles/NTRP/Users",$file,"Sex") == "1") $player_sex = "Male"; else $player_sex = "Female";
echo "- <u>Sex</u>: $player_sex<br />";
if (GetServerFileKey($ftp_con,"server1/scriptfiles/NTRP/Users",$file,"Skin") == "1") $player_skin = "White"; else $player_skin = "Black";
echo "- <u>Skin</u>: $player_skin<br />";
echo "- <u>Age</u>: ",GetServerFileKey($ftp_con,"server1/scriptfiles/NTRP/Users",$file,"Age"),"<br />";
echo "- <u>Origin</u>: ",GetServerFileKey($ftp_con,"server1/scriptfiles/NTRP/Users",$file,"Origin"),"<br />";
//Job+Rank
$job_num = GetServerFileKey($ftp_con,"server1/scriptfiles/NTRP/Users",$file,"Job");
$rank_num = GetServerFileKey($ftp_con,"server1/scriptfiles/NTRP/Users",$file,"Rank");
$rank = (in_array($job_name[$job_num],$factions)) ? $factions[$factions[$job_num]][$rank_num] : "None";
echo "- <u>Job</u>: {$job_title[$job_num]}<br />";
echo "- <u>Rank</u>: $rank<br />";
//Money
$pocket = GetServerFileKey($ftp_con,"server1/scriptfiles/NTRP/Users",$file,"Money");
$bank = GetServerFileKey($ftp_con,"server1/scriptfiles/NTRP/Users",$file,"Bank");
$bag = GetServerFileKey($ftp_con,"server1/scriptfiles/NTRP/Users",$file,"BMoney");
$paycheck = GetServerFileKey($ftp_con,"server1/scriptfiles/NTRP/Users",$file,"PayCheck");
$debts = GetServerFileKey($ftp_con,"server1/scriptfiles/NTRP/Users",$file,"Debts");
$total_money = $pocket+$bank+$bag+$paycheck+$debts;
echo "- <u><b>Money</b></u>: (Total: $total_money$)<br />";
echo "-- <u>Pocket Money</u>: $pocket$<br />";
echo "-- <u>Bank Money</u>: $bank$<br />";
echo "-- <u>Bag Money</u>: $bag$<br />";
echo "-- <u>Paycheck</u>: $paycheck$<br />";
echo "-- <u>Debts</u>: $debts$<br />";

// Vehicles - START

$veh_name = array(400=>"Landstalker",	401=>"Bravura",		402=>"Buffalo",
		405=>"Sentinel",		415=>"Cheetah",		422=>"Bobcat",
		445=>"Admiral",		461=>"PCJ-600",		462=>"Faggio",
		463=>"Freeway",		468=>"Sanchez",		474=>"Hermes",
		475=>"Sabre",		480=>"Comet",		481=>"BMX",	
		482=>"Burrito",		489=>"Rancher",		491=>"Virgo",
		492=>"Greenwood",	500=>"Mesa",		507=>"Elegant",
		533=>"Feltzer",		536=>"Blade",		540=>"Vincent",
		542=>"Clover",		543=>"Sadler",		549=>"Tempa",
		550=>"Sunrise",		554=>"Yosmite",		555=>"Windsor",
		558=>"Uranus",		559=>"Jester",		560=>"Sultan",	
		562=>"Elegy",		565=>"Flash",		567=>"Savanna",
		579=>"Huntley",		580=>"Stafford",		586=>"Wayfarer",
		589=>"Club",		603=>"Phoenix");


echo "- <b><u>Vehicles</u></b>:<br />";

ftp_up($ftp_con,4);
ftp_chdir($ftp_con,"server1/scriptfiles/NTRP/Other");

$file = 'Cars.NTRP';
$tempfile = 'tempfile.txt';
$handle = fopen($tempfile,"w+");
ftp_get($ftp_con,$tempfile,$file,FTP_ASCII);
$read = fread($handle,filesize($tempfile));
fclose($handle);
$i = 0;
$split =  split("\n",$read);
foreach($split as $name) {
$sub_split = split(",",$name);

if ($username == $sub_split[0]) {
$i++;
switch ($i) { case "1": $i_text = "First"; break; case "2": $i_text = "Second"; break; case "3": $i_text = "Third"; break; }
echo "-- <u>$i_text Vehicle</u>: <a href='#' onclick=' popitup(\"images/vehs/{$sub_split[1]}.jpg\",150,225)'>{$veh_name[$sub_split[1]]}</a><br />";
}
}
if ($i == "0") echo "-- You don't have any vehicle.<br />";
// Vehicles - END

// Weapons - START

$gun3 = GetServerFileKey($ftp_con,"server1/scriptfiles/NTRP/Users",$file,"Gun3"); // Silend Pistol
$gun4 = GetServerFileKey($ftp_con,"server1/scriptfiles/NTRP/Users",$file,"Gun4"); // Deagle
$gun5 = GetServerFileKey($ftp_con,"server1/scriptfiles/NTRP/Users",$file,"Gun5"); // Shotgun
$gun6 = GetServerFileKey($ftp_con,"server1/scriptfiles/NTRP/Users",$file,"Gun6"); // MP5 / SMG
$gun7 = GetServerFileKey($ftp_con,"server1/scriptfiles/NTRP/Users",$file,"Gun7"); // AK47
$gun8 = GetServerFileKey($ftp_con,"server1/scriptfiles/NTRP/Users",$file,"Gun8"); // Sniper
$gun3 = ($gun3 < 1) ? 0 : $gun3;
$gun4 = ($gun4 < 1) ? 0 : $gun4;
$gun5 = ($gun5 < 1) ? 0 : $gun5;
$gun6 = ($gun6 < 1) ? 0 : $gun6;
$gun7 = ($gun7 < 1) ? 0 : $gun7;
$gun8 = ($gun8 < 1) ? 0 : $gun8;
$total_gun = $gun3+$gun4+$gun5+$gun6+$gun7+$gun8;

echo "- <b><u>Weapons</u></b>:<br />";
if ($total_gun == "0") echo "-- You don't have any weapon which contains any ammo.";
else {
echo "<table><tr><td><img src='images/weapons/9mm.gif'></td><td><u>Silenced 9mm</u>: $gun3 Bullets.</td></tr>";
echo "<tr><td><img src='images/weapons/deagle.gif'></td><td><u>Desert Eagle</u>: $gun4 Bullets.</td></tr>";
echo "<tr><td><img src='images/weapons/shotgun.gif'></td><td><u>Shotgun</u>: $gun5 Bullets.</td></tr>";
echo "<tr><td><img src='images/weapons/mp5.gif'></td><td><u>MP5 / SMG</u>: $gun6 Bullets.</td></tr>";
echo "<tr><td><img src='images/weapons/ak.gif'></td><td><u>AK47</u>: $gun7 Bullets.</td></tr>";
echo "<tr><td><img src='images/weapons/sniper.gif'></td><td><u>Sniper Rifle</u>: $gun8 Bullets.</td></tr></table>";
}

// Weapons - END

?>