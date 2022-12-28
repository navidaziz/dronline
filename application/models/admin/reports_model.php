<?php if (!defined('BASEPATH')) exit('Direct access not allowed!');

class Reports_model extends MY_Model
{

	public function __construct()
	{

		parent::__construct();
		$this->table = "test_groups";
		$this->pk = "test_group_id";
		$this->status = "status";
		$this->order = "order";
	}

	public function today_recp_report_old($date)
	{
		$query = "SELECT
					`test_categories`.`test_category`
					, SUM(IF(`invoices`.`is_deleted`=0,`invoices`.`total_price`,NULL)) AS total_sum
					, SUM(IF(`invoices`.`is_deleted`=0,`invoices`.`discount`,NULL)) AS total_discount
					, COUNT(IF((`invoices`.`is_deleted`=0 AND `invoices`.`discount` > 0) ,1,NULL)) AS total_dis_count
					, COUNT(IF(`invoices`.`is_deleted`=0,1,NULL)) AS total_count
					, COUNT(IF(`invoices`.`is_deleted`=1,1,NULL)) AS total_receipt_cancelled
					FROM
					`test_categories`
					LEFT JOIN `invoices` 
					ON (`test_categories`.`test_category_id` = `invoices`.`category_id`)
					WHERE DATE(`invoices`.`created_date`) = '" . $date . "'
					AND `invoices`.`category_id` !=5
					GROUP BY `test_categories`.`test_category`;";
		$today_cat_wise_progress_report = $this->db->query($query)->result();
		$data["today_cat_wise_progress_reports"] = $today_cat_wise_progress_report;

		$query = "SELECT SUM(IF(`invoices`.`is_deleted`=0,`invoices`.`total_price`,NULL)) AS total_sum
		, COUNT(IF(`invoices`.`is_deleted`=0,1,NULL)) AS total_count
		, COUNT(IF(`invoices`.`is_deleted`=1,1,NULL)) AS total_receipt_cancelled
		, SUM(IF(`invoices`.`is_deleted`=0,`invoices`.`discount`,NULL)) AS total_discount
		, COUNT(IF((`invoices`.`is_deleted`=0 AND `invoices`.`discount` > 0) ,1,NULL)) AS total_dis_count
					FROM
					`test_categories`
					LEFT JOIN `invoices` 
					ON (`test_categories`.`test_category_id` = `invoices`.`category_id`)
					WHERE DATE(`invoices`.`created_date`) = '" . $date . "'
					AND `invoices`.`category_id` !=5";
		$today_cat_wise_progress_report = $this->db->query($query)->result();
		$data["today_total_cat_wise_progress_reports"] = $today_cat_wise_progress_report;

		$query = "SELECT
					`test_groups`.`test_group_name`
					, SUM(IF(`invoices`.`is_deleted`=0,`invoices`.`total_price`,NULL)) AS total_sum
					, COUNT(IF(`invoices`.`is_deleted`=0,1,NULL)) AS total_count
					, COUNT(IF(`invoices`.`is_deleted`=1,1,NULL)) AS total_receipt_cancelled
					, SUM(IF(`invoices`.`is_deleted`=0,`invoices`.`discount`,NULL)) AS total_discount
		            , COUNT(IF((`invoices`.`is_deleted`=0 AND `invoices`.`discount` > 0) ,1,NULL)) AS total_dis_count
				FROM
				`test_groups`,
				`invoices` 
				WHERE `test_groups`.`test_group_id` = `invoices`.`opd_doctor`
				AND `invoices`.`category_id`=5
				AND DATE(`invoices`.`created_date`) = '" . $date . "'
				GROUP BY `test_groups`.`test_group_name`";
		$today_OPD_report = $this->db->query($query)->result();
		$data["today_OPD_reports"] = $today_OPD_report;

		$query = "SELECT SUM(IF(`invoices`.`is_deleted`=0,`invoices`.`total_price`,NULL)) AS total_sum
		, COUNT(IF(`invoices`.`is_deleted`=0,1,NULL)) AS total_count
		, COUNT(IF(`invoices`.`is_deleted`=1,1,NULL)) AS total_receipt_cancelled
		, SUM(IF(`invoices`.`is_deleted`=0,`invoices`.`discount`,NULL)) AS total_discount
		            , COUNT(IF((`invoices`.`is_deleted`=0 AND `invoices`.`discount` > 0) ,1,NULL)) AS total_dis_count
				FROM
				`test_groups`,
				`invoices` 
				WHERE `test_groups`.`test_group_id` = `invoices`.`opd_doctor`
				AND `invoices`.`category_id`=5
				AND DATE(`invoices`.`created_date`) = '" . $date . "'";
		$today_OPD_report = $this->db->query($query)->result();
		$data["today_total_OPD_reports"] = $today_OPD_report;


		$query = "SELECT
					`test_groups`.`test_group_name`
					, `test_groups`.`test_group_id`
					, SUM(IF(`invoices`.`is_deleted`=0,`invoices`.`total_price`,NULL)) AS total_sum
					, COUNT(IF(`invoices`.`is_deleted`=0,1,NULL)) AS total_count
					, COUNT(IF(`invoices`.`is_deleted`=1,1,NULL)) AS total_receipt_cancelled
					, SUM(IF(`invoices`.`is_deleted`=0,`invoices`.`discount`,NULL)) AS total_discount
		            , COUNT(IF((`invoices`.`is_deleted`=0 AND `invoices`.`discount` > 0) ,1,NULL)) AS total_dis_count
				FROM
				`test_groups`,
				`invoices` 
				WHERE `test_groups`.`test_group_id` = `invoices`.`opd_doctor`
				AND `invoices`.`category_id`=5
				AND `test_groups`.`test_group_id` IN (77,86,104,114)
				AND DATE(`invoices`.`created_date`) = '" . $date . "'
				GROUP BY `test_groups`.`test_group_name`";
		$income_from_drs = $this->db->query($query)->result();
		$data["income_from_drs"] = $income_from_drs;


		return $data;
	}

