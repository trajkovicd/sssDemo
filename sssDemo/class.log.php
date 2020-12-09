<?php

/*
 class.log  2015  SolutionSoft Systems Inc.
  
 Main class for retrieving the log data and building display table
 
*/

require_once('function.inc');

class logKMS {

public $uid;
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
        error_log("sssDemo: Cannot connect to MySQL: " . $this->mysqli->connect_error);
        return false;
    }
    
} //end __construct

public function getLogTable() {
         
    $htmlTableRows = "";
    if (!$dbResult = $this->getLogData()) return false;    

    while ($row = $dbResult->fetch_row()) {
        $createDate = $row[0];
        $email = $row[1];
        $hostID = $row[2];
        $systemID = $row[3];
        $cpuCores = $row[4];
        $prod = $row[5];
        $duration = $row[6];
				
//      $createDate = date("d-M H:i:s T", $pbsPostedDate);	
			
        $htmlTableRows .= '
            <tr>
            <td> ' . $createDate . '</td>
            <td> ' . $email . '</td>
            <td> ' . $hostID . '</td>
            <td> ' . $systemID . '</td>
            <td> ' . $cpuCores . '</td>
            <td> ' . $prod . '</td>
            <td> ' . $duration . '</td>
            </tr> ';

    } // end while

	return $htmlTableRows;
    
}//end buildLogtable

function getLogData() {

    $query = 'select a.create_date, a.customerEmail,hostID,systemID,cpuCores,prod,' .
               'duration from logFile a, register b where b.uid = a.uid order by a.create_date desc';
    if (!$dbResult = $this->mysqli->query($query)) {
        error_log("sssDemo: Cannot retrieve log records");
        return false;
    }

    return $dbResult;
}

}// end class
