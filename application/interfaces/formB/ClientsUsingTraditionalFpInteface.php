<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('base/BaseInterface');

abstract class ClientsUsingTraditionalFpInteface extends BaseInterface
{
    public $NumberOfClients;
}
