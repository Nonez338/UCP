<?php

if (basename($_SERVER['PHP_SELF']) != "index.php") header("location: index.php");

IsUserConnect();

$step = $_GET['step'];
$stories_dir = "lifestories/";
$file = $stories_dir.GetNameByCookie().".TBUCPLS";
$story_count = GetLocalFileKey("users/".GetNameByCookie().".TBCPUser","Storycount");
$story_date = GetLocalFileKey("users/".GetNameByCookie().".TBCPUser","Storydate");

switch($step) {

	case '0':

	echo "<a href='?a=lifestory&step=1'>My life story</a><br />";
	echo "<a href='?a=lifestory&step=2'>Edit my life story</a><br />";
	echo "<a href='?a=lifestory&step=4'>Find another story</a><br />";

	break;

	case '1':

		if ($story_count > 0) {
		if (strtotime(date('m/d/Y')) > strtotime($story_date)) {
		if(file_exists($file)) {
			echo "<b>My life story:</b><br />";
			$handle = fopen($file,"r");
			$read = TBSecure(fread($handle,filesize($file)));
			if ($read == '') print_error("You dont has a life story. Please Write one.");
			echo nl2br($read);
			fclose($handle);
		}
		else print_error("You don't have a life story, you are being directed to life story editing.");
		}
		else print_error("You can't use the 'Life Story' tab, it is currently blocked for you to use until $story_date");
		}
		else print_error("You can't use the 'Life Story' tab, it is currently blocked for you!");

	break;
	case '2':

		if ($story_count > 0) {
		if (strtotime(date('m/d/Y')) > strtotime($story_date)) {

			echo "<b>Edit my life story:</b><br />";
			$handle = fopen($file,"r");
			$read = TBSecure(fread($handle,filesize($file)));
			echo "<form method='POST' action='?a=lifestory&step=3'>
			<textarea name='story' cols='100' rows='10' >$read</textarea><br />
			<input type='submit' value='Go'>
			</form>";

		}
		else print_error("You can't use the 'Life Story' tab, it is currently blocked for you to use until $story_date");
		}
		else print_error("You can't use the 'Life Story' tab, it is currently blocked for you!");
	break;
	case '3':

		$handle = fopen($file,"w+");
		fwrite($handle,$_POST['story']);
		print_completed("Your life story had successfully updated.","?a=lifestory&step=index");

	break;
	case '4':

		if ($story_count <= 0) print_error("You can't use the 'Life Story' tab, it is currently blocked for you to use until $story_date");
		if (strtotime(date('m/d/Y')) < strtotime($story_date)) print_error("You can't use the 'Life Story' tab, it is currently blocked for you!");

		echo "Enter user name <form method='GET'>
		<input type='hidden' name='step' value='5'>
		<input type='hidden' name='a' value='lifestory'>
		<input type='text' name='show'><br />
		<input type='submit' value='Go'>
		</form>";

	break;
	case '5':

	$show = $_GET['show'];
	$file = $stories_dir.$show.".TBUCPLS";

		if (file_exists(($file))) {
			$handle = fopen($file,"r");
			$read = TBSecure(fread($handle,filesize($file)));
			echo "{$_GET['show']}'s life story:<br />";
			echo "<textarea cols='100' rows='10' disabled>$read</textarea><br />";
			if (GetAdminLevel($ftp_con,GetNameByCookie()) >= 5) {
				echo "AA:<br />
				User's reset counter until block: ", GetLocalFileKey("users/$show.TBCPUser","Storycount"),
				 "<br /><a href='?a=lifestory&step=6&show=$show'>Reset life story</a>";
			}
		}
		else {
		print_error("User dont has a life story");
		}

	break;

	case '6':

		$show = $_GET['show'];

		// Count down
		$story_count = GetLocalFileKey("users/$show.TBCPUser","Storycount");
		$story_count--;
		SetLocalFileKey("users/$show.TBCPUser","Storycount", $story_count);

		//Reset the story
		$open = fopen("$stories_dir$show.TBUCPLS","w");
		fclose($open);

		$admin_name = GetNameByCookie();
		$user_email = GetLocalFileKey("users/$show.TBCPUser","Email");
		$date = date("m/d/Y - h:i");
		$subject = "Your life story reseted";

		$message = "
		<font face='tahoma'>
		Hello $show,<br />This mail sent to let you know that your life story reseted.<br />
		Your life story reseted by admin $admin_name on $date.<br />
		You have more $story_count times until 'life story' option will be blocked for your user.<br />
		";

		switch ($story_count) {

		case "2":

		$nextweek = time() + (7 * 24 * 60 * 60);
		$nextweek = date('m/d/Y - h:i', $nextweek);
		$nextweek2 = date('m/d/Y', $nextweek);
		$message .= "</br><b>*This is the 3rd time, 'story life' option is blocked to you until $nextweek.</b>";
		SetLocalFileKey("users/$show.TBCPUser","Storydate", $nextweek2);

		break;

		case "0":

		$message .= "</br><b>*This is the 5th time, 'story life' option is blocked to you.</b>";

		break;

		}

		$message .="</font>";

		TB_mail($user_email, $subject, $message);
		
		print_completed("Reset Successfully","?a=lifestory");

	break;
	default:
	header('location: ?a=lifestory&step=0');
	break;
}

?>