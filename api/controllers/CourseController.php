<?php

namespace controllers;
require_once __DIR__ . '/../constants/constants.php';

use services\CourseService;
use Api\Constants\HttpStatusCodes;
use Api\Constants\ErrorMessages;
use Api\Constants\CoursesErrorMessage;
use Api\Constants\SuccessMessages;

class CourseController
{
    private $courseService;

    public function __construct(CourseService $courseService)
    {
        $this->courseService = $courseService;
        header('Content-Type: application/json');
    }

    public function getAllCourses()
    {
        try {
            $courses = $this->courseService->getAllCourses();
            echo json_encode(['data' => $courses]);
        } catch (\Exception $e) {
           http_response_code(HttpStatusCodes::INTERNAL_SERVER_ERROR);
           echo json_encode(['error' => ErrorMessages::SERVER_ERROR]);
        }
    }


     public function getCourseById($id)
    {
        try {
            $course = $this->courseService->getCourseById($id);

            if (!$course) {
                http_response_code(HttpStatusCodes::NOT_FOUND);
                echo json_encode(['error' => CoursesErrorMessage::COURSE_NOT_FOUND]);
                return;
            }

            http_response_code(HttpStatusCodes::OK);
            echo json_encode(['data' => $course, 'message' => SuccessMessages::COURSE_RETRIEVED]);
        } catch (\Exception $e) {
            http_response_code(HttpStatusCodes::INTERNAL_SERVER_ERROR);
            echo json_encode(['error' => ErrorMessages::SERVER_ERROR]);
        }
    }
    
    public function getCoursesByCategoryId($categoryId)
    {
        
        try {
            // Retrieve the courses by category ID
            $courses = $this->courseService->getCoursesByCategoryId($categoryId);
    
            if (empty($courses)) {
                http_response_code(HttpStatusCodes::NOT_FOUND);
                echo json_encode(['error' => ErrorMessages::CATEGORY_NOT_FOUND]);
                return;
            }

            // Return the courses data
            echo json_encode(['data' => $courses]);
        } catch (\Exception $e) {
            http_response_code(HttpStatusCodes::INTERNAL_SERVER_ERROR);
            echo json_encode(['error' => ErrorMessages::SERVER_ERROR]);
        }
    }
    
}