	public function today_recp_report($date)
	{
		$query = "SELECT
					`test_categories`.`test_category`
					, SUM(IF(`invoices`.`is_deleted`=0,`invoices`.`total_price`,NULL)) AS total_sum
					, SUM(IF(`invoices`.`is_deleted`=0,`invoices`.`discount`,NULL)) AS total_discount
					, COUNT(IF((`invoices`.`is_deleted`=0 AND `invoices`.`discount` > 0) ,1,NULL)) AS total_dis_count
					, COUNT(IF(`invoices`.`is_deleted`=0,1,NULL)) AS total_count
					, COUNT(IF(`invoices`.`is_deleted`=1,1,NULL)) AS total_receipt_cancelled
					FROM
					`test_categories`
					LEFT JOIN `invoices` 
					ON (`test_categories`.`test_category_id` = `invoices`.`category_id`)
					WHERE DATE(`invoices`.`created_date`) = '" . $date . "'
					AND `invoices`.`category_id` !=5
					GROUP BY `test_categories`.`test_category`;";
		$today_cat_wise_progress_report = $this->db->query($query)->result();
		$data["today_cat_wise_progress_reports"] = $today_cat_wise_progress_report;

		$query = "SELECT SUM(IF(`invoices`.`is_deleted`=0,`invoices`.`total_price`,NULL)) AS total_sum
		, COUNT(IF(`invoices`.`is_deleted`=0,1,NULL)) AS total_count
		, COUNT(IF(`invoices`.`is_deleted`=1,1,NULL)) AS total_receipt_cancelled
		, SUM(IF(`invoices`.`is_deleted`=0,`invoices`.`discount`,NULL)) AS total_discount
		, COUNT(IF((`invoices`.`is_deleted`=0 AND `invoices`.`discount` > 0) ,1,NULL)) AS total_dis_count
					FROM
					`test_categories`
					LEFT JOIN `invoices` 
					ON (`test_categories`.`test_category_id` = `invoices`.`category_id`)
					WHERE DATE(`invoices`.`created_date`) = '" . $date . "'
					AND `invoices`.`category_id` !=5";
		$today_cat_wise_progress_report = $this->db->query($query)->result();
		$data["today_total_cat_wise_progress_reports"] = $today_cat_wise_progress_report;

		$query = "SELECT
					`test_groups`.`test_group_name`
					, SUM(IF(`invoices`.`is_deleted`=0,`invoices`.`total_price`,NULL)) AS total_sum
					, SUM(IF(`invoices`.`is_deleted`=0,`invoices`.`alkhidmat_income`,NULL)) AS shares
					, COUNT(IF(`invoices`.`is_deleted`=0,1,NULL)) AS total_count
					, COUNT(IF(`invoices`.`is_deleted`=1,1,NULL)) AS total_receipt_cancelled
					, SUM(IF(`invoices`.`is_deleted`=0,`invoices`.`discount`,NULL)) AS total_discount
		            , COUNT(IF((`invoices`.`is_deleted`=0 AND `invoices`.`discount` > 0) ,1,NULL)) AS total_dis_count
				FROM
				`test_groups`,
				`invoices` 
				WHERE `test_groups`.`test_group_id` = `invoices`.`opd_doctor`
				AND `invoices`.`category_id`=5
				AND DATE(`invoices`.`created_date`) = '" . $date . "'
				GROUP BY `test_groups`.`test_group_name`";
		$today_OPD_report = $this->db->query($query)->result();
		$data["today_OPD_reports"] = $today_OPD_report;

		$query = "SELECT SUM(IF(`invoices`.`is_deleted`=0,`invoices`.`total_price`,NULL)) AS total_sum,
		SUM(IF(`invoices`.`is_deleted`=0,`invoices`.`alkhidmat_income`,NULL)) AS shares
		, COUNT(IF(`invoices`.`is_deleted`=0,1,NULL)) AS total_count
		, COUNT(IF(`invoices`.`is_deleted`=1,1,NULL)) AS total_receipt_cancelled
		, SUM(IF(`invoices`.`is_deleted`=0,`invoices`.`discount`,NULL)) AS total_discount
		            , COUNT(IF((`invoices`.`is_deleted`=0 AND `invoices`.`discount` > 0) ,1,NULL)) AS total_dis_count
				FROM
				`test_groups`,
				`invoices` 
				WHERE `test_groups`.`test_group_id` = `invoices`.`opd_doctor`
				AND `invoices`.`category_id`=5
				AND DATE(`invoices`.`created_date`) = '" . $date . "'";
		$today_OPD_report = $this->db->query($query)->result();
		$data["today_total_OPD_reports"] = $today_OPD_report;


		$query = "SELECT
					`test_groups`.`test_group_name`
					, `test_groups`.`test_group_id`
					, SUM(IF(`invoices`.`is_deleted`=0,`invoices`.`total_price`,NULL)) AS total_sum
					, SUM(IF(`invoices`.`is_deleted`=0,`invoices`.`alkhidmat_income`,NULL)) AS shares
					, COUNT(IF(`invoices`.`is_deleted`=0,1,NULL)) AS total_count
					, COUNT(IF(`invoices`.`is_deleted`=1,1,NULL)) AS total_receipt_cancelled
					, SUM(IF(`invoices`.`is_deleted`=0,`invoices`.`discount`,NULL)) AS total_discount
		            , COUNT(IF((`invoices`.`is_deleted`=0 AND `invoices`.`discount` > 0) ,1,NULL)) AS total_dis_count
				FROM
				`test_groups`,
				`invoices` 
				WHERE `test_groups`.`test_group_id` = `invoices`.`opd_doctor`
				AND `invoices`.`category_id`=5
				AND `test_groups`.`share` >0
				AND DATE(`invoices`.`created_date`) = '" . $date . "'
				GROUP BY `test_groups`.`test_group_name`";
		$income_from_drs = $this->db->query($query)->result();
		$data["income_from_drs"] = $income_from_drs;


		return $data;
	}

