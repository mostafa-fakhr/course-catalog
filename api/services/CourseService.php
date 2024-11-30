<?php

namespace services;

use repositories\CourseRepository; 
use Exception;

class CourseService
{
    private $courseRepository;

    public function __construct(CourseRepository $courseRepository)
    {
        $this->courseRepository = $courseRepository;
    }

    public function getAllCourses()
    {
        try {
            return $this->courseRepository->getAllCourses();
        } catch (Exception $e) {
            throw new Exception("Unable to retrieve courses: " . $e->getMessage());
        }
    }

    public function getCourseById($id)
    {
        try {
            return $this->courseRepository->getCourseById($id);
        } catch (Exception $e) {
            throw new Exception("Unable to retrieve course by id: " . $e->getMessage());
        }
    }

    public function getCoursesByCategoryId($categoryId)
    {
        return $this->courseRepository->getCoursesByCategoryId($categoryId);
    }

    
}
