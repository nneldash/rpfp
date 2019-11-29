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
                    ($type == "date") ? $field : $field
                );
            }
        }
    }

    public static function inputName($is_pdf, $field, $type, $name, $class, $placeholder, $returnIfEmpty = "")
    {
        if (!$is_pdf) {
            $data = array(
                "name" => $name,
                "value" => (
                    ($type == "date") ? $date : $field
                ),
                "class" => $class,
                "type" => $type,
                "placeholder" => $placeholder
            );
            return form_input($data);
        } else {
            if (empty($field) && !empty($returnIfEmpty)) {
                return returnIfEmpty;
            } else {
                return (
                    ($type == "date") ? $field : $field
                );
            }
        }
    }

    public static function inputMaskPdf($is_pdf, $field, $type, $name, $class, $mask, $returnIfEmpty = "")
    {
        $date = "";        
        if (!$is_pdf) {
            $data = array(
                "name" => $name,
                "value" => (
                    ($type == "date") ? $date : $field
                ),
                "class" => $class,
                "type" => $type,
                "data-inputmask" => $mask
            );
            return form_input($data);
        } else {
            if (empty($field) && !empty($returnIfEmpty)) {
                return returnIfEmpty;
            } else {
                return (
                    ($type == "date") ? $field : $field
                );
            }
        }
    }
    
    public static function checkBox($is_pdf, $field, $value, $name)
    {
        $state = BLANK;
        if (!$is_pdf) {
            $state = (($field == $value) ? "checked" : BLANK);
            return "<input class='text-inherit text-size10' type='checkbox' value='{$value}'
                    name='{$name}' {$state} />{$value}";
        } else {
            $state = (($field == $value) ? "&#x25A0;" : "&#9744;");
            return "{$state}<span class='padding-l5'>{$value}</span>";
        }
    }

    public static function firstEntry_Id($first, $second)
    {
        $individualId = $first != 'N/A' ? ($first != 'N/A' ? $first : '') : ($second != 'N/A' ? $second : '');

        return $individualId;
    }

    public static function secondEntry_Id($first, $second)
    {
        $individualId = $first == 'N/A' ? '' : ($second != 'N/A' ? $second : '');

        return $individualId;
    }

    public static function firstEntry_Name($firstEntry, $secondEntry) // original
    {
        $name = $firstEntry->Firstname != 'N/A' ? ($firstEntry->Firstname != 'N/A' ? $firstEntry->Firstname : '').($firstEntry->Surname != 'N/A' ? ', '.$firstEntry->Surname : '').($firstEntry->Middlename != 'N/A' ? ', '.$firstEntry->Middlename : '').($firstEntry->Extname != 'N/A' ? ', '.$firstEntry->Extname : '') : ($secondEntry->Firstname != 'N/A' ? $secondEntry->Firstname : '').($secondEntry->Surname != 'N/A' ? ', '.$secondEntry->Surname : '').($secondEntry->Middlename != 'N/A' ? ', '.$secondEntry->Middlename : '');

        return $name;
    }

    public static function firstEntry_FirstName($firstEntry, $secondEntry)
    {
        $name = $firstEntry->Firstname == 'N/A' ? ($secondEntry->Firstname != 'N/A' ? $secondEntry->Firstname : '') : ($firstEntry->Firstname != 'N/A' ? $firstEntry->Firstname : '');

        return $name;
    }

    public static function firstEntry_MiddleName($firstEntry, $secondEntry)
    {
        $name = $firstEntry->Middlename == 'N/A' ? ($secondEntry->Middlename != 'N/A' ? $secondEntry->Middlename : '') : ($firstEntry->Middlename != 'N/A' ? $firstEntry->Middlename : '');

        return $name;
    }

    public static function firstEntry_LastName($firstEntry, $secondEntry)
    {
        $name = $firstEntry->Surname == 'N/A' ? ($secondEntry->Surname != 'N/A' ? $secondEntry->Surname : '') : ($firstEntry->Surname != 'N/A' ? $firstEntry->Surname : '');

        return $name;
    }

    public static function firstEntry_ExtName($firstEntry, $secondEntry)
    {
        $name = $firstEntry->Extname == 'N/A' ? ($secondEntry->Extname != 'N/A' ? $secondEntry->Extname : '') : ($firstEntry->Extname != 'N/A' ? $firstEntry->Extname : '');

        return $name;
    }

    public static function secondEntry_Name($firstEntry, $secondEntry) // original
    {
        $name = $firstEntry->Surname == 'N/A' ? '' : ($secondEntry->Firstname != 'N/A' ? $secondEntry->Firstname : '').($secondEntry->Surname != 'N/A' ? ', '.$secondEntry->Surname : '').($secondEntry->Middlename != 'N/A' ? ', '.$secondEntry->Middlename : '');

        return $name;
    }

    public static function secondEntry_FirstName($firstEntry, $secondEntry)
    {
        $name = $firstEntry->Firstname == 'N/A' ? '' : ($secondEntry->Firstname != 'N/A' ? $secondEntry->Firstname : '');

        return $name;
    }

    public static function secondEntry_MiddleName($firstEntry, $secondEntry)
    {
        $name = $firstEntry->Middlename == 'N/A' ? '' : ($secondEntry->Middlename != 'N/A' ? $secondEntry->Middlename : '');

        return $name;
    }

    public static function secondEntry_LastName($firstEntry, $secondEntry)
    {
        $name = $firstEntry->Surname == 'N/A' ? '' : ($secondEntry->Surname != 'N/A' ? $secondEntry->Surname : '');

        return $name;
    }

    public static function secondEntry_ExtName($firstEntry, $secondEntry)
    {
        $name = $firstEntry->Extname == 'N/A' ? '' : ($secondEntry->Extname != 'N/A' ? $secondEntry->Extname : '');

        return $name;
    }

    public static function firstEntry_Sex($first, $second)
    {
        $sex = $first == 2 ? 'F' : ($second == 2 ? 'F' : $second != 'N/A' ? 'M' : '');

        return $sex;
    }

    public static function secondEntry_Sex($first, $second)
    {
        $sex = $first == 'N/A' ? '' : ($second == 2 ? 'F' : $second != 'N/A' ? 'M' : '');

        return $sex;
    }

    public static function firstEntry_Civil($first, $second)
    {
        $civil = $first != 'N/A' ? ($first != 'N/A' ? $first : '') : ($second != 'N/A' ? $second : '');

        return $civil;
    }

    public static function secondEntry_Civil($first, $second)
    {
        $civil = $first == 'N/A' ? '' : ($second != 'N/A' ? $second : '');

        return $civil;
    }

    public static function firstEntry_Birthday($firstBday, $secondBday)
    {
        $birthday = $firstBday != 'N/A' ? ($firstBday != 'N/A' ? $firstBday : '') : ($secondBday != 'N/A' ? $secondBday : '');

        return $birthday;
    }

    public static function firstEntry_BirthAge($firstAge, $secondAge)
    {
        $birthage = $firstAge != 'N/A' ? ($firstAge != 'N/A' ? $firstAge : '') : ($secondAge != 'N/A' ? $secondAge : '');

        return $birthage;
    }

    public static function secondEntry_Birthday($firstBday, $secondBday)
    {
        $birthday = $firstBday == 'N/A' ? '' : ($secondBday != 'N/A' ? $secondBday : '');

        return $birthday;
    }

    public static function secondEntry_BirthAge($firstAge, $secondAge)
    {
        $birthage = $firstAge == 'N/A' ? '' : ($secondAge != 'N/A' ? $secondAge : '');

        return $birthage;
    }

    public static function firstEntry_Education($firstEduc, $secondEduc)
    {
        $education = $firstEduc != 'N/A' ? ($firstEduc != 'N/A' ? $firstEduc : '') : ($secondEduc != 'N/A' ? $secondEduc : '');

        return $education;
    }

    public static function secondEntry_Education($firstEduc, $secondEduc)
    {
        $education = $firstEduc == 'N/A' ? '' : ($secondEduc != 'N/A' ? $secondEduc : '');

        return $education;
    }

    public static function dashInputPdf($field) : string
    {
        if ($field != N_A) {
            if ($field instanceof BasicInt) {
                return strval($field->value());
            }
            return strval($field);
            
        }
        return " - ";
    }
}
 