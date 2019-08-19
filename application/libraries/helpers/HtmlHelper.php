<?php
defined('BASEPATH') or exit('No direct script access allowed');

class HtmlHelper
{
    public static function inputPdf($type, $name, $class)
    {
        $data = array(
                "name" => $name,
                "type" => $type,
                "class" => $class
            );
            return form_input($data);
    }
    
    
}
