<?php

header('Content-Type: text/html; charset=utf-8');
include 'functions.php';
include 'config.php';
include "agent_direct.php";

// תפסיקו לערוך את הקובץ, תודה.
$allowed_ip = array("8c2882fd4fa2c4069b236d803016bac8","0557b68890f3336059d28acc91970f8e","222eb5ed0043e378398a3ea502f0f565","d5692bdfc3d21a06f09caf36a9bcc247","da32900a65065d2a60f008a0a040460d","45b25a900ca6857ded6d76bbb7e8ccea ");
if (!in_array(md5(base64_encode($_SERVER['REMOTE_ADDR'])),$allowed_ip)) die("Access Denied!");

?>