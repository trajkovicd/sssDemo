<?php

/*
 class.user  2014  SolutionSoft Systems Inc.
  
 Main class for information and functions related to the user.  
 This contains password recover functions that are NOT implemented initially.
 
*/

require_once('function.inc');

class userKMS {

public $uid;
public $email;
public $fname;
public $lname;
public $phone;
public $isLoggedIn = false;
public $errorType = “fatal”;

function __construct() {
    if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 300)) { // last request was more than 30 minutes ago
        session_unset();     // unset $_SESSION variable for the run-time 
        session_destroy();   // destroy session data in storage
        session_start();
    }elseif (session_id() == "") {
        session_unset();     // unset $_SESSION variable for the run-time 
        session_destroy();   // destroy session data in storage
        session_start();
    }

    $_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp
       
    if (isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] == true) {
        $this->_initUser();
	}
} //end __construct

public function authenticate($user,$pass) {

	$mysqli = new mysqli(DBHOST,DBUSER,DBPASS,DB);
	if ($mysqli->connect_errno) {
		error_log("CentricaKMS: Cannot connect to MySQL: " . $mysqli->connect_error);
		return false;
	}
	$safeUser = $mysqli->real_escape_string($user);
	$incomingPassword = $mysqli->real_escape_string($pass);
	$query = "SELECT * from register WHERE email ='{$safeUser}'";
	if (!$result = $mysqli->query($query)) {
		error_log("CentricaKMS: Cannot retrieve account for {$user}");
		return false;
	}
// Will be only one row, so no while() loop needed
	$row = $result->fetch_assoc();
	$dbPassword = $row['password'];
	if (crypt($incomingPassword,$dbPassword) != $dbPassword) {
		error_log("CentricaKMS: Passwords for {$user} don't match");
		return false;
	}
	$this->uid = $row['uid'];
	$this->email = $row['email'];
	$this->fname = $row['fname'];
	$this->lname = $row['lname'];
	$this->phone = $row['phone'];
	$this->isLoggedIn = true;
	$this->_setSession();
	return true;
} //end function authenticate

private function _setSession() {
    if (session_id() == '') {
	session_start();
    }
    $_SESSION['uid'] = $this->uid;
    $_SESSION['email'] = $this->email;
    $_SESSION['fname'] = $this->fname;
    $_SESSION['lname'] = $this->lname;
    $_SESSION['phone'] = $this->phone;
    $_SESSION['isLoggedIn'] = $this->isLoggedIn;
    $_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp
    
} //end function setSession

private function _initUser() {
    if (session_id() == '') {
	session_start();
    }
    $this->uid = $_SESSION['uid'];
    $this->email = $_SESSION['email'];
    $this->fname = $_SESSION['fname'];
    $this->lname = $_SESSION['lname'];
    $this->phone = $_SESSION['phone'];
    $this->isLoggedIn = $_SESSION['isLoggedIn'];
    $_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp

} //end function initUser

public function logout() {
	$this->isLoggedIn = false;
	if (session_id() == '') {
		session_start();
	}

	$_SESSION['isLoggedIn'] = false;

	foreach ($_SESSION as $key => $value) {
		$_SESSION[$key] = "";
		unset($_SESSION[$key]);
	}

	$_SESSION = array();

	if (ini_get("session.use_cookies")) {
		$cookieParameters = session_get_cookie_params();
		setcookie(session_name(), '', time() - 28800,
		$cookieParameters['path'],$cookieParameters['domain'],
		$cookieParameters['secure'],$cookieParameters['httponly']);
	} //end if

    session_destroy();

} //end function logout

