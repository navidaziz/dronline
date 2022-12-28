<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends Admin_Controller
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
		$this->load->model('admin/reports_model');
		// $this->load->model("admin/patient_model");
		//$this->output->enable_profiler(TRUE);
	}
	//---------------------------------------------------------------


	/**
	 * Default action to be called
	 */
	public function index()
	{

		//get today data......
		$this->data['today_report'] = $this->reports_model->today_report();
		$this->data['this_month_report'] = $this->reports_model->this_month_report();
		$this->data["today_OPD_reports"] = $this->reports_model->today_opd_report();
		$this->data["today_total_OPD_reports"] = $this->reports_model->today_total_opd_report();
		$this->data["this_month_OPD_reports"] = $this->reports_model->this_month_opd_report();
		$this->data["this_month_total_OPD_reports"] = $this->reports_model->this_month_total_opd_report();
		$this->data['today_expenses'] = $this->reports_model->today_expense_types();
		$this->data['today_total_expenses'] = $this->reports_model->today_total_expense();
		$this->data['this_month_expenses'] = $this->reports_model->this_months_expense_types();
		$this->data['this_month_total_expenses'] = $this->reports_model->this_month_total_expense();
		$this->data['day_wise_monthly_report'] = $this->reports_model->day_wise_monthly_report();
		$this->data['month_wise_yearly_report'] = $this->reports_model->month_wise_yearly_report();
		$this->data['yearly_report'] = $this->reports_model->yearly_report();
		$this->data['this_month_tests'] = $this->reports_model->this_month_tests();




		$this->data["view"] = ADMIN_DIR . "dashboard/dashboard";
		$this->load->view(ADMIN_DIR . "layout", $this->data);
	}
}
