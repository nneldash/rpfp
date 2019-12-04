<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI = get_instance();
$CI->load->iface('base/BaseInterface');

class StringHolder extends BaseInterface
{
    /** @var string */
    public $value = "";

    public function __construct($params = array())
    {
        if (is_string($params)) {
            $this->value = $params;
            return;
        }
    }

    public static function getFromVariable($variable)
    {
        if ($variable instanceof StringHolder) {
            return $variable;
        }
        return new StringHolder($variable);
    }
}