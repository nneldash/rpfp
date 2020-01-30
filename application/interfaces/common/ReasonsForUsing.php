<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('base/BasicEnum');

abstract class ReasonsForUsing extends BasicEnum
{
    const SPACING = 1;
    const LIMITING = 2;
    const ACHIEVING = 3;

    public static function enumerate() : array
    {
        return array(
            self::SPACING => 'Condom',
            self::LIMITING => 'IUD',
            self::ACHIEVING => 'LAM'
        );
    }

    public static function getString(int $key) : string
    {
        return (self::enumerate()[$key]);
    }

    public static function count() : int
    {
        return 3;
    }
}
