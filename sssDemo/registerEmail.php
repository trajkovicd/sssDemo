<?php require_once('function.inc'); 
/*
 registerEmail  2015  SolutionSoft Systems Inc.
  
 This is a UI for separate application that registers email addresses for mailing list for CABoE Key cutter
 
*/
?>
<!doctype html>
<html>
<head>
<script type="text/javascript" 
	src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<title>Register CA State Board of Equalization KMS Email Address</title>
</head>
<body>
<form id="userForm" method="POST" action="process.email.php">
<div>
	<fieldset>
		<legend>Email Information</legend>
		<div id=”errorDiv”>
<?php
		ini_set('display_errors', 'On');
		error_reporting(E_ALL | E_STRICT);
		if (isset($_SESSION["error"]) && isset($_SESSION["formAttempt"])) {
			unset($_SESSION["formAttempt"]);
			echo "Errors encountered<br /> \n";
			foreach ($_SESSION['error'] as $error) {
					echo $error . "<br /> \n";
				} //end foreach
			} //end if
?>		</div>
			<label for="email">E-mail Address:* </label>
			<input type="email" id="email" name="email" required="required" placeholder="Email address" >
			<span class="errorFeedback errorSpan"
		id="emailError">E-mail is required</span>
			<br />
			<input type="submit" id="submit" name="submit">
	</fieldset>
</div>
</form>
</body>
</html>