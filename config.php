<?php
error_reporting(0);

//DB Details
DEFINE('HOST', 'localhost'); // DB Host
DEFINE('DBUSERNAME', 'root'); // DB User name
DEFINE('DBPASS',''); //DB Pass

//FTP Details
DEFINE('FTPUSERNAME','gta7'); // FTP User name
DEFINE('FTPPASS','fp5KqoN8s0Tq'); // FTP Pass
DEFINE('FTPIP','213.8.254.139'); // FTP IP
DEFINE('FTPURL','ftp://'.FTPUSERNAME.':'.FTPPASS.'@'.FTPIP); // FTP URL - Username&Pass Included

//Users
DEFINE('USERSDIR', 'server1/scriptfiles/NTRP/Users/'); // Users folder

//Config
DEFINE('INDEX', 'index.php');
$page_title = array(
"index" => "Home Page"
);

////////// Logins

// FTP Login
$ftp_con = ftp_connect('213.8.254.139');
$ftp_log = ftp_login($ftp_con, FTPUSERNAME, FTPPASS);
ftp_pasv($ftp_con, true);

?>