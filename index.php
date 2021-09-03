<?php


include_once('credentials.php');
include_once('connect.php');
$message = '';

if(isset($_POST["send"]))
{
	require 'class/class.phpmailer.php';
	$mail = new PHPMailer;
	$mail->IsSMTP();
	$mail->Mailer = "smtp";
	// $mail->Host = 'smtpout.secureserver.net';

	$mail->SMTPDebug  = 0;  
	$mail->SMTPSecure = "tls";	

    //Gmail  host
// 	$mail->Host = 'smtp.gmail.com'; 

    //Outlook host 1
    $mail->Host = 'smtp.office365.com'; 
    
    //Outlook host 2
//  $mail->Host = 'smtp-mail.outlook.com'; 
    
	$mail->Port = '587';
	$mail->SMTPAuth = true;
	$mail->Username = $username_email_from;
	$mail->Password = $user_password;
	$mail->From = $username_email_from;
	$mail->FromName = $from_name;
	$mail->AddAddress($_POST["receiver_email"]);
	$mail->WordWrap = 50;
	$mail->IsHTML(true);
	$mail->Subject = $_POST['email_subject'];
	$track_code = md5(rand());
	$message_body = $_POST['email_body'];
	$message_body .= '<img src="'.$base_url.'email_track.php?code='.$track_code.'" width="100" height="100" />';
	$mail->Body = $message_body;
	if($mail->Send())
	{
		$data = array(
			':email_subject'			=>		$_POST["email_subject"],
			':email_body'				=>		$_POST["email_body"],
			':email_address'			=>		$_POST["receiver_email"],
			':email_track_code'			=>		$track_code
		);
		$query = "
		INSERT INTO email_data 
		(email_subject, email_body, email_address, email_track_code) VALUES 
		(:email_subject, :email_body, :email_address, :email_track_code)
		";

		$statement = $connect->prepare($query);
		if($statement->execute($data))
		{
			$message = '<div class="alert alert-success" role="alert">Email Send Successfully</div>';
		}
	}
	else
	{
		$message = '<div class="alert alert-danger" role="alert">Email Sending Error</div>';
	}
	

}

function getEmailData($connect)
{
	$query = "SELECT * FROM email_data ORDER BY email_id";
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$total_row = $statement->rowCount();
	$output = '
	<div class="table-responsive">
		<table class="table table-bordered table-striped">
			<tr>
				<th width="25%">Email</th>
				<th width="45%">Subject</th>
				<th width="10%">Status</th>
				<th width="20%">Open Datetime</th>
			</tr>
	';
	if($total_row > 0)
	{
		foreach($result as $row)
		{
			$status = '';
			if($row['email_status'] == 'yes')
			{
				$status = '<span class="label label-success">Open</span>';
			}
			else
			{
				$status = '<span class="label label-danger">Not Open</span>';
			}
			$output .= '
				<tr>
					<td>'.$row["email_address"].'</td>
					<td>'.$row["email_subject"].'</td>
					<td>'.$status.'</td>
					<td>'.$row["email_open_datetime"].'</td>
				</tr>
			';
		}
	}
	else
	{
		$output .= '
		<tr>
			<td colspan="4" align="center">No Email Send Data Found</td>
		</tr>
		';
	}
	$output .= '</table>';
	return $output;
}


?>
<!DOCTYPE html>
<html>
	<head>
		<title>Simple Php script to send email</title>
		<script src="jquery.min.js"></script>
		<link rel="stylesheet" href="bootstrap.min.css" />
		<script src="bootstrap.min.js"></script>
	</head>
	<body>
		
		<br />
		<div class="container">
			<h3 class="text-center">Simple Php script to send email</h3>
			<br />
			<div class="row">
				<div class="col-md-6">
				<?php
			
				echo $message;

				?>
				<form method="post">
				<div class="form-group">
					<label>Enter Email Subject</label>
					<input type="text" name="email_subject" class="form-control" required />
				</div>
				<div class="form-group">
					<label>Enter Receiver Email</label>
					<input type="email" name="receiver_email" class="form-control" required />
				</div>
				<div class="form-group">
					<label>Enter Email Body</label>
					<textarea name="email_body" required rows="5" class="form-control"></textarea>
				</div>
				<div class="form-group">
					<input type="submit" name="send" class="btn btn-primary" value="Send Email" />
				</div>
				</form>
				</div>
			</div>
			
			<br />
			<h4 class="text-center">Email Read Status</h4>
			<?php 
			
			echo getEmailData($connect);

			?>
		</div>
		<br />
		<br />
	</body>
</html>