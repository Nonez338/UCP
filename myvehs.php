<?php

include 'header.php';
IsUserConnect();

$username = GetNameByCookie();

ftp_chdir($ftp_con,"server1/scriptfiles/NTRP/Other");

$file = 'Cars.NTRP';
$tempfile = 'tempfile.txt';
$handle = fopen($tempfile,"w+");
ftp_get($ftp_con,$tempfile,$file,FTP_ASCII);
$read = fread($handle,filesize($tempfile));
fclose($handle);
$split =  split("\n",$read);
echo "<table border='1'>";
echo "<tr>";
echo "<td>Vehicle</td>";
foreach($split as $name) {
$sub_split = split(",",$name);

if ($username == $sub_split[0]) {

echo "<td>",GetPictureByModelID($sub_split[1]),"</td>";

}
}
echo "</tr><tr>";
echo "<td>Lock</td>";
foreach($split as $name) {
$sub_split = split(",",$name);
if ($username == $sub_split[0]) {
echo "<td>";
switch ($sub_split[27]) {
case '6': echo "Very Low"; break;
case '7': echo "Low"; break;
case '8': echo "Medium"; break;
case '9': echo "Proffesional"; break;
}
echo "</td>";
print_r($sub_split);
}
}
echo "</tr>";
echo "</table>";

?>