<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('common/ErrorInterface');

class Errors extends ErrorInterface
{
    public function __construct($params = null)
    {
        parent::__construct($params);
        $this->Code = self::NO_ERROR;
        $this->Description = BLANK;
        $this->Message = BLANK;
        $this->ReturnValue = 0;
    }

    public static function getFromVariable($variable) : ErrorInterface
    {
        if ($variable instanceof ErrorInterface) {
            return $variable;
        }
        return new Errors();
    }
}
