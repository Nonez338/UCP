<?php

if (basename($_SERVER['PHP_SELF']) != "index.php") header("location: index.php");

include '../js/functions.js';

$step = $_GET['step'];
$show = base64_decode($_GET['show']); // User name
$registered = GetNameByCookie();
$userpassword = strtoupper(md5(GetLocalFileKey("../uofusers/waiting-list/$show.uofuser",'password')));
$useremail = GetLocalFileKey("../uofusers/waiting-list/$show.uofuser",'email');
$userbornplace = GetLocalFileKey("../uofusers/waiting-list/$show.uofuser",'bornplace');
$usertries = GetLocalFileKey("../uofusers/waiting-list/$show.uofuser",'tries');
$usertries_after_deny = $usertries--;
$usergender = GetLocalFileKey("../uofusers/waiting-list/$show.uofuser",'gender');
$userage = GetLocalFileKey("../uofusers/waiting-list/$show.uofuser",'age');
$que1 = GetLocalFileKey("../uofusers/waiting-list/$show.uofuser",'que1');
$que2 = GetLocalFileKey("../uofusers/waiting-list/$show.uofuser",'que2');
$que3 = GetLocalFileKey("../uofusers/waiting-list/$show.uofuser",'que3');
$que4 = GetLocalFileKey("../uofusers/waiting-list/$show.uofuser",'que4');
$que1 = str_replace("\n","<br>",$que1);
$que2 = str_replace("\n","<br>",$que2);
$que3 = str_replace("\n","<br>",$que3);
$que4 = str_replace("\n","<br>",$que4);

