<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('base/BasicEnum');

abstract class CivilStatuses extends BasicEnum
{
    const MARRIED = 1;
    const SINGLE = 2;
    const WIDOW = 3;
    const SEPARATED = 4;
    const LIVE_IN = 5;

    public static function enumerate() : array
    {
        return array(
            self::MARRIED => 'Married',
            self::SINGLE => 'Single',
            self::WIDOW => 'Widow/Widower',
            self::SEPARATED => 'Separated',
            self::LIVE_IN => 'Living-in'
        );
    }

    public static function getString(int $key) : string
    {
        return (self::enumerate()[$key]);
    }

    public static function count() : int
    {
        return 5;
    }
}
