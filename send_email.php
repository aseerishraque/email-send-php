<?php
session_start();
include_once('credentials.php');
include_once('connect.php');


// $data = getEmailById(2, $connect);
// echo $data['mail'];

if(isset($_POST["send"]))
{

    $email_data = getEmailById($_POST['selected_mail_id'], $connect);
    if(isset($email_data)){
        require 'class/class.phpmailer.php';
        $mail = new PHPMailer;
        $mail->IsSMTP();
        $mail->Mailer = "smtp";
        // $mail->Host = 'smtpout.secureserver.net';
    
        $mail->SMTPDebug  = 0;  
        $mail->SMTPSecure = "tls";	
    
        //Outlook host 1
        $mail->Host = $email_data['mail_host'];     
        $mail->Port = $email_data['mail_port'];
        $mail->SMTPAuth = true;
        $mail->Username = $email_data['mail'];
        $mail->Password = $email_data['mail_password'];
        $mail->From = $email_data['mail'];
        $mail->FromName = $from_name;
        $mail->AddAddress($_POST["receiver_email"]);
        $mail->WordWrap = 50;
        $mail->IsHTML(true);
        $mail->Subject = $_POST['email_subject'];
        $track_code = md5(rand());
        $message_body = $_POST['email_body'];
        $message_body .= '<br/><img src="'.$base_url.'email_track.php?code='.$track_code.'" width="100" height="100" />';
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
    }else{
        $message = '<div class="alert alert-danger" role="alert">Invalid Email Configuration</div>';
    }

	

    $_SESSION['message'] = $message;
    header("Location: index.php");
	

}