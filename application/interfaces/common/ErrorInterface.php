<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('common/CodeInterface');

abstract class ErrorInterface extends CodeInterface
{
    const NO_ERROR = 0;
    const DATABASE_ERROR = 1;
    const INVALID_PARAMETER = 2;
    const INVALID_RETURN_VALUE = 3;
    const INVALID_ROLE = 4;

    /** @var string */
    public $Message;

    public $ReturnValue;

}
