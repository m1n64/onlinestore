<?php

namespace App\Enums;

enum StatusCodesEnum : int
{
    case SUCCESS = 200;
    case VALIDATION_ERROR = 422;
    case BAD_REQUEST = 400;
    case UNAUTHORIZED = 401;
    case NOT_FOUND = 404;
    case NOT_ALLOWED = 403;
    case SERVER_ERROR = 500;
}
