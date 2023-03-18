<?php

namespace App\Exceptions;

/**
 * Class BaseException
 * @package App\Exceptions
 */
class BaseException extends \Exception
{
    /**
     * @var int $responseCode
     */
    protected $code = 400;

    /**
     * @var string $responseMessage
     */
    protected $errorMessage = 'Uh-oh Something went wrong.';

    /**
     * @var array $data
     */
    protected $data = [];

    /**
     * @var array $logData
     */
    protected $logData = [];

    /**
     * @param int $code
     * @return BaseException
     */
    public function code(int $code)
    {
        $this->code = $code;
        return $this;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @param array $data
     * @return BaseException
     */
    public function data(array $data)
    {
        $this->data = $data;
        return $this;
    }

    /**
     * @return array
     */
    public function getLogData(): array
    {
        return $this->logData;
    }

    /**
     * @param array $logData
     * @return BaseException
     */
    public function setLogData(array $logData)
    {
        $this->logData = $logData;
        return $this;
    }

    /**
     * @return string
     */
    public function getErrorMessage(): string
    {
        return $this->errorMessage;
    }

    /**
     * @param string $message
     * @return BaseException
     */
    public function setErrorMessage(string $message): BaseException
    {
        $this->errorMessage = $message;
        return $this;
    }
}
