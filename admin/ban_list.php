<?php

if (basename($_SERVER['PHP_SELF']) != "index.php") header("location: index.php");

$list = ftp_nlist($ftp_con,'server1/scriptfiles/NTRP/Users');
$tempfile = "tempfile.txt";


echo "<table border='1'>";
echo "<tr><th>#</th><th>Banned users</th></tr>";
ftp_chdir($ftp_con,"server1/scriptfiles/NTRP/Users");
$count=0;

foreach ($list as $file) {

$tempfile = 'tempfile.txt';
$handle = fopen($tempfile,'w+');
$getthis = substr($file,31);
ftp_fget($ftp_con,$handle,$getthis,FTP_ASCII);

if (GetServerFileKey($ftp_con,USERSDIR,$getthis,"Bans") > '0') {
$count++;
echo "<tr><td>$count</td><td>",substr($file,31,-7),"</td></tr>";

}
}
echo "</table>";

?>