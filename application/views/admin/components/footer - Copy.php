
<div class="separator"></div>
<!-- /PAGE MAIN CONTENT -->

</div>
</div>
</div>
</div>
</section>
<!--/PAGE --> 
<!-- JAVASCRIPTS --> 
<!-- Placed at the end of the document so the pages load faster --> 

<!-- JQUERY UI--> 
<script src="<?php echo site_url("assets/".ADMIN_DIR."js/jquery-ui-1.10.3.custom/js/jquery-ui-1.10.3.custom.min.js"); ?>"></script> 

<!-- UNIFORM --> 
<script type="text/javascript" src="<?php echo site_url("assets/".ADMIN_DIR); ?>/js/uniform/jquery.uniform.min.js"></script> 

<!-- SLIMSCROLL --> 
<script type="text/javascript" src="<?php echo site_url("assets/".ADMIN_DIR."js/jQuery-slimScroll-1.3.0/jquery.slimscroll.min.js"); ?>"></script> 
<script type="text/javascript" src="<?php echo site_url("assets/".ADMIN_DIR."js/jQuery-slimScroll-1.3.0/slimScrollHorizontal.min.js"); ?>"></script> 
<!-- COOKIE --> 
<script type="text/javascript" src="<?php echo site_url("assets/".ADMIN_DIR."js/jQuery-Cookie/jquery.cookie.min.js"); ?>"></script> 
<!-- CUSTOM SCRIPT --> 

<script type="text/javascript" 
	src="<?php echo site_url("assets/".ADMIN_DIR."js/bootstrap-datepicker/js/bootstrap-datepicker.js"); ?>"></script> 

<!-- DATE PICKER --> 
<script type="text/javascript" src="<?php echo site_url("assets/".ADMIN_DIR."js/datepicker/picker.js"); ?>"></script> 
<script type="text/javascript" src="<?php echo site_url("assets/".ADMIN_DIR."js/datepicker/picker.date.js"); ?>"></script> 
<script type="text/javascript" src="<?php echo site_url("assets/".ADMIN_DIR."js/datepicker/picker.time.js"); ?>"></script> 
<script src="<?php echo site_url("assets/".ADMIN_DIR."js/script.js"); ?>"></script> 
<script>
  


	$(document).ready(function() {
		$(".datepicker").datepicker({
			
				format: 'yyyy-mm-dd',
                autoclose: true
            });
		
		});
		
	</script> 
<script type="text/javascript">
		jQuery(document).ready(function() {		
			App.setPage("widgets_box");  //Set current page
			App.init(); //Initialise plugins and elements
		});
	</script> 
<!-- /JAVASCRIPTS --> 
<script>
    $("img").error(function () {
  $(this).unbind("error").attr("src", "<?php echo site_url("assets/".ADMIN_DIR."img/no_image.png"); ?>");
});
</script>

<link href="<?php echo site_url("assets/".ADMIN_DIR."font-awesome/css/font-awesome.min.css"); ?>" rel="stylesheet" />


</body></html>