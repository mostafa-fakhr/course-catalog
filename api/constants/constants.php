<?php
namespace Api\Constants;

class HttpStatusCodes
{
    public const OK = 200;
    public const CREATED = 201;
    public const BAD_REQUEST = 400;
    public const NOT_FOUND = 404;
    public const INTERNAL_SERVER_ERROR = 500;
}

class ErrorMessages
{
    public const CATEGORY_NOT_FOUND = 'Category not found';
    public const SERVER_ERROR = 'Something went wrong';
}

class CoursesErrorMessage
{
    public const COURSE_NOT_FOUND = 'Course not found';
}

class SuccessMessages
{
    public const CATEGORY_RETRIEVED = 'Category retrieved successfully';
    public const COURSE_RETRIEVED = 'Course retrieved successfully';
}
