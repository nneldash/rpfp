<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('form/FormInterface');
$CI->load->library('form/CoupleClass');
$CI->load->library('form/IndividualClass');
$CI->load->library('form/SeminarClass');
$CI->load->library('form/lists/ListEducationalBackgroundClass');


class FormClass extends FormInterface
{
    public function __construct($params = null)
    {
        $this->Couple = new CoupleClass();
        $this->Individual = new IndividualClass();
        $this->Seminar = new SeminarClass();
        $this->ListEducationalBackground = new ListEducationalBackgroundClass();
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