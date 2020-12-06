<?php


namespace app\core\exceptions;


class ForbiddenException extends \Exception // Exception is a predefined PHP's class
{
    protected $message = "You don't have permission to access this page";
    protected $code = 403;
}