<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('form1/FormInterface');
$CI->load->library('form1/SeminarClass');
$CI->load->library('form1/lists/ListCoupleClass');
$CI->load->library('form1/lists/ListProfileClass');
$CI->load->library('form1/lists/ListModernFpUserClass');
$CI->load->library('form1/TraditionalFpUserClass');


class FormClass extends FormInterface
{
    public function __construct($params = null)
    {
		$this->Seminar = new SeminarClass();
        $this->ListCouple = new ListCoupleClass();
        $this->ListProfile = new ListProfileClass();
        $this->ListModernFpUser = new ListModernFpUserClass();
        $this->TraditionalFpUser = new TraditionalFpUserClass();
    }

    /* If needed in the future */
    /* 
    public static function getFormFromVariable($form) : FormInterface
    {
        if ($form instanceof FormInterface) {
            return $form;
        }
        return new FormClass($form);
    }
    */
}   
