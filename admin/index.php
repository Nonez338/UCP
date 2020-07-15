<?php

session_start();
include '../header.php';
$act = $_GET['act'];

//Are You Admin?
if (GetAdminLevel($ftp_con,GetNameByCookie()) < 1) header("location: ../index.php");

// So Log in with the global password..
$true_pass = GetLocalFileKey("../inc/config.inc","ACPP");
if (!isset($_SESSION['global_pass']) || $_SESSION['global_pass'] != md5($true_pass)) {
if ($act != "login") header("location: index.php?act=login");
}

$user_cookie = $_COOKIE['TBCP_Login'];
$decode_cookie = split('_',base64_decode($_COOKIE['TBCP_Login']));

$page_explain = array(
"login" => "Dear admin, Please enter the global password that you got with the SMS.",
"users" => "Users functions.",
"user_add" => "User add.",
"user_edit" => "Users edit.",
"approving" => "Here is the list of the users that are waiting for testers approving.",
"ban_info" => "Information about banned users",
"user_info" => "Information about users",
"mail" => "Mass mail to all IRP users",
"say" => "Server rcon `say` command",
"factions" => "Factions lists.",
"records" => "Team meeting records.",
"statics" => "UCP statics",
"unban" => "Unban a user.",
"unbanip" => "Unban a IP.",
"reports" => "Users reports",
"logs" => "Server/UCP logs"
);

$page_access = array(
"user_add" => 15,
"user_edit" => 15,
"approving" => 3,
"ban_info" => 3,
"user_info" => 8,
"mail" => 8,
"say" => 15,
"factions" => 5,
"statics" => 15,
"unban" => 3,
"unbanip" => 3,
"msg" => 15,
"ban_list" => 10,
"money_list" => 10,
"reports" => 15,
"logs" => 20
);

include "../templates/admin/header.tmp";

if (!isset($act)) header('location: index.php?act=index');

if (GetAdminLevel($ftp_con,GetNameByCookie()) < $page_access[$act]) print_error("You have not access to this page");
else {

ftp_up($ftp_con,4);

switch($act) {

case "UCP": header("location: ../index.php"); break;
case "login": include "login.php"; break;
case "users": include "../templates/admin/users.tmp"; break;
case "user_add": include "user_add.php"; break; 
case "user_edit": include "user_edit.php"; break;
case "approving": include "approving.php"; break; 
case "ban_list": include "ban_list.php"; break; 
case "ban_info": include "ban_info.php"; break; 
case "money_list": include "money_list.php"; break;
case "user_info": include "user_info.php"; break;
case "mail": include "mass_mail.php"; break; 
case "say": include "say.php"; break; 
case "factions": include "factions.php"; break;
case "records": include "staff_recs.php"; break;
case "msg": include "msg.php"; break;
case "ipcheck": include "ipcheck.php"; break;
case "statics": include "statics.php"; break;
case "global_options": include "global_options.php"; break;
case "unban": include "unban.php"; break;
case "unbanip": include "unbanip.php"; break;
case "slock": include "slock.php"; break;
case "reports": include "reports.php"; break;
case "logs": include "logs.php"; break;
case "msgbox":
$open = fopen("msgbox.txt","w"); 
fwrite($open,$_POST['msgbox']);
fclose($open);
// Log it
if (filesize("../logs/msgbox.TBLog") > 6666666) unlink("../logs/msgbox.TBLog"); // 1/3 OF 10 MB
$open=fopen("../logs/msgbox.TBLog", "a");
$log = GetNameByCookie()." edited the box and wrote: `{$_POST['msgbox']}`\n";
fwrite($open, $log);
fclose($open);
header("location: {$_SERVER['HTTP_REFERER']}");
break;

case "index":

echo "Hello {$decode_cookie[0]} {$decode_cookie[1]}.<br />";
echo "This is the ACP (admin control panel) of IRP.<br />";
echo "Here you can <a href='?act=user_add'>add users</a>, <a href='?act=user_edit'>edit users</a> and use another functions of the panel.<br />";
echo "You can also visit the server <a href='?act=statics'>statics</a>.<br />";
echo "<a href='index.php?act=say'>Say something to the server.</a><br />";

break;

default: header("location: ?act=index"); break;

}

}
include "../templates/admin/footer.tmp";
?>