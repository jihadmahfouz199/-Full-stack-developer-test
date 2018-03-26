<?php
/**
 * Created by PhpStorm.
 * User: Mahfouz
 * Date: 3/26/2018
 * Time: 11:38 AM
 */

class items extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Item_model');
    }

    public function index_get()
    {
        $items = $this->Item_model->get_items();
        if ($items) {
            $this->successWithData($items);
        } else {
            $this->error('No Items');
        }
    }


}