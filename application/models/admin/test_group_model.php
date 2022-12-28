<?php if (!defined('BASEPATH')) exit('Direct access not allowed!');

class Test_group_model extends MY_Model
{

	public function __construct()
	{

		parent::__construct();
		$this->table = "test_groups";
		$this->pk = "test_group_id";
		$this->status = "status";
		$this->order = "order";
	}

	public function validate_form_data()
	{
		$validation_config = array(
			array(
				"field"  =>  "test_group_name",
				"label"  =>  "Test Group Name",
				"rules"  =>  "required"
			),

			array(
				"field"  =>  "test_category_id",
				"label"  =>  "Group Category",
				"rules"  =>  "required"
			),

			array(
				"field"  =>  "test_price",
				"label"  =>  "Test Price",
				"rules"  =>  "required"
			),

			array(
				"field"  =>  "test_time",
				"label"  =>  "Test Time",
				"rules"  =>  "required"
			),

		);
		//set and run the validation
		$this->form_validation->set_rules($validation_config);
		return $this->form_validation->run();
	}

	public function save_data($image_field = NULL)
	{
		$inputs = array();

		$inputs["test_group_name"]  =  $this->input->post("test_group_name");
		$inputs["category_id"]  =  $this->input->post("test_category_id");

		$inputs["test_price"]  =  $this->input->post("test_price");
		$inputs["share"]  =  $this->input->post("share");

		$inputs["test_time"]  =  $this->input->post("test_time");

		return $this->test_group_model->save($inputs);
	}

	public function update_data($test_group_id, $image_field = NULL)
	{
		$inputs = array();

		$inputs["test_group_name"]  =  $this->input->post("test_group_name");
		$inputs["category_id"]  =  $this->input->post("test_category_id");


		$inputs["test_price"]  =  $this->input->post("test_price");
		$inputs["share"]  =  $this->input->post("share");

		$inputs["test_time"]  =  $this->input->post("test_time");

		return $this->test_group_model->save($inputs, $test_group_id);
	}

	//----------------------------------------------------------------
	public function get_test_group_list($where_condition = NULL, $pagination = TRUE, $public = FALSE)
	{
		$data = (object) array();
		$fields = array("test_groups.*");
		$join_table = array();
		if (!is_null($where_condition)) {
			$where = $where_condition;
		} else {
			$where = "";
		}

		if ($pagination) {
			//configure the pagination
			$this->load->library("pagination");

			if ($public) {
				$config['per_page'] = 10;
				$config['uri_segment'] = 3;
				$this->test_group_model->uri_segment = $this->uri->segment(3);
				$config["base_url"]  = base_url($this->uri->segment(1) . "/" . $this->uri->segment(2));
			} else {
				$this->test_group_model->uri_segment = $this->uri->segment(4);
				$config["base_url"]  = base_url(ADMIN_DIR . $this->uri->segment(2) . "/" . $this->uri->segment(3));
			}
			$config["total_rows"] = $this->test_group_model->joinGet($fields, "test_groups", $join_table, $where, true);
			$this->pagination->initialize($config);
			$data->pagination = $this->pagination->create_links();
			$data->test_groups = $this->test_group_model->joinGet($fields, "test_groups", $join_table, $where);
			return $data;
		} else {
			return $this->test_group_model->joinGet($fields, "test_groups", $join_table, $where, FALSE, TRUE);
		}
	}

	public function get_test_group($test_group_id)
	{

		$fields = array("test_groups.*");
		$join_table = array();
		$where = "test_groups.test_group_id = $test_group_id";

		return $this->test_group_model->joinGet($fields, "test_groups", $join_table, $where, FALSE, TRUE);
	}
}
