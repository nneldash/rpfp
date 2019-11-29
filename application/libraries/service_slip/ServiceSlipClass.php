<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('service_slip/ServiceSlipInterface');

class ServiceSlipClass extends ServiceSlipInterface
{
    public function __construct($params = null)
    {
        parent::__construct($params);
    }

    public static function getServiceSlipFromVariable($slip) : ServiceSlipInterface
    {
        if ($slip instanceof ServiceSlipInterface) {
            return $slip;
        }
        return new ServiceSlipClass($slip);
    }
}
