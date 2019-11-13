<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('base/BasicEnum');

abstract class Sexes extends BasicEnum
{
    const MALE = 1;
    const FEMALE = 2;

    public static function Enumerate() : array
    {
        return array(
            Sexes::MALE => 'Male',
            Sexes::FEMALE => 'Female'
        );
    }

    public static function getString(int $key) : string
    {
        return (Sexes::enumerate()[$key]);
    }

    public static function count() : int
    {
        return 2;
    }      
}
