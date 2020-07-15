<?php

// Logs the enter
if (getenv("HTTP_X_FORWARDED_FOR")) $ipaddress=getenv("HTTP_X_FORWARDED_FOR"); 
else 
if (getenv("HTTP_CLIENT_IP")) {
$ipaddress=getenv("HTTP_CLIENT_IP");
}
else
{ 
$ipaddress=getenv("REMOTE_ADDR"); 
}

$username = GetNameByCookie();
if ($username=="_") $username="Guest";

$agent=split("; ", getenv("HTTP_USER_AGENT"));
$browser=$agent[1];
$operatingsystem=$agent[2];

$thelanguage=getlanguage(getenv("HTTP_ACCEPT_LANGUAGE"));

$thedate=date("m").".".date("d").".".date("y")." - ".date("H").":".date("i").":".date("s");

$referrerpage=$_SERVER['HTTP_REFERER'];
if($referrerpage != "") $keywords = getkeywords($referrerpage);
else $keywords="Not Available"; $referrerpage="Not Available";
if ($keywords == "") $keywords = "Not Available";

// Log it

if (filesize("logs/enters.TBLog") > 6666666) unlink("logs/enters.TBLog"); // 1/3 OF 10 MB
$open=fopen("logs/enters.TBLog", "r");
$read = fread($open, filesize("logs/enters.TBLog"));
$split = split("\n",$read);
$counter = 0;
foreach($split as $line) {
if (strpos($line,$username) && strpos($line,$ipaddress)) $counter++; // If This IP or this Username not logs yes, log it.
}
fclose($open);


if ($counter <= 0) {
$open=fopen("logs/enters.TBLog", "a");
$newrecord = "`$ipaddress` (Username [$username] Browser [$browser] OperatingSystem [$operatingsystem] Language [$thelanguage] Date/Time [$thedate] Referrer [$referrerpage] Search Keywords [$keywords])\n";
fwrite($open, $newrecord);
fclose($open);
}
?>