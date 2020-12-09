<?php require_once('function.inc'); 
/*
 registerUser  2015  SolutionSoft Systems Inc.
  
 This is a UI for separate application that registers users for CABoE Key cutter
 
*/
?>
<!doctype html>
<html>
<head>
<script type="text/javascript" 
	src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<title>Register CA State Board of Equalization KMS User</title>
</head>
<body>
<form id="userForm" method="POST" action="process.register.php">
<div>
	<fieldset>
		<legend>Registration Information</legend>
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
			<label for="fname">First Name:* </label>
			<input type="text" id="fname" name="fname">
			<span class="errorFeedback errorSpan"
		id="fnameError">First Name is required</span>
			<br />
			<label for="lname">Last Name:* </label>
			<input type="text" id="lname" name="lname">
			<span class="errorFeedback errorSpan"
		id="lnameError">Last Name is required</span>
			<br />
			<label for="email">E-mail Address:* </label>
			<input type="email" id="email" name="email">
			<span class="errorFeedback errorSpan"
		id="emailError">E-mail is required</span>
			<br />
			<label for="password1">Password:* </label>
			<input type="password" id="password1"
		name="password1">
			<span class="errorFeedback errorSpan"
		id="password1Error">Password required</span>
			<br />
			<label for="password2">Verify Password:* </label>
			<input type="password" id="password2"
		name="password2">
			<span class="errorFeedback errorSpan"
		id="password2Error">Passwords do not match</span>
			<br />
			<label for="phone">Phone Number: </label>
			<input type="text" id="phone" name="phone">
			<span class="errorFeedback errorSpan"
		id="phoneError">Format: xxxxxxxxxx</span>
			<br />
			<input type="submit" id="submit" name="submit">
	</fieldset>
</div>
</form>
</body>
</html>