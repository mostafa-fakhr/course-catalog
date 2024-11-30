<?php

namespace repositories;

use PDO;
use Exception;

class CourseRepository
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAllCourses()
    {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM courses");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            throw new Exception("Unable to retrieve courses: " . $e->getMessage());
        }
    }

    public function getCourseById($id)
    {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM courses WHERE id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            throw new Exception("Unable to retrieve course by ID: " . $e->getMessage());
        }
    }

    public function getCoursesByCategoryId($categoryId)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM courses WHERE category_id = ?");
        $stmt->execute([$categoryId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
}
