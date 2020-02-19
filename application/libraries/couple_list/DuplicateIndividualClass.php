<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('couple_list/DuplicateIndividualInterface');

class DuplicateIndividualClass extends DuplicateIndividualInterface
{
    public function __construct($params = null)
    {
        parent::__construct($params);
    }
}
