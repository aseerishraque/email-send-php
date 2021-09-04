<?php
session_start();

include_once('credentials.php');
include_once('connect.php');
$message = '';
if(isset($_SESSION['message'])){
	$message = $_SESSION['message'];
	unset($_SESSION['message']);
}

function getEmailList($connect)
{
	$query = "SELECT * FROM email_configs ORDER BY id";
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$total_row = $statement->rowCount();
	$output = '
	<div class="table-responsive">
		<table class="table table-bordered table-striped">
			<tr>
				<th width="25%">Company</th>
				<th width="25%">Email</th>
				<th width="25%">Host Server</th>
				<th width="10%">Port Number</th>
				<th width="20%">Action</th>
			</tr>
	';
	if($total_row > 0)
	{
		foreach($result as $row)
		{
			$output .= '
				<tr>
					<td>'.$row["mail_company"].'</td>
					<td>'.$row["mail"].'</td>
					<td>'.$row["mail_host"].'</td>
					<td>'.$row["mail_port"].'</td>
					<td>
                    <a href="edit_email.php?id='.$row['id'].'" class="btn btn-primary">Edit</a>
                    <a href="process.php?delete_email=1&id='.$row['id'].'" class="btn btn-danger">Delete</a>
                    </td>
				</tr>
			';
		}
	}
	else
	{
		$output .= '
		<tr>
			<td colspan="4" align="center">No Email Data Found</td>
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
			<h3 class="text-center">Email List</h3>
			<br />
            <a style="margin-bottom:5px" class="btn btn-primary" href="index.php">Home</a>
            <a style="margin-bottom:5px;float:right" class="btn btn-primary" href="create_email.php">Add New Email Configuration</a>
			<div class="row">
				<div class="col-md-12">
				<?php
			
                    echo $message;
                    echo getEmailList($connect);

		    	?>
				
				</div>
			</div>
			
		
			
		</div>
		<br />
		<br />
	</body>
</html>