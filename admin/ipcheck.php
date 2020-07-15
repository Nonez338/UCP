<?php

if (basename($_SERVER['PHP_SELF']) != "index.php") header("location: index.php");

$list = ftp_nlist($ftp_con,'server1/scriptfiles/NTRP/Users');


echo "<table border=1>";
echo "<tr><th>Username with this IP</th></tr>";

foreach ($list as $file) {

$tempfile = 'tempfile.txt';
$handle = fopen($tempfile,'w+');
$getthis = substr($file,31);
ftp_chdir($ftp_con,"server1/scriptfiles/NTRP/Users");
ftp_fget($ftp_con,$handle,$getthis,FTP_ASCII);
if (GetLocalFileKey($tempfile,'IP') == '79.181.15.129') {
echo "<tr>";
echo "<td>", substr($file,31,-7),"</td>";
echo "</tr>";
}
}
echo "<table>";
?>