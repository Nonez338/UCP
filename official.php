<?php

if (basename($_SERVER['PHP_SELF']) != "index.php") header("location: index.php");

session_start();
$user_cookie = $_COOKIE['user_cookie'];

$step = $_GET['step'];
$user_name = $_SESSION['username'];
$user_password = $_SESSION['userpassword'];

if (!isset($user_name) || !file_exists('uofusers/'.$user_name.'.uofuser')) header('location: index.php');

switch ($step) {
	case '1':

	$user_email = GetLocalFileKey('uofusers/'.$user_name.'.uofuser','email');
	$tries = GetLocalFileKey('uofusers/'.$user_name.'.uofuser','tries');
	$deny_reason = GetLocalFileKey('uofusers/'.$user_name.'.uofuser',"reason");
	$deny_reason = str_replace("\n","<br>",$deny_reason);

				if ($tries < 5) {
echo "<table><tr><th><u>Last deny reason</u></th></tr><tr><td>{$deny_reason}<br />You got {$tries} attempts to be official.</td></tr></table>";
				}
					if ($tries > '0') {
echo "<form method='post' action='?a=official&step=2'>";
echo "<table>";

// OOC Part
echo "<tr><td><b><u>Out Of Character</u></b></td></tr>";
echo "<tr><th>User name</th><td><input type='text' name='username' value='{$user_name}'  readonly size='{strlen($user_email)}'></td></tr>";
echo "<tr><th>Email</th><td><input type='text' name='useremail' value='{$user_email}' readonly size='{strlen($user_email)}'></td></tr>";

// IC Part
echo "<tr><td><b><u>In Character</u></b></td></tr>";
echo "<tr><th>Origin</th>";
echo "<td><select name='bornplace'>
<option value='Israel'>Israel</option>
<option value='USA'>USA</option>
<option value='Italy'>Italy</option>
<option value='Mexico'>Mexico</option>
<option value='Russia'>Russia</option>
<option value='China'>China</option>
<option value='England'>England</option>
<option value='Spain'>Spain</option>
</select></td></tr>";
echo "<tr><th>Gender</th><td><select name='gender'><option value='1'>Male</option><option value='2'>Female</option></select></td></tr>";
echo "<tr><th>Age</th><td><input type='text' name='age' maxlength='2' size='2'></td></tr>";

echo "</table><table>";

// Application Part
echo "<tr><td><b><u>Application</u></b></td></tr>";
echo "<tr><th>For how long are you roleplaying ?<br />
Did you played in IRP or in other servers (Global servers, not just israel) before ?<br />
If yes, what was your name there ?</th></tr>";
echo "<tr><td><textarea name='que1' cols='50' rows='5'></textarea></td></tr>";
echo "<tr><th>What does Powergaming, Deathmatching stand for and why do they aren't allowed ?</th></tr>";
echo "<tr><td><textarea name='que2' cols='50' rows='5'></textarea></td></tr>";
echo "<tr><th>Explain more 3 basic terms that every roleplayer needs to know.</th></tr>";
echo "<tr><td><textarea name='que3' cols='50' rows='5'></textarea></td></tr>";
echo "<tr><th>What is your In Character's roleplay background ?<br />How did your character reach Los Santos, and why ?</th></tr>";
echo "<tr><td><textarea name='que4' cols='50' rows='5'></textarea></td></tr>";
echo "</table>";
echo "<input type='submit' name='submit' value='Go'></form>";
						}
else print_error('User locked, You reached your maximum register tries','index.php');

	break;
	case '2':

#Vars
$username = $_POST['username'];
$useremail = $_POST['useremail'];
$allowed_bornplaces = array("Israel","USA","Italy","Mexico","Russia","China","England","Spain");
$bornplace = (in_array($_POST['bornplace'],$allowed_bornplaces)) ? $_POST['bornplace'] : "Israel";
$gender = $_POST['gender'];
$age = $_POST['age'];
$que1 = $_POST['que1'];
$que2 = $_POST['que2'];
$que3 = $_POST['que3'];
$que4 = $_POST['que4'];

$tries = GetLocalFileKey('uofusers/'.$username.'.uofuser','tries');

		if ($tries > '0') {

chmod("uofusers/$username.uofuser",0777);
copy('uofusers/'.$username.'.uofuser','uofusers/waiting-list/'.$username.'.uofuser');

SetLocalFileKey('uofusers/waiting-list/'.$username.'.uofuser',"bornplace",$bornplace);
SetLocalFileKey('uofusers/waiting-list/'.$username.'.uofuser',"gender",$gender);
SetLocalFileKey('uofusers/waiting-list/'.$username.'.uofuser',"age",$age);
SetLocalFileKey('uofusers/waiting-list/'.$username.'.uofuser',"que1",$que1);
SetLocalFileKey('uofusers/waiting-list/'.$username.'.uofuser',"que2",$que2);
SetLocalFileKey('uofusers/waiting-list/'.$username.'.uofuser',"que3",$que3);
SetLocalFileKey('uofusers/waiting-list/'.$username.'.uofuser',"que4",$que4);


// Too many `waiting-users`?
$openfolder = opendir("uofusers");
$users_num=0;
while (false !== ($file = readdir($openfolder))) {
if ($file !== '.' && $file !== '..') {
$users_num++;
}
}

if ($users_num >= 100 && substr($users_num,-2) == "00") TB_mail("talbeno.irp@gmail.com,eliranvg@gmail.com,gil@vgames.co.il","Warning - Too much `waiting for approving` users","Dear Managment,<br />There are $users_num users that are waiting for approving.<br />Please take care.");

unlink('uofusers/'.$username.'.uofuser');

print_completed("Aplication sent. You can login to check your status.","?a=login");

}
else print_error('User locked, You reached your maximum register tries','index.php');

break;
	default: header('location: ?a=official&step=1');
break;
}

?>