	public function daily_reception_report()
	{
		$query = "SELECT
					`test_categories`.`test_category`
					, SUM(IF(`invoices`.`is_deleted`=0,`invoices`.`total_price`,NULL)) AS total_sum
					, SUM(IF(`invoices`.`is_deleted`=0,`invoices`.`discount`,NULL)) AS total_discount
					, COUNT(IF((`invoices`.`is_deleted`=0 AND `invoices`.`discount` > 0) ,1,NULL)) AS total_dis_count
					, COUNT(IF(`invoices`.`is_deleted`=0,1,NULL)) AS total_count
					, COUNT(IF(`invoices`.`is_deleted`=1,1,NULL)) AS total_receipt_cancelled
					FROM
					`test_categories`
					LEFT JOIN `invoices` 
					ON (`test_categories`.`test_category_id` = `invoices`.`category_id`)
					WHERE DATE(`invoices`.`created_date`) = DATE(NOW())
					AND `invoices`.`category_id` !=5
					GROUP BY `test_categories`.`test_category`;";
		$today_cat_wise_progress_report = $this->db->query($query)->result();
		$data["today_cat_wise_progress_reports"] = $today_cat_wise_progress_report;

		$query = "SELECT SUM(IF(`invoices`.`is_deleted`=0,`invoices`.`total_price`,NULL)) AS total_sum
		, COUNT(IF(`invoices`.`is_deleted`=0,1,NULL)) AS total_count
		, COUNT(IF(`invoices`.`is_deleted`=1,1,NULL)) AS total_receipt_cancelled
		, SUM(IF(`invoices`.`is_deleted`=0,`invoices`.`discount`,NULL)) AS total_discount
		, COUNT(IF((`invoices`.`is_deleted`=0 AND `invoices`.`discount` > 0) ,1,NULL)) AS total_dis_count
					FROM
					`test_categories`
					LEFT JOIN `invoices` 
					ON (`test_categories`.`test_category_id` = `invoices`.`category_id`)
					WHERE DATE(`invoices`.`created_date`) = DATE(NOW())
					AND `invoices`.`category_id` !=5";
		$today_cat_wise_progress_report = $this->db->query($query)->result();
		$data["today_total_cat_wise_progress_reports"] = $today_cat_wise_progress_report;

		$query = "SELECT
					`test_groups`.`test_group_name`
					, SUM(IF(`invoices`.`is_deleted`=0,`invoices`.`total_price`,NULL)) AS total_sum
					, SUM(IF(`invoices`.`is_deleted`=0,`invoices`.`alkhidmat_income`,NULL)) AS shares
					, COUNT(IF(`invoices`.`is_deleted`=0,1,NULL)) AS total_count
					, COUNT(IF(`invoices`.`is_deleted`=1,1,NULL)) AS total_receipt_cancelled
					, SUM(IF(`invoices`.`is_deleted`=0,`invoices`.`discount`,NULL)) AS total_discount
		            , COUNT(IF((`invoices`.`is_deleted`=0 AND `invoices`.`discount` > 0) ,1,NULL)) AS total_dis_count
				FROM
				`test_groups`,
				`invoices` 
				WHERE `test_groups`.`test_group_id` = `invoices`.`opd_doctor`
				AND `invoices`.`category_id`=5
				AND DATE(`invoices`.`created_date`) = DATE(NOW())
				GROUP BY `test_groups`.`test_group_name`";
		$today_OPD_report = $this->db->query($query)->result();
		$data["today_OPD_reports"] = $today_OPD_report;

		$query = "SELECT SUM(IF(`invoices`.`is_deleted`=0,`invoices`.`total_price`,NULL)) AS total_sum,
		SUM(IF(`invoices`.`is_deleted`=0,`invoices`.`alkhidmat_income`,NULL)) AS shares
		, COUNT(IF(`invoices`.`is_deleted`=0,1,NULL)) AS total_count
		, COUNT(IF(`invoices`.`is_deleted`=1,1,NULL)) AS total_receipt_cancelled
		, SUM(IF(`invoices`.`is_deleted`=0,`invoices`.`discount`,NULL)) AS total_discount
		            , COUNT(IF((`invoices`.`is_deleted`=0 AND `invoices`.`discount` > 0) ,1,NULL)) AS total_dis_count
				FROM
				`test_groups`,
				`invoices` 
				WHERE `test_groups`.`test_group_id` = `invoices`.`opd_doctor`
				AND `invoices`.`category_id`=5
				AND DATE(`invoices`.`created_date`) = DATE(NOW())";
		$today_OPD_report = $this->db->query($query)->result();
		$data["today_total_OPD_reports"] = $today_OPD_report;


		$query = "SELECT
					`test_groups`.`test_group_name`
					, `test_groups`.`test_group_id`
					, SUM(IF(`invoices`.`is_deleted`=0,`invoices`.`total_price`,NULL)) AS total_sum
					, SUM(IF(`invoices`.`is_deleted`=0,`invoices`.`alkhidmat_income`,NULL)) AS shares
					, COUNT(IF(`invoices`.`is_deleted`=0,1,NULL)) AS total_count
					, COUNT(IF(`invoices`.`is_deleted`=1,1,NULL)) AS total_receipt_cancelled
					, SUM(IF(`invoices`.`is_deleted`=0,`invoices`.`discount`,NULL)) AS total_discount
		            , COUNT(IF((`invoices`.`is_deleted`=0 AND `invoices`.`discount` > 0) ,1,NULL)) AS total_dis_count
				FROM
				`test_groups`,
				`invoices` 
				WHERE `test_groups`.`test_group_id` = `invoices`.`opd_doctor`
				AND `invoices`.`category_id`=5
				AND `test_groups`.`share` >0
				AND DATE(`invoices`.`created_date`) = DATE(NOW())
				GROUP BY `test_groups`.`test_group_name`";
		$income_from_drs = $this->db->query($query)->result();
		$data["income_from_drs"] = $income_from_drs;


		return $data;
	}

