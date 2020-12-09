<?php

/*
 process.keys  2015  SolutionSoft Systems Inc.
  
 Called from the keygen form in Index.php to process cutting of the key and
 writing the logFile information
 
*/

require_once('function.inc');

$keysKMS = new keysKMS();

    $_SESSION['formAttempt'] = true;
    if (isset($_SESSION['error'])) 
        unset($_SESSION['error']);
	
    $_SESSION['error'] = array();
    
    if (isset($_SESSION['KEY'])) 
        unset($_SESSION['KEY']);
                	
/*    $required = array("os","CustomerEmail","hostID","sysID","duration","CPUcore","prod");
	
//Check required fields
    foreach ($required as $requiredField) {
        if (!isset($_POST[$requiredField]) || $_POST[$requiredField] == "") {
            $_SESSION['error'][] = $requiredField . " is required.";
        }
    }

    if (count($_SESSION['error']) > 0) {
        //die(header("Location: index.php"));
        echo FALSE;
    }else {
        $os = $_POST['os'];
        $CustomerEmail = $_POST['CustomerEmail'];
        $hostID = $_POST['hostID'];
        $sysID = $_POST['sysID'];
        $duration = $_POST['duration'];
        $CPUcore = $_POST['CPUcore'];
        $prod = $_POST['prod'];                       */
        $keygen = $keysKMS->getDate();
        if (!$keygen) {
            $_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp
            $_SESSION['error'][] = "There was a problem cutting key";
//            die(header("Location: index.php"));
            echo FALSE;
        }else {
            unset($_SESSION['formAttempt']);
            $_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp
            $_SESSION['CURDATE'] = $keygen;
//            die(header("Location: index.php"));
            echo TRUE;
        }
//    }
?>