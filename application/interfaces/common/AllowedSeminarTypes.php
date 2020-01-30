<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('base/BasicEnum');

abstract class AllowedSeminarTypes extends BasicEnum
{
    const FOUR_PS = 1;
    const FAITHBASED_ORG = 2;
    const PMC = 3;
    const USAPAN = 4;
    const HOUSE_2_HOUSE = 5;
    const PROFILE_ONLY = 6;
    const OTHERS = 7;

    public static function enumerate() : array
    {
        return array(
            self::FOUR_PS => '4Ps',
            self::FAITHBASED_ORG => 'Faith-Based Organization',
            self::PMC => 'Pre-Marriage Counseling',
            self::USAPAN => 'USAPAN',
            self::HOUSE_2_HOUSE => 'House-To-House',
            self::PROFILE_ONLY => 'Profile Only',
            self::OTHERS => 'Others'
        );
    }

    public static function getString(int $key) : string
    {
        return (self::enumerate()[$key]);
    }

    public static function count() : int
    {
        return 7;
    }
}