switch ($step) {
	case '1': // Wait for approving users list
		$openfolder = opendir('../uofusers/waiting-list');
		$files_num=0;
		while (false !== ($file = readdir($openfolder))) {
			if ($file !== '.' && $file !== '..') {
				$files_num++;
			}
		}

		closedir($openfolder);
		if ($files_num==0) {
			echo "<b>There are no users for approving</b>";
		}
		else {
			echo "<table border='1'>";
			echo "<tr><th>#</th><th>Username</th><th>Origin</th><th>Sex</th><th>Age</th><th>Check</th></tr>";
			$files_num=0;
			$openfolder = opendir('../uofusers/waiting-list');
			while (false !== ($file = readdir($openfolder))) {
				if ($file !== '.' && $file !== '..') {
					$files_num++;
					echo "<tr>";
					echo "<td>$files_num</td>";
					echo "<td>", substr($file,0,-8), "</td><td>", GetLocalFileKey('../uofusers/waiting-list/'.$file,'bornplace');
					echo "</td><td>" , GetLocalFileKey('../uofusers/waiting-list/'.$file,'gender');
					echo "</td><td>" , GetLocalFileKey('../uofusers/waiting-list/'.$file,'age');
					echo "</td><td><a href = '?act=approving&step=2&show=" , base64_encode(substr($file,0,-8)) , "'>Check</a></td>";
					echo "</tr>";
				}
			}
			echo "</table>";
			closedir($openfolder);
		}
	break;

	case '2': //Here the user details

		// Did you copied this answers?
		#User Vars
		$compare = 0;
		$user_all_ques = "$que1 $que2 $que3 $que4";
		$user_split = split(" ",$user_all_ques);
		$officialfolder = opendir('../users/'); // Check the officials..
		$waitingfolder = opendir('../uofusers/waiting-list/'); // Check the waiting for approving..

		// Official
		while (false !== ($officialfile = readdir($officialfolder))) {
			if ($officialfile !== '.' && $officialfile !== '..') {
				$res_all_ques = GetLocalFileKey("../users/$officialfile","que1")." ".GetLocalFileKey("../users/$officialfile","que2")." ".GetLocalFileKey("../users/$officialfile","que3")." ".GetLocalFileKey("../users/$officialfile","que4");
				foreach($user_split as $word) {
					if (strpos($res_all_ques,$word,1) > 0 && $show != substr($officialfile,0,-9)) { $compare++; $other .= substr($officialfile,0,-9)." | "; }
				}
			}
		}

		// Waiting list
		while (false !== ($waitingfile = readdir($waitingfolder))) {
			if ($waitingfile !== '.' && $waitingfile !== '..') {
				$res_all_ques = GetLocalFileKey("../uofusers/waiting-list/$waitingfile","que1")." ".GetLocalFileKey("../uofusers/waiting-list/$waitingfile","que2")." ".GetLocalFileKey("../uofusers/waiting-list/$waitingfile","que3")." ".GetLocalFileKey("../uofusers/waiting-list/$waitingfile","que4");
				foreach($user_split as $word) {
					if (strpos($res_all_ques,$word,1) > 0 && $show != substr($waitingfile,0,-8)) { $compare++; $other .= substr($waitingfile,0,-8)." | "; }
				}
			}
		}

		echo "<table>";
		echo "<tr><th><b>Out Of Character</b></th></tr>";
		echo "<tr><th>User Name</th><td><input type='text' value='{$show}'  disabled size='",strlen($useremail),"'></td></tr>";
		echo "<tr><th>Email</th><td><input type='text' value='$useremail' disabled size='",strlen($useremail),"'></td></tr>";
		echo "<tr><th>Try number</th><td><input type='text' value='",6 - $usertries,"/5' disabled></td></tr>";
		echo "<tr><th><b>In Character</b></th></tr>";
		echo "<tr><th>Origin</th><td><input type='text' value='$userbornplace' disabled></td></tr>";
		echo "<tr><th>Gender</th><td><input type='text' value='",($usergender == '1') ? "Male":"Female","' disabled></td></tr>";
		echo "<tr><th>Age</th><td><input type='text' value='$userage' disabled></td></tr>";
		echo "<tr><th>Question 1</th><td>$que1</td></tr>";
		echo "<tr><th>Question 2</th><td>$que2</td></tr>";
		echo "<tr><th>Question 3</th><td>$que3</td></tr>";
		echo "<tr><th>Question 4</th><td>$que4</td></tr>";
		$show = base64_encode($show);
		$other = base64_encode($other);
		echo "<tr><th>Suspected to be copied</th><td>",($compare >= 10) ? "Yes  (<a href='#' onclick='return popitup(\"cmp.php?show=$show&other=$other\",300,1000)'>Compare</a>)" : "No","</td></tr>";
		echo "</table>";

		echo "<a href='?act=approving&step=3&do=1&show=",base64_encode($show),"'>Accept</a><br>";
		echo "<a href='?act=approving&step=3&do=2&show=",base64_encode($show),"'>Deny</a><br>";
		echo "<a href='?act=approving&step=1'>Back</a>";
	break;

	case '3':

		if (!file_exists("../uofusers/waiting-list/$show.uofuser")) print_error("User not found (probably another admin aprove\deny him).");
		else {

		// Approve User
		if ($_GET['do'] == '1') { 
			#Vars
			if ($userskin == "1" && $usersex == "1") $usermodel = $whitemans[array_rand($whitemans)];
			elseif ($userskin == "1" && $usersex == "2") $usermodel = $whitewomans[array_rand($whitewomans)];
			elseif ($userskin == "2" && $usersex == "1") $usermodel = $blackmans[array_rand($blackmans)];
			elseif ($userskin == "2" && $usersex == "2") $usermodel = $blackwomans[array_rand($blackwomans)];
			$id_card = rand(1000000,9999999);

			// Server
			$tempfile = '../templates/firstNTUser.NTUser';
			$file = fopen($tempfile, 'r');
			ftp_fput($ftp_con,'server1/scriptfiles/NTRP/Users/'.$show.'.NTUser',$file,FTP_ASCII);
			SetServerFileKey($ftp_con,USERSDIR,"$show.NTUser","Password",GetLocalFileKey('../uofusers/waiting-list/'.$show.'.uofuser','password'));
			SetServerFileKey($ftp_con,USERSDIR,"$show.NTUser","Origin",GetLocalFileKey('../uofusers/waiting-list/'.$show.'.uofuser','bornplace'));
			SetServerFileKey($ftp_con,USERSDIR,"$show.NTUser","Sex",GetLocalFileKey('../uofusers/waiting-list/'.$show.'.uofuser','gender'));
			SetServerFileKey($ftp_con,USERSDIR,"$show.NTUser","Age",GetLocalFileKey('../uofusers/waiting-list/'.$show.'.uofuser','age'));
			SetServerFileKey($ftp_con,USERSDIR,"$show.NTUser","Model",$usermodel);
			SetServerFileKey($ftp_con,USERSDIR,"$show.NTUser","IDCard",$id_card);
			SetServerFileKey($ftp_con,USERSDIR,"$show.NTUser","Registered",$registered);

			//UCP
			#Vars
			$que1 = str_replace("<br>","\n",$que1);
			$que2 = str_replace("<br>","\n",$que2);
			$que3 = str_replace("<br>","\n",$que3);
			$que4 = str_replace("<br>","\n",$que4);
			$tempfile = '../templates/new_user.TBCPUser';
			copy($tempfile,"../users/".$show.".TBCPUser");
			chmod("../users/$show.TBCPUser",0777);
			SetLocalFileKey("../users/$show.TBCPUser",'Password', $userpassword);
			SetLocalFileKey("../users/$show.TBCPUser",'Email', $useremail);
			SetLocalFileKey("../users/$show.TBCPUser",'que1', $que1);
			SetLocalFileKey("../users/$show.TBCPUser",'que2', $que2);
			SetLocalFileKey("../users/$show.TBCPUser",'que3', $que3);
			SetLocalFileKey("../users/$show.TBCPUser",'que4', $que4);
			unlink("../uofusers/waiting-list/".$show.".uofuser");
			print_completed("User approved","?act=approving");

		}

		elseif ($_GET['do'] == '2') {
			echo "Please enter your deny reason.<br />";
			echo "<form method='post' action='?act=approving&step=3&do=3&show=",base64_encode($show),"'><textarea name='reason' cols='50' rows='5'></textarea><br /><input type='submit' value='Go'></form>";
		}

		//Deny User
		elseif ($_GET['do'] == '3') {
			$reason = $_POST['reason'];

			copy("../templates/uofuser.template","../uofusers/$show.uofuser");
			chmod("../uofusers/$show.uofuser",0777);
			unlink("../uofusers/waiting-list/$show.uofuser");
			SetLocalFileKey("../uofusers/$show.uofuser",'password', $userpassword);
			SetLocalFileKey("../uofusers/$show.uofuser",'email', $useremail);
			SetLocalFileKey("../uofusers/$show.uofuser",'bornplace', $userbornplace);
			SetLocalFileKey("../uofusers/$show.uofuser",'gender', $usergender);
			SetLocalFileKey("../uofusers/$show.uofuser",'tries', $usertries_after_deny);
			SetLocalFileKey("../uofusers/$show.uofuser","reason", $reason);
			print_completed("You denied the user!","?act=approving");
		}
		}

	break;

	default:
	header('location: index.php?act=approving&step=1');
	break;
}
?>
