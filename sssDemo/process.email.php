<?php

/*
 process.email  2015  SolutionSoft Systems Inc.
  
 This processes the form data for separate application that registers emails for CABoE Key cutter
 
*/


require_once("function.inc");
//prevent access if they haven’t submitted the form.
if (!isset($_POST["submit"])) 
    die(header('Location: registerEmail.php'));
$_SESSION['formAttempt'] = true;
if (isset($_SESSION['error'])) {
    unset($_SESSION['error']);
}
$_SESSION['error'] = array();
$required = array("email");
//echo "Check Fields"; //Check required fields

foreach ($required as $requiredField) {
    if (!isset($_POST[$requiredField]) || $_POST[$requiredField]== "") {
        $_SESSION['error'][] = $requiredField . ' is required.';
    }
}

//final disposition
if (count($_SESSION['error']) > 0) {
    die(header('Location: registerEmail.php'));
} else {
    if(registerEmail($_POST)) {
        unset($_SESSION['formAttempt']);
        die(header('Location: registerEmail.php'));
    } else {
        error_log('Problem registering email: ' . $_POST["email"]);
        $_SESSION['error'][] = 'Problem registering email';
        die(header('Location: registerEmail.php'));
    }
}
function registerEmail($userData) {
    $mysqli = new mysqli(DBHOST,DBUSER,DBPASS,DB);
    if ($mysqli->connect_errno) {
        error_log('CABoEKMS: Cannot connect to MySQL: ' . $mysqli->connect_error);
        return false;
    }
    $email = $mysqli->real_escape_string($_POST['email']);
//check for an existing user
    $findUser = "SELECT email from emaiList where email = '{$email}'";
    $findResult = $mysqli->query($findUser);
    $findRow = $findResult->fetch_assoc();
    if (isset($findRow['email']) && $findRow['email'] != "") {
        $_SESSION['error'][] = 'That e-mail address already exists';
        return false;
    }
    $query = "INSERT INTO emaiList (email) VALUES ('{$email}')";
    if ($mysqli->query($query)) {
        error_log("CABoEKMS: Inserted " . $email . " into the mailing list");
        $_SESSION['error'][] = 'Added Sucessfully';
        return true;
    } else {
        error_log($mysqli->error . "Problem inserting " . $query);
        $_SESSION['error'][] = 'EMAIL passed edits but failed DB Update.  See error_log.';
        return false;
    }
} //end function registerUser
?>
