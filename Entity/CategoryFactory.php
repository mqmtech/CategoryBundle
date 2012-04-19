<?php

namespace MQM\CategoryBundle\Entity;

use MQM\CategoryBundle\Model\CategoryFactoryInterface;

class CategoryFactory implements CategoryFactoryInterface
{
    private $categoryClass;

    
    public function __construct($categoryClass)
    {
        $this->categoryClass = $categoryClass;
    }
    
    /**
     * {@inheritDoc}
     */
    public function createCategory()
    {
        return new $this->categoryClass();
    }

    /**
     * {@inheritDoc}
     */
    public function getCategoryClass()
    {
        return $this->categoryClass;
    }
}