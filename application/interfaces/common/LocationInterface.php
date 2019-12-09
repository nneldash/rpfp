<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('base/BaseInterface');
$CI->load->iface('common/PSGCInterface');

abstract class LocationInterface extends BaseInterface
{
    /** @var PSGCInterface */
    public $Region;

    /** @var PSGCInterface */
    public $Province;

    /** @var PSGCInterface */
    public $City;
    
    /** @var PSGCInterface */
    public $Barangay;
}
