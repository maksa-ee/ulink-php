<?php

/**
 * @author Alex Rudakov <alexandr.rudakov@modera.net>
 * @author Cravler <http://github.com/cravler>
 */
class Ulink_PaymentResponse extends Ulink_PaymentRequest implements Ulink_Response
{
    private $isSuccess;
    private $isTest = true;

    private $errors     = array();
    private $errorCodes = array();

    public function getType()
    {
        return 'pay-response';
    }

    public function getJsonData()
    {
        $data = parent::getJsonData();

        $data["success"]    = $this->isSuccess();
        $data["test"]       = $this->isTest();
        $data["errors"]     = $this->getErrors();
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

    public function setTest($isTest)
    {
        $this->isTest = $isTest;
    }

    public function isTest()
    {
        return $this->isTest;
    }

    public static function createFromJson($json)
    {
        $data = $json->data;

        $response = new Ulink_PaymentResponse();
        $response->setAmount(new Ulink_Money($data->amount));
        $response->setCurrency($data->currency);
        if (isset($json->id) && $json->id) {
            $response->setClientTransactionId($json->id);
        }
        if (isset($json->{'response-url'}) && $json->{'response-url'}) {
            $request->setResponseUrl($json->{'response-url'});
        }
        if (isset($json->{'back-url'}) && $json->{'back-url'}) {
            $request->setGoBackUrl($json->{'back-url'});
        }
        if (isset($data->order)) {
            $response->setOrder(Ulink_Order::createFromJson($data->order));
        }
        $response->setSuccess($json->success);
        if (isset($data->test)) {
            $response->setTest($json->test);
        }
        $response->setErrors($json->errors);
        $response->setErrorCodes($json->errorCodes);

        return $response;
    }

    public static function clazz()
    {
        return __CLASS__;
    }
}
