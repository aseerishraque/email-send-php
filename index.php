<?php
session_start();

include_once('credentials.php');
include_once('connect.php');
$message = '';
if(isset($_SESSION['message'])){
	$message = $_SESSION['message'];
	unset($_SESSION['message']);
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

function getEmailList($connect){
	$query = "SELECT * FROM email_configs ";
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$total_row = $statement->rowCount();
	$output = '';
	if($total_row > 0)
	{
		foreach($result as $row)
		{
			$output .= '
				<option value="'.$row['id'].'">'.$row['mail'].' - '.$row['mail_company'].'</option>
			';
		}
	}
	else
	{
		$output .= '
				<option> No Emails</option>
			';
	}
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
				<form action="send_email.php" method="post">
				<div class="form-group">
					<label>Select Email</label>
					<select class="form-control" required name="selected_mail_id">
						<option value="">Select Email</option>
						<?php 
			
						echo getEmailList($connect);

						?>
					</select>
				</div>
				<div class="form-group">
					<label>Enter Email Subject</label>
					<input required type="text" name="email_subject" class="form-control" required />
				</div>
				<div class="form-group">
					<label>Enter Receiver Email</label>
					<input required type="email" name="receiver_email" class="form-control" required />
				</div>
				<div class="form-group">
					<label>Enter Email Body</label>
					<textarea required name="email_body" required rows="5" class="form-control"></textarea>
				</div>
				<div class="form-group">
					<input type="submit" name="send" class="btn btn-primary" value="Send Email" />
				</div>
				</form>
				</div>
			</div>
			
			<br />
			<h5>
				<a class="btn btn-info" href="email_list.php">Email List</a>
			</h5>
			<h4 class="text-center">Email Read Status</h4>
			<?php 
			
			echo getEmailData($connect);

			?>
		</div>
		<br />
		<br />
	</body>
</html>