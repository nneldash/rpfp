<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('form/FormInterface');
$CI->load->library('form/SeminarClass');
$CI->load->library('form/lists/ListCoupleClass');
$CI->load->library('form/lists/ListProfileClass');
$CI->load->library('form/ModernFpUserClass');
$CI->load->library('form/TraditionalFpUserClass');


class FormClass extends FormInterface
{
    public function __construct($params = null)
    {
		$this->Seminar = new SeminarClass();
        $this->ListCouple = new ListCoupleClass();
        $this->ListProfile = new ListProfileClass();
        $this->ModernFpUser = new ModernFpUserClass();
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
