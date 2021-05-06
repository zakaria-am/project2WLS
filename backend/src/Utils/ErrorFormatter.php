<?php

namespace App\Utils;

use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * Class ErrorFormatter
 */
class ErrorFormatter
{
    const EXCEPTION_DEFAULT_MESSAGE = 'Data is invalid';
    /**
     * @param ConstraintViolationListInterface $formErrors
     *
     * @return array
     */
    public static function format(ConstraintViolationListInterface $formErrors): array
    {
        $error = [];
        foreach ($formErrors as $formError) {
            $error[$formError->getPropertyPath()] = $formError->getMessage();
        }

        return $error;
    }
}
