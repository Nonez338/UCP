<?php

$list = ftp_nlist($ftp_con,'server1/scriptfiles/NTRP/Users');


echo "<body dir='rtl'><center><table border=1>";
echo "המשתמשים בבאן הם:<br>";
echo "<th>שם משתמש</th></tr>";

foreach ($list as $file) {

$tempfile = 'tempfile.txt';
$handle = fopen($tempfile,'w+');
$getthis = substr($file,31);
ftp_chdir($ftp_con,"server1/scriptfiles/NTRP/Users");
ftp_fget($ftp_con,$handle,$getthis,FTP_ASCII);
if (GetLocalFileKey($tempfile,'Bans') == '1') {
echo "<tr>";
echo "<td>", substr($file,31,-7), "</td>";
echo "</tr>";
}
}

?>