	public function today_report()
	{
		$query = "SELECT * FROM `invoices_data` WHERE DATE(created_date) = date(NOW())";

		$today_report = $this->db->query($query)->result();
		if (count($today_report)) {

			$today_report = $today_report[0];
		} else {
			$today_report = (object) array(
				'created_date' => date('d M, Y'),
				'lab' => 0,
				'ecg' => 0,
				'ultrasound' => 0,
				'x_ray' => 0,
				'opd' => 0,
				'dr_naila' => 0,
				'dr_shabana' => 0,
				'dr_shabana_us_doppler' => 0,
				'discount' => 0,
				'other_deleted' => 0,
				'opd_deleted' => 0,
				'alkhidmat_total' => 0,
				'lab_count' => 0,
				'ecg_count' => 0,
				'ultrasound_count' => 0,
				'x_ray_count' => 0,
				'opd_count' => 0,
				'dr_naila_count' => 0,
				'dr_shabana_count' => 0,
				'dr_shabana_us_doppler_count' => 0,
				'discount_count' => 0,
			);
		}
		return $today_report;
	}

	public function today_opd_report()
	{
		$query = "SELECT
					`test_groups`.`test_group_name`
					, SUM(IF(`invoices`.`is_deleted`=0,`invoices`.`total_price`,NULL)) AS total_sum
					, COUNT(IF(`invoices`.`is_deleted`=0,1,NULL)) AS total_count
					, COUNT(IF(`invoices`.`is_deleted`=1,1,NULL)) AS total_receipt_cancelled
					, SUM(IF(`invoices`.`is_deleted`=0,`invoices`.`discount`,NULL)) AS total_discount
		            , COUNT(IF((`invoices`.`is_deleted`=0 AND `invoices`.`discount` > 0) ,1,NULL)) AS total_dis_count
				FROM
				`test_groups`,
				`invoices` 
				WHERE `test_groups`.`test_group_id` = `invoices`.`opd_doctor`
				AND `invoices`.`category_id`=5
				AND DATE(`invoices`.`created_date`) = DATE(NOW())
				GROUP BY `test_groups`.`test_group_name`";
		$today_OPD_report = $this->db->query($query)->result();
		return $today_OPD_report;
	}

