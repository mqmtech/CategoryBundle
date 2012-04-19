<?php

namespace MQM\CategoryBundle\Model;

use MQM\CategoryBundle\Model\CategoryInterface;

interface CategoryFactoryInterface
{
    /**
     * @return CategoryInterface
     */
    public function createCategory();
    
    /**
     * @return string
     */
    public function getCategoryClass();
}

?>
