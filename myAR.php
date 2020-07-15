<?php

header('Content-Type: text/html; charset=windows-1255');
if (basename($_SERVER['PHP_SELF']) != "index.php") header("location: index.php");

IsUserConnect();

$step = $_GET['step'];
$name = GetNameByCookie();
$file = "$name.NTARUser";
ftp_chdir($ftp_con,"server1/scriptfiles/NTRP/Logs/AR");

		$tempfile = 'tempfile.txt';
		$handle = fopen($tempfile,"w+");
		ftp_get($ftp_con,$tempfile,$file,FTP_ASCII);
		$read = fread($handle,filesize($tempfile));
		fclose($handle);
		if ($read == '') print_error("You dont has a Admin Record");
		else echo "<textarea cols='100' rows='10' disabled>$read</textarea>";
?>