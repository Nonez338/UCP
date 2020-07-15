<?php

if (basename($_SERVER['PHP_SELF']) != "index.php") header("location: index.php");

include "passg.inc";
include "inc/american_quiz.inc";
$step = $_GET['step'];

$quesnum = 10;

function print_quiz($id,$title,$name,$ans1,$ans2,$ans3) {
echo "<b>$title</b><br />";
	for ($i=0; $i < 3; $i++) {
	$randq = rand(1,3);
	while (in_array($randq, $randqnum)) {
		$randq = rand(1,3);
	}
switch($randq) {
case "1": echo "<input name='$name' type='radio' value='a'>$ans1<br />"; break;
case "2": echo "<input name='$name' type='radio' value='b'>$ans2<br />"; break;
case "3": echo "<input name='$name' type='radio' value='c'>$ans3<br />"; break;
}
$randqnum[] = $randq;
}
echo "<br />";
}

switch ($step) {
	
	case '1':
	if (GetLocalFileKey("inc/config.inc","Register_Locked") == "1") print_error("The lead.admin locked the register");

	echo "<form method='post' action='?a=register&step=2'>";
	for ($i=0; $i < $quesnum; $i++) {
	$rand = rand(1,$quesnum);
	while (in_array($rand, $randnum)) {
		$rand = rand(1,$quesnum);
	}
	print_quiz($rand,$titles[$rand],"Q".$rand,$ans1[$rand],$ans2[$rand],$ans3[$rand]);
	$randnum[] = $rand;
	}
	echo "<br><input type='submit' value='Go'></form>";
	break;
	
	case '2':

		for ($i=1; $i <= $quesnum; $i++) {
			if ($_POST['Q'.$i] == '') print_error("You have to fill all the questions");
			if ($_POST['Q'.$i] != $right_answer[$i]) $wrongs++;
		}
		if ($wrongs > 0) {
			print_error($wrongs.'/'.$quesnum." wrong answers");
		}
		else {
			echo "<form method='post' action='?a=register&step=3'><table>
			<tr><td>Username</td><td><input type='text' name='username'></td></tr>
			<tr><td>Email</td><td><input type='text' name='useremail'></td></tr>
			</table>
			<input type='submit' value='Go'>
			</form>";
		}

	break;

	case '3':

	$username = TBSecure($_POST['username']);
	$useremail = $_POST['useremail'];
	$open = fopen("mails.phplist","r");
	$read = fread($open,filesize("mails.phplist"));
	if ($username == '' || $useremail == '') header('location: ?a=register');
	elseif (!IsRPName($username)) print_error("Choose a name in Firstname_Lastname format.");
	elseif (!IsEmailFormat($useremail)) print_error("Choose an email in `UCP@vgames.co.il` format.");
	elseif (file_exists('users/'.$username.'.TBCPUser') || file_exists('uofusers/'.$username.'.uofuser') || file_exists('uofusers/waiting-list/'.$username.'.uofuser')) print_error("This username already in use.");
	elseif(strpos($read,$useremail)) print_error("This email already in use.");
	
	else {
	copy('templates/uofuser.template','uofusers/'.$username.'.uofuser');
	SetLocalFileKey('uofusers/'.$username.'.uofuser','email',$useremail);
	SetLocalFileKey('uofusers/'.$username.'.uofuser','password',strtoupper(md5($codeg)));
	
	//Mail Sending - START
	
	$subject = "user registeration";
	$message = "
	You successfully registered to Infinity RP user control panel!<br />
	Click <a href='http://{$_SERVER['HTTP_HOST']}/2/index.php?a=login'>here</a> to continue to the next step of the registeration.<br />
	<b>User name:</b> {$username}<br />
	<b>Password:</b> {$codeg}<br />
	";
	$mail = TB_mail($useremail, $subject, $message);

	// Mail Sending - END
	// Add email

//	header('Content-Type: text/plain');
	$open = fopen("mails.phplist","r+");
	fwrite($open,"$username=$useremail\n");
	fclose($open);
	
		print_completed("Your password has been sent to your E-mail box, please check it.","?a=official");
}
break;
	default: header('location: ?a=register&step=1');
}
?>