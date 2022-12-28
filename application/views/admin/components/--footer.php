<style>
.bold_label {
	font-size: larger !important;
}
.vis-even {
	background-color: #FCFCFC !important;
}
.vis-label {
	text-align: center;
	padding-top: 5px;
}
.vis-label Img {
	width: 50px;
}
.resolved {
	background: #9F9;
!important;
}
.new_demand {
	background: red;
!important;
}
.Inprogress {
	background: #3FF;
	;
!important;
}
.escalated {
	background: #f7b7d7;
!important;
}
.dormant {
	background: #D5D5D5;
!important;
}
.vis-labelset .vis-label {
 //border:1px solid red !important;
	text-align: center !important;
}
.vis-labelset .vis-label .vis-inner .demand_category {
	margin: 5%;
}
.vis-text {
	font-size: 16px;
}
.stakeholder_time_line {
	width: 30px;
	height: 30px;
	border-radius: 30px;
	padding: 5px;
	background-color: #FFF;
	margin-left: 10px;
}
.stakeholder_time_line img {
	width: 20px !important;
	height: 20px !important;
}
/*.modal:nth-of-type(even) {
	z-index: 1042 !important;
}
.modal-backdrop.in:nth-of-type(odd) {
	z-index: 1041 !important;
}*/

.top_model {
	z-index: 1043 !important;
}
.vis-item.vis-dot {
	position: absolute;
	padding: 0;
	border-width: 0px !important;
	border-style: solid;
	border-radius: 4px;
}
.vis_image {
	border: 1px solid white !important;
	margin-left: -15px !important;
	box-shadow: #CCC;
	box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
}
.vis-item.vis-point.vis-selected {
	background-color: none !important;
}
.events2 ol {
	list-style: none !important;
}
.events ol {
	list-style: none !important;
}
.red_border {
	/*border-color:red !important;*/
	border-width: 3px;
}

.red_star{
  color:red;
  }
.legend_icon{
	text-align:center !important;
	min-height:170px;
	}
.legend_icon .legend_image{
	border-radius: 150px;
	-webkit-border-radius: 150px;
	-moz-border-radius: 150px;
	border:1px solid #999;
	box-shadow: 0 0 8px rgba(0, 0, 0, .8);
	-webkit-box-shadow: 0 0 8px rgba(0, 0, 0, .8);
	-moz-box-shadow: 0 0 8px rgba(0, 0, 0, .8);
	width:102px !important;
	height:102px !important;
	}	
.legend_icon .legend_image2{
	
	
	box-shadow: 0 0 8px rgba(0, 0, 0, .8);
	-webkit-box-shadow: 0 0 8px rgba(0, 0, 0, .8);
	-moz-box-shadow: 0 0 8px rgba(0, 0, 0, .8);
	width:100%;
	}
</style>








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
<script src="<?php echo site_url("assets/".ADMIN_DIR); ?>/js/jquery/jquery-2.0.3.min.js"></script>
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
</body></html>