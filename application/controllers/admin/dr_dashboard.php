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

	public function add_visit()
	{
		$patient_id = (int) $this->input->post('patient_id');
		$history_id = (int) $this->input->post('history_id');
		$query = "SELECT COUNT(*) as total FROM patient_visits 
		          WHERE patient_id = '" . $patient_id . "'
				  AND history_id = '" . $history_id . "'";
		$visit_no = $this->db->query($query)->row()->total;
		if ($visit_no <= 0) {
			$visit_no = 1;
		} else {
			$visit_no++;
		}
		$user_id = $this->session->userdata('user_id');

		$query = "UPDATE `patient_visits` SET `status`=0 WHERE created_by = '" . $user_id . "'
		and patient_id = '" . $patient_id . "'";
		$this->db->query($query);

		$query = "INSERT INTO `patient_visits`(`visit_no`, `history_id`, `patient_id`, `remarks`, `created_by`) 
		          VALUES ('" . $visit_no . "', '" . $history_id . "', '" . $patient_id . "', '', '" . $user_id . "')";
		$this->db->query($query);
		redirect(ADMIN_DIR . "dr_dashboard/patient_history/$history_id");
	}
	public function update_visit()
	{
		$visit_id = (int) $this->input->post('visit_id');
		$patient_id = (int) $this->input->post('patient_id');
		$history_id = (int) $this->input->post('history_id');
		$dr_prescriptions = $this->db->escape($this->input->post("dr_prescriptions"));
		$query = "UPDATE `patient_visits` SET `remarks`=" . $dr_prescriptions . " WHERE visit_id = '" . $visit_id . "'";
		$this->db->query($query);
		redirect(ADMIN_DIR . "dr_dashboard/patient_history/$history_id");
	}

	public function upload_attachment()
	{
		$config = array(
			"upload_path" => "./assets/uploads/reception/",
			"allowed_types" => "jpg|jpeg|bmp|png|gif|doc|docx|xlsx|xls|pdf|ppt|pptx|webp|mp4",
			"max_size" => 1024 * 100,
			"max_width" => 0,
			"max_height" => 0,
			"remove_spaces" => true,
			"encrypt_name" => true
		);
		if ($this->upload_file("attchment_file", $config)) {
			$attchment_file = $this->data["upload_data"]["file_name"];
		} else {
			$attchment_file = "";
		}
		$name = $this->input->post('attachment_name');
		$detail = $this->input->post('attachment_detail');
		$invoice_id = $this->input->post('invoice_id');
		$visit_id = $this->input->post('visit_id');


		$query = "INSERT INTO `patient_attachments`(`name`, `detail`, `file`, `invoice_id`, `visit_id`) 
		          VALUES ('" . $name . "','" . $detail . "','" . $attchment_file . "', '" . $invoice_id . "', '" . $visit_id . "')";
		if ($this->db->query($query)) {
			redirect(ADMIN_DIR . "dr_dashboard/patient_history/$invoice_id");
		} else {
			redirect(ADMIN_DIR . "dr_dashboard/patient_history/$invoice_id");
		}
	}
	public function delete_attachement($invoice_id, $attachment_id)
	{
		$invoice_id = (int) $invoice_id;
		$attachment_id = (int) $attachment_id;
		$query = "SELECT * FROM patient_attachments WHERE invoice_id = '" . $invoice_id . "' and id = '" . $attachment_id . "'";
		$attachment = $this->db->query($query)->row();
		$this->delete_file($attachment->file);
		$query = "DELETE FROM patient_attachments WHERE invoice_id = '" . $invoice_id . "' and id = '" . $attachment_id . "'";
		if ($this->db->query($query)) {
			redirect(ADMIN_DIR . "dr_dashboard/patient_history/$invoice_id");
		} else {
			redirect(ADMIN_DIR . "dr_dashboard/patient_history/$invoice_id");
		}
	}
	public function delete_file($file_path)
	{

		@$path_parts = pathinfo($file_path);
		@$orginal_file = FCPATH . "assets/uploads/" . $file_path;
		@$thumb_file = FCPATH . "assets/uploads/" . $path_parts['dirname'] . "/" . $path_parts['filename'] . "_thumb." . $path_parts['extension'];
		@unlink($orginal_file);
		@unlink($thumb_file);
		return true;
	}

	public function get_visit_update_form()
	{
		$this->data['visit_id'] = (int) $this->input->post('id');
		$this->data['patient_id'] = (int) $this->input->post('patient_id');
		$this->data['history_id'] = (int) $this->input->post('history_id');
		$this->load->view(ADMIN_DIR . "dr_dashboard/get_visit_update_form", $this->data);
	}
}
