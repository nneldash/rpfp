<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('formB/ClientsUnmetNeedInterface');

class ClientsUnmetNeedClass extends ClientsUnmetNeedInterface
{
    public function __construct($params = null)
    {
        parent::__construct($params);
    }
}
