<?php if (!defined('BASEPATH')) exit('Direct access not allowed!');


class MY_Controller extends CI_Controller
{

    public $data = array();

    public function __construct()
    {



        parent::__construct();
        $this->data['site_name'] = config_item("site_name");
        $this->data['errors'] = array();
        // date_default_timezone_set("Asia/karachi");

    }
    //-----------------------------------------------------------------------


    /**
     * upload a file
     * @param $field_name name of the form field
     * @param $config configuration array - this array will be set in
     * controller function where file upload is required
     * if file upload is failed, error will be saved in $data[upload_error]
     * and if upload is successfull, details of the file will be saved in 
     * $data[upload_data]
     * a thumbnail of the file is also created with same file name concatinated
     * with _thumbnail.
     * @return always return true
     */
    public function upload_file($field_name, $config = NULL)
    {
        if (is_null($config)) {
            $config = array(
                "upload_path" => "./assets/uploads/" . $this->router->fetch_class() . "/",
                "allowed_types" => "jpg|jpeg|bmp|png|gif|doc|docx|xlsx|xls|pdf|ppt|pptx|webp|mp4|wmp|WMP",
                "max_size" => 1024 * 100,
                "max_width" => 0,
                "max_height" => 0,
                "remove_spaces" => true,
                "encrypt_name" => true
            );
        }

        $dir = $config["upload_path"];
        if (!is_dir($dir)) {
            mkdir($dir, 0777);
        }

        $this->load->library("upload", $config);

        if (!$this->upload->do_upload($field_name)) {

            $this->data['upload_error'] = $this->upload->display_errors();
            return false;
        } else {

            $this->data['upload_data'] = $this->upload->data();


            //now create image thumbnail
            //if($this->data['upload_data']['is_image'] == true){

            $config['image_library'] = 'gd2';
            $config['source_image']    = $dir . $this->data['upload_data']['file_name'];
            $config['create_thumb'] = TRUE;
            //$config['maintain_ratio'] = TRUE;
            $config['width']    = 100;
            $config['height']    = 100;

            //$this->load->library('image_lib', $config); 
            $this->image_lib->initialize($config);

            $this->image_lib->resize();
            //}
            return true;
        }
    }
    //------------------------------------------------------------------------------------








    /**
     * check allowed file type - custom validation function
     * @param $filename name of the file
     * @return boolean if extension is not allowed
     */
    public function _filetype_validation($str, $filename)
    {

        //if the file field is empty
        if (strlen($filename) < 1) {
            return true;
        }

        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        $allowed = array('jpg', 'jpeg', 'bmp', 'png', 'gif', 'doc', 'docx', 'xlsx', 'xls', 'pdf', 'ppt', 'pptx', 'mp4');

        if (!in_array($ext, $allowed)) {
            $this->form_validation->set_message("_filetype_validation", "$ext file type is not allowed");
            return false;
        }
        return true;
    }
    //---------------------------------------------------------------------------------




    /**
     * function for required file type validation
     */
    public function _file_required($str, $filename)
    {

        if (strlen($filename) < 1) {
            $this->form_validation->set_message("_file_required", "%s is a required field");
            return false;
        }
        return true;
    }
    //-------------------------------------------------------------------------------




}
