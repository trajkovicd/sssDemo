<?php
/************************************************************************************

header January 2014  SolutionSoft Systems Inc.

This is the HTML Header for all pages


************************************************************************************/
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Solution-Soft</title>
    <link href="css3/bootstrap.min.css" rel="stylesheet">
    <link href="css3/font-awesome.min.css" rel="stylesheet">
    <link href="css3/prettyPhoto.css" rel="stylesheet">
    <link href="css3/main.css" rel="stylesheet">
    <link href="css3/theme.default.css" rel="stylesheet">
</head><!--/head-->

<body data-spy="scroll" data-target="#navbar" data-offset="0">
    <header id="header" role="banner">
        <div class="container">
            <div id="navbar" class="navbar navbar-default navbar-fixed-top">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-main">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="http://www.solution-soft.com"></a>
                </div>
                <center>
                <div class="navbar-collapse collapse" id="navbar-main">
                    <ul class="nav navbar-nav ">
                        <li class="active"><a id="menu_home" href="#"><i class="icon-home"></i></a></li>
                        <li><a id="menu_log" href="#">View Log</a></li>
                        <li><a id="menu_keys" href="#">Keys</a></li>
                        <li><a id="menu_contact" href="#">Contact</a></li>
                    </ul>
        <?php
		if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] < 300)) {
                    if (isset($_SESSION['email'])) {
                        $email = $_SESSION['email'];
                        echo '<form class="navbar-form navbar-right" role="search">
                        <div class="form-group">
                            <input type="email" class="form-control" name="email" value=' . $email . ' id="field-email" readonly>
                        </div>
                        </form>';
                    }
                } //end if
	?>
                </div>
                </center>
            </div>
        </div>
    </header><!--/#header-->