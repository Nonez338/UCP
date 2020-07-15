<?php

include "functions.php";

$show = $_GET['show'];

echo "<head>
	<title>Inifnity RolePlay - Vgames</title>
	<link rel='stylesheet' type='text/css' href='css/style.css' />
</head>";

if ($show == "all") {
		$msg_num=0;
		echo "<table border='1'><tr><td>#</td><td>Title</td></tr>";
		$openfolder = opendir("admin/msg");
		while (false !== ($file = readdir($openfolder))) {
			if ($file !== '.' && $file !== '..') {
				$msg_num++;
				echo "<tr><td>$msg_num</td><td><a href=\"msg.php?show=",base64_encode(substr($file,0,-8)),"\">",substr($file,0,-8),"</a></td></tr>";
			}
		}
		echo "</table>";
}


else {
$show = base64_decode($show);

if (file_exists("admin/msg/$show.TBCPMsg")) {

$open = fopen("admin/msg/$show.TBCPMsg","r");
$read = fread($open,filesize("admin/msg/$show.TBCPMsg"));
echo nl2br("<b><u>$show</u></b><br />$read");

}

else {
echo "<body onload='window.close()' />";
}

}
echo "<br /><br /><center><a href='javascript: history.go(-1)'>Back</a><br /><a href='#' onclick='window.close()'>Close</a></center>";
?>