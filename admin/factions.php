<?php

if (basename($_SERVER['PHP_SELF']) != "index.php") header("location: index.php");

include "../inc/jobs.inc";
IsUserConnect();

$faction = $_GET['faction'];
$step = $_GET['step'];

switch($step) {

	case "1":
		echo "<a href='index.php?act=factions&step=2&faction=LSPD'>Los Santos Police Department</a><br />";
		echo "<a href='index.php?act=factions&step=2&faction=LSES'>Los Santos Emergency Service</a><br />";
		echo "<a href='index.php?act=factions&step=2&faction=LSFD'>Los Santos Fire Department</a><br />";
		echo "<a href='?act=factions&step=2&faction=FBI'>Federal Bureau of Investigation</a><br />";
		echo "<a href='index.php?act=factions&step=2&faction=Mechanic'>Los Santos Mechanic</a><br />";
		echo "<a href='index.php?act=factions&step=2&faction=News'>Los Santos News</a><br />";
		echo "<a href='index.php?act=factions&step=2&faction=Transportation'>Los Santos Transportation</a><br />";
	break;

	case "2":
		if (in_array($faction,$factions)) {
			echo "<table border='1'><tr><td>Name</td><td>Rank</td><td>Fire</td></tr>";
			$file = $faction.".NTFile";
			ftp_chdir($ftp_con,"server1/scriptfiles/NTRP/Jobs");
			$tempfile = 'tempfile.txt';
			$handle = fopen($tempfile,"w+");
			ftp_get($ftp_con,$tempfile,$file,FTP_ASCII);
			$read = fread($handle,filesize($tempfile));
			fclose($handle);
			$split = split("\n",trim($read));
			foreach($split as $split2) {
				if ($split2 != "") {
				$sub_split = split("=",$split2);
				echo "<tr><td>$sub_split[0]</td><td>{$factions[$faction][$sub_split[1]]}</td><td><a href='index.php?act=factions&step=3&faction=$faction&rank={$sub_split[1]}&username=".base64_encode($sub_split[0])."'>Fire</a></td></tr>";
				}
			}
			echo "</table>";
		}
		else header("location: index.php?act=factions");
	break;

	case "3":

		$username = base64_decode($_GET['username']);
		$faction = $_GET['faction'];
		$file = $faction.".NTFile";
		$rank = $_GET['rank'];
		$tempfile = 'tempfile.txt';

		ftp_chdir($ftp_con,"server1/scriptfiles/NTRP/Jobs");
		$handle = fopen($tempfile,"w+");
		ftp_get($ftp_con,$tempfile,$file,FTP_ASCII);
		$read = fread($handle,filesize($tempfile));
		$read = trim(str_replace("$username=$rank","",$read));
		fclose($handle);
		$handle = fopen($tempfile,"w+");
		fwrite($handle,trim($read));
		fclose($handle);
		ftp_put($ftp_con,$file,$tempfile,FTP_ASCII);
		print_completed("User fired","index.php?act=factions");
	break;

	default:
	header("location: index.php?act=factions&step=1");
	break;
}
?>