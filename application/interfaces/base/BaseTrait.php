<?php

trait BaseTrait
{
    protected function &newIfEmpty(BaseProperty $variable, $class)
    {
        if (!($variable->davalue instanceof $class)) {
            $variable->davalue = new $class($variable->davalue);
        }
        return $variable->davalue;
    }
}
