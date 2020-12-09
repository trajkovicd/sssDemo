<?php

/*
 class.keys  2016  SolutionSoft Systems Inc.
  
 This class contains all functions related to the generation of the license keys,
 including the calculation of the keys remaining. This generates rental keys 
 21-March-2016  Check length of key to make sure it worked
 
*/

require_once('function.inc');

class keysKMS {
    
public $totalCPU=32;   
public $totalMachines=17;   
public $keygen='';
private $mysqli;

function __construct() {
    if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 300)) { // last request was more than 30 minutes ago
        session_unset();     // unset $_SESSION variable for the run-time 
        session_destroy();   // destroy session data in storage
        session_start();
    }elseif (session_id() == "") {
        error_log("started session");
        session_unset();     // unset $_SESSION variable for the run-time 
        session_destroy();   // destroy session data in storage
        session_start();
    }

    $_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp
       
    $this->mysqli = new mysqli(DBHOST,DBUSER,DBPASS,DB);
    if ($this->mysqli->connect_errno) {
        error_log("sssDemo: Keys Cannot connect to MySQL: " . $this->mysqli->connect_error);
        return false;
    }
/*
    if (isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] == true) {
        $this->_calcRemaining();
    }
    */
} //end __construct

public function getDate() {
    
    $query = "select current_timestamp";
    if (!$result = $this->mysqli->query($query)) {
        error_log("sssDemo: Cannot retrieve date");
	return false;
	}
// Will be only one row, so no while() loop needed
	$row = $result->fetch_row();
	$curDate = $row[0];

        $_SESSION['CURDATE'] = $curDate;
    
 //   return $dateHTML;
    
}

function _calcRemaining() {

	$query = "select sum(cpuCores) from logFile where TIMESTAMPDIFF(WEEK, create_date, current_timestamp) < duration";
	if (!$result = $this->mysqli->query($query)) {
		error_log("KMSEast: Cannot retrieve cores");
		return false;
	}
// Will be only one row, so no while() loop needed
	$row = $result->fetch_row();
	$cpuCores = $row[0];
        $this->remainingCPU = $this->totalCPU - $cpuCores; 
    
	$query = "select count(transactionId) from logFile where TIMESTAMPDIFF(WEEK, create_date, current_timestamp) < duration";
	if (!$result = $this->mysqli->query($query)) {
		error_log("KMSEast: Cannot retrieve machines");
		return false;
	}
// Will be only one row, so no while() loop needed
	$row = $result->fetch_row();
	$machines = $row[0];
        $this->remainingMachines = $this->totalMachines - $machines; 
        
        $_SESSION['REMAININGCPU'] = $this->remainingCPU;
        $_SESSION['LAST_ACTIVITY'] = time(); 
    
} //end _calcRemaining

public function keyGen($os,$CustomerEmail,$hostID,$sysID,$duration,$CPUcore,$prod) {

    $_SESSION['KEY'] = 'KEY';
/*
    if (($this->remainingCPU - $CPUcore) < 0) {
        $_SESSION['error'][] = "Not enough cores available to cut this key";
        return FALSE;
    }  */
    if ($os == 9) {
        if ($prod == 4) {
            $winDuration = ($duration / 7) + 0.9;
            $cmdline = '/var/www/KMS-East/webkey -o windows -k e -p ' . 
                $CPUcore . ' -g ' . $winDuration . ' -h ' . $sysID;
        } else {
            $cmdline = '/var/www/KMS-East/ssskeygen_win -k 4 -n ' . $CPUcore .
               ' -p ' . $prod . ' -d ' . $duration . ' -h ' . $sysID;    
        }
    } else {
        $cmdline = '/var/www/KMS-East/ssskeygen_cmd -k 4 -n ' . $CPUcore . ' -p ' .
            $prod . ' -d ' . $duration . ' -h ' . $sysID . ' -s ' . $os;
    }    
    $keygen = exec($cmdline);
    $this->keygen = $keygen;
    if (strstr($keygen, "Sorry") || strstr($keygen, "supported") || strstr($keygen, "-0000000000") )  {
        $_SESSION['KEYGEN'] = $keygen;
        error_log('keyGen=' . $keygen);
        return FALSE;
    }else {
        $_SESSION['KEYGEN'] = $keygen;
        error_log('keyGen=' . $keygen);
        $this->_writeLog($os,$CustomerEmail,$hostID,$sysID,$duration,$CPUcore,$prod);
        $this->_sendNotification($os,$CustomerEmail,$hostID,$sysID,$duration,$CPUcore,$prod);
        return TRUE;
    }
}//end keygen

private function _writeLog($os,$CustomerEmail,$hostID,$sysID,$duration,$CPUcore,$prod) {
    $uid = $_SESSION['uid'];
    if ($uid == '') $uid = 1;
    $queryI = "INSERT INTO logFile (os,customerEmail,hostID,systemID,cpuCores,keyGen,duration,uid,prod)".
        " VALUES ('{$os}','{$CustomerEmail}','{$hostID}','{$sysID}',$CPUcore,'{$this->keygen}' ". 
        ",$duration,$uid,$prod)";
    if ($this->mysqli->query($queryI)) {
        $txid = $this->mysqli->insert_id;
        $_SESSION['error'][] = 'Added Sucessfully';
        return true;
    }else {
        error_log('KMS-East: Inserted Log Record Failed: ' . $this->mysqli->error);
        return FALSE;
    }
    
}//end _writeLog

private function _sendNotification($os,$CustomerEmail,$hostID,$sysID,$duration,$CPUcore,$prod) {
    
    $email = $_SESSION['email'];
    
    switch ($prod) {
    case 1:
        $product = "TM Sync Server";
        break;
    case 3:
        $product = "TM License Server";
        break;
    case 4:
        $product = "Time Machine";
        break;
    case 5:
        $product = "TM Framework for Oracle";
        break;
    case 8:
        $product = "TM Console";
        break;
    case 10:
        $product = "TM Framework for WebLogic";
        break;
    case 15:
        $product = "TM Framework for JBoss";
        break;
    }
    $subject = 'KMS-East License sent to ' . $CustomerEmail;
    $message = date("Y-m-d:H:i:s") . " " . $CustomerEmail . " was sent a " . 
            $duration . " Day " . $product . " key for HOST " .
           $hostID . ' HWID: ' . $sysID;
    $headers = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'X-Priority: 1 (Highest)' . "\r\n";
    $headers .= 'Importance: High' . "\r\n";
    $headers .= 'From: KMS-East <support@solution-soft.com>' . "\r\n";
    
    $query = "select email from emaiList";
    if (!$dbResult = $this->mysqli->query($query)) {
        error_log("KMS-East: Cannot retrieve mail list records");
        return false;
    }
    while ($row = $dbResult->fetch_row()) {
        $email = $row[0];				
        mail($email, $subject, $message, $headers);

    } // end while

    // send this email directly to the cusomer entered
    
    $subject = $product . ' License for ' . $hostID;
    $message = date("Y-m-d:H:i:s") .  ' A ' .
            $duration . ' day license for HOST ' .
           $hostID . " has been generated. \r\n\r\n" . $this->keygen .
            "\r\n\r\n  Copy and paste the above key into the license manager program. " .
            'Please make sure that you apply the license within six days and with current system time on the host.';
    $headers = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'X-Priority: 1 (Highest)' . "\r\n";
    $headers .= 'Importance: High' . "\r\n";
    $headers .= 'From: Solution-Soft Support <support@solution-soft.com>' . "\r\n";
    mail($CustomerEmail, $subject, $message, $headers);
    
}//end _sendNotification

}//end class
