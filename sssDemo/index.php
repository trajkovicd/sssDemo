<?php 
/*
 Index  2016  SolutionSoft Systems Inc.
  
 Main Page for internal Key Management System. Intended for demo Time Machne Only
     Use of open source projects acknowledged:
 Twitter Bootstrap framework, JQuery javascript libraries.
 
*/
require_once('function.inc');
$userKMS = new userKMS; 
$keysKMS = new keysKMS; 
$logKMS = new logKMS; 
include('header.php'); 


?>
<!-- The following HTML Sections address the functional decomposition of the application.
    The sections are hidden until needed as this is a Single Page Application. -->

<!-- This section describes the main carousel -->

    <section id="main-slider" class="carousel">
        <div class="carousel-inner">
            <div class="item active">
                <div class="container">
                    <div class="carousel-content">
                        <h1>20,000 Virtual Clocks </h1>
                        <h1>24 Time Zones Just One Server</h1>
                    </div>
                </div>
            </div><!--/.item-->
            <div class="item">
                <div class="container">
                    <div class="carousel-content">
                        <h1>47 of the Fortune 100 </h1>                       
                        <h1>Trust Time Machine®</h1>                       
                    </div>
                </div>
            </div><!--/.item-->
            <div class="item">
                <div class="container">
                    <div class="carousel-content">
                        <h1>Time Machine® is Cloud-Friendly</h1>                       
                    </div>
                </div>
            </div><!--/.item-->
            <div class="item">
                <div class="container">
                    <div class="carousel-content">
                        <h1>Time Machine® is Cloud-Ready</h1>                       
                    </div>
                </div>
            </div><!--/.item-->
        </div><!--/.carousel-inner-->
        <a class="prev" href="#main-slider" data-slide="prev"><i class="icon-angle-left"></i></a>
        <a class="next" href="#main-slider" data-slide="next"><i class="icon-angle-right"></i></a>
    </section><!--/#main-slider-->

<!-- This section describes the contact page -->    
    
    <section id="contact">
        <div class="container">
            <div class="box last">
                <div class="row">
                    <div class="col-sm-6">
                        <p />
                        <h1>Contact Form</h1>
                        <p>Feel free to drop us a note.</p>
                        <div class="status alert alert-success" style="display: none"></div>
                        <form id="main-contact-form" class="contact-form" name="contact-form" method="post" action="#" role="form">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control" required="required" placeholder="Name" id="name1" name="name1">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control" required="required" placeholder="Email address" id="email1" name="email1">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <textarea name="message1" id="message1" required="required" class="form-control" rows="8" placeholder="Message"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-danger btn-lg">Send Message</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div><!--/.col-sm-6-->
                    <div class="col-sm-6">
                        <h1>Our Address</h1>
                        <div class="row">
                            <div class="col-md-6">
                                <address>
                                    <strong>SolutionSoft Systems Inc.</strong><br>
                                    2350 Mission College Blvd. #7777<br>
                                    Santa Clara, CA 95054<br>
                                    <abbr title="Phone">P:</abbr> 408.346.1400
                                </address>
                            </div>
                        </div>
                        <h1>Connect with us</h1>
                        <div class="row">
                            <div class="col-md-6">
                                <ul class="social">
                                    <li><a href=https://www.facebook.com/solutionsoftsystems><i class="icon-facebook icon-social"></i> Facebook</a></li>
                                    <li><a href=https://www.linkedin.com/company/solution-soft><i class="icon-linkedin icon-social"></i> Linkedin</a></li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <ul class="social">
                                    <li><a href=http://www.twitter.com/SolutionSoftTM><i class="icon-twitter icon-social"></i> Twitter</a></li>
                                    <li><a href=http://www.youtube.comuser/SolutionSoftTM><i class="icon-youtube icon-social"></i> Youtube</a></li>
                                </ul>
                            </div>
                        </div>
                    </div><!--/.col-sm-6-->
                </div><!--/.row-->
            </div><!--/.box-->
        </div><!--/.container-->
    </section><!--/#contact-->    

<!-- This section describes the Log In page.  This page will be displayed whenever the session is not active -->
    
    <section id="signin">
        <div class="container">
            <div class="box last">
                <div class="row">
                    <div class="col-sm-6">
                        <h1>Please Log in</h1>
                        <p></p>
        <?php
		if (isset($_SESSION['error']) && isset($_SESSION['formAttempt'])) {
                    unset($_SESSION['formAttempt']);
                    echo '<div class="status alert alert-success" id="login-error">';
		}  else {
                    echo '<div class="status alert alert-success" style="display: none" id="login-error">';
                } //end if
	?>
                            <p> Login has Failed. Please contact Solution-Soft support </p>
                        </div><!--/.login-error-->
                        <form id="main-signin-form" class="signin-form" name="signin-form" method="post" action="process.login.php" role="form">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <input type="email" class="form-control" required="required" placeholder="Email address" id="email" name="email">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <input type="password" class="form-control" required="required" placeholder="Password" id="password" name="password">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-danger btn-lg">Log In</button>
                                    </div>
                            </div>
                        </form>
                    </div><!--/col-sm-6-->
                </div><!--/.row-->
            </div><!--/.box-->
        </div><!--/.container-->
    </section><!--/#signin-->    
    
