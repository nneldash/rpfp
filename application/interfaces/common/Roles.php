<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('base/BasicEnum');

abstract class Roles extends BasicEnum
{
    const ENCODER = 50;
    const PARTNER = 60;
    const FOCAL_PERSON = 70;
    const DATA_MANAGER = 80;
    const PMED_STAFF = 90;
    const ITDMU_STAFF = 100;

    public static function Enumerate() : array
    {
        return array(
            self::ENCODER => 'Encoder',
            self::PARTNER => 'Partner',
            self::FOCAL_PERSON => 'Regional/Provincial Focal Person',
            self::DATA_MANAGER => 'Regional Data Manager',
            self::PMED_STAFF => 'PMED/Central Office Staff',
            self::ITDMU_STAFF => 'Administrator'
        );
    }

    public static function getString(int $key) : string
    {
        return (self::enumerate()[$key]);
    }

    public static function count() : int
    {
        return 6;
    }
}
