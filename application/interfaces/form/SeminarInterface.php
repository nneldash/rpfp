<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('base/BaseInterface');

abstract class SeminarInterface extends BaseInterface
{
    public $Location;
    public $ClassNumber;
	public $Province;
	public $Barangay;
    public $DateConducted;
    public $ParentLeader;
    public $TypeOfClass;
}
