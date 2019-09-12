<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('base/BaseInterface');

abstract class DateRangeInterface extends BaseInterface
{
    /** @var DateTime */
    public $DateFrom;
    /** @var DateTime */
    public $DateTo;
    
    public function __construct($params = null)
    {
        $this->DateFrom    = new DateTime();
        $this->DateTo      = new DateTime();
        parent::__construct($params);
    }
}
