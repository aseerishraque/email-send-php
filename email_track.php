<?php


include_once('credentials.php');
include('connect.php');

if(isset($_GET["code"]))
{
	$query = "
	UPDATE email_data 
	SET email_status = 'yes', email_open_datetime = '".date("Y-m-d H:i:s", STRTOTIME(date('h:i:sa')))."' 
	WHERE email_track_code = '".$_GET["code"]."' 
	AND email_status = 'no'
	";
	$statement = $connect->prepare($query);
	$statement->execute();
}
header('Content-type: image/jpeg');
echo file_get_contents("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAMAAAAJbSJIAAAAA1BMVEX///+nxBvIAAAASElEQVR4nO3BgQAAAADDoPlTX+AIVQEAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAADwDcaiAAFXD1ujAAAAAElFTkSuQmCC");



?>