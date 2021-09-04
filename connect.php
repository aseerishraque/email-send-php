<?php
try {
	$connect = new PDO("mysql:host=localhost;dbname=".$db_name, $db_user, $db_password);
	$connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	// echo "Connected successfully";
} catch(PDOException $e) {
  	echo "Connection failed: " . $e->getMessage();
}

function getEmailById($id, $connect){
	$query = "SELECT * FROM email_configs WHERE id=$id";
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$total_row = $statement->rowCount();
    $data = array();
	if($total_row == 1)
	{
		foreach($result as $row)
		{
			$data[0] = $row;
		}
	}
	
	return $data[0];
}