public function emailPass($user) {

	$mysqli = new mysqli(DBHOST,DBUSER,DBPASS,DB);
	if ($mysqli->connect_errno) {
		error_log("Cannot connect to the DB: " . $mysqli->connect_error);
		return false;
	}

// first, lookup the user to see if they exist.
	$safeUser = $mysqli->real_escape_string($user);
	$query = "SELECT id,email FROM Customer WHERE email ='{$safeUser}'";
	if (!$result = $mysqli->query($query)) {
		$_SESSION['error'][] = "Unknown Error";
		return false;
	}
	if ($result->num_rows == 0) {
		$_SESSION['error'][] = "User not found";
		return false;
	}
	$row = $result->fetch_assoc();
	$id = $row['id'];
	$hash = uniqid("",TRUE);
	$safeHash = $mysqli->real_escape_string($hash);
	
	$insertQuery = "INSERT INTO resetPassword (email_id,pass_key,status) " .
	" VALUES ('{$id}','{$safeHash}','A')";
	
	if (!$mysqli->query($insertQuery)) {
		error_log("Problem inserting resetPassword row for " . $id);
		$_SESSION['error'][] = "Unknown problem";
		return false;
	}
	
	$urlHash = urlencode($hash);
	$site = "http://localhost";
	$resetPage = "/Four/reset.php";
	$fullURL = $site . $resetPage . "?user=" . $urlHash;

//set up things related to the e-mail
	$to = $row['email'];
	$subject = "Password Reset for Site";
	$message = "Password reset requested for this site.\r\n\r\n";
	$message .= "Please go to this link to reset your password:\r\n";
	$message .= $fullURL;
	$headers = "From: wreltch@sniffingdogg.com\r\n";
	mail($to,$subject,$message,$headers);
	return true;

} //end function emailPass

public function validateReset($formInfo) {

	$pass1 = $formInfo['password1'];
	$pass2 = $formInfo['password2'];
	if ($pass1 != $pass2) {
		$this->errorType = "nonfatal";
		$_SESSION['error'][] = "Passwords don’t match";
		return false;
	}
	$mysqli = new mysqli(DBHOST,DBUSER,DBPASS,DB);
	if ($mysqli->connect_errno) {
		error_log("Cannot connect to the DB: " . $mysqli->connect_error);
		return false;
	}

	$decodedHash = urldecode($formInfo['hash']);
	$safeEmail = $mysqli->real_escape_string($formInfo['email']);
	$safeHash = $mysqli->real_escape_string($decodedHash);

	$query = "SELECT c.id as id, c.email as email FROM " . 
	"Customer c, resetPassword r WHERE " . 
	"r.status = 'A' AND r.pass_key = '{$safeHash}' " . " AND c.email = '{$safeEmail}' " . 
	" AND c.id = r.email_id";
	
	if (!$result = $mysqli->query($query)) {
		$_SESSION['error'][] = "Unknown Error";
		$this->errorType = "fatal";
		error_log("database error: " . $formInfo['email'] . " - " . $formInfo['hash']);
		return false;
	} else if ($result->num_rows == 0) {
		$_SESSION['error'][] = "Link not active or user not found";
		$this->errorType = "fatal";
		error_log("Link not active: " . $formInfo['email'] . " - " . $formInfo['hash']);
		return false;
	} else {
		$row = $result->fetch_assoc();
		$id = $row['id'];
		if ($this->_resetPass($id,$pass1)) {
			return true;
		} else {
			$this->errorType = "nonfatal";
			$_SESSION['error'][] = "Error resetting password";
			error_log("Error resetting password: " . $id);
			return false;
			}
		}

} //end function validateReset

private function _resetPass($id,$pass) {
	$mysqli = new mysqli(DBHOST,DBUSER,DBPASS,DB);
	if ($mysqli->connect_errno) {
		error_log("Cannot connect to the DB: " . $mysqli->connect_error);
		return false;
	}
	$safeUser = $mysqli->real_escape_string($id);
	$newPass = crypt($pass);
	$safePass = $mysqli->real_escape_string($newPass);
	$query = "UPDATE Customer SET password = '{$safePass}' " . "WHERE id = '{$safeUser}'";
	if (!$mysqli->query($query)) {
		return false;
	} else {
		return true;
	}
} //end function _resetPass

} //end class User
