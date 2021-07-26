<?php

namespace App\Utils;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class FakeEntityBuilder
{
    private $entity;

    private $reflection;

    public function __construct($className)
    {
        $this->entity = new $className();

        $this->reflection = new \ReflectionObject($this->entity);
    }

    public function getEntity()
    {
        return $this->entity;
    }

    public function setField($property, $value)
    {
        $property = $this->reflection->getProperty($property);
        $property->setAccessible(true);
        $property->setValue($this->entity, $value);

        return $this;
    }

    public function add($property, $element)
    {
        $collection = $this->reflection->getProperty($property);

        if (!($collection instanceof Collection)) {
            $collection = new ArrayCollection();
            $this->setField($property, $collection);
        }

        $collection->add($element);

        return $this;
    }
}
