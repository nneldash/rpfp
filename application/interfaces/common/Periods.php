<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('base/BasicEnum');

abstract class Periods extends BasicEnum
{
    const WEEKLY = 1;
    const MONTHLY = 2;
    const QUARTERLY = 3;
    const SEMI_ANNUALY = 4;
    const ANNUALLY = 5;

    public static function enumerate() : array
    {
        return array(
            Periods::WEEKLY => 'Weekly',
            Periods::MONTHLY => 'Monthly',
            Periods::QUARTERLY => 'Quarterly',
            Periods::SEMI_ANNUALY => 'Semi-Annually',
            Periods::ANNUALLY => 'Annually'
        );
    }

    public static function getString(int $key) : string
    {
        return (Periods::enumerate()[$key]);
    }

    public static function count() : int
    {
        return 5;
    }
}
