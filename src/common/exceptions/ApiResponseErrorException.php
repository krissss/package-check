<?php

namespace common\exceptions;

use yii\base\Exception;

class ApiResponseErrorException extends Exception
{
    /**
     * @return string the user-friendly name of this exception
     */
    public function getName()
    {
        return 'ApiResponseErrorException';
    }
}
