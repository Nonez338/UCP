<?php

$list = ftp_nlist($ftp_con,'server1/scriptfiles/NTRP/Users');


echo "<body dir='rtl'><center><table border=1>";
echo "<th>שם משתמש</th><th>כסף על עצמו</th><th>בנק</th><th>תיק</th></tr>";
$money=0;
$bank=0;
$bmoney=0;
foreach ($list as $file) {

$tempfile = 'tempfile.txt';
$handle = fopen($tempfile,'w+');
$getthis = substr($file,31);
ftp_chdir($ftp_con,"server1/scriptfiles/NTRP/Users");
ftp_fget($ftp_con,$handle,$getthis,FTP_ASCII);
if (GetLocalFileKey($tempfile,'Bans') == '0') {
echo "<tr>";
echo "<td>", substr($file,31,-7), "</td><td>", GetLocalFileKey($tempfile,'Money'), "</td><td>", GetLocalFileKey($tempfile,'Bank'), "</td><td>",GetLocalFileKey($tempfile,'BMoney'), "</td>";
echo "</tr>";
$money+=GetLocalFileKey($tempfile,'Money');
$bank+=GetLocalFileKey($tempfile,'Bank');
$bmoney+=GetLocalFileKey($tempfile,'BMoney');
}
}
echo "<tr>";
echo "<td>סך הכל</td>";
echo "<td>{$money}</td>";
echo "<td>{$bank}</td>";
echo "<td>{$bmoney}</td>";
echo "</tr>";
?>