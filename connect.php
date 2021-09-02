<?php
try {
	$connect = new PDO("mysql:host=localhost;dbname=".$db_name, $db_user, $db_password);
	$connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	// echo "Connected successfully";
} catch(PDOException $e) {
  	echo "Connection failed: " . $e->getMessage();
}