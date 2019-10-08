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

}