	public function today_total_opd_report()
	{
		$query = "SELECT SUM(IF(`invoices`.`is_deleted`=0,`invoices`.`total_price`,NULL)) AS total_sum
		, COUNT(IF(`invoices`.`is_deleted`=0,1,NULL)) AS total_count
		, COUNT(IF(`invoices`.`is_deleted`=1,1,NULL)) AS total_receipt_cancelled
		, SUM(IF(`invoices`.`is_deleted`=0,`invoices`.`discount`,NULL)) AS total_discount
		            , COUNT(IF((`invoices`.`is_deleted`=0 AND `invoices`.`discount` > 0) ,1,NULL)) AS total_dis_count
				FROM
				`test_groups`,
				`invoices` 
				WHERE `test_groups`.`test_group_id` = `invoices`.`opd_doctor`
				AND `invoices`.`category_id`=5
				AND DATE(`invoices`.`created_date`) = DATE(NOW())";
		$today_OPD_report = $this->db->query($query)->result();
		return $today_OPD_report;
	}

	public function this_month_opd_report($month = NULL, $year = NULL)
	{
		if ($month == NULL and $year == NULL) {
			$month = date("m", time());
			$year = date("Y", time());
		} else {
			$month = $month;
			$year = $year;
		}
		$query = "SELECT
					`test_groups`.`test_group_name`
					, SUM(IF(`invoices`.`is_deleted`=0,`invoices`.`total_price`,NULL)) AS total_sum
					, COUNT(IF(`invoices`.`is_deleted`=0,1,NULL)) AS total_count
					, COUNT(IF(`invoices`.`is_deleted`=1,1,NULL)) AS total_receipt_cancelled
					, SUM(IF(`invoices`.`is_deleted`=0,`invoices`.`discount`,NULL)) AS total_discount
		            , COUNT(IF((`invoices`.`is_deleted`=0 AND `invoices`.`discount` > 0) ,1,NULL)) AS total_dis_count
				FROM
				`test_groups`,
				`invoices` 
				WHERE `test_groups`.`test_group_id` = `invoices`.`opd_doctor`
				AND `invoices`.`category_id`=5
				AND YEAR(`invoices`.`created_date`) = '" . $year . "'
				AND MONTH(`invoices`.`created_date`) = '" . $month . "'
				GROUP BY `test_groups`.`test_group_name`";
		$today_OPD_report = $this->db->query($query)->result();
		return $today_OPD_report;
	}

	public function this_month_total_opd_report($month = NULL, $year = NULL)
	{
		if ($month == NULL and $year == NULL) {
			$month = date("m", time());
			$year = date("Y", time());
		} else {
			$month = $month;
			$year = $year;
		}

		$query = "SELECT SUM(IF(`invoices`.`is_deleted`=0,`invoices`.`total_price`,NULL)) AS total_sum
		, COUNT(IF(`invoices`.`is_deleted`=0,1,NULL)) AS total_count
		, COUNT(IF(`invoices`.`is_deleted`=1,1,NULL)) AS total_receipt_cancelled
		, SUM(IF(`invoices`.`is_deleted`=0,`invoices`.`discount`,NULL)) AS total_discount
		            , COUNT(IF((`invoices`.`is_deleted`=0 AND `invoices`.`discount` > 0) ,1,NULL)) AS total_dis_count
				FROM
				`test_groups`,
				`invoices` 
				WHERE `test_groups`.`test_group_id` = `invoices`.`opd_doctor`
				AND `invoices`.`category_id`=5
				AND YEAR(`invoices`.`created_date`) = '" . $year . "'
				AND MONTH(`invoices`.`created_date`) = '" . $month . "'";
		$today_OPD_report = $this->db->query($query)->result();
		return $today_OPD_report;
	}

