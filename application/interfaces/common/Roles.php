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
            Roles::ENCODER => 'Encoder',
            Roles::PARTNER => 'Partner',
            Roles::FOCAL_PERSON => 'Regional/Provincial Focal Person',
            Roles::DATA_MANAGER => 'Regional Data Manager',
            Roles::PMED_STAFF => 'PMED/Central Office Staff',
            Roles::ITDMU_STAFF => 'Administrator'
        );
    }

    public static function getString(int $key) : string
    {
        return (Roles::enumerate()[$key]);
    }

    public static function count() : int
    {
        return 6;
    }
}
