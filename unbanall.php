<?php
/*
include 'header.php';

$list = ftp_nlist($ftp_con,'server1/scriptfiles/NTRP/Users');
$tempfile = "tempfile.txt";


echo "<body dir='rtl'><center><table border=1>";
echo "המשתמשים שירדו להם הבאן:<br>";
echo "<tr><th>שם משתמש</th></tr>";

foreach ($list as $file) {

ftp_chdir($ftp_con,"server1/scriptfiles/NTRP/Users");

$tempfile = 'admin/temp.txt';
$handle = fopen($tempfile,'w+');
$getthis = substr($file,31);
ftp_fget($ftp_con,$handle,$getthis,FTP_ASCII);

if (GetIniValue($tempfile,"Bans") > '0') {

ftp_get ($ftp_con, $tempfile, substr($file,31), FTP_ASCII);
$handle = fopen($tempfile,"r");
$read = fread($handle,filesize($tempfile));
fclose($handle);
$handle = fopen($tempfile,"w");
$replace = str_replace('Bans=1','Bans=0',$read);
$write = fwrite($handle,$replace);
ftp_put($ftp_con, substr($file,31), $tempfile, FTP_ASCII);

echo "<tr><td>",substr($file,31,-7),"</td></tr>";

}
}
echo "</table>";
*/
?>