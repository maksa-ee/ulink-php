<?php
/**
 * Date: 8/17/11
 * Time: 11:19 AM
 * @author Alex Rudakov <alexandr.rudakov@modera.net>
 */

namespace Ulink;
 
class PaymentResponse extends PaymentRequest implements Response {

    
    private $isSuccess;

    private $errors = array();
    private $errorCodes = array();

    public function getType()
    {
        return 'pay-response';
    }

    public function getJsonData()
    {
        $data = parent::getJsonData();
        $data["success"] = $this->isSuccess();
        $data["errors"] = $this->getErrors();
        $data["errorCodes"] = $this->getErrorCodes();
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

    public function setErrors($errors)
    {
        $this->errors = $errors;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function addError($error)
    {
        $this->errors[] = $error;
    }

    public function addErrorCode($errorCode)
    {
        $this->errorCodes[] = $errorCode;
    }

    public function setSuccess($isSuccess)
    {
        $this->isSuccess = $isSuccess;
    }

    public function isSuccess()
    {
        return $this->isSuccess;
    }

    public static function createFromJson($json) {

        $data = $json->data;

        $response = new PaymentResponse();
        $response->setAmount(new Money($data->amount));
        $response->setCurrency($data->currency);
        if (isset($json->id) && $json->id) {
            $response->setClientTransactionId($json->id);
        }
        if (isset($data->order)) {
            $response->setOrder(Order::createFromJson($data->order));
        }
        $response->setSuccess($json->success);
        $response->setErrors($json->errors);
        $response->setErrorCodes($json->errorCodes);

        return $response;
    }
}
