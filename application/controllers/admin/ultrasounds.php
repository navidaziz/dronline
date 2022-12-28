<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Ultrasounds extends Admin_Controller
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
		$this->load->model("admin/patient_test_model");
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

		$user_id = $this->session->userdata("user_id");
		$query = "SELECT test_group_ids FROM users WHERE user_id = '" . $user_id . "'";
		$test_group_ids = $this->db->query($query)->row()->test_group_ids;

		$where = "`invoices`.`status` IN (1) AND opd_doctor = '" . $test_group_ids . "' AND category_id=5 AND DATE(`invoices`.`created_date`) = DATE(NOW()) AND `is_deleted`=0 ORDER BY `invoices`.`invoice_id` DESC";
		$this->data["forwarded_tests"] = $this->invoice_model->get_invoice_list($where, false);


		$where = "`invoices`.`status` IN (2) AND opd_doctor = '" . $test_group_ids . "' AND  category_id=5 AND DATE(`invoices`.`created_date`) = DATE(NOW()) ORDER BY `invoices`.`invoice_id` DESC";
		$this->data["inprogress_tests"] = $this->invoice_model->get_invoice_list($where, false);

		$where = "`invoices`.`status` IN (3) AND opd_doctor = '" . $test_group_ids . "' AND category_id=5 AND DATE(`invoices`.`created_date`) = DATE(NOW()) ORDER BY `invoices`.`invoice_id` DESC";
		$this->data["completed_tests"] = $this->invoice_model->get_invoice_list($where, false);


		$this->load->view(ADMIN_DIR . "ultrasound/home", $this->data);
	}

	public function save_data()
	{




		//save patient data and get pacient id ....
		$patient_id = $this->patient_model->save_data();
		//var_dump($_POST);
		$test_group_ids =  implode(',', $this->input->post('test_group_id'));




		$discount = $this->input->post("discount");
		$tax = $this->input->post("tax");
		$refered_by = $this->input->post("refered_by");

		$query = "SELECT SUM(`test_price`) as `total_test_price` 
				FROM `test_groups` 
				WHERE `test_groups`.`test_group_id` IN (" . $test_group_ids . ")";
		$query_result = $this->db->query($query);
		$total_test_price = $query_result->result()[0]->total_test_price;


		$inputs = array();
		$inputs["patient_id"]  =  $patient_id;
		$inputs["discount"]  =  $discount;
		$inputs["price"]  =  $total_test_price;
		$inputs["sale_tax"]  =  $tax;
		$inputs["total_price"]  =  ($total_test_price + $tax) - $discount;
		$inputs["patient_refer_by"]  =  $refered_by;

		$invoice_id  = $this->invoice_model->save($inputs);


		$where = "`test_groups`.`test_group_id` IN (" . $test_group_ids . ") ORDER BY `test_groups`.`order`";
		$patient_test_groups = $this->test_group_model->get_test_group_list($where, false);
		foreach ($patient_test_groups as $patient_test_group) {
			$query = "INSERT INTO `invoice_test_groups`(`invoice_id`, `patient_id`, `test_group_id`, `price`) 
				    VALUES ('" . $invoice_id . "', '" . $patient_id . "', '" . $patient_test_group->test_group_id . "', '" . $patient_test_group->test_price . "')";
			$this->db->query($query);
		}


		$this->session->set_flashdata("msg_success", "Data Save Successfully.");
		redirect(ADMIN_DIR . "reception");
	}

	public function save_and_process()
	{

		$invoice_id = (int) $this->input->post("invoice_id");
		$test_token_id = (int) $this->input->post("test_token_id");
		if ($this->input->post("patient_group_test_ids")) {
			$group_ids = trim(trim($this->input->post("patient_group_test_ids")), ",");
		} else {
			$group_ids = 0;
		}
		//$group_ids = trim(trim($this->input->post("patient_group_test_ids")), ",");
		$process_date = date('Y-m-d H:i:s');
		$query = "UPDATE `invoices` 
				SET `test_token_id`='" . $test_token_id . "',
				    `test_report_by`='" . $this->session->userdata("user_id") . "',
					`status`='2',
					`process_date` = '" . $process_date . "'
			    WHERE `invoice_id` = '" . $invoice_id . "'";
		$this->db->query($query);

		$query = "SELECT 
				  `test_group_tests`.`test_group_id`,
				  `tests`.`test_id`,
				  `tests`.`test_category_id`,
				  `tests`.`test_type_id`,
				  `tests`.`test_name`,
				  `tests`.`test_description`,
				  `tests`.`normal_values` 
				FROM
				  `tests`,
				  `test_group_tests`
				WHERE  `tests`.`test_id` = `test_group_tests`.`test_id` 
				AND `test_group_tests`.`test_group_id` IN (" . $group_ids . ") 
				ORDER BY `test_group_tests`.`test_group_id` ASC, `test_group_tests`.`order` ASC";
		$query_result = $this->db->query($query);
		$all_tests = $query_result->result();
		$order = 1;
		foreach ($all_tests as $test) {
			$query = "INSERT INTO `patient_tests`(`invoice_id`, 
												  `test_group_id`, 
												  `test_category_id`, 
												  `test_type_id`, 
												  `test_id`, 
												  `test_name`, 
												  `test_normal_value`, 
												  `test_result`, 
												  `remarks`,
												  `created_by`,
												  `order`) 
										VALUES('" . $invoice_id . "',
											   '" . $test->test_group_id . "',
											   '" . $test->test_category_id . "',
											    '" . $test->test_type_id . "',
												'" . $test->test_id . "',
												'" . $test->test_name . "',
												'" . $test->normal_values . "',
												'',
												'',
												'" . $this->session->userdata("user_id") . "',
												'" . $order++ . "')";
			$this->db->query($query);
		}



		redirect(ADMIN_DIR . "ultrasounds/index");
	}

	public function get_patient_test_form()
	{

		$this->load->view(ADMIN_DIR . "ultrasound/get_patient_test_form", $this->patient_test_data());
	}

	public function get_patient_test_report()
	{
		$this->load->view(ADMIN_DIR . "ultrasound/get_patient_test_report", $this->patient_test_data());
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

	public function update_test_value()
	{

		$patient_test_id = (int) $this->input->post("patient_test_id");
		$partient_test_value = $this->input->post("partient_test_value");
		$query = "UPDATE `patient_tests` 
				  SET `test_result`='" . $partient_test_value . "' 
				  WHERE `patient_test_id`='" . $patient_test_id . "'";
		$this->db->query($query);
	}


	public function update_test_remark()
	{

		$patient_test_id = (int) $this->input->post("patient_test_id");
		$partient_test_remark = $this->input->post("partient_test_remark");
		$query = "UPDATE `patient_tests` 
				  SET `remarks`='" . $partient_test_remark . "' 
				  WHERE `patient_test_id`='" . $patient_test_id . "'";
		$this->db->query($query);
	}

	public function complete_test()
	{

		if ($this->input->post('test_values')) {
			$test_values = $this->input->post('test_values');
			foreach ($test_values as $patient_test_id => $test_value) {
				$query = "UPDATE `patient_tests` 
				  SET `test_result`=" . $this->db->escape($test_value) . " 
				  WHERE `patient_test_id`=" . $this->db->escape($patient_test_id) . "";
				$this->db->query($query);
			}
		}

		$reported_date = date('Y-m-d H:i:s');
		$invoice_id = (int) $this->input->post("invoice_id");
		$remarks = $this->db->escape($this->input->post("test_remarks"));
		$query = "UPDATE `invoices` 
				SET `status`='3'
				, `remarks`= $remarks
				, `reported_date` = '" . $reported_date . "'
			    WHERE `invoice_id` = '" . $invoice_id . "'";
		$this->db->query($query);
		// $query = "SELECT 
		// 	`invoices`.`invoice_id`,
		// 	`patients`.`patient_name`,
		// 	`patients`.`patient_mobile_no` 
		// FROM
		// 	`patients`,
		// 	`invoices` 
		// WHERE `patients`.`patient_id` = `invoices`.`patient_id` 
		// AND `invoices`.`invoice_id` = '" . $invoice_id . "'";
		// $patient_detail = $this->db->query($query)->result()[0];
		// $customer_name = $patient_detail->patient_name;
		// $mobile_number = $patient_detail->patient_mobile_no;
		// $message = 'CITY Medical Laboratory. Dear ' . $customer_name . ', your laboratory test report has been ready. kindly collect your laboratory test report.';
		// if (strlen($mobile_number) == 11) {
		// 	if (substr($mobile_number, 0, 2) == '03') {
		// 		$this->db->query("INSERT INTO `sms`( `message`, `mobile_number`, `status`,`priority`) 
		//    						  VALUES ('" . $message . " ', " . $this->db->escape($mobile_number) . ", '0', '1')");
		// 	}
		// }
		redirect(ADMIN_DIR . "ultrasounds/index");
	}

	public function print_patient_test_receipts($invoice_id)
	{
		$_POST['invoice_id'] = (int) $invoice_id;

		$this->load->view(ADMIN_DIR . "ultrasound/print_patient_test_receipts", $this->patient_test_data());
	}


	public function print_patient_test_report($invoice_id)
	{
		$_POST['invoice_id'] = $invoice_id;
		$this->load->view(ADMIN_DIR . "ultrasound/print_test_report", $this->patient_test_data());
	}

	public function print_patient_test_type_report($invoice_id)
	{
		$_POST['invoice_id'] = $invoice_id;
		$this->load->view(ADMIN_DIR . "ultrasound/print_test_type_report", $this->patient_test_type_data());
	}


	public function patient_test_type_data()
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
			$query = "SELECT
									`test_types`.`test_type`
									, `patient_tests`.`test_type_id`
								FROM `test_types`,
								`patient_tests`
								WHERE `test_types`.`test_type_id` = `patient_tests`.`test_type_id`
								AND `patient_tests`.`test_group_id`= '" . $patient_tests_group->test_group_id . "'
								AND `patient_tests`.`invoice_id`='" . $invoice_id . "'
								GROUP BY `patient_tests`.`test_type_id`";
			$patient_tests_types = $this->db->query($query)->result();
			foreach ($patient_tests_types as $patient_tests_type) {
				$where = "`patient_tests`.`invoice_id` = '" . $invoice_id . "'
									AND `patient_tests`.`test_group_id` = '" . $patient_tests_group->test_group_id . "' 
									AND `patient_tests`.`test_type_id` =  '" . $patient_tests_type->test_type_id . "'";
				$patient_tests_type->patient_tests = $this->patient_test_model->get_patient_test_list($where, false);
			}
			$patient_tests_group->patient_tests_types = $patient_tests_types;
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


	public function delete_invoice($invoice_id)
	{
		$invoice_id = (int)  $invoice_id;
		// if ($this->db->query("DELETE FROM `invoices` WHERE `invoice_id` = '" . $invoice_id . "' AND `status` IN(1,2)")) {
		// 	$this->db->query("DELETE FROM `invoice_test_groups` WHERE `invoice_id` = '" . $invoice_id . "'");
		// 	redirect(ADMIN_DIR . "reception");
		// }

		$query = "UPDATE invoices
			          SET is_deleted=1, 
					  cancel_reason='Fault Entry',  
					  cancel_reason_detail='Deleted By Reception' 
					  WHERE invoice_id= $invoice_id";
		if ($this->db->query($query)) {
			$this->session->set_flashdata("msg_success", "Receipt Cancelled Successfully.");
			redirect(ADMIN_DIR . "reception");
		} else {
			$this->session->set_flashdata("msg_error", "DB Error try again.");
			redirect(ADMIN_DIR . "reception");
		}
	}

	public function get_patient_search_result()
	{

		$search = trim($this->input->post('search'));
		if (!$search) {
			return false;
		}
		$search = $this->db->escape("%" . $this->input->post('search') . "%");
		$where = "`invoices`.`status` IN (1,2,3) 
		AND (`invoice_id` LIKE " . $search . " 
		OR `patients`.`patient_name` LIKE " . $search . "
		OR `patients`.`patient_mobile_no` LIKE " . $search . ")
		ORDER BY `invoices`.`invoice_id` DESC LIMIT 20";
		$all_tests = $this->invoice_model->get_invoice_list($where, false);
		if ($all_tests) {
?>
			<table class="table table-bordered">
				<h5>Search Result</h5>
				<thead>
					<tr>
						<th>#</th>
						<th>Name</th>
						<th>Mobile</th>
						<th>Receipts</th>
						<!-- <th>Price</th>
              <th>Discount</th> -->
						<th>Rs:</th>
						<th>Status</th>
						<th>Dated</th>
					</tr>
				</thead>
				<?php foreach ($all_tests as $test) {
					$color = '';
					if ($test->status == 1) {
						$color = "#E9F1FC";
					}
					if ($test->status == 2) {
						$color = "#ffe8e7";
					}
					if ($test->status == 3) {
						$color = "#F0FFF0";
					}

				?>
					<tr style="background-color: <?php echo $color; ?>;">
						<td><?php echo $test->invoice_id; ?> </td>
						<td><?php echo $test->patient_name; ?></td>
						<td><?php echo $test->patient_mobile_no; ?></td>
						<td>
							<a style="margin-left: 10px;" target="new" href="<?php echo site_url(ADMIN_DIR . "ultrasounds/print_patient_test_receipts/$test->invoice_id") ?>"><i class="fa fa-print" aria-hidden="true"></i> Receipts</a>


						</td>
						<!-- <td><?php echo $test->price; ?></td>
              <td><?php echo $test->discount; ?></td> -->
						<td><?php echo $test->total_price; ?></td>
						<td>

							<?php if ($test->status == 3) { ?>
								<a style="margin-left: 10px;" target="new" href="<?php echo site_url(ADMIN_DIR . "ultrasounds/print_patient_test_report/$test->invoice_id") ?>"><i class="fa fa-print" aria-hidden="true"></i> Print</a>
							<?php  } ?>
						</td>
						<td><?php echo date('d F, y', strtotime($test->created_date)); ?> </td>
					</tr>
				<?php } ?>
			</table>
		<?php } else {
			echo '<p style="color:red;"> Search Result not found. </p>';
		} ?>
<?php }
}
