<?php
$this->CI =& get_instance();
$this->CI->load->model('BaseModel');

class FormModel extends BaseModel
{
    public function __construct()
    {
        parent::__construct();
        $this->CI->load->library('form/FormClass');
    }

    public function saveForm1()
    {
        return true;
    }
}
?>