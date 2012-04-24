<?php

namespace MQM\CategoryBundle\Test\Category;


use MQM\CategoryBundle\Model\CategoryManagerInterface;


class CategoryManagerTest extends \Symfony\Bundle\FrameworkBundle\Test\WebTestCase
{   
    protected $_container;
    
    /**
     * @var CategoryManagerInterface
     */
    private $categoryManager;


    public function __construct()
    {
        parent::__construct();
        
        $client = static::createClient();
        $container = $client->getContainer();
        $this->_container = $container;  
    }
    
    protected function setUp()
    {
        $this->categoryManager = $this->get('mqm_category.category_manager');
    }

    protected function tearDown()
    {
        $this->resetCategories();
    }

    protected function get($service)
    {
        return $this->_container->get($service);
    }
    
    public function testGetAssertManager()
    {
        $this->assertNotNull($this->categoryManager);
    }
    
    private function resetCategories()
    {
        $categories = $this->categoryManager->findCategories();
        foreach ($categories as $category) {
            $this->categoryManager->deleteCategory($category, false);
        }
        $this->categoryManager->flush();
    }
}
