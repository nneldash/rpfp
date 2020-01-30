<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('base/BasicEnum');

abstract class TraditionalMethods extends BasicEnum
{
    const WITHDRAWAL = 1;
    const RHYTHM = 2;
    const CALENDAR = 3;
    const ABSTINENCE = 4;
    const HERBAL = 5;
    const NO_METHOD = 6;

    public static function Enumerate() : array
    {
        return array(
            self::WITHDRAWAL => 'Withdrawal Method',
            self::RHYTHM => 'Rhythm Method',
            self::CALENDAR => 'Calendar Method',
            self::ABSTINENCE => 'Abstinence',
            self::HERBAL => 'Herbal',
            self::NO_METHOD => 'No Specific Method'
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
