<?php

namespace Ulink;

/**
 * @author Alex Rudakov <alexandr.rudakov@modera.net>
 */
class AuthResponse extends AuthRequest
{
    private $isSuccess;

    private $errors     = array();
    private $errorCodes = array();

    public function getType()
    {
        return 'auth-response';
    }

    public function getJsonData()
    {
        $data = parent::getJsonData();
        $data['success']    = $this->isSuccess();
        $data['errors']     = $this->getErrors();
        $data['errorCodes'] = $this->getErrorCodes();
        return $data;
    }

    public function setErrorCodes($errorCodes)
    {
        $this->errorCodes = $errorCodes;
    }

    public function getErrorCodes()
    {
        return $this->errorCodes;
    }

    public function addError($error)
    {
        $this->errors[] = $error;
    }

    public function addErrorCode($errorCode)
    {
        $this->errorCodes[] = $errorCode;
    }

    public function setErrors($errors)
    {
        $this->errors = $errors;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function setSuccess($isSuccess)
    {
        $this->isSuccess = $isSuccess;
    }

    public function isSuccess()
    {
        return $this->isSuccess;
    }
}
