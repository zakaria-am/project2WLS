<?php

namespace App\Exception;

/**
 * Class FormException
 */
class FormException extends \Exception
{
    const DATA_INVALID = "invalid data";

    /**
     * @var array|null
     */
    private $data;

    /**
     * CollaboratorException constructor.
     *
     * @param string $message
     * @param int $code
     * @param array $data
     */
    public function __construct($message = "", $code = 0, $data = null)
    {
        $this->data = $data;
        parent::__construct($message, $code);
    }

    /**
     * @return array|null
     */
    public function getData(): ?array
    {
        return $this->data;
    }
}
