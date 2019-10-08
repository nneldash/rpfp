<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('base/BaseInterface');
$CI->load->iface('common/AllowedSeminarTypes');

abstract class SeminarTypeInterface extends BaseInterface
{
    /** @var AllowedSeminarTypes */
    public $Type;
    /** @var string */
    public $Others;
}