<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('base/BasicEnum');

abstract class EducationBackgrounds extends BasicEnum
{
    const NO_EDUCATION = 1;
    const ELEMENTARY_LEVEL = 2;
    const ELEMENTARY_GRADUATE = 3;
    const HIGH_SCHOOL_LEVEL = 4;
    const HIGH_SCHOOL_GRADUATE = 5;
    const VOCATIONAL = 6;
    const COLLEGE_LEVEL = 7;
    const COLLEGE_GRADUATE = 8;
    const POST_GRADUATE = 9;

    public static function enumerate() : array
    {
        return array(
            self::NO_EDUCATION => 'No Formal Education',
            self::ELEMENTARY_LEVEL => 'Elementary Level',
            self::ELEMENTARY_GRADUATE => 'Elementary Graduate',
            self::HIGH_SCHOOL_LEVEL => 'High School Level',
            self::HIGH_SCHOOL_GRADUATE => 'High School Graduate',
            self::VOCATIONAL => 'Vocational Level',
            self::COLLEGE_LEVEL => 'College Level',
            self::COLLEGE_GRADUATE => 'College Graduate',
            self::POST_GRADUATE => 'Post Graduate Degree Holder'
        );
    }

    public static function getString(int $key) : string
    {
        return (self::enumerate()[$key]);
    }

    public static function count() : int
    {
        return 9;
    }
}
