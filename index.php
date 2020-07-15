<?php
include "header.php";
include "enters_log.php";

// Step 2 Block

//if ($_GET['step'] >= "2" && !strpos($_SERVER['HTTP_REFERER'],"step")) header("location: {$_SERVER['HTTP_REFERER']}");

$a = $_GET['a'];
$user_cookie = $_COOKIE['TBCP'];
$decode_cookie = split('_',base64_decode($_COOKIE['TBCP']));

$page_explain = array(
"login" => "If you already have account, here you can login it.<br />
Don't have an account ? Use <a href='?a=register'>register</a> tab to register our control panel.<br />
<b>* You have to enable cookies.</b>",
"register" => "This is the register page. To register our server, you have to pass few steps:<br />
1. You will have to answer a few questions.<br />
2. Enter your REAL username and email address in the filling boxes, and <a href='?a=login'>login</a> with the password which you'll get to your email.<br />
3. Fill an application form.<br />
<b>* You have to enable sessions.</b>",
"official" => "Welcome to IRP's application, this is the last step of the UCP registeration.<br />
It's recommended to read the rules before trying to fill the application.<br />
Fill in the application below, just in English language. Else, you won't be accepted.<br />
We recommend you to read the question clearly, and to put the most effort as you can.<br />
<b>* If we will find, and we WILL, that you have copied the answer, your account will be permanently banned.</b>",
"rules" => "There are a few rules which you MUST read and follow, before registering our control panel.",
"contact" => "Here you can contact and report to/about IRP team easily.",
"profile" => "You can see your character information below.",
"control" => "In the control panel you can edit your character information.",
"changeemail" => "Change your email address.",
"changepass" => "Change your password.",
"AR" => "My admin record.",
"admins" => "Admins list.<br /><font color='green'>NOTICE : Green colored admins stands for admin which currently in the server.</font>"
);

include "templates/header.tmp";

if (!isset($a)) header('location: index.php?a=index');

switch($a) {

case "register": include "register.php"; break;
case "login": include "login.php"; break;
case "official": include "official.php"; break;
case "profile": include "profile.php"; break;
case "control": include "templates/control.tmp"; break;
case "msg": include "msg.php"; break;
case "admins": include "admins.php"; break;
case "lifestory": include "lifestory.php"; break;
case "AR": include "myAR.php"; break;
case "changepass": include "changepass.php"; break;
case "changeemail": include "changeemail.php"; break;
case "vehicles": include "myvehs.php"; break;
case "weapons": include "myweapons.php"; break;
case "rules": include "rules.php"; break;
case "contact": include "contact.php"; break;
case "players": include "players.php"; break;
case "forum": header('location: http://forum.vgames.co.il/forumdisplay.php?f=350'); break;
case "shoutbox": include "shoutbox.php"; break;
case "adminp": header("location: admin/index.php"); break;
case "back": header("location: javascript:history.go(-2)"); break;
case "index":

if (!isset($user_cookie)) {
echo <<<end
Hello, Guest!<br />
Welcome to Infinity RolePlay User Control Panel.<br />
If you are already registered, please <a href="index.php?a=login">login</a>.<br />
If you are not registered, please <a href='index.php?a=register'>register</a>.<br />
You can also read our <a href='index.php?a=rules'>server rules</a>.<br />
Enjoy.
end;
}

else {

if (!file_exists("users/{$decode_cookie[0]}_{$decode_cookie[1]}.TBCPUser")) { setcookie("TBCP","",time()-3600); header("location: index.php"); }
if (GetServerFileKey($ftp_con,USERSDIR,$username."NTUser","Bans") > 0) { setcookie("TBCP","",time()-3600); header("location: index.php"); }

/*

$openfolder = opendir("admin/msg");
$msg_num=0;
while (false !== ($file = readdir($openfolder))) {
if ($file !== '.' && $file !== '..') {
$msg_num++;
if ($msg_num==1) $msg_title = substr($file,0,-8);
}
}

*/

//Last Message in Chat
$open = fopen("shout.txt","r");
$read = fread($open,filesize("shout.txt"));
$split = split("\n",$read);
$split2 = split(": ",$split[0]);
$last_msg = split("<",$split2[1]);

//if ($msg_num > 0) echo "<a href=\"#\" onclick=\" return msgpop('msg.php?show=all')\">There are $msg_num admin's messages.</a><br />";
echo "Hello {$decode_cookie[0]} {$decode_cookie[1]}.<br />";
echo "<a href=\"#\" onclick=\" return chatpop('shoutbox.php')\">Chat with other players</a> ! (Last message: <i>`{$last_msg[0]}`)</i><br />";
echo "You can visit your <a href='?a=profile'>profile</a>, or <a href='?a=control'>control</a> it.<br />";
echo "And either, <a href='?a=contact'>contact</a> us.<br />";
}

break;

default: header("location: ?a=index"); break;
}



include "templates/footer.tmp";

?>