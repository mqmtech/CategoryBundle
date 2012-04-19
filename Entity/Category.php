<?php

namespace MQM\CategoryBundle\Entity;

use MQM\CategoryBundle\Model\CategoryInterface;
use MQM\ImageBundle\Model\ImageInterface;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="shop_category")
 * @ORM\Entity(repositoryClass="MQM\CategoryBundle\Entity\CategoryRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Category implements CategoryInterface
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @var text $description
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var datetime $createdAt
     *
     * @ORM\Column(name="createdAt", type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @var datetime $modifiedAt
     *
     * @ORM\Column(name="modifiedAt", type="datetime", nullable=true)
     */
    private $modifiedAt;
    
    /**
     * @Assert\Type(type="MQM\ImageBundle\Entity\Image")
     *
     *
     * @ORM\ManyToOne(targetEntity="MQM\ImageBundle\Entity\Image", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="imageId", referencedColumnName="id", nullable=true)
     *
     * @var ImageInterface $image
     */
    private $image;
    
    /**
     * @ORM\ManyToOne(targetEntity="MQM\CategoryBundle\Entity\Category", inversedBy="categories", cascade={"persist"})
     * @ORM\JoinColumn(name="parentCategoryId", referencedColumnName="id")
     * 
     * @var Category $parentCategory
     */
    private $parentCategory;
    
    /**
     * //added cascade persist on 02/12/2011 as another way to save the parentCategory when only changing the array of categories directly but it's not tested that this way works (without setting the parentCategory manually)
     * @ORM\OneToMany(targetEntity="MQM\CategoryBundle\Entity\Category", mappedBy="parentCategory", cascade={"persist"}) 
     * @var ArrayCollection $categories
     */
    private $categories;
    
    /**
     * 
     * @ORM\OneToMany(targetEntity="MQM\ProductBundle\Entity\Product", mappedBy="category")
     * @var ArrayCollection $products
     */
    private $products;
    
    public function __construct(){
        $this->createdAt = new \DateTime();
    }
    
    /**
     *
     * {@inheritDoc}
     */
    public function getOffer() {
        return $this->offer;
    }

    /**
     *
     * {@inheritDoc}
     */
    public function setOffer($offer) {
        $this->offer = $offer;
    }
    
    /**
     *
     * {@inheritDoc}
     */
    public function getProducts() {
            return $this->products;
    }

    /**
     *
     * {@inheritDoc}
     */
    public function setProducts($products) {
            $this->products = $products;
    }

    /**
     *
     * {@inheritDoc}
     */
    public function getParentCategory() {
            return $this->parentCategory;
    }

    /**
     *
     * {@inheritDoc}
     */
    public function addCategory(CategoryInterface $category){
        if($this->categories == null){
            $this->categories = new ArrayCollection();
        }
        $this->categories [] = $category;
        
        $category->setParentCategory($this); //IMPORTANT FOR THE SQL MAPPING AS THE PARENT CATEGORY IS WHAT KEEP THE HIERARCHY/DEPENDENCY INFO IN THE DATABASE BETWEEN CATEGORIES
    }

    /**
     *
     * {@inheritDoc}
     */
    public function getCategories() {
            return $this->categories;
    }

    /**
     *
     * {@inheritDoc}
     */
    public function setCategories($categories) {
            $this->categories = $categories;
    }

    /**
     *
     * {@inheritDoc}
     */
    public function setParentCategory($parentCategory) {
            $this->parentCategory = $parentCategory;
    }
    
    /**
     *
     * {@inheritDoc}
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     *
     * {@inheritDoc}
     */
    public function setId($id) {
        $this->id = $id;
    }

    /**
     *
     * {@inheritDoc}
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     *
     * {@inheritDoc}
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     *
     * {@inheritDoc}
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     *
     * {@inheritDoc}
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     *
     * {@inheritDoc}
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     *
     * {@inheritDoc}
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     *
     * {@inheritDoc}
     */
    public function setModifiedAt($modifiedAt)
    {
        $this->modifiedAt = $modifiedAt;
    }

    /**
     *
     * {@inheritDoc}
     */
    public function getModifiedAt()
    {
        return $this->modifiedAt;
    }
    
    /**
     *
     * {@inheritDoc}
     */
    public function getImage(){
    	return $this->image;
    }
    
    /**
     *
     * {@inheritDoc}
     */
    public function setImage($image){
        $this->image = $image;
    }

    /**
     *
     * {@inheritDoc}
     */
    public function getRootCategory(){
        $parentCategory = $this->getParentCategory();
        if($parentCategory== null){
            return $this;
        }
        else{
            return $parentCategory->getRootCategory();
        }
    }

    /**
     *
     * {@inheritDoc}
     */
    public function getHierarchyDepth(){
        $parentCategory = $this->getParentCategory();
        if($parentCategory== null){
            return 1;
        }
        
        else{
            return 1 + $parentCategory->getHierarchyDepth();
        }
    }
    
    /**
     *
     * {@inheritDoc}
     */
    public function getAncestors(){
        if($this->getParentCategory() == null){
            return array();
        }
        else{
            $ancestors = $this->getParentCategory()->getAncestors();
            $ancestor = $this->getParentCategory();     
            $ancestors[] = $ancestor;
            
            return $ancestors;
        }
        
        //return array($this, $this, $this);
    }    
    
    public function __toString() {
       $depth = $this->getHierarchyDepth();
       
       $contentStart = "";
       $contentEnd = "";
       $name = $this->getName();
       
       if($depth == 1){
           $contentStart = "";
           $contentEnd = "";
           $name = strtoupper($name);
       }
       else{
           
           //capitalize first character
           $name = strtolower($name);
           $name = ucfirst($name);
           //end capitalizing first character

           $depth = 2 * ($depth -1);
           for ($index = 0; $index < $depth; $index++) {
               $contentStart .='-';
           }
       }
       return $contentStart . "  " . $name . "  " . $contentEnd;
    }    
    
    function __clone(){
        // If the entity has an identity, proceed as normal.
        if ($this->id) {
            
        }
        // otherwise do nothing, do NOT throw an exception!
        
        //reset images
        if($this->image){
            $this->image = null;
        }
        //end reseting the images
    }

    /**
     * Invoked before the entity is updated.
     *
     * @ORM\PreUpdate
     */
    public function preUpdate()
    {
        $this->updatedAt = new \DateTime();
    }

}