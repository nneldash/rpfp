<?php
defined('BASEPATH') or exit('No direct script access allowed');

class HtmlHelper
{
    public static function inputPdf($is_pdf, $field, $type, $name, $class, $attr, $returnIfEmpty = "")
    {
        $date = "";
        if ($type == "date" && !empty($field) && ($field instanceof DateTime)) {
            $today = new DateTime();
            if ($today->format("Ymd") != $field->format("Ymd")) {
                $date = $field->format("Y-m-d");
                $date_pdf = $field->format("m/d/Y");
            }
        }
        
        if (!$is_pdf) {
            $data = array(
                "name" => $name,
                "value" => (
                    ($type == "date") ? $date : $field
                ),
                "class" => $class,
                "type" => $type,
                "maxlength" => $attr
            );
            return form_input($data);
        } else {
            if (empty($field) && !empty($returnIfEmpty)) {
                return returnIfEmpty;
            } else {
                return (
                    ($type == "date") ? $date_pdf : $field
                );
            }
        }
    }
    
    
}
