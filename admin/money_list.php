<?php

if (basename($_SERVER['PHP_SELF']) != "index.php") header("location: index.php");

$list = ftp_nlist($ftp_con,'server1/scriptfiles/NTRP/Users');
$step = $_GET['step'];

switch($step) {

	case "1":
		echo "<form method='POST' action='index.php?act=money_list&step=2'><table>";
		echo "<tr><td>Money limit</td><td><input type='text' name='limit'></td></tr>";
		echo "</table><input type='submit' value='Check'></form>";
	break;
		
	case "2":

		$limit = $_POST['limit'];
		echo "<table border='1'><th>Username</th><th>Pocket money</th><th>Bank</th><th>Bag</th></tr>";
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
				if (GetLocalFileKey($tempfile,'Money')>$limit || GetLocalFileKey($tempfile,'Bank')>$limit || GetLocalFileKey($tempfile,'BMoney')>$limit) {
					echo "<tr>";
					echo "<td>", substr($file,31,-7), "</td><td>", GetLocalFileKey($tempfile,'Money'), "</td><td>", GetLocalFileKey($tempfile,'Bank'), "</td><td>",GetLocalFileKey($tempfile,'BMoney'), "</td>";
					echo "</tr>";
					$money+=GetLocalFileKey($tempfile,'Money');
					$bank+=GetLocalFileKey($tempfile,'Bank');
					$bmoney+=GetLocalFileKey($tempfile,'BMoney');
				}
			}
		}
		echo "<tr>";
		echo "<td>Total</td>";
		echo "<td>{$money}</td>";
		echo "<td>{$bank}</td>";
		echo "<td>{$bmoney}</td>";
		echo "</tr>";
		echo "</table>";
	break;

	default:
	header("location: index.php?act=money_list&step=1");
	break;

}
?>