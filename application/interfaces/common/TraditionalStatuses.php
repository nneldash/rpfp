<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('base/BasicEnum');

abstract class TraditionalStatuses extends BasicEnum
{
    const EXPRESSING_INTENTION = 1;
    const UNDECIDED = 2;
    const CURRENTLY_PREGNANT = 3;
    const NO_INTENTION = 4;

    public static function Enumerate() : array
    {
        return array(
            TraditionalMethods::EXPRESSING_INTENTION => 'Expressing Intention',
            TraditionalMethods::UNDECIDED => 'Undecided',
            TraditionalMethods::CURRENTLY_PREGNANT => 'Currently Pregnant',
            TraditionalMethods::NO_INTENTION => 'No Intention to Shift'
        );
    }
    
    public static function getString(int $key) : string
    {
        return (TraditionalMethods::enumerate()[$key]);
    }

    public static function count() : int
    {
        return 4;
    }
}
