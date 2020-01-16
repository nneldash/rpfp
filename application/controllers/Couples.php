<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Couples extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->LoginModel->isLoggedIn()) {
            redirect(site_url());
            return;
        }

        $this->load->model('CoupleModel');
    }

    public function index()
    {
        redirect('Menu');
    }

    public function pendingList()
    {
        // if ($this->input->server(REQUEST_METHOD) != POST) {

        // }
        $page_no = $this->input->post('page_no');
        $items_per_page = $this->input->post('items_per_page');

        $page_no = empty($page_no) ? 1 : $page_no;
        $items_per_page = empty($items_per_page) ? 1 : $items_per_page;

        $list = $this->CoupleModel->getPendingList($page_no, $items_per_page);
        $retVal = array(
            'data' => array(),
            'page' => $page_no,
            'items' => $items_per_page,
            'method' => $this->input->server(REQUEST_METHOD)
        );

        foreach ($list as $item) {
            $class = PendingClass::getFromVariable($item);
            $retVal['data'][] = array(
                $class->ClassNo,
                $class->TypeClass,
                $class->Barangay,
                $class->DateConduct
            );
        }

        $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(($retVal)));

    }
}
