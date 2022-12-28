<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Roles extends Admin_Controller
{

    public function __construct()
    {

        parent::__construct();
        $this->load->model("role_m");
        $this->lang->load("system", 'english');
    }
    //--------------------------------------------------


    public function index()
    {
        $main_page = base_url() . ADMIN_DIR . $this->router->fetch_class() . "/view";
        redirect($main_page);
    }
    //--------------------------------------------------

    public function view()
    {

        $query = "SELECT 
				  `modules`.`module_title`,
				  `roles`.* 
				FROM
				  `roles`,
				  `modules` 
				WHERE `roles`.`role_homepage` = `modules`.`module_id` 
				AND roles.status IN (0,1)
				AND `roles`.`role_id` !=1";
        $query_result = $this->db->query($query);
        $this->data['data'] =     $query_result->result();

        /* $fields = "roles.*, modules.module_title";
        $join  = array(
            "modules" => "roles.role_homepage = modules.module_id"
        );
        $where = "roles.status in (0,1)";*/

        $this->data['title'] = "Roles";
        //$this->data['data'] = $this->role_m->joinGet($fields, "roles", $join, $where);
        //var_dump($this->data['data']);
        $this->data["view"] = ADMIN_DIR . "roles/roles";
        $this->load->view(ADMIN_DIR . "layout", $this->data);
    }
    //--------------------------------------------------------


    /**
     * add new role
     */
    public function add_role()
    {

        //load required models
        $this->load->model("mr_m");
        $this->load->model("module_m");
        $module_ids = explode(",", $this->input->post("checked_modules"));



        //validation configuration
        $validation_config = array(
            array(
                'field' =>  'role_title',
                'label' =>  'Role Title',
                'rules' =>  'trim|required'
            ),
            array(
                'field' => 'role_level',
                'label' => 'Role Level',
                'rules' => 'trim|required'
            ),
            array(
                'field' =>  'checked_modules',
                'label' =>  'Modules',
                'rules' =>  'trim|is_string'
            )
        );
        $this->form_validation->set_rules($validation_config);
        if ($this->form_validation->run() === TRUE) {

            $inputs = array(
                'role_title'    =>  $this->input->post('role_title'),
                'role_desc'     =>  $this->input->post('role_desc'),
                'role_homepage' =>  $this->input->post('role_homepage'),
                'role_level'    =>  $this->input->post('role_level'),
                'status'   =>  $this->input->post('status')
            );

            $role_id = $this->role_m->save($inputs);

            if ($role_id) {
                //now save all checked modules
                $compiled_module_ids = $this->module_m->compileModuleIds($module_ids);
                if (count($compiled_module_ids) > 1) {
                    $this->mr_m->addRights($role_id, $compiled_module_ids);
                }




                $this->session->set_flashdata('msg_success', 'New role has been created successfully');
                redirect(ADMIN_DIR . 'roles/roles');
            } else {
                $this->session->set_flashdata('msg_error', "Something's wrong, Please try later");
                redirect(ADMIN_DIR . 'roles/add_role');
            }
        } else {


            $this->data['module_tree'] = $this->module_m->modulesTree();
            $this->data['modules'] = $this->module_m->get();
            $this->data['title'] = "Create new role";
            $this->data['view'] = ADMIN_DIR . "roles/add_role";
            $this->load->view(ADMIN_DIR . "layout", $this->data);
        }
    }
    //--------------------------------------------------------------


    /**
     * edit a role
     * @param $role_id integer
     */
    public function edit_role($role_id)
    {



        //load required models
        $this->load->model("mr_m");
        $this->load->model("module_m");

        //get this controller data to populate form
        $role_id = (int) $role_id;
        $this->data['role'] = $this->role_m->get($role_id);
        $module_ids = explode(",", $this->input->post("checked_modules"));


        //validation configuration
        $validation_config = array(
            array(
                'field' =>  'role_title',
                'label' =>  'Role Title',
                'rules' =>  'trim|required'
            ),
            array(
                'field' => 'role_level',
                'label' => 'Role Level',
                'rules' => 'trim|required'
            ),
            array(
                'field' =>  'checked_modules',
                'label' =>  'Modules',
                'rules' =>  'trim|is_string'
            )
        );
        $this->form_validation->set_rules($validation_config);
        if ($this->form_validation->run() === TRUE) {



            $inputs = array(
                'role_title'    =>  $this->input->post('role_title'),
                'role_desc'     =>  $this->input->post('role_desc'),
                'role_homepage' =>  $this->input->post('role_homepage'),
                'role_level'    =>  $this->input->post('role_level'),
                'status'   =>  $this->input->post('status')
            );

            if ($this->role_m->save($inputs, $role_id)) {

                //now lets process modules rights
                $this->mr_m->deleteRights($role_id);
                //get parent module ids and compile the array
                $compiled_module_ids = $this->module_m->compileModuleIds($module_ids);
                if (count($compiled_module_ids) > 1) {
                    $this->mr_m->addRights($role_id, $compiled_module_ids);
                }

                // add project partneres........
                $inputs = array();


                $this->session->set_flashdata('msg_success', 'Role has been updated successfully');
                redirect(ADMIN_DIR . 'roles/edit_role/' . $role_id);
            } else {
                $this->session->set_flashdata('msg_error', "Something's wrong, Please try later");
                redirect(ADMIN_DIR . 'roles/edit_role/' . $role_id);
            }
        } else {


            $this->data['module_tree'] = $this->module_m->modulesTree();
            $this->data['this_role_rights'] = $this->mr_m->rightsByRole($role_id);
            $this->data['modules'] = $this->module_m->get();
            $this->data['title'] = "Edit role";
            $this->data['view'] = ADMIN_DIR . "roles/edit_role";
            $this->load->view(ADMIN_DIR . "layout", $this->data);
        }
    }
    //-----------------------------------------------------------------------



    /**
     * function to send a role to trash
     */
    public function trash_role($role_id)
    {

        $role_id = (int) $role_id;
        $this->role_m->changeStatus($role_id, "2");
        $this->session->set_flashdata('msg_success', 'Role has been send to trash');
        redirect(ADMIN_DIR . "roles/roles");
    }


    /**
     * function to list of trashed roles
     */
    public function trashed_roles()
    {

        $this->data['title'] = "Trash";
        $this->data['data'] = $this->role_m->getRolesModule("2");
        $this->data["view"] = ADMIN_DIR . "roles/trashed_roles";
        $this->load->view(ADMIN_DIR . "layout", $this->data);
    }
    //----------------------------------------------------------------------------



    /**
     * function to restor role from trash
     * @param $role_id integer
     */
    public function restore_role($role_id)
    {

        $role_id = (int) $role_id;
        $this->role_m->changeStatus($role_id, "1");
        $this->session->set_flashdata("msg_success", "Role has been restored");
        redirect(ADMIN_DIR . "roles/trashed_roles");
    }
    //---------------------------------------------------------------------------


    /**
     * function to permanently delete role
     * @param $role_id integer
     */
    public function delete_role($role_id)
    {

        $this->load->model("mr_m");

        $role_id = (int) $role_id;
        $this->role_m->changeStatus($role_id, "3");

        //now delete all rights of this role
        //$this->mr_m->deleteRights($role_id);

        $this->session->set_flashdata("msg_success", "Role has been permanently deleted!");
        redirect(ADMIN_DIR . "roles/trashed_roles");
    }
    //-------------------------------------------------------------------------------

    /*public function test($r){
        $this->load->model("mr_m");
        $this->mr_m->rightsByRole($r);
     }*/


    public function role_modules($role_id)
    {
        $role_id = (int) $role_id;
        $this->data['role_id'] = $role_id;
        $query = "SELECT
				`module_rights`.`module_right_id`,
				`module_rights`.`order`,
					`modules`.`module_title`
					, `roles`.`role_title`
					, `modules`.`parent_id`
				FROM
				`module_rights`,
				`modules`,
				`roles` 
				WHERE `module_rights`.`module_id` = `modules`.`module_id`
				AND `roles`.`role_id` = `module_rights`.`role_id`
				AND `modules`.`parent_id` = 0
				AND `roles`.`role_id` = " . $role_id . " ORDER BY `order` ASC";
        $query_result = $this->db->query($query);
        $this->data['RoleModules'] = $RoleModules = $query_result->result();

        foreach ($RoleModules as $RoleModule) {

            if (is_null($RoleModule->order)) {
                $query = "UPDATE `module_rights` SET `order` = '" . $RoleModule->module_right_id . "' WHERE `module_rights`.`module_right_id` =" . $RoleModule->module_right_id;
                $this->db->query($query);
            }
        }

        $this->data['title'] = "Order Role Modules";



        $this->data["view"] = ADMIN_DIR . "roles/role_modules";
        $this->load->view(ADMIN_DIR . "layout", $this->data);
    }

    public function up($role_id, $module_right_id)
    {
        $module_right_id = (int) $module_right_id;
        $role_id = (int)  $role_id;
        $query = "SELECT  `module_rights`.`order` as current_module_order FROM `module_rights` WHERE `module_rights`.`module_right_id` = " . $module_right_id;
        $query_result = $this->db->query($query);
        $current_module_order = $query_result->result()[0]->current_module_order;

        $query = "SELECT  `module_rights`.`order` as pre_order,`module_rights`.`module_right_id` as pre_id  FROM `module_rights` WHERE `module_rights`.`order` <= " . $current_module_order;
        $query_result = $this->db->query($query);
        $pre_order = $query_result->result()[0]->pre_order;
        $pre_id = $query_result->result()[0]->pre_id;

        $query = "UPDATE `module_rights` SET `order` = '" . $pre_order . "' WHERE `module_rights`.`module_right_id` =" . $module_right_id;
        $this->db->query($query);

        $query = "UPDATE `module_rights` SET `order` = '" . $current_module_orde . "' WHERE `module_rights`.`module_right_id` =" . $pre_id;
        $this->db->query($query);

        redirect(ADMIN_DIR . "roles/role_modules/$role_id");
    }
}
