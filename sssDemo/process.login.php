<?php

/*
 process.login  2015  SolutionSoft Systems Inc.
  
 Called from the login form in Index.php to process login
 
*/

require_once('function.inc');

        $_SESSION['formAttempt'] = true;
	if (isset($_SESSION['error'])) 
            unset($_SESSION['error']);
	
	$_SESSION['error'] = array();
	
	$required = array("email","password");
	
//Check required fields
	foreach ($required as $requiredField) {
            if (!isset($_POST[$requiredField]) || $_POST[$requiredField] == "") 
                $_SESSION['error'][] = $requiredField . " is required.";
            }

	if (count($_SESSION['error']) > 0) {
            die(header("Location: login.php"));
        }else {
            $userKMS = new userKMS;
            if ($userKMS->authenticate($_POST['email'],$_POST['password'])) {
                unset($_SESSION['formAttempt']);
                $_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp
                die(header("Location: index.php"));
            } else {
		$_SESSION['error'][] = "There was a problem with your username or password.";
                die(header("Location: index.php"));
                }
            }
?>