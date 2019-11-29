<?php
defined('BASEPATH') or exit('No direct script access allowed');

abstract class ReportBase extends ArrayObject
{
    /** @var BaseInterface */
    protected $baseInterface;

    /** @var DateTime */
    public $From;

    /** @var DateTime */
    public $To;

    /** @var string */
    public $RegionalOffice;

    /** @var string */
    public $PreparedBy;

    /** @var string */
    public $NotedBy;

    /** @var string */
    public $ApprovedBy;

    
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
