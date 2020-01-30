<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('base/BasicEnum');

abstract class Scopes extends BasicEnum
{
    const NATIONAL = 50;
    const REGIONAL = 40;
    const PROVINCIAL = 30;
    const CITYWIDE = 20;

    public static function Enumerate() : array
    {
        return array(
            self::NATIONAL => 'National/Central Office',
            self::REGIONAL => 'Regional Level',
            self::PROVINCIAL => 'Provincial Level',
            self::CITYWIDE => 'City/Municipality Level'
        );
    }

    public static function getString(int $key) : string
    {
        return (self::enumerate()[$key]);
    }

    public static function count() : int
    {
        return 4;
    }        
}
