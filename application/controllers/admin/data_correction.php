<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class data_correction extends Admin_Controller
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
		$this->load->model("admin/invoice_model");
		$this->load->model("admin/test_type_model");


		$this->load->model("admin/patient_model");
		// $this->load->model("admin/patient_model");
		//$this->output->enable_profiler(TRUE);
	}
	//---------------------------------------------------------------




	/**
	 * Default action to be called
	 */
	public function index()
	{

		$where = "`test_groups`.`status` IN (1) ORDER BY  test_group_name ASC";
		$this->data["test_groups"] = $this->test_group_model->get_test_group_list($where, false);
		$this->data["test_categories"] = $this->test_type_model->getList("test_categories", "test_category_id", "test_category", $where = "`test_categories`.`status` IN (1) ");

		$this->data["title"] = "Data Correction";

		$where = "`invoices`.`status` IN (1,2,3) AND DATE(`invoices`.`created_date`) = DATE(NOW())  ORDER BY `invoices`.`invoice_id` DESC";
		$this->data["all_tests"] = $this->invoice_model->get_invoice_list($where, false);
		$this->data["view"] = ADMIN_DIR . "data_correction/data_correction";
		$this->load->view(ADMIN_DIR . "layout", $this->data);
	}

	public function cancel_receipt()
	{
		$invoice_id = (int) $this->input->post('invoice_id');
		$receipt_token = (int) $this->input->post('receipt_token');

		$query = "SELECT test_token_id FROM `invoices` WHERE invoice_id = '" . $invoice_id . "'";
		$invoice_token_id = $this->db->query($query)->result()[0]->test_token_id;
		if ($receipt_token == $invoice_token_id) {
			$cancel_reason = $this->db->escape(ucwords(str_replace("_", " ", $this->input->post('cancel_reason'))));
			$cancel_reason_detail = $this->db->escape($this->input->post('cancel_reason_detail'));
			$query = "UPDATE invoices
			          SET is_deleted=1, 
					  cancel_reason=$cancel_reason,  
					  cancel_reason_detail=$cancel_reason_detail 
					  WHERE invoice_id= $invoice_id";
			if ($this->db->query($query)) {
				$this->session->set_flashdata("msg_success", "Receipt Cancelled Successfully.");
				redirect(ADMIN_DIR . "data_correction");
			} else {
				$this->session->set_flashdata("msg_error", "DB Error try again.");
				redirect(ADMIN_DIR . "data_correction");
			}
		} else {
			$this->session->set_flashdata("msg_error", "Receipt token not matched. try again with valid token number.");
			redirect(ADMIN_DIR . "data_correction");
		}
	}

	public function add_discount()
	{

		$discount = (int) $this->input->post("discount");

		$invoice_id = (int) $this->input->post("invoice_id");
		$query = "SELECT price, sale_tax FROM invoices WHERE invoice_id = '" . $invoice_id . "'";
		$invoice_data = $this->db->query($query)->row();
		$invoice_price = $invoice_data->price;
		$tax = $invoice_data->sale_tax;
		$inputs = array();
		if ($discount) {
			$inputs['discount_type_id'] = $this->input->post("discount_type_id");
			$inputs['discount_ref_by'] = $this->input->post("discount_ref_by");
		} else {
			$inputs['discount_type_id'] = "";
			$inputs['discount_ref_by'] = "";
		}
		$inputs["total_price"]  =   ($invoice_price + $tax) - $discount;
		$inputs['discount'] = $this->input->post("discount");
		if ($this->invoice_model->save($inputs, $invoice_id)) {
			$this->session->set_flashdata("msg_success", "Discount Add Successfully");
			redirect(ADMIN_DIR . "data_correction");
		} else {
			$this->session->set_flashdata("msg_success", "DB Error While Discount Entry");
			redirect(ADMIN_DIR . "data_correction");
		}
	}

	public function undo_cancelation($invoice_id)
	{

		$invoice_id = (int) $invoice_id;
		$query = "UPDATE invoices
			          SET is_deleted=0, 
					  cancel_reason= NULL,  
					  cancel_reason_detail= NULL 
					  WHERE invoice_id= $invoice_id";
		if ($this->db->query($query)) {
			$this->session->set_flashdata("msg_success", "Receipt Cancellation Undo Successfully.");
			redirect(ADMIN_DIR . "data_correction");
		} else {
			$this->session->set_flashdata("msg_error", "DB Error try again.");
			redirect(ADMIN_DIR . "data_correction");
		}
	}
}
