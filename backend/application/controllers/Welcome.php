<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Item_model');
    }

    public function index()
    {
        //$this->load->view('main-view');
    }

    public function uploadFile()
    {
        $tmp_file = $_FILES['file']['tmp_name'];
        $is_image = getimagesize($tmp_file);
        $uploadPath = '../images';
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }
        if ($is_image === FALSE) {
            $data = array('is_done' => false, 'error_code' => 'is_not_image');
        } else {
            $mime_type = getimagesize($_FILES['file']['tmp_name'])['mime'];
            $valid_mime_types = array(
                "image/png",
                "image/jpeg",
                "image/jpg",
            );
            if (in_array($mime_type, $valid_mime_types)) {
                $file_extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
                $valid_extension = array("jpg", "png", "jpeg");
                if (in_array(strtolower($file_extension), $valid_extension)) {
                    $new_name = $this->getUniqueCode(30) . "." . $file_extension;
                    if (move_uploaded_file($tmp_file, $uploadPath . DIRECTORY_SEPARATOR . $new_name)) {
                        $data = array('is_done' => true, 'file_name' => $new_name);
                    } else {
                        $data = array('is_done' => false);
                    }
                } else {
                    $data = array('is_done' => false, 'error_code' => 'extension_not_allowed');
                }
            } else {
                $data = array('is_done' => false, 'error_code' => 'is_not_image');
            }
        }
        echo json_encode($data);
    }

    function getUniqueCode($length)
    {
        $code = md5(uniqid(rand(), true));
        if ($length != "")
            return substr($code, 0, $length);
        else
            return $code;
    }

    public function addItem()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);
        $this->form_validation->set_rules('name', 'name', 'trim|required');
        $this->form_validation->set_rules('desc', 'desc', 'trim|required');
        $this->form_validation->set_rules('image', 'image', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $data = array('msg' => validation_errors(), 'is_done' => false);
            echo json_encode($data);
        } else {
            $data = array(
                'name' => $this->input->post('name'),
                'description' => $this->input->post('desc'),
                'picture' => $this->input->post('image'),
                'tags' => $this->input->post('tags'),
            );
            $isAdded = $this->Item_model->itemAdd($data);
        }
    }

    public function tags_get()
    {
        $tags = $this->Item_model->getTags();
        echo json_encode($tags);
    }

}
