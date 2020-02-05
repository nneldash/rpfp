<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('base/BaseInterface');
$CI->load->iface('common/CodeInterface');

abstract class LocationInterface extends BaseInterface
{
    /** @var CodeInterface */
    public $Region;

    /** @var CodeInterface */
    public $Province;

    /** @var CodeInterface */
    public $City;
    
    /** @var CodeInterface */
    public $Barangay;
}
