<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mobile_messages extends Public_Controller
{

	/**
	 * constructor method
	 */
	public function __construct()
	{

		parent::__construct();
	}

	public function index()
	{
	}

	public function get_message()
	{
		// error_reporting(0);

		$query = "SELECT last_updated FROM `sms` WHERE status=1 ORDER BY last_updated DESC LIMIT 1";
		$query_result = $this->db->query($query);
		$last_updated = strtotime(@$query_result->result()[0]->last_updated);
		$sec_difference = time() - $last_updated;

		if ($sec_difference <= 80) {
			$response["message"] = 'Message Not Found.';
			$response["success"] = false;
			echo json_encode($response);
			exit();
		}






		$sms_date = date('Y-m-d H:i:s', strtotime('-10 minutes'));
		$query = "SELECT * FROM `sms`
	 		 WHERE `sms`.`status`=0 ORDER BY `sms`.`priority` DESC  LIMIT 1";
		$query_result = $this->db->query($query);
		@$mobile_sms = $query_result->result()[0];
		if ($mobile_sms) {
			$response["id"] = $mobile_sms->sms_id;
			$response["mobile_number"] = $mobile_sms->mobile_number;
			$response["sms_detail"] = $mobile_sms->message;
			$response["message"] = 'Message Found.';
			$response["success"] = true;

			$query = "UPDATE `sms` SET `sms`.`status`=1,
	         `sms`.`last_updated` = '" . date('Y-m-d H:i:s', time()) . "'
	 		 WHERE `sms`.`sms_id`=" . $mobile_sms->sms_id;
			$this->db->query($query);
			$effect_rows = $this->db->affected_rows();
		} else {
			$response["message"] = 'Message Not Found.';
			$response["success"] = false;
		}
		echo json_encode($response);
	}
}
