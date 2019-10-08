<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('base/BaseInterface');
$CI->load->iface('form1/SeminarTypeInterface');
$CI->load->iface('common/LocationInterface');

abstract class SeminarInterface extends BaseInterface
{
    public $ClassId;

    /** @var SeminarTypeInterface */
    public $TypeOfClass;

    public $ClassNumber;

    /** @var DateTime */
    public $DateConducted;
    
    /** @var LocationInterface */
    public $Location;    
}
