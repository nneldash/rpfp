<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('form/IndividualInterface');

class IndividualClass extends IndividualInterface
{
    public function __construct($params = null)
    {
        parent::__construct($params);
    }
}
    