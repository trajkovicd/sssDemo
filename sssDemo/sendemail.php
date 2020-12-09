<?php
	$status = array(
		'type'=>'success',
		'message'=>'Email sent!'
	);
    if (isset($_POST['name1']))
        $name = @trim(stripslashes($_POST['name1']));
    else
        $name = 'Key Cutter';
    if (isset($_POST['email1']))
        $email = @trim(stripslashes($_POST['email1']));
    else
        $email = 'CABoE Key Cutter';
    $_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp
    if (isset($_POST['subject']))
        $subject = @trim(stripslashes($_POST['subject'])); 
    else
        $subject = 'CABoEKMS Contact Page';
    if (isset($_POST['message1']))
        $message = $_POST['message1']; 
    else
        $message = 'CABoEKMS Contact Page message not set';

    $email_from = $email;
    $email_to = 'support@solution-soft.com';

    $body = 'Name: ' . $name . "\n\n" . 'Email: ' . $email . "\n\n" . 'Subject: ' . $subject . "\n\n" . 'Message: ' . $message;

    $success = mail($email_to, $subject, $body, 'From: <'.$email_from.'>');

    echo json_encode($status);
     