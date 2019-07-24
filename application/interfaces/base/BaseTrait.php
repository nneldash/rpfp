<?php

trait BaseTrait
{
    protected function &newIfEmpty(BaseProperty $variable, $class)
    {
        if (!($variable->value instanceof $class)) {
            $variable->value = new $class($variable->value);
        }
        return $variable->value;
    }
}