	public function this_month_report()
	{
		$query = "SELECT * FROM invoices_current_month";

		$today_report = $this->db->query($query)->result();
		if (count($today_report)) {

			$today_report = $today_report[0];
		} else {
			$today_report = (object) array(
				'created_date' => date('d M, Y'),
				'lab' => 0,
				'ecg' => 0,
				'ultrasound' => 0,
				'x_ray' => 0,
				'opd' => 0,
				'dr_naila' => 0,
				'dr_shabana' => 0,
				'dr_shabana_us_doppler' => 0,
				'discount' => 0,
				'other_deleted' => 0,
				'opd_deleted' => 0,
				'alkhidmat_total' => 0,
				'lab_count' => 0,
				'ecg_count' => 0,
				'ultrasound_count' => 0,
				'x_ray_count' => 0,
				'opd_count' => 0,
				'dr_naila_count' => 0,
				'dr_shabana_count' => 0,
				'dr_shabana_us_doppler_count' => 0,
				'discount_count' => 0,
			);
		}
		return $today_report;
	}

	public function today_expense_types()
	{
		$query = "SELECT 
		 `expense_types`.`expense_type`,
		 SUM(`expenses`.`expense_amount`) as expense_total 
		 FROM
		 `expense_types`,
		 `expenses` 
		 WHERE `expense_types`.`expense_type_id` = `expenses`.`expense_type_id`
		 AND DATE(`expenses`.`created_date`) = DATE(NOW())
		 GROUP BY `expense_types`.`expense_type` ";
		$query_result = $this->db->query($query);
		return $query_result->result();
	}
	public function today_total_expense()
	{
		$query = "SELECT sum(`expense_amount`) as total_expenses 
			FROM `expenses` WHERE  DATE(`expenses`.`created_date`) = DATE(NOW())";
		$result = $this->db->query($query);
		$total_expenses = $result->result()[0]->total_expenses;
		if ($total_expenses) {
			return $total_expenses;
		} else {
			return 0;
		}
	}
	public function this_months_expense_types($month = NULL, $year = NULL)
	{

		if ($month == NULL and $year == NULL) {
			$month = date("m", time());
			$year = date("Y", time());
		} else {
			$month = $month;
			$year = $year;
		}
		$query = "SELECT 
		 `expense_types`.`expense_type`,
		 `expense_types`.`expense_type_id`,
		 SUM(`expenses`.`expense_amount`) as expense_total 
		 FROM
		 `expense_types`,
		 `expenses` 
		 WHERE `expense_types`.`expense_type_id` = `expenses`.`expense_type_id`
		 AND YEAR(`expenses`.`created_date`) = '" . $year . "'
		 AND MONTH(`expenses`.`created_date`) = '" . $month . "'
		 GROUP BY `expense_types`.`expense_type` ";
		$query_result = $this->db->query($query);
		$expense_types = $query_result->result();
		foreach ($expense_types as $expense_type) {
			$query = "SELECT *, `expenses`.`created_date` as created_date FROM expenses 
			         WHERE expense_type_id = '" . $expense_type->expense_type_id . "'
					 AND YEAR(`expenses`.`created_date`) = '" . $year . "'
					 AND MONTH(`expenses`.`created_date`) = '" . $month . "'
					 GROUP BY `expenses`.`created_date`
					 ";
			$expense_type->expense_detail = $this->db->query($query)->result();
		}

		return $expense_types;
	}
	public function this_month_total_expense($month = NULL, $year = NULL)
	{

		if ($month == NULL and $year == NULL) {
			$month = date("m", time());
			$year = date("Y", time());
		} else {
			$month = $month;
			$year = $year;
		}
		$query = "SELECT sum(`expense_amount`) as total_expenses 
			FROM `expenses` WHERE  YEAR(`expenses`.`created_date`) = '" . $year . "'
		 AND MONTH(`expenses`.`created_date`) = '" . $month . "'";
		$result = $this->db->query($query);
		$total_expenses = $result->result()[0]->total_expenses;
		if ($total_expenses) {
			return $total_expenses;
		} else {
			return 0;
		}
	}
	public function monthly_expenses($month = NULL, $year = NULL)
	{
		if ($month == NULL and $year == NULL) {
			$month = date("m", time());
			$year = date("Y", time());
			$mont_last_day = cal_days_in_month(CAL_GREGORIAN, $month, $year);
		} else {
			$month = $month;
			$year = $year;
			$mont_last_day = cal_days_in_month(CAL_GREGORIAN, $month, $year);
		}

		$monthly_expenses = array();
		for ($day = 1; $day <= $mont_last_day; $day++) {
			$date_query = $year . "-" . $month . "-" . $day;
			$query = "SELECT 
		`expense_types`.`expense_type`,
		SUM(`expenses`.`expense_amount`) AS expense_total,
		`expenses`.`expense_title`,
		 `expenses`.`expense_description`,
		 IF(`expenses`.`expense_attachment` != NULL, 'yes', 'no') AS expense_attachment,
		 DATE(`expenses`.`created_date`) AS created_date
	  FROM
		`expense_types`,
		`expenses` 
	  WHERE `expense_types`.`expense_type_id` = `expenses`.`expense_type_id`
		 AND DATE(`expenses`.`created_date`) = '" . $date_query . "'
		 GROUP BY `expense_types`.`expense_type` ";
			$query_result = $this->db->query($query);
			if ($query_result->result()) {
				$monthly_expenses[$date_query] = $query_result->result();
			} else {
				$monthly_expenses[$date_query] = NULL;
			}
		}
		return $monthly_expenses;
	}

