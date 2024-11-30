<?php

namespace repositories;

use PDO;
use Exception;

class CategoryRepository
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAllCategories()
    {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM categories");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            throw new Exception("Unable to retrieve categories: " . $e->getMessage());
        }
    }

    public function getCategoryById($id)
    {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM categories WHERE id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            throw new Exception("Unable to retrieve category by ID: " . $e->getMessage());
        }
    }


    public function findSubcategoriesByParentId($parentId)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM categories WHERE parent_id = :parentId');
        $stmt->execute(['parentId' => $parentId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCourseCountByCategoryId($categoryId)
    {
        $stmt = $this->pdo->prepare('SELECT COUNT(*) AS course_count FROM courses WHERE category_id = :categoryId');
        $stmt->execute(['categoryId' => $categoryId]);
        return $stmt->fetch(PDO::FETCH_ASSOC)['course_count'];
    }

    public function getCategoriesWithTheirCourseCount()
    {
        $stmt = $this->pdo->query('
            SELECT c.*, COUNT(co.id) AS course_count 
            FROM categories c
            LEFT JOIN courses co ON c.id = co.category_id
            GROUP BY c.id
        ');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCategoryTreeWithCourseCount()
{
    $stmt = $this->pdo->query('
        SELECT id, name, description, parent_id 
        FROM categories
    ');
    
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt = $this->pdo->query('
        SELECT category_id 
        FROM courses
    ');

    $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $courseCount = [];

    // Calculate course count for each category
    foreach ($courses as $course) {
        $categoryId = $course['category_id'];
        if (!isset($courseCount[$categoryId])) {
            $courseCount[$categoryId] = 0;
        }
        $courseCount[$categoryId]++;
    }

    $categoryTree = $this->buildCategoryTree($categories, $courseCount);

    return $categoryTree;
}

private function buildCategoryTree(array $categories, array $courseCount, $parentId = null)
{
    $tree = [];

    foreach ($categories as $category) {
        if ($category['parent_id'] === $parentId) {
            // Get the course count for this category
            $category['course_count'] = isset($courseCount[$category['id']]) ? $courseCount[$category['id']] : 0;
            // Build the tree for child categories
            $category['children'] = $this->buildCategoryTree($categories, $courseCount, $category['id']);
            $tree[] = $category;
        }
    }

    return $tree;
}




}
