<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('form1/FormInterface');
$CI->load->library('form1/SeminarClass');
$CI->load->library('form1/lists/ListCoupleClass');

class FormClass extends FormInterface
{
    public function __construct($params = null)
    {
		$this->Seminar = new SeminarClass();
        $this->ListCouple = new ListCoupleClass();
    }

    public static function getFormFromVariable($form) : FormInterface
    {
        if ($form instanceof FormInterface) {
            return $form;
        }
        return new FormClass($form);
    }
}   
