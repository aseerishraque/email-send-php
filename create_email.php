<?php
session_start();

include_once('credentials.php');
include_once('connect.php');
$message = '';
if(isset($_SESSION['message'])){
	$message = $_SESSION['message'];
	unset($_SESSION['message']);
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
			<h3 class="text-center">Create Email Configuration</h3>
			<br />
            <a style="margin-bottom:5px" class="btn btn-primary" href="index.php">Home</a>
			<div class="row">
				<div class="col-md-6">
				<?php
                    echo $message;
		    	?>
				<form action="process.php" method="post">
                    <div class="form-group">
                        <Label>Select Email Company</Label>
                        <select class="form-control" required name="mail_company">
                            <option value="">Select Company</option>
                            <option value="Outlook">Outlook</option>
                            <option value="Gmail">Gmail</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <Label>Email</Label>
                        <input class="form-control" type="text" name="mail" placeholder="Enter Email Address" required>
                    </div>
                    <div class="form-group">
                        <Label>Password of Email</Label>
                        <input class="form-control" type="text" name="mail_password" placeholder="Enter Email Password" required>
                    </div>
                    <div class="form-group">
                        <Label>Email Host Server Address</Label>
                        <p class="bg-info">Note: <br> Gmail: <span style="font-weight:bold" class="text-success"> smtp.gmail.com</span> <br/> Outlook:<span style="font-weight:bold" class="text-success">smtp.office365.com</span> but for outlook it differs sometimes.</p>
                        
                        <input class="form-control" type="text" name="mail_host" placeholder="Enter Email Server Host Address" required>
                    </div>
                    <div class="form-group">
                        <Label>Email Port Number</Label>
                        <input class="form-control" type="text" name="mail_port" placeholder="Enter Email Port Number" required>
                    </div>
                    <input name="create_email" type="submit" class="btn btn-primary" value="Create Email Configuration"/>
                </form>
				</div>
			</div>
			
		
			
		</div>
		<br />
		<br />
	</body>
</html>