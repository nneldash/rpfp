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

    const UI_EXPRESSING_INTENTION = 'A';
    const UI_UNDECIDED = 'B';
    const UI_CURRENTLY_PREGNANT = 'C';
    const UI_NO_INTENTION = 'C';

    public static function Enumerate() : array
    {
        return array(
            self::EXPRESSING_INTENTION => 'Expressing Intention',
            self::UNDECIDED => 'Undecided',
            self::CURRENTLY_PREGNANT => 'Currently Pregnant',
            self::NO_INTENTION => 'No Intention to Shift'
        );
    }
    
    public static function UI_Enumerate() : array
    {
        return array(
            self::UI_EXPRESSING_INTENTION => 'Expressing Intention',
            self::UI_UNDECIDED => 'Undecided',
            self::UI_CURRENTLY_PREGNANT => 'Currently Pregnant',
            self::UI_NO_INTENTION => 'No Intention to Shift'
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
