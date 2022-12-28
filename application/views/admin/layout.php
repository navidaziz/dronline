<?php $this->load->view(ADMIN_DIR . "components/header"); ?>
<?php

//now we will check if the current module is assigned to the user or not
/*$this->data['current_action_id'] = $current_action_id = $this->module_m->actionIdFromName($this->controller_name, $this->method_name);*/
$this->data['current_action_id'] = $current_action_id = $this->module_m->allowed_module_id($this->controller_name);

$allowed_modules = $this->mr_m->rightsByRole($this->session->userdata("role_id"));

//var_dump($allowed_modules);
//add role homepage to allowed modules
$allowed_modules[] = $this->session->userdata("role_homepage_id");



if (in_array($current_action_id, $allowed_modules) or $this->uri->segment(3) == 'update_profile') {



    $this->load->view($view);

    //$this->session->set_flashdata('msg_error', 'You are not allowed to access this module');
    //redirect(ADMIN_DIR.$this->session->userdata("role_homepage_uri"));
} else { ?>

    <div style=" margin:0px auto; width:100%; text-align:center !important;">
        <div style="margin:150px !important;">

            <h1 style="color: #d9534f;  font-size: 80px;  ">Access Denied</h1>
            <div class="content">
                <h3>Oops! Something went wrong</h3>
                <p>You are not allowed to access this module. Thanks.</p>
                <div class="btn-group">
                    <a href="<?php echo site_url(ADMIN_DIR . $this->session->userdata("role_homepage_uri")); ?>" class="btn btn-danger"><i class="fa fa-chevron-left"></i> Go Back</a>
                </div>
            </div>

        </div>

    </div>

<?php } ?>



<?php //$this->load->view($view); 
?>
<?php $this->load->view(ADMIN_DIR . "components/footer"); ?>