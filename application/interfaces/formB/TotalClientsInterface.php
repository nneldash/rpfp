<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('base/BaseInterface');

abstract class TotalClientsInterface extends BaseInterface
{
    public $TotalNumber;
}
