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
            EducationBackgrounds::NO_EDUCATION => 'No Formal Education',
            EducationBackgrounds::ELEMENTARY_LEVEL => 'Elementary Level',
            EducationBackgrounds::ELEMENTARY_GRADUATE => 'Elementary Graduate',
            EducationBackgrounds::HIGH_SCHOOL_LEVEL => 'High School Level',
            EducationBackgrounds::HIGH_SCHOOL_GRADUATE => 'High School Graduate',
            EducationBackgrounds::VOCATIONAL => 'Vocational Level',
            EducationBackgrounds::COLLEGE_LEVEL => 'College Level',
            EducationBackgrounds::COLLEGE_GRADUATE => 'College Graduate',
            EducationBackgrounds::POST_GRADUATE => 'Post Graduate Degree Holder'
        );
    }

    public static function getString(int $key) : string
    {
        return (EducationBackgrounds::enumerate()[$key]);
    }

    public static function count() : int
    {
        return 9;
    }
}
