<?php
defined('BASEPATH') or exit('No direct script access allowed');

class HtmlHelper
{
    public static function inputPdf($type, $name, $class, $attr)
    {
        $data = array(
                "name" => $name,
                "type" => $type,
                "class" => $class,
                "maxlength" => $attr
            );
            return form_input($data);
    }
    
    
}
