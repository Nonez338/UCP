<?php

function ftp_up($connection,$times) {
for ($i=0;$i<$times;$i++) ftp_cdup($connection);
}

function IsKeySet($file,$key) {

if (file_exists($file)) {
$getvalue = parse_ini_file($file);
if (strlen($getvalue[$key]) > 0) return true;
}

}

function GetLocalFileKey($file, $key) {

if (IsKeySet($file,$key)) {
$getvalue = parse_ini_file($file);
return $getvalue[$key];
}
else return false;
}

function SetLocalFileKey($file, $key, $value) {

$getvalue = GetLocalFileKey($file,$key);
$open = fopen($file, 'r');
$read = fread($open, filesize($file)+2000);
$replace = str_replace("$key=\"$getvalue\"","$key=\"$value\"",$read);
$replace = str_replace("$key=$getvalue","$key=\"$value\"",$replace);
fclose($open);
$open = fopen($file, 'w+');
$write = fwrite($open,$replace);
fclose($open);

}

function GetServerFileKey($connection,$address,$file,$key) {

ftp_chdir($connection,$address);

$tempfile = 'tempfile.txt';
$handle = fopen($tempfile,"w+");
ftp_get($connection,$tempfile,$file,FTP_ASCII);
fclose($handle);
return GetLocalFileKey($tempfile,$key);

}

function SetServerFileKey($connection,$address,$file,$key,$value) {

$Get_Key = GetServerFileKey($connection,$address,$file,$key);
ftp_chdir($connection,$address);
$tempfile = 'tempfile.txt';

ftp_get ($connection, $tempfile, $file, FTP_ASCII);
$handle = fopen($tempfile,"r");
$read = fread($handle,filesize($tempfile)+2000);
fclose($handle);
$handle = fopen($tempfile,"w");
$replace = str_replace("$key=$Get_Key","$key=$value",$read);
$write = fwrite($handle,$replace);
ftp_put($connection, $file, $tempfile, FTP_ASCII);

}


function GetAdminLevel($connection,$adminname) {

return GetServerFileKey($connection,"server1/scriptfiles/NTRP/Other","Admins.NTRP",$adminname);

}

function GetNameByCookie() {

$decode_cookie = split('_',base64_decode($_COOKIE['TBCP']));
return $decode_cookie[0].'_'.$decode_cookie[1];

}

function IsRPName($name) {

if (preg_match('/[A-Z][a-z]*\_[A-Z][a-z]*/',$name)) return true;

}

function IsEmailFormat($email) {

if (preg_match('/.*|\.@gmail|walla|nana|hotmail|vgames\.com|co\.il/',$email)) return true;

}

function TBSecure($input) {

$denywords = array('mysql.user','FLUSH','GRANT','USER()','SHOW DATABASES','DESCRIBE','INFINE',
'LOCAL','UNLOCK','SET PASSWORD FOR','PRIVILEGS','USEAGE','DATABASE()','SHOW TABLES',
'CREATE','LOAD','LINES','DROP','ALERT','SCRIPT','DOCUMENT','<','>');

foreach($denywords as $word) {
$input = str_replace(strtolower($word),"",$input);
$input = str_replace(strtoupper($word),"",$input);
}
$input = htmlspecialchars($input);
return $input;
}

function print_error($text) {

echo "<table><tr><td><b>Error: </b></td><td>$text<td></tr>";
echo "<tr><td></td><td>You redirected.</td></table>";
header("refresh: 4; url={$_SERVER['HTTP_REFERER']}"); 

}

function print_completed($text, $goto) {
	
echo "<table><tr><td><b>Completed: </b></td><td>$text<td></tr>";
echo "<tr><td></td><td>You redirected.</td></table>";
header("refresh: 4; url=$goto"); 

}

function GetPictureByModelID($model) {

echo "<img src='images/vehs/{$model}.jpg' />";

}

function IsUserConnect() {

if (!isset($_COOKIE['TBCP'])) header('location:index.php');

}

function TB_mail($mail,$subject,$message) {

$design = "<font face='tahoma'>";
$singature = "
<br /><br />
Inifnity RP Team.<br />
- - - - - - - - - - - - - - - - - - - - - --<br />
Our main forums: http://forum.vgames.co.il/forumdisplay.php?f=350<br />
Our server information: http://forum.vgames.co.il/showthread.php?t=1350683<br />
- - - - - - - - - - - - - - - - - - - - - --<br />
</font>
";
$headers  = 'MIME-Version: 1.0' . "\n";
$headers .= 'Content-type: text/html;' . "\n";
$headers .= 'From: Infinity RP Team<no-reply@vgames.co.il>' . "\n";

mail($mail,"[Infinity Role Play] ".$subject, $design.$message.$singature, $headers);

}

// User Enters Log

function getkeywords($thereferrer) {

	$searchengines=Array("search.yahoo p", "google q", "altavista q", "alltheweb q", "search.msn q");
	for($i=0;$i<count($searchengines);$i++){
		$currsearch=split(" ", $searchengines[$i]);
		if(strpos($thereferrer, $currsearch[0])!=false){
			$searchqueries=split("&", split("?", $thereferrer[1]));
			break;
		}
	 }
	if($searchqueries){
		for($i=0;$i<count($searchqueries);$i++){
			if($searchqueries[$i][0]==$currsearch[1]){
				$thekeywords=join(", ", split(" ", urldecode($searchqueries[$i][1])));
				break;
			}
		}
	}

return $thekeywords;
}

function getlanguage($lan) {

$languages=Array("Chinese zh", "Spanish es", "French fr", "Japanese ja", "Italian it", "English en","Hebrew he");
	for($i=0;$i<count($languages);$i++){
		$currlan=split("-", $lan);
		$languagedb=split(" ", $languages[$i]);
		if($currlan[0]==$languagedb[1]){
			$thelanguage=$languagedb[0];
			break;
		}
	}
	if(!$thelanguage) $thelanguage="Other ($lan)";
	return $thelanguage;
}
?>