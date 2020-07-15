<?php

if (basename($_SERVER['PHP_SELF']) != "index.php") header("location: index.php");

$step = $_GET['step'];
$open = fopen("../mails.phplist","r");
$read = fread($open,filesize("../mails.phplist"));
$split = split("\n",$read);

switch($step) {

	case "1":
		echo "<form method='POST' action='index.php?act=mail&step=2'><table>";
		echo "<tr><td>From</td><td><input type='text' value='Infinity RolePlay Management' size='25' readonly></td></tr>";
		echo "<tr><td>To</td><td><textarea name='to' cols='70' rows='8' readonly>";
		foreach($split as $line) {
		$sub_split = split("=",trim($line));
		echo $sub_split[1],", ";
		}
		echo "</textarea></td></tr>";
		echo "<tr><td>Subject</td><td><input type='text' name='subject'></td></tr>";
		echo "<tr><td>Text</td><td><textarea name='text' cols='70' rows='8'></textarea></td></tr>";
		echo "</table><input type='submit' value='Send'></form>";
	break;

	case "2":
		$to = $_POST['to'];
		$subject = $_POST['subject'];
		$text = $_POST['text'];
		if ($to == '' || $subject == '' || $text == '') print_error("Please fill all the fileds");
		else {
		TB_mail($to,$subject,"<font face='tahoma'>".nl2br($text)."</font>");
		print_completed("Mass mail sent","index.php");
		}
	break;

	default:
	header("location: index.php?act=mail&step=1");
	break;

}

?>