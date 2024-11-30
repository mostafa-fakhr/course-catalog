<?php

namespace services;

use repositories\CategoryRepository; 
use Exception;

class CategoryService
{
    private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function getAllCategories()
    {
        try {
            return $this->categoryRepository->getAllCategories();
        } catch (Exception $e) {
            throw new Exception("Unable to retrieve categories: " . $e->getMessage());
        }
    }

    public function getCategoryById($id)
    {
        try {
            return $this->categoryRepository->getCategoryById($id);
        } catch (Exception $e) {
            throw new Exception("Unable to retrieve category by id: " . $e->getMessage());
        }
    }

    public function getSubcategoriesByParentId($parentId)
    {
        return $this->categoryRepository->findSubcategoriesByParentId($parentId);
    }

    public function getCourseCountByCategoryId($categoryId)
    {
        return $this->categoryRepository->getCourseCountByCategoryId($categoryId);
    }

    public function getCategoriesWithTheirCourseCount()
    {
        return $this->categoryRepository->getCategoriesWithTheirCourseCount();
    }

    public function getCategoryTreeWithCourseCount()
    {
        return $this->categoryRepository->getCategoryTreeWithCourseCount();
    }


}
