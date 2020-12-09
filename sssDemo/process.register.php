<?php

/*
 process.register  2015  SolutionSoft Systems Inc.
  
 This processes the forma data for separate application that registers users for CABoE Key cutter
 
*/


require_once("function.inc");
//prevent access if they haven’t submitted the form.
if (!isset($_POST["submit"])) 
    die(header('Location: registerUser.php'));
$_SESSION['formAttempt'] = true;
if (isset($_SESSION['error'])) {
    unset($_SESSION['error']);
}
$_SESSION['error'] = array();
$required = array("lname","fname","email","password1","password2");
//echo "Check Fields"; //Check required fields

foreach ($required as $requiredField) {
    if (!isset($_POST[$requiredField]) || $_POST[$requiredField]== "") {
        $_SESSION['error'][] = $requiredField . ' is required.';
    }
}
if (!preg_match("/^[\w .]+$/",$_POST['fname'])) {
    $_SESSION['error'][] = 'First Name must be letters and numbers only.';
}
if (!preg_match("/^[\w .]+$/",$_POST['lname'])) {
    $_SESSION['error'][] = 'Last Name must be letters and numbers only.';
}
if (isset($_POST['phone']) && $_POST['phone'] != "") {
    if (!preg_match("/^[\d]+$/",$_POST['phone'])) {
        $_SESSION['error'][] = 'Phone number should be digits only';
    } else if (strlen($_POST['phone']) < 10) {
        $_SESSION['error'][] = 'Phone number must be at least 10 digits';
    }
}
if ($_POST['password1'] != $_POST['password2']) {
    $_SESSION['error'][] = "Passwords don't match";
}
//final disposition
if (count($_SESSION['error']) > 0) {
    die(header('Location: registerUser.php'));
} else {
    if(registerUser($_POST)) {
        unset($_SESSION['formAttempt']);
        die(header('Location: registerUser.php'));
    } else {
        error_log('Problem registering user: ' . $_POST["email"]);
        $_SESSION['error'][] = 'Problem registering account';
        die(header('Location: registerUser.php'));
    }
}
function registerUser($userData) {
    $mysqli = new mysqli(DBHOST,DBUSER,DBPASS,DB);
    if ($mysqli->connect_errno) {
        error_log('CABoEKMS: Cannot connect to MySQL: ' . $mysqli->connect_error);
        return false;
    }
    $email = $mysqli->real_escape_string($_POST['email']);
//check for an existing user
    $findUser = "SELECT uid from register where email = '{$email}'";
    $findResult = $mysqli->query($findUser);
    $findRow = $findResult->fetch_assoc();
    if (isset($findRow['uid']) && $findRow['uid'] != "") {
        $_SESSION['error'][] = 'A user with that e-mail address already exists';
        return false;
    }
    $lastName = $mysqli->real_escape_string($_POST['lname']);
    $firstName = $mysqli->real_escape_string($_POST['fname']);
    $cryptedPassword = crypt($_POST['password1']);
    $password = $mysqli->real_escape_string($cryptedPassword);
    if (isset($_POST['phone'])) {
        $phone = $mysqli->real_escape_string($_POST['phone']);
    } else {
        $phone = "";
    }
    $query = "INSERT INTO register (email,password,lname,fname,".
        "phone) " . 
        " VALUES ('{$email}','{$password}','{$lastName}','{$firstName}' ". 
        ",'{$phone}')";
    if ($mysqli->query($query)) {
        $uid = $mysqli->insert_id;
        error_log("CABoEKMS: Inserted " . $email . " as UID: " . $uid);
        $_SESSION['error'][] = 'Added Sucessfully';
        return true;
    } else {
        error_log($mysqli->error . "Problem inserting " . $query);
        $_SESSION['error'][] = 'User passed edits but failed DB Update.  See error_log.';
        return false;
    }
} //end function registerUser
?>