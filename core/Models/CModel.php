<?php

namespace core\Models;

class CModel
{
    /**
     * Return property by name
     *
     * @param object $object
     * @param string $name
     */
    public function getProperty(object $object, string $name)
    {
        if(!isset($object->{$name}))
            throw new \Exception("Not exists property $name");

        return $object->{$name};
    }
}