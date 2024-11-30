<?php

return [
    'GET' => [
        '/categories' => [\controllers\CategoryController::class, 'getAllCategories', \services\CategoryService::class],
        '/categories/{id}' => [\controllers\CategoryController::class, 'getCategoryById', \services\CategoryService::class],
        '/categories/{id}/subcategories' => [\controllers\CategoryController::class, 'getSubcategoriesByParentId', \services\CategoryService::class], // Route for getting subcategories by parent ID
        '/categories/{id}/course_count' => [\controllers\CategoryController::class, 'getCourseCountByCategoryId', \services\CategoryService::class], // Route for getting course count by category ID
        '/categories-with-course_count' => [\controllers\CategoryController::class, 'getCategoriesWithTheirCourseCount', \services\CategoryService::class], // Route for categories with course count
        '/category_tree_with_counts' => [\controllers\CategoryController::class, 'getCategoryTreeWithCourseCount', \services\CategoryService::class], // Route for category tree with course counts
        '/courses' => [\controllers\CourseController::class, 'getAllCourses', \services\CourseService::class],
        '/courses/{id}' => [\controllers\CourseController::class, 'getCourseById', \services\CourseService::class],
        '/courses/category/{categoryId}' => [\controllers\CourseController::class, 'getCoursesByCategoryId', \services\CourseService::class], // New route for getting courses by category ID
    ],
];
