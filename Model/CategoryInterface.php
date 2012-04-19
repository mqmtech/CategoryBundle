<?php

namespace MQM\CategoryBundle\Model;

use MQM\ImageBundle\Model\ImageInterface;

interface CategoryInterface
{
    
    
    public function getOffer();

    public function setOffer($offer);
    
    /**
     * @return array
     */
    public function getProducts();

    /**
     * @param array $products
     */
    public function setProducts($products);

    /**
     * @return CategoryInterface $parentCategory
     */
    public function getParentCategory();

    /**
     *
     * @param CategoryInterface $category 
     */
    public function addCategory(CategoryInterface $category);

    /**
     * @return aray $categories
     */
    public function getCategories();

    /**
     * @param array $categories
     */
    public function setCategories($categories);

    /**
     * @param CategoryInterface $parentCategory
     */
    public function setParentCategory($parentCategory);
    
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId();
    
    /**
     * Set id
     *
     * @param integer $id
     */
    public function setId($id);

    /**
     * Set name
     *
     * @param string $name
     */
    public function setName($name);

    /**
     * Get name
     *
     * @return string 
     */
    public function getName();

    /**
     * Set description
     *
     * @param string $description
     */
    public function setDescription($description);

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription();

    /**
     * Set createdAt
     *
     * @param datetime $createdAt
     */
    public function setCreatedAt($createdAt);

    /**
     * Get createdAt
     *
     * @return datetime 
     */
    public function getCreatedAt();

    /**
     * Set modifiedAt
     *
     * @param datetime $modifiedAt
     */
    public function setModifiedAt($modifiedAt);

    /**
     * Get modifiedAt
     *
     * @return datetime 
     */
    public function getModifiedAt();
    
    /**
     * 
     * Get image
     * 
     * @return Image
     */
    public function getImage();
    
    /**
     * 
     * Set image
     * 
     * @param ImageInterface $image
     */
    public function setImage($image);

    /**
    * @return CategoryInterface
    */
    public function getRootCategory();

    /**
     * @return integer 
     */
    public function getHierarchyDepth();
    
    /**
     *
     * @return array 
     */
    public function getAncestors();
    
}