<?php

namespace controllers;

require_once __DIR__ . '/../constants/constants.php';

use Api\Constants\HttpStatusCodes;
use Api\Constants\ErrorMessages;
use Api\Constants\SuccessMessages;
use services\CategoryService;


class CategoryController
{
    private $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
        header('Content-Type: application/json'); 
    }

public function getAllCategories()
    {
        try {
            $categories = $this->categoryService->getAllCategories();
            http_response_code(response_code: HttpStatusCodes::OK);
            echo json_encode(['data' => $categories]);
        } catch (\Exception $e) {
            http_response_code(HttpStatusCodes::INTERNAL_SERVER_ERROR);
            echo json_encode(['error' => ErrorMessages::SERVER_ERROR]);
        }
    }

 public function getCategoryById($id)
    {
        try {
            $category = $this->categoryService->getCategoryById($id);

            if (!$category) {
                http_response_code(HttpStatusCodes::NOT_FOUND);
                echo json_encode(['error' => ErrorMessages::CATEGORY_NOT_FOUND]);
                return;
            }

            http_response_code(HttpStatusCodes::OK);
            echo json_encode(['data' => $category, 'message' => SuccessMessages::CATEGORY_RETRIEVED]);
        } catch (\Exception $e) {
            http_response_code(HttpStatusCodes::INTERNAL_SERVER_ERROR);
            echo json_encode(['error' => ErrorMessages::SERVER_ERROR]);
        }
    }

    public function getSubcategoriesByParentId($parentId)
    {
        try {
            $subcategories = $this->categoryService->getSubcategoriesByParentId($parentId);

            if (empty($subcategories)) {
                http_response_code(HttpStatusCodes::NOT_FOUND);
                echo json_encode(['error' => ErrorMessages::CATEGORY_NOT_FOUND]);
                return;
            }

            http_response_code(HttpStatusCodes::OK);
            echo json_encode(['data' => $subcategories]);
        } catch (\Exception $e) {
            http_response_code(HttpStatusCodes::INTERNAL_SERVER_ERROR);
            echo json_encode(['error' => ErrorMessages::SERVER_ERROR]);
        }
    }

    public function getCourseCountByCategoryId($id)
    {
        try {
            $count = $this->categoryService->getCourseCountByCategoryId($id);

            http_response_code(HttpStatusCodes::OK);
            echo json_encode(['data' => ['count_of_courses' => $count]]);
        } catch (\Exception $e) {
            http_response_code(HttpStatusCodes::NOT_FOUND);
            echo json_encode(['error' => ErrorMessages::CATEGORY_NOT_FOUND]);
        }
    }

 public function getCategoriesWithTheirCourseCount()
    {
        try {
            $categories = $this->categoryService->getCategoriesWithTheirCourseCount();

            http_response_code(HttpStatusCodes::OK);
            echo json_encode(['data' => $categories]);
        } catch (\Exception $e) {
            http_response_code(HttpStatusCodes::INTERNAL_SERVER_ERROR);
            echo json_encode(['error' => ErrorMessages::SERVER_ERROR]);
        }
    }

 public function getCategoryTreeWithCourseCount()
    {
        try {
            $tree = $this->categoryService->getCategoryTreeWithCourseCount();

            http_response_code(HttpStatusCodes::OK);
            echo json_encode(['data' => $tree]);
        } catch (\Exception $e) {
            http_response_code(HttpStatusCodes::INTERNAL_SERVER_ERROR);
            echo json_encode(['error' => ErrorMessages::SERVER_ERROR]);
        }
    }
}
    