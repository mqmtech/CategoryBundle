<?php

namespace MQM\CategoryBundle\Entity;

use Doctrine\ORM\EntityRepository;
use MQM\PaginationBundle\Pagination\PaginationInterface;

class CategoryRepository extends EntityRepository{
    
    /**
     * 
     * return array
     */
    public function findAll(PaginationInterface $pagination = null)
    {
        $em = $this->getEntityManager();
        $q = $em->createQuery('SELECT cat from MQMCategoryBundle:Category cat');
        if ($pagination) {
            $q = $pagination->paginateQuery($q);
        }
        $categories = $q->getResult();

        return $categories;
    }
    
     /**
     * 
     * return array
     */
    public function findAllFamilies(PaginationInterface $pagination = null)
    {
        $em = $this->getEntityManager();
        $q = $em->createQuery('SELECT cat from MQMCategoryBundle:Category cat WHERE cat.parentCategory is NULL ORDER BY cat.name ASC');
        if ($pagination) {
            $q = $pagination->paginateQuery($q);
        }
        $categories = $q->getResult();

        return $categories;
    }
    
    /**
     * Random list of categories
     * 
     * return array
     */
    public function findRandomFamilies($maxResults)
    {
        $em = $this->getEntityManager();
        $q = $em->createQuery('SELECT cat from MQMCategoryBundle:Category cat WHERE cat.parentCategory is NULL');
        $categories = $q->getResult();        
        if ($categories == null) {
            return null;
        }        
        $catSize = sizeof($categories);
        if ($catSize < $maxResults) {
            $maxResults = $catSize;
        }
        $rand_keys = array_rand($categories, $maxResults);
        
        $randCategories = array();
        if (sizeof($rand_keys) > 1) {
            foreach ($rand_keys as $key) {
                 $randCategories[] = $categories[$key];            
            }
        }
        else {
            $randCategories[] = $categories[$rand_keys];            
        }
        
        return $randCategories;
    }
}
