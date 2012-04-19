<?php

namespace MQM\CategoryBundle\Entity;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use MQM\CategoryBundle\Model\CategoryManagerInterface;
use MQM\CategoryBundle\Model\CategoryFactoryInterface;
use MQM\CategoryBundle\Model\CategoryInterface;
use MQM\PaginationBundle\Pagination\PaginationInterface;

class CategoryManager implements CategoryManagerInterface
{
    private $factory;
    private $entityManager;
    private $repository;
   
    public function __construct(EntityManager $entityManager, CategoryFactoryInterface $factory)
    {
        $this->entityManager = $entityManager;
        $this->factory = $factory;
        $categoryClass = $factory->getCategoryClass();
        $this->repository = $this->entityManager->getRepository($categoryClass);
    }
    
    /**
     * 
     * {@inheritDoc}
     */
    public function createCategory() {
        return $this->getFactory()->createCategory();
    }
    
    /**
     * 
     * {@inheritDoc}
     */
    public function saveCategory(CategoryInterface $category, $andFlush = true)
    {
        $this->getEntityManager()->persist($category);
        if ($andFlush) {
            $this->getEntityManager()->flush();
        }
    }
    
    /**
     * 
     * {@inheritDoc}
     */
    public function deleteCategory(CategoryInterface $category, $andFlush = true)
    {
        $this->getEntityManager()->remove($category);
        if ($andFlush) {
            $this->getEntityManager()->flush();
        }
    }
    
    /**
     * {@inheritDoc}
     */
    public function flush()
    {
        $this->getEntityManager()->flush();
    }
    
    /**
     * 
     * {@inheritDoc}
     */
    public function findCategoryBy(array $criteria) {
        return $this->getRepository()->findOneBy($criteria);
    }

    /**
     * 
     * {@inheritDoc}
     */
    public function findCategories(PaginationInterface $pagination = null) {
        return $this->getRepository()->findAll($pagination);
    }
    
    /**
     * 
     * {@inheritDoc}
     */
    public function findAllFamilies(PaginationInterface $pagination = null)
    {
        return $this->getRepository()->findAllFamilies($pagination);
    }
    
    /**
     * 
     * {@inheritDoc}
     */
    public function findRandomFamilies($maxResults = self::MAX_RANDOM_RESULTS)
    {
        return $this->getRepository()->findRandomFamilies($maxResults);
    }

    /**
     *
     * @return CategoryFactoryInterface
     */
    protected function getFactory() {
        return $this->factory;
    }
    
    /**
     *
     * @return EntityManager
     */
    protected function getEntityManager()
    {
        return $this->entityManager;
    }

    /**
    *
    * @return EntityRepository
    */
    protected function getRepository()
    {
        return $this->repository;
    }  
}