<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class reports extends Admin_Controller
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
		// $this->load->model("admin/patient_model");
		//$this->output->enable_profiler(TRUE);
	}
	//---------------------------------------------------------------



	public function index()
	{

		exit();
		$this->load->view(ADMIN_DIR . "reports/index", $this->data);
	}


	public function daily_reception_report()
	{
		$date = $this->input->get('date');
		if ($date) {
			$date = date("Y-m-d", strtotime($date));
		} else {
			$date = date("Y-m-d");
		}
		//$this->data = $this->reports_model->daily_reception_report($date);
		$this->data = $this->reports_model->today_recp_report($date);
		$this->data['date'] = $date;

		$this->load->view(ADMIN_DIR . "reports/daily_reception_report", $this->data);
	}

	public function today_recp_report($date)
	{

		$this->data = $this->reports_model->today_recp_report($date);
		$this->load->view(ADMIN_DIR . "reports/daily_reception_report", $this->data);
	}

	public function monthly_report($month, $year)
	{
		$month = (int) $month;
		$year = (int) $year;
		$this->data['month'] = date("F, Y ", strtotime($year . "-" . $month . "-1"));
		$this->data['month_filter'] = $month;
		$this->data['year_filter'] = $year;



		$this->data['day_wise_monthly_report'] = $this->reports_model->day_wise_monthly_report($month, $year);
		$this->data['monthly_total_report'] = $this->reports_model->monthly_total_report($month, $year);
		$this->data["this_month_OPD_reports"] = $this->reports_model->this_month_opd_report($month, $year);
		$this->data["this_month_total_OPD_reports"] = $this->reports_model->this_month_total_opd_report($month, $year);

		$this->data['this_month_expenses'] = $this->reports_model->this_months_expense_types($month, $year);
		$this->data['this_month_total_expenses'] = $this->reports_model->this_month_total_expense();
		$this->data['monthly_expenses'] = $this->reports_model->monthly_expenses($month, $year);
		$this->data['categories_wise_cancellations'] = $this->reports_model->categories_wise_cancellations();
		$this->data['dr_refers'] = $this->reports_model->dr_refers($month, $year);
		$this->data['this_month_tests'] = $this->reports_model->this_month_tests($month, $year);


		$this->load->view(ADMIN_DIR . "reports/monthly_report", $this->data);
	}
}
