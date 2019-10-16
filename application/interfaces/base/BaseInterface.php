<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('base/BaseTrait');
$CI->load->iface('base/BaseProperty');

/*
 *
 * This utilizes magic methods to easily access private fields
 * https://beaconfire-red.com/smarts/better-getters-and-setters-php
 *
 */

abstract class BaseInterface
{
    use BaseTrait;
    
    const _PROP = 'xXx';
    const _SET = 'set';
    const _GET = 'get';
    const _INTERFACE = 'Interface';
    const _CLASS = 'Class';
    
    public function __construct($params = null)
    {
        $fields = get_class_vars(get_class($this));
        foreach ($fields as $name => $value) {
            $res = strpos($name, self::_PROP);
            if ($res === false || $res != 0) {
                $assignedValue = new BaseProperty(
                    [
                        _TYPE => (gettype($this->$name) === 'object' ? get_class($this->$name) : null),
                        _VALUE => null
                    ]
                );
                $newProp = self::_PROP . $name;
                $this->{$newProp} = $assignedValue;
                unset($this->{$name});
            }
        }
    }


    public function __get($name)
    {
        $property =  $name;
        $pos = strpos($name, self::_PROP);
        if ($pos !== 0) {
            $property = self::_PROP . $name;
        }

        $action = self::_SET . str_replace(self::_PROP, BLANK, $property);
        if (method_exists($this, $action)) {
            return $this->$action();
        }

        if (property_exists($this, $property)) {
            if (!empty($this->$property->datype)) {
                $value =& $this->newIfEmpty($this->$property, $this->$property->datype);
            } else {
                $value = $this->$property->davalue;
            }
            return $value ?: N_A;
        }
        
        return substr($property, 1) . NOT_FOUND;
    }
    
    public function __set($name, $value = null)
    {
        $property =  $name;
        $pos = strpos($name, self::_PROP);
        if ($pos !== 0) {
            $property = self::_PROP . $name;
        }

        $action = self::_SET . str_replace(self::_PROP, BLANK, $property);
        if (method_exists($this, $action)) {
            $this->$action($value);
            return true;
        }

        if ($value instanceof BaseProperty) {
            $this->$property = $value;
            return true;
        }

        if (!property_exists($this, $property)) {
            return false;
        }

        $this->$property->davalue = $value;
        return true;
    }
}
