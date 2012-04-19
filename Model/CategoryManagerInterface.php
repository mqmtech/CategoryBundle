<?php

namespace MQM\CategoryBundle\Model;

use MQM\CategoryBundle\Model\CategoryInterface;
use MQM\PaginationBundle\Pagination\PaginationInterface;

interface CategoryManagerInterface
{    
    const MAX_RANDOM_RESULTS = 4;
    
    /**
     * @return CategoryInterface 
     */
    public function createCategory();
    
    /**
     *
     * @param CategoryInterface $category
     * @param boolean $andFlush 
     */
    public function saveCategory(CategoryInterface $category, $andFlush = true);
    
    /**
     *
     * @param CategoryInterface $category
     * @param boolean $andFlush 
     */
    public function deleteCategory(CategoryInterface $category, $andFlush = true);
    
    /**
     * @return CategoryManagerInterface
     */
    public function flush();
    
    /**
     * @param array $criteria
     * @return CategoryInterface 
     */
    public function findCategoryBy(array $criteria);
    
    /**
     * @return array 
     */
    public function findCategories(PaginationInterface $pagination = null);
    
    /**
     * 
     * @return array 
     */
    public function findAllFamilies(PaginationInterface $pagination = null);
    
    /**
     * Random list of categories
     * 
     * @return array 
     */
    public function findRandomFamilies($maxResults = self::MAX_RANDOM_RESULTS);   
}