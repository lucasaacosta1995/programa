<?php

namespace core\Interfaces;

interface Model
{
   /**
    * Return specific fields
    *
    * @return object
    */
   public function getProperties(): object;
}