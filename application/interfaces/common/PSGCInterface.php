<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('base/BaseInterface');

abstract class PSGCInterface extends BaseInterface
{
    /** @var int */
    public $Code;
    /** @var string */
    public $Description;
}