<!-- This section describes the key generation page -->
    
    <section id="keygen">
        <div class="container">
            <div class="box last">
                <div class="row">
                    <div class="col-sm-6">
        <?php
                $curDateHTML = '';
                $dateHTML = $keysKMS->getDate();
                $curDateHTML .= "<h1>" . $_SESSION['CURDATE'] . "</strong>";
                echo $curDateHTML;
        ?>
                        <p></p><br><br>
        <?php 

                $divsection  = '<div class="status alert alert-success" style="display: none">';
		$keyGenMsg  = '';
		if (isset($_SESSION['KEY']) && isset($_SESSION['error'])) {
                    $keyGenMsg = $_SESSION['error'][0];
                    $divsection  = '<div class="status alert alert-success" id="key-status">';
                }
                $divsection .= '<p>' . $keyGenMsg . '</p>';
                echo $divsection; 
	?>     
                        </div><!--/.key-status-->
                        <form id="main-keygen-form" class="keygen-form" name="keygen-form" method="post" action="#" role="form">
<!--                        <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <select id="os-select" name="os" class="os-select form-control">
                                            <option value="9" >Windows</option>
                                            <option value="4" selected>Linux</option>
                                            <option value="1" >AIX</option>
                                            <option value="3" >HPUX</option>
                                            <option value="6" >Solaris</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <input type="email" class="form-control" required="required" placeholder="CUSTOMER EMAIL" id="CustomerEmail" name="CustomerEmail">
                                    </div>
                                </div>
                            </div>                            
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <select id="prod-select" name="prod" class="prod-select form-control">
                                            <option value="1" >TMSS</option>
                                            <option value="3" >TMFL</option>
                                            <option value="4" selected>TM</option>
                                            <option value="5" >TMFO</option>
                                            <option value="8" disabled>TMCEE</option>
                                            <option value="10" >TMFWL</option>
                                            <option value="15" >TMFJB</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control" required="required" placeholder="HOST ID" id="hostID" name="hostID" maxlength="35">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <input type="text" class="form-control" required="required" placeholder="Date" id="sysID" name="sysID" size="35" maxlength="35">
                                    </div>
                                </div>
                            </div>
<!--                        
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <select id="duration" name="duration" class="form-control">
                                            <option value="7" >1 Week</option>
                                            <option value="14" >2 Weeks</option>
                                            <option value="21" >3 Weeks</option>
                                            <option value="30" selected>4 Weeks</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <input type="number" class="form-control" required="required" placeholder="CPU / LU" id="CPUcore" name="CPUcore" min="1" max="256">
                                    </div>
                                </div>
                            </div><-->
                            <div class="row">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-danger btn-lg">Get Date</button>
                                    </div>
                            </div><!--/.row-->
                        </form>
                    </div><!--/col-sm-6-
                    <div class="col-sm-6">
    <!--                    <h1>License Usage</h1>
                        <div class="row">
                            <div class="col-md-6">
        <?php /*
            if (isset($_SESSION['REMAININGCPU'])) {
                $licenseHTML = '';
                $licenseHTML .= '<strong>' . $_SESSION['REMAININGCPU'] . ' OUT OF ';
                $licenseHTML .= $keysKMS->totalCPU . ' CPU CORES REMAINING</strong><br>';
                echo $licenseHTML;
            }  */
        ?>
                            </div>
                        </div> -->
        <?php /*
                $keysHTML = '';
            if (isset($_SESSION['KEYGEN'])) {
                $keysHTML .= '<h1>License Key</h1>
                        <div class="row" id="newkey">
                            <div class="col-md-6">
                                <strong>' . $_SESSION['KEYGEN'] . '</strong>
                            </div>
                         </div>';
                echo $keysHTML;
            } */
        ?>
                    </div><!--/.col-sm-6-->
                </div><!--/.row-->
        <?php
                $keysHTML2 = '';
            if (isset($_SESSION['KEYGEN'])) {
                $keysHTML2 .= '<div class="row" id="newkey">
                            <div class="col-md-6">
                                <strong>' . $_SESSION['KEYGEN'] . '</strong>
                            </div>
                         </div>';
                echo $keysHTML2;
            }
        ?>
                
            </div><!--/.box-->
        </div><!--/.container-->
    </section><!--/#keygen-->    
    
<!-- This section describes the log file display page -->

    <section id="displayLog">
        <div class="container">
            <div class="box last">
                <form id="main-log-form" class="log-form" name="log-form" method="post" action="#" role="form">
                    <div class="form-group table_container" style="width:99%; overflow:hidden; height:100%; overflow-x:scroll;">
                        <table id="myTable" class="tablesorter" style="background-color: #222; color: #999;">
                            <thead id="myHead">
				<tr>
				<th>Date</th>
				<th>Customer</th>
				<th>Host</th>
				<th>System/HW</th>
				<th>CPU/LU</th>
				<th>Product</th>
				<th>Duration</th>
				</tr>
                            </thead>
                            <tbody>
        <?php
                $logHTML = '';
                $htmlTableRows = $logKMS->getLogTable();
                $logHTML .= $htmlTableRows;
                echo $logHTML;
        ?>
                            </tbody> 
                        </table>
                    </div>
                </form>
            </div><!--/.box-->
        </div><!--/.container-->
    </section><!--/#displayLog-->   
    
<!-- This section describes the Banner.  This page will be displayed just after log in -->
    
    <section id="KMSbanner">
        <div class="container">
            <div class="box last">
                <div class="row">
                    <div class="col-sm-12" style="margin-left: auto; margin-right: auto; font-style: oblique">
                        <h1>This application is the property of and for the sole use of SolutionSoft Systems Inc. Unauthorized use prohibited.</h1>
                        <p> </p>
                        <p> Please do not forget to close this browser window.</p>
                    </div><!--/col-sm-12-->
                </div><!--/.row-->
            </div><!--/.box-->
        </div><!--/.container-->
    </section><!--/#KMSbanner-->    
    
<?php include('footer.php'); ?>
