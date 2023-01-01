<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Dr_dashboard extends Admin_Controller
{

	/**
	 * constructor method
	 */
	public function __construct()
	{

		parent::__construct();
		$this->lang->load("patients", 'english');
		$this->lang->load("system", 'english');
		$this->load->model("admin/test_group_model");
		$this->load->model("admin/reports_model");
		$this->load->model("admin/invoice_model");
		$this->load->model("admin/test_type_model");


		$this->load->model("admin/patient_model");
		$this->load->model("admin/patient_test_model");

		// $this->load->model("admin/patient_model");
		//$this->output->enable_profiler(TRUE);
	}

	public function index()
	{
		// $where = "`test_groups`.`status` IN (1) AND category_id!=5 ORDER BY  test_group_name ASC";
		// $this->data["test_groups"] = $this->test_group_model->get_test_group_list($where, false);
		// $this->data["test_categories"] = $this->test_type_model->getList("test_categories", "test_category_id", "test_category", $where = "`test_categories`.`status` IN (1) ");
		$user_id = $this->session->userdata('user_id');
		$query = "SELECT test_group_ids FROM users WHERE user_id ='" . $user_id . "'";
		$dr_opd = $this->db->query($query)->row()->test_group_ids;


		// $where = "`invoices`.`status` IN (2) AND DATE(`invoices`.`created_date`) = DATE(NOW())  
		// ORDER BY `invoices`.`invoice_id` ASC";
		$where = "`invoices`.`status` IN (2) 
		AND opd_doctor = '" . $dr_opd . "' 
		ORDER BY `invoices`.`invoice_id` ASC";
		$this->data["new_appointments"] = $this->invoice_model->get_invoice_list($where, false);

		// $where = "`invoices`.`status` IN (3) AND DATE(`invoices`.`created_date`) = DATE(NOW())  
		// ORDER BY `invoices`.`invoice_id` ASC";
		$where = "`invoices`.`status` IN (3) 
		AND opd_doctor = '" . $dr_opd . "'  
		ORDER BY `invoices`.`invoice_id` ASC";
		$this->data["completed_appointments"] = $this->invoice_model->get_invoice_list($where, false);
		$this->data["view"] = ADMIN_DIR . "dr_dashboard/dashboard";
		$this->load->view(ADMIN_DIR . "layout", $this->data);
	}

	function patient_history($invoice_id)
	{
		$invoice_id = (int) $invoice_id;
		$this->data["view"] = ADMIN_DIR . "dr_dashboard/patient_history";
		$this->load->view(ADMIN_DIR . "layout", $this->patient_data($invoice_id));
	}

	public function patient_data($invoice_id)
	{
		$invoice_id = (int) $invoice_id;
		$this->data["invoice_id"] = $invoice_id;
		$where = "`invoices`.`status` IN (1,2,3) AND `invoices`.`invoice_id`= '" . $invoice_id . "'";
		$this->data["invoice_detail"] = $this->invoice_model->get_invoice_list($where, false)[0];

		$patient_test_ids = "";
		$query = "SELECT
			`test_groups`.`test_group_id`,
			`test_groups`.`test_group_name`
			, `test_groups`.`test_time` 
		FROM `test_groups`,
				`patient_tests` 
		WHERE `test_groups`.`test_group_id` = `patient_tests`.`test_group_id`
		AND `patient_tests`.`invoice_id`=$invoice_id
		GROUP BY `test_groups`.`test_group_name`
		ORDER BY `patient_tests`.`patient_test_id` ASC;";

		$patient_tests_groups = $this->db->query($query)->result();
		foreach ($patient_tests_groups as $patient_tests_group) {
			$patient_test_ids .= $patient_tests_group->test_group_id . ", ";
			$where = "`patient_tests`.`invoice_id` = '" . $invoice_id . "'
			AND `patient_tests`.`test_group_id` = '" . $patient_tests_group->test_group_id . "' ";
			$patient_tests_group->patient_tests = $this->patient_test_model->get_patient_test_list($where, false);
		}
		$this->data["patient_tests_groups"] = $patient_tests_groups;
		$this->data["patient_test_ids"] = rtrim($patient_test_ids, ", ");

		$query = "SELECT * FROM `invoices` WHERE `invoices`.`invoice_id`=$invoice_id;";
		$invoice = $this->db->query($query)->result()[0];
		$query = "SELECT 
					`test_groups`.`test_group_name`, 
					`invoice_test_groups`.`price`,
					`test_groups`.`test_price`,
					`test_groups`.`test_time` 
				FROM
					`invoice_test_groups`,
					`test_groups` 
				WHERE `invoice_test_groups`.`test_group_id` = `test_groups`.`test_group_id` 
				AND `invoice_test_groups`.`invoice_id`=$invoice_id;";
		$invoice->invoice_details = $this->db->query($query)->result();
		$this->data["invoice"] = $invoice;
		return $this->data;
	}

	public function add_prescriptions($invoice_id)
	{
		$invoice_id = (int) $invoice_id;
		$dr_prescriptions = $this->db->escape($this->input->post("dr_prescriptions"));
		$query = "UPDATE `invoices` 
				SET  `dr_prescriptions`= $dr_prescriptions
			    WHERE `invoice_id` = '" . $invoice_id . "'";
		$this->db->query($query);
		redirect(ADMIN_DIR . "dr_dashboard/patient_history/$invoice_id");
	}

	public function mark_as_complete($invoice_id)
	{

		$invoice_id = (int) $invoice_id;
		$completed_date = date('Y-m-d H:i:s');
		$user_id = $this->session->userdata('user_id');
		$query = "UPDATE `invoices` 
				SET `status`='3', `completed_date` = '" . $completed_date . "',
				`test_report_by` = '" . $user_id . "'
			    WHERE `invoice_id` = '" . $invoice_id . "'";

		if ($this->db->query($query)) {
			redirect(ADMIN_DIR . "dr_dashboard/patient_history/$invoice_id");
		} else {
			redirect(ADMIN_DIR . "dr_dashboard/patient_history/$invoice_id");
		}
	}

	public function print_patient_report($invoice_id)
	{
		$_POST['invoice_id'] = $invoice_id;
		$this->load->view(ADMIN_DIR . "dr_dashboard/print_patient_report", $this->patient_test_data());
	}

	public function patient_test_data()
	{
		$invoice_id = (int) $this->input->post('invoice_id');
		$this->data["invoice_id"] = $invoice_id;
		$where = "`invoices`.`status` IN (1,2,3) AND `invoices`.`invoice_id`= '" . $invoice_id . "'";
		$this->data["invoice_detail"] = $this->invoice_model->get_invoice_list($where, false)[0];

		$query = "SELECT
			`test_groups`.`test_group_id`,
			`test_groups`.`test_group_name`
			, `test_groups`.`test_time` 
		FROM `test_groups`,
				`patient_tests` 
		WHERE `test_groups`.`test_group_id` = `patient_tests`.`test_group_id`
		AND `patient_tests`.`invoice_id`=$invoice_id
		GROUP BY `test_groups`.`test_group_name`;";

		$patient_tests_groups = $this->db->query($query)->result();
		foreach ($patient_tests_groups as $patient_tests_group) {
			$where = "`patient_tests`.`invoice_id` = '" . $invoice_id . "'
			AND `patient_tests`.`test_group_id` = '" . $patient_tests_group->test_group_id . "' ";
			$patient_tests_group->patient_tests = $this->patient_test_model->get_patient_test_list($where, false);
		}
		$this->data["patient_tests_groups"] = $patient_tests_groups;


		$query = "SELECT * FROM `invoices` WHERE `invoices`.`invoice_id`=$invoice_id;";
		$invoice = $this->db->query($query)->result()[0];
		$query = "SELECT 
					`test_groups`.`test_group_name`, 
					`invoice_test_groups`.`price`,
					`test_groups`.`test_price`,
					`test_groups`.`test_time` 
				FROM
					`invoice_test_groups`,
					`test_groups` 
				WHERE `invoice_test_groups`.`test_group_id` = `test_groups`.`test_group_id` 
				AND `invoice_test_groups`.`invoice_id`=$invoice_id;";
		$invoice->invoice_details = $this->db->query($query)->result();
		$this->data["invoice"] = $invoice;
		return $this->data;
	}
}
