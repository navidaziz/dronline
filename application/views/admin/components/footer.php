<div class="separator"></div>
</div>
</div>
</div>
</div>
</section>

<script type="text/javascript" src="<?php echo site_url("assets/".ADMIN_DIR); ?>/js/magic-suggest/magicsuggest-1.3.1-min.js"></script>
<script src="<?php echo site_url("assets/".ADMIN_DIR."js/jquery-ui-1.10.3.custom/js/jquery-ui-1.10.3.custom.min.js"); ?>"></script><script src="<?php echo site_url("assets/".ADMIN_DIR."js/script.js"); ?>"></script> 
<script type="text/javascript"> jQuery(document).ready(function(){App.setPage("widgets_box");App.init();});</script> 
<link href="<?php echo site_url("assets/".ADMIN_DIR."font-awesome/css/font-awesome.min.css"); ?>" rel="stylesheet" />
<?php 
if($this->router->fetch_method()=='add_order_new'){ ?>
<script src="<?php echo site_url("assets/".ADMIN_DIR."js/jquery-1.min.js"); ?>"></script>
<?php }else{?>

<script src="<?php echo site_url("assets/".ADMIN_DIR."js/jquery-0.min.js"); ?>"></script>
<?php } ?>

<script>

var picking_location= $("#picking_location").magicSuggest({ 
		 cls: 'form-control'
		});
		
		$(picking_location).on('keyup', function(e, m, v){
			//alert('Key code # ' + v.keyCode);
			if(v.keyCode!=40){
			var location  = picking_location.getRawValue();
			 this.setData('<?php echo base_url(ADMIN_DIR."orders/get_address/"); ?>/'+location);
			}
			 });
		$(picking_location).on('selectionchange', function(e,m){
			//var location  = this.getValue();
			//alert(location);
			});	 
			 
		var delivery_location= $("#delivery_location").magicSuggest({ 
		 cls: 'form-control'
		});
		
		$(delivery_location).on('keyup', function(e, m, v){
			//alert('Key code # ' + v.keyCode);
			if(v.keyCode!=40){
			var location  = delivery_location.getRawValue();
			 this.setData('<?php echo base_url(ADMIN_DIR."orders/get_address/"); ?>/'+location);
			}
			 });	 
	
	</script>
    
<link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/".ADMIN_DIR."js/magic-suggest/magicsuggest-1.3.1-min.css"); ?>" />    
</body></html>