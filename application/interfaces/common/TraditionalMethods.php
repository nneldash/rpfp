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
            TraditionalMethods::WITHDRAWAL => 'Withdrawal Method',
            TraditionalMethods::RHYTHM => 'Rhythm Method',
            TraditionalMethods::CALENDAR => 'Calendar Method',
            TraditionalMethods::ABSTINENCE => 'Abstinence',
            TraditionalMethods::HERBAL => 'Herbal',
            TraditionalMethods::NO_METHOD => 'No Specific Method'
        );
    }
    
    public static function getString(int $key) : string
    {
        return (TraditionalMethods::enumerate()[$key]);
    }

    public static function count() : int
    {
        return 6;
    }
}
