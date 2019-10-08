<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('form1/CoupleInterface');
$CI->load->library('form1/lists/IndividualClass');
$CI->load->library('form1/lists/ModernFpUserClass');
$CI->load->library('form1/lists/TraditionalFpUserClass');


class CoupleClass extends CoupleInterface
{
    public function __construct($params = null)
    {
        $this->FirstEntry = new IndividualClass();
        $this->SecondEntry = new IndividualClass();
        $this->ModernFp  = new ModernFpUserClass();
        $this->TraditionalFp = new TraditionalFpUserClass();

        parent::__construct($params);
    }

    
    public function Wife() : IndividualInterface
    {
        if ($this->FirstEntry->Sex == Sexes::MALE ) {
            return $this->FirstEntry;
        }
        return $this->SecondEntry;
    }

    public function Husband() : IndividualInterface
    {
        if ($this->FirstEntry->Sex == Sexes::FEMALE ) {
            return $this->FirstEntry;
        }
        return $this->SecondEntry;
    }
}
    