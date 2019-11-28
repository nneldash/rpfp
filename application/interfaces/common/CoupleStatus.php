<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('base/BasicEnum');

abstract class CoupleStatus extends BasicEnum
{
    const PENDING = 2;
    const APPROVE = 0;

    public static function enumerate() : array
    {
        return array(
            CoupleStatus::PENDING => 'Pending',
            CoupleStatus::APPROVE => 'Approve'
        );
    }

    public static function getString(int $key) : string
    {
        return (CoupleStatus::enumerate()[$key]);
    }

    public static function count() : int
    {
        return 2;
    }
}
