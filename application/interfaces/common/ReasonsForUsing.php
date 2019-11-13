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
            ReasonsForUsing::SPACING => 'Condom',
            ReasonsForUsing::LIMITING => 'IUD',
            ReasonsForUsing::ACHIEVING => 'LAM'
        );
    }

    public static function getString(int $key) : string
    {
        return (ReasonsForUsing::enumerate()[$key]);
    }

    public static function count() : int
    {
        return 3;
    }
}