	public function day_wise_monthly_report($month = NULL, $year = NULL)
	{

		if ($month == NULL and $year == NULL) {
			$month = date("m", time());
			$year = date("Y", time());
			$mont_last_day = cal_days_in_month(CAL_GREGORIAN, $month, $year);
		} else {
			$month = $month;
			$year = $year;
			$mont_last_day = cal_days_in_month(CAL_GREGORIAN, $month, $year);
		}


		for ($day = 1; $day <= $mont_last_day; $day++) {
			$date_query = $year . "-" . $month . "-" . $day;


			$query = "SELECT *, (`i`.`lab` + `i`.`ecg` + `i`.`ultrasound` + `i`.`x_ray` + `i`.`dr_naila` + `i`.`dr_shabana` + `i`.`dr_shabana_us_doppler`) as total, 
			        `i`.`discount`, `i`.`discount_count` FROM `invoices_data` as i WHERE   DATE(`i`.`created_date`) = '" . $date_query . "'";
			$query_result = $this->db->query($query);
			$DateQuery = date("d M, Y", strtotime($date_query));
			$result = $query_result->result();
			if ($result) {
				$income_expence_report[$DateQuery] = $result[0];
			}

			//get Expences 	
			$query = "SELECT SUM(`expense_amount`) as total_expense FROM `expenses` 
					  WHERE  DATE(`expenses`.`created_date`) = '" . $date_query . "'";
			$query_result = $this->db->query($query);
			$result = $query_result->result();

			if ($result) {
				@$income_expence_report[$DateQuery]->expense = $result[0]->total_expense;
			} else {
				$income_expence_report[$DateQuery]->expense = 0;
			}
		}
		return $income_expence_report;
	}


	public function monthly_total_report($month = NULL, $year = NULL)
	{
		if ($month == NULL and $year == NULL) {
			$month = date("m", time());
			$year = date("Y", time());
		} else {
			$month = $month;
			$year = $year;
		}
		$date_query = $year . "-" . $month . "-1";
		$month_income_expence_report = array();

		$query = "SELECT *, (`i`.`lab` + `i`.`ecg` + `i`.`ultrasound` + `i`.`x_ray` + `i`.`dr_naila` + `i`.`dr_shabana` + `i`.`dr_shabana_us_doppler`) as total, 
			        `i`.`discount`, `i`.`discount_count` FROM `invoice_data_monthly` as i 
					WHERE   `i`.`month` ='" . $month . "'
					AND `i`.`year` ='" . $year . "'";
		$query_result = $this->db->query($query);
		$DateQuery = date("M, Y", strtotime($date_query));
		$result = $query_result->result();
		if ($result) {
			$month_income_expence_report[$DateQuery] = $result[0];
		}

		//get Expences 	
		$query = "SELECT SUM(`expense_amount`) as total_expense 
			          FROM `expenses` 
					  WHERE  YEAR(`expenses`.`created_date`) = '" . $year . "' 
					  AND  MONTH(`expenses`.`created_date`) = '" . $month . "'";
		$query_result = $this->db->query($query);
		$result = $query_result->result();

		if ($result) {
			@$month_income_expence_report[$DateQuery]->expense = $result[0]->total_expense;
		} else {
			$month_income_expence_report[$DateQuery]->expense = 0;
		}
		return $month_income_expence_report;
	}

	public function month_wise_yearly_report($year = NULL)
	{
		if ($year == NULL) {
			$year = date("Y", time());
		} else {
			$year = $year;
		}
		$month_income_expence_report = array();

		for ($month = 1; $month <= 12; $month++) {
			$date_query = $year . "-" . $month . "-1";

			$query = "SELECT *, (`i`.`lab` + `i`.`ecg` + `i`.`ultrasound` + `i`.`x_ray` + `i`.`dr_naila` + `i`.`dr_shabana` + `i`.`dr_shabana_us_doppler`) as total, 
			        `i`.`discount`, `i`.`discount_count` FROM `invoice_data_monthly` as i 
					WHERE   `i`.`month` ='" . $month . "'
					AND `i`.`year` ='" . $year . "'";
			$query_result = $this->db->query($query);
			$DateQuery = date("M, Y", strtotime($date_query));
			$result = $query_result->result();
			if ($result) {
				$month_income_expence_report[$DateQuery] = $result[0];
			}

			//get Expences 	
			$query = "SELECT SUM(`expense_amount`) as total_expense 
			          FROM `expenses` 
					  WHERE  YEAR(`expenses`.`created_date`) = '" . $year . "' 
					  AND  MONTH(`expenses`.`created_date`) = '" . $month . "'";
			$query_result = $this->db->query($query);
			$result = $query_result->result();

			if ($result) {
				@$month_income_expence_report[$DateQuery]->expense = $result[0]->total_expense;
			} else {
				$month_income_expence_report[$DateQuery]->expense = 0;
			}
		}
		return $month_income_expence_report;
	}

