<?php
session_start();
include_once('credentials.php');
include_once('connect.php');


if(isset($_POST['update_email'])){
    extract($_POST);

    $sql = "UPDATE email_configs
                    SET mail='$mail',
                         mail_password='$mail_password', 
                         mail_host='$mail_host', 
                         mail_port='$mail_port',
                         mail_company='$mail_company' 
                    WHERE id=$email_id";

    // Prepare statement
    $stmt = $connect->prepare($sql);

    // execute the query
    if($stmt->execute()){
        $_SESSION['message'] = '<div class="alert alert-success" role="alert">Email Configuration Updated Successfully</div>';
        header('Location: email_list.php');
    }else{
        $_SESSION['message'] = '<div class="alert alert-success" role="alert">Email Configuration Update Error</div>';
        header('Location: email_list.php');
    }
}



if(isset($_POST['create_email'])){
    extract($_POST);

    $sql = "INSERT INTO email_configs
                    SET mail='$mail',
                         mail_password='$mail_password', 
                         mail_host='$mail_host', 
                         mail_port='$mail_port',
                         mail_company='$mail_company'";

    // Prepare statement
    $stmt = $connect->prepare($sql);

    // execute the query
    if($stmt->execute()){
        $_SESSION['message'] = '<div class="alert alert-success" role="alert">Email Configuration Created Successfully</div>';
        header('Location: email_list.php');
    }else{
        $_SESSION['message'] = '<div class="alert alert-success" role="alert">Email Configuration Create Error</div>';
        header('Location: email_list.php');
    }
}

if(isset($_GET['delete_email'])){
    extract($_GET);

    $sql = "DELETE FROM email_configs WHERE id=$id";

    // Prepare statement
    $stmt = $connect->prepare($sql);

    // execute the query
    if($stmt->execute()){
        $_SESSION['message'] = '<div class="alert alert-success" role="alert">Email Configuration Deleted Successfully</div>';
        header('Location: email_list.php');
    }else{
        $_SESSION['message'] = '<div class="alert alert-success" role="alert">Email Configuration Delete Error</div>';
        header('Location: email_list.php');
    }
}