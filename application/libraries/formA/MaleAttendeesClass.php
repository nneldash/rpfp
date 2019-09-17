<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('formA/MaleAttendeesInterface');

class MaleAttendeesClass extends MaleAttendeesInterface
{
    public function __construct($params = null)
    {
        parent::__construct($params);
    }
}