	public function yearly_report($year = NULL)
	{

		for ($year = 2020; $year <= 2025; $year++) {
			$date_query = $year . "-01-1";

			$query = "SELECT *, (`i`.`lab` + `i`.`ecg` + `i`.`ultrasound` + `i`.`x_ray` + `i`.`dr_naila` + `i`.`dr_shabana` + `i`.`dr_shabana_us_doppler`) as total, 
			        `i`.`discount`, `i`.`discount_count` FROM `invoice_data_yearly` as i 
					WHERE    `i`.`year` ='" . $year . "'";
			$query_result = $this->db->query($query);
			$DateQuery = date("M, Y", strtotime($date_query));
			$result = $query_result->result();
			if ($result) {
				$month_income_expence_report[$DateQuery] = $result[0];
			}

			//get Expences 	
			$query = "SELECT SUM(`expense_amount`) as total_expense 
			          FROM `expenses` 
					  WHERE  YEAR(`expenses`.`created_date`) = '" . $year . "' ";
			$query_result = $this->db->query($query);
			$result = $query_result->result();

			if ($result) {
				@$month_income_expence_report[$DateQuery]->expense = $result[0]->total_expense;
			} else {
				$month_income_expence_report[$DateQuery]->expense = 0;
			}
		}
		return $month_income_expence_report;
	}

	public function this_month_tests($month = NULL, $year = NULL)
	{
		if ($month == NULL and $year == NULL) {
			$month = date("m", time());
			$year = date("Y", time());
		} else {
			$month = $month;
			$year = $year;
		}
		$date_query = $year . "-" . $month . "-1";

		$query = "SELECT * FROM `test_categories` WHERE `test_category_id` IN (1,2,3,4)";
		$test_categories = $this->db->query($query)->result();
		foreach ($test_categories as $test_categorie) {
			$query = "SELECT tg.`test_group_name` AS test_name, 
			COUNT(tg.`test_group_id`) AS test_total,
			SUM(itg.`price`) AS total_rs 
			FROM `invoice_test_groups` AS itg, 
			`test_groups` AS tg,
			`invoices` AS i
			WHERE itg.`test_group_id` = tg.`test_group_id`
			AND itg.`invoice_id` = i.`invoice_id`
			AND i.`is_deleted` = 0
			AND tg.`category_id`= '" . $test_categorie->test_category_id . "'
			AND MONTH(`itg`.`created_date`)  = '" . $month . "'
			AND YEAR(`itg`.`created_date`)  = '" . $year . "'
			GROUP BY tg.`test_group_id`
			ORDER BY test_total DESC";
			$result = $this->db->query($query);
			$test_categorie->test_total = $result->result();
		}

		return $test_categories;
	}


	function categories_wise_cancellations()
	{

		$query = "SELECT cancel_reason 
		          FROM `deleted_receipts` GROUP BY cancel_reason";
		$cancel_reasons = $this->db->query($query)->result();
		$query = "SELECT `test_category_id`,`test_category` FROM `test_categories` ";
		$categories = $this->db->query($query)->result();
		$canceled_invoices = array();
		foreach ($categories as $category) {
			foreach ($cancel_reasons as $cancel_reason) {
				$query = "SELECT COUNT(*) AS total  FROM `invoices` AS `i` 
				WHERE `i`.cancel_reason = '" . $cancel_reason->cancel_reason . "'
				AND `i`.`category_id` = '" . $category->test_category_id . "'";
				$canceled_invoices[$category->test_category][$cancel_reason->cancel_reason] = $this->db->query($query)->result()[0]->total;
			}
		}
		return $canceled_invoices;
	}

	function dr_refers($month = NULL, $year = NULL)
	{
		if ($month == NULL and $year == NULL) {
			$month = date("m", time());
			$year = date("Y", time());
		} else {
			$month = $month;
			$year = $year;
		}

		$query = "SELECT IF(opd_dr, (SELECT `test_group_name` FROM `test_groups` WHERE `test_group_id`=opd_dr), 'SELF') AS dr_name,
		SUM(opd) AS opd,
		SUM(lab) AS lab, SUM(ecg) AS ecg, SUM(ultrasound) AS ultrasound, SUM(x_ray) AS x_ray
		FROM `doctors_patients`
		WHERE  YEAR(`created_date`) = '" . $year . "' 
		AND  MONTH(`created_date`) = '" . $month . "'
		GROUP BY opd_dr
		ORDER BY opd DESC";
		$dr_referred = $this->db->query($query)->result();
		return $dr_referred;
	}
}
