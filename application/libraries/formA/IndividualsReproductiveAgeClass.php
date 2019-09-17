<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('formA/IndividualsReproductiveAgeInterface');

class IndividualsReproductiveAgeClass extends IndividualsReproductiveAgeInterface
{
    public function __construct($params = null)
    {
        parent::__construct($params);
    }
}
