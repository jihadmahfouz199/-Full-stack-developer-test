<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

/**
 * @property Users_model $Users_model
 * @property EmpMaster_model $EmpMaster_model
 */
class MY_Controller extends REST_Controller
{

    protected $auto_check_login = true;
    protected $user;

    function __construct()
    {
        parent::__construct();
    }

    public function post($key = NULL, $default = null)
    {
        $value = parent::post($key);

        return ($value) ? $value : $default;
    }

    public function error($message = 'Failed', $errors = null)
    {
        $response = [
            'status' => FALSE,
            'message' => $message,
        ];
        if ($errors) {
            $response['Data'] = $errors;
        }
        $this->response($response, MY_Controller::HTTP_OK);
    }

    protected function forceResponse()
    {
        header("Content-type:application/json");
        $CI =& get_instance();
        echo $CI->output->get_output();
        exit;
    }

    public function validate()
    {
        if ($this->form_validation->run()) {
            return;
        } else {
            $this->error('Failed', $this->form_validation->error_array());
            $this->forceResponse();
        }
    }

    public function successWithData($data = null, $message = 'Successfully')
    {
        $response = [
            'status' => TRUE,
            'message' => $message,
        ];
        if ($data) {
            $response['Data'] = $data;
        }
        $this->response($response, MY_Controller::HTTP_OK);
    }

    public function successWithDataPagination($data = null, $count = null, $message = 'Successfully')
    {
        $response = [
            'status' => TRUE,
            'message' => $message,
        ];
        if ($data) {
            $response['total'] = $count;
            $response['Data'] = $data;
        }
        $this->response($response, MY_Controller::HTTP_OK);
    }

    public function success($message = 'Successfully')
    {
        $response = [
            'status' => TRUE,
            'message' => $message,
        ];
        $this->response($response, MY_Controller::HTTP_OK);
    }

    public function successWithDataAdd($data = null, $message = 'Successfully')
    {
        $response = [
            'status' => TRUE,
            'message' => $message,
        ];
        if ($data) {
            $response['last_id'] = $data;
        }
        $this->response($response, MY_Controller::HTTP_OK);
    }

    public function errorWithDataAdd($data = null)
    {
        $response = [
            'status' => FALSE,
            'message' => $data,
        ];
        $this->response($response, MY_Controller::HTTP_OK);
    }

    /**
     * @return array
     */
    protected function paginationData()
    {
        $pagination = [
            'page' => $this->post('page'),
            'count' => $this->post('count')
        ];
        return $pagination;
    }
}