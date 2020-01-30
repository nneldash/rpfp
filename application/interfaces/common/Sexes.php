<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('base/BasicEnum');

abstract class Sexes extends BasicEnum
{
    const MALE = 1;
    const FEMALE = 2;

    const UI_MALE = 'M';
    const UI_FEMALE = 'F';

    public static function Enumerate() : array
    {
        return array(
            self::MALE => 'Male',
            self::FEMALE => 'Female'
        );
    }

    public static function UI_Enumerate() : array
    {
        return array(
            self::UI_MALE => 'Male',
            self::UI_FEMALE => 'Female'
        );
    }

    public static function getString(int $key) : string
    {
        return (self::enumerate()[$key]);
    }

    public static function count() : int
    {
        return 2;
    }      
}
