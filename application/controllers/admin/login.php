<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Login extends Admin_Controller
{

    /**
     * constructor method
     */
    public function __construct()
    {

        parent::__construct();
        $this->load->model("admin/user_model");
        $this->lang->load("users", 'english');
        $this->lang->load("system", 'english');

        //$this->output->enable_profiler(TRUE);
    }
    //---------------------------------------------------------------


    /**
     * Default action to be called
     */
    public function index()
    {


        //$this->data['captcha'] = $this->captcha(); 
        //check if the user is already logedin
        if ($this->user_m->loggedIn() == TRUE) {
            $homepage_path = $this->session->userdata('role_homepage_uri');
            redirect(ADMIN_DIR . $homepage_path);
        }

        //load other models
        $this->load->model("role_m");
        $this->load->model("module_m");

        $validations = array(
            /*array(
                'field' =>  'user_email',
                'label' =>  'Email Address',
                'rules' =>  'valid_email|required'
            ),
            */
            array(
                'field' =>  'user_password',
                'label' =>  'Password',
                'rules' =>  'required'
            )
        );
        $this->form_validation->set_rules($validations);
        if ($this->form_validation->run() === TRUE) {

            $input_values = array(
                'user_name' => $this->input->post("user_email"),
                'user_password' => $this->input->post("user_password"),
                'status' => 1
            );

            //get the user
            $user = $this->user_m->getBy($input_values, TRUE);
            //var_dump($user);
            //exit;

            if (count($user) > 0) {

                //
                $role_homepage_id = $this->role_m->getCol("role_homepage", $user->role_id);
                $role_homepage_parent_id = $this->module_m->getCol("parent_id", $role_homepage_id);

                //now create homepage path
                $homepage_path = "";
                if ($role_homepage_parent_id != 0) {
                    $homepage_path .= $this->module_m->getCol("module_uri", $role_homepage_parent_id) . "/";
                }
                $homepage_path .= $this->module_m->getCol("module_uri", $role_homepage_id);

                $fields = "roles.*";
                $join  = array();
                $where = "roles.role_id = $user->role_id";
                $role = $roles = $this->role_m->joinGet($fields, "roles", $join, $where);

                //get user projects  by role id



                $user_data = array(
                    "user_id"  => $user->user_id,
                    "user_email" => $user->user_email,
                    "user_title" => $user->user_title,
                    "role_id" => $user->role_id,
                    "profile_complete" => 1,
                    "role_level" =>  $role[0]->role_level,
                    "district_id" => '',
                    "role_homepage_id" => $role_homepage_id,
                    "role_homepage_uri" => $homepage_path,
                    "ngo_id" => '',
                    "user_image" => $user->user_image,
                    "user_unique_id" => md5(uniqid(rand(), TRUE)),
                    "logged_in" => TRUE
                );


                //add to session
                $this->session->set_userdata($user_data);
                //var_dump($this->session->userdata);
                //exit;
                $this->session->set_flashdata('msg_success', "<strong>" . $user->user_title . '</strong><br/><i>welcome to admin panel</i>');

                redirect(ADMIN_DIR . $homepage_path);
            } else {
                $this->session->set_flashdata('msg', 'User Name or Password is incorrect or Your Are not Allowed to Access this Admin Section ');
                redirect(ADMIN_DIR . "login");
            }
        } else {

            $this->data['title'] = "Login to dashboard";
            $this->load->view(ADMIN_DIR . "login/login", $this->data);
        }
    }
}
