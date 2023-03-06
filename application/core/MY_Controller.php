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


        // if (isset($_FILES[$field_name])) {
        //     $file_name = $_FILES[$field_name]['name'];
        //     $file_tmp = $_FILES[$field_name]['tmp_name'];
        //     $file_size = $_FILES[$field_name]['size'];
        //     $file_type = $_FILES[$field_name]['type'];
        //     $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        //     // Set the upload directory
        //     $upload_dir = './assets/uploads/';

        //     // Set the allowed file types
        //     $allowed_types = array('jpg', 'jpeg', 'bmp', 'png', 'gif', 'doc', 'docx', 'xlsx', 'xls', 'pdf', 'ppt', 'pptx', 'webp', 'mp4', 'wmv', 'avi');

        //     // Check if the file type is allowed
        //     if (in_array($file_ext, $allowed_types)) {

        //         // Set the maximum file size (in bytes)
        //         $max_size = 1024 * 5000; // 500 KB

        //         // Check if the file size is within the allowed limit
        //         if ($file_size <= $max_size) {

        //             // Generate a unique name for the uploaded file
        //             $new_file_name = md5(uniqid()) . '.' . $file_ext;

        //             // Move the uploaded file to the upload directory
        //             if (move_uploaded_file($file_tmp, $upload_dir . $new_file_name)) {
        //                 // File uploaded successfully
        //                 echo "File uploaded successfully.";
        //             } else {
        //                 // Error uploading file
        //                 echo "Error uploading file.";
        //             }
        //         } else {
        //             // File size is too large
        //             echo "File size is too large. Maximum file size is 500 KB.";
        //         }
        //     } else {
        //         // Invalid file type
        //         echo "Invalid file type. Allowed file types are: " . implode(', ', $allowed_types);
        //     }
        // }
        // exit();
        $uploadedfile = $_FILES[$field_name]['tmp_name'];
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $uploadedfile);

        $extension = pathinfo($_FILES[$field_name]['name'], PATHINFO_EXTENSION);
        if ($extension === 'zip' or $extension === 'wmv') {

            if (isset($_FILES[$field_name]) && $_FILES[$field_name]['error'] === UPLOAD_ERR_OK) {
                $allowedExtensions = ['zip', 'wmv'];
                $maxFileSize = 1048576; // 1MB
                $uploadDir = "./assets/uploads/reception/";

                // Check file extension

                if (!in_array(strtolower($extension), $allowedExtensions)) {
                    echo 'Invalid file extension.';
                    exit;
                }

                // Check file size
                $fileSize = $_FILES[$field_name]['size'];
                if ($fileSize > $maxFileSize) {
                    echo 'File size exceeds maximum allowed size.';
                    exit;
                }

                // Extract zip file and scan for malicious content
                $zip = new ZipArchive;
                if ($zip->open($_FILES[$field_name]['tmp_name']) === true) {
                    for ($i = 0; $i < $zip->numFiles; $i++) {
                        $filename = $zip->getNameIndex($i);
                        $fileInfo = pathinfo($filename);

                        // Check for malicious content
                        if (strpos($fileInfo['basename'], 'php') !== false || strpos($fileInfo['basename'], 'sh') !== false) {
                            echo 'Malicious file detected.';
                            $zip->close();
                            exit;
                        }
                    }

                    // Save zip file
                    $filename = uniqid() . '_' . $_FILES[$field_name]['name'];
                    $this->data["upload_data"]["file_name"] = $filename;
                    $uploadPath = $uploadDir . $filename;
                    if (move_uploaded_file($_FILES[$field_name]['tmp_name'], $uploadPath)) {
                        // echo 'File uploaded successfully.';
                        return true;
                    } else {
                        echo 'File upload failed.';
                    }
                    $zip->close();
                } else {
                    // Save zip file
                    $filename = uniqid() . '_' . $_FILES[$field_name]['name'];
                    $this->data["upload_data"]["file_name"] = $filename;
                    $uploadPath = $uploadDir . $filename;
                    if (move_uploaded_file($_FILES[$field_name]['tmp_name'], $uploadPath)) {
                        // echo 'File uploaded successfully.';
                        return true;
                    } else {
                        echo 'File upload failed.';
                    }
                }
            } else {
                echo 'No file uploaded.';
            }
            exit();
        } else {
            if (is_null($config)) {
                $config = array(
                    "upload_path" => "./assets/uploads/" . $this->router->fetch_class() . "/",
                    "allowed_types" => "jpg|jpeg|bmp|png|gif|doc|docx|xlsx|xls|pdf|ppt|pptx|webp|mp4|wmv|WMV|avi|zip",
                    //"allowed_types" => "asf|ASF",

                    "max_size" => 1024 * 50000,
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
                var_dump($this->data['upload_error']);
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
