<?php
defined('BASEPATH') or exit('No direct script access allowed');

abstract class ListBase extends ArrayObject
{
    protected $baseInterface;
    
    public function offsetSet($key, $val)
    {
        if (!$this->baseInterface) {
            throw new Exception("Interface must be initialized");
        }
        
        if (!($val instanceof $this->baseInterface)) {
            throw new InvalidArgumentException("Value must be a {$this->baseInterface}");
        }

        return parent::offsetSet($key, $val);
    }
}
