
    <footer id="footer">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    &copy; 2017 SolutionSoft Systems Inc. All Rights Reserved.
                </div>
            </div>
        </div>
    </footer><!--/#footer-->
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.isotope.min.js"></script>
    <script src="js/jquery.prettyPhoto.js"></script>
    <script src="js/main.js"></script>
    <script src="js/jquery.tablesorter.js"></script>
    <script src="js/jquery.tablesorter.widgets.js"></script>
    <script src="js/widget-cssStickyHeaders.js"></script>
    <script>
        
    $(document).ready(function() {

/* Control menus based on login */
        if ($('#field-email').length === 0) {  /* Not Logged In */
            $('#navbar-main').navbar-main("disable", "menu_log", true);
        } else {
            $('#navbar-main').attr("disabled", "false");  /* Logged In */
            $('#signin').css('display', 'none'); 
            if ($('#newkey').length > 0) {
                $('#keygen').css('display', 'inline');
            } 
            else {
                if ($('#key-status').length > 0) {
                    $('#keygen').css('display', 'inline');
                }else {
                    $('#keygen').css('display', 'inline');
                //    $('#KMSbanner').toggle();             
                }
            }
        }

       $("#os-select").change(function (e) {
           if($(this).val() === "9"){
             $("#prod-select option[value='3']").prop('disabled',true);
             $("#prod-select option[value='8']").prop('disabled',false);
         } else if($(this).val() === "4"){
               $("#prod-select option[value='8']").prop('disabled',true);
               $("#prod-select option[value='3']").prop('disabled',false);
         } else {
             $("#prod-select option[value='3']").prop('disabled',true);
             $("#prod-select option[value='8']").prop('disabled',true);
         }
});

/* Submit function for the keyGen */
        $('#main-keygen-form').submit(function() {
            var aOdata = $('#main-keygen-form').serialize();
            var jqXHR = $.post('process.keys.php',aOdata,processSubmit).error('ouch');
            function processSubmit(keyGen) {
                $(location).attr('href','index.php'); 
            	
            } //end processSubmit
			
            return false;

	}); // end submit

/* Submit function for the Contact */
        $('#main-contact-form').submit(function() {
            var aOdata = $('#main-contact-form').serialize();
            var jqXHR = $.post('sendemail.php',aOdata,processMail).error('ouch');
            function processMail(mailStat) {
                $(location).attr('href','index.php'); 
            	
            } //end processMail
			
            return false;

	}); // end submit

/* Shows and hides sections based on menu selections */
        $('#menu_home').click(function() {
            $('#signin').css('display', 'none');
            $('#keygen').css('display', 'none');
            $('#displayLog').css('display', 'none');
            $("#contact").css('display', 'none');
            $('#KMSbanner').css('display', 'inline');
        }); // end click
        $('#menu_contact').click(function() {
            $('#signin').css('display', 'none');
            $('#keygen').css('display', 'none');
            $('#displayLog').css('display', 'none');
            $('#KMSbanner').css('display', 'none');
            $("#contact").css('display', 'inline');
        }); // end click
        $('#menu_keys').click(function() {
            $('#signin').css('display', 'none');
            $('#displayLog').css('display', 'none');
            $('#contact').css('display', 'none');
            $('#KMSbanner').css('display', 'none');
            $("#keygen").css('display', 'inline');
        }); // end click
        $('#menu_log').click(function() {
            $('#signin').css('display', 'none');
            $('#contact').css('display', 'none');
            $("#keygen").css('display', 'none');
            $('#KMSbanner').css('display', 'none');
            $('#displayLog').css('display', 'inline');
        }); // end click
		
/* Function to set parameters for the table that holds log records       */         
 	$(function(){

            var options = {
                widthFixed : true,
                showProcessing: true,
                headerTemplate : '{content} {icon}', // Add icon for jui theme; new in v2.7!
//                widgets: [ 'uitheme', 'zebra', 'stickyHeaders', 'filter' ],
                widgets: ['zebra', 'stickyHeaders'],
                widgetOptions: {   
                    stickyHeaders : '',  // extra class name added to the sticky header row
                    stickyHeaders_offset : 0,  // number or jquery selector targeting the position:fixed element
                    stickyHeaders_cloneId : '-sticky', // added to table ID, if it exists
                    stickyHeaders_addResizeEvent : true, // trigger "resize" event on headers
                    stickyHeaders_includeCaption : true,  // if false and a caption exist, it won't be included in the sticky header
                    stickyHeaders_zIndex : 2,  // The zIndex of the stickyHeaders, allows the user to adjust this to their needs
                    stickyHeaders_attachTo : $('.table_container'), // jQuery selector or object to attach sticky header to
		    } // end widget options
		  }; // end var options

            $("#myTable").tablesorter(options);

	}); 
  
    }); // end ready

    </script>
</body>
</html>
