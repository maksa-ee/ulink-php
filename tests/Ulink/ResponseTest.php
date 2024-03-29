<?php

/**
 * @group response
 * @author Alex Rudakov <alexandr.rudakov@modera.net>
 * @author Cravler <http://github.com/cravler>
 */
class Ulink_ResponseTest extends PHPUnit_Framework_TestCase
{
    public function testSuccessAuthResponse()
    {
        $response = new Ulink_AuthResponse();
        $response->setSuccess(true);
        $response->setTimestamp(123);
        $response->setClientTransactionId(456);
        $this->assertEquals("{\"type\":\"auth-response\",\"timestamp\":123,\"response-url\":null,\"back-url\":null,\"id\":456,\"data\":{},\"success\":true,\"errors\":[],\"errorCodes\":[]}", $response->toJson());
    }

    public function testClientTransactionIdPay()
    {
        $response = Ulink_RequestFactory::createFromJson("{\"type\":\"pay-response\",\"timestamp\":123,\"id\":456,\"data\":{\"amount\":\"23.50\",\"currency\":\"EUR\"},\"success\":true,\"errors\":[],\"errorCodes\":[]}");
        $this->assertEquals(456, $response->getClientTransactionId());
    }

    public function testFailedAuthResponse()
    {
        $response = new Ulink_AuthResponse();
        $response->setSuccess(false);
        $response->setTimestamp(123);
        $response->setClientTransactionId(456);
        $response->addError("Wrong signature");
        $response->addErrorCode(17987);
        $this->assertEquals("{\"type\":\"auth-response\",\"timestamp\":123,\"response-url\":null,\"back-url\":null,\"id\":456,\"data\":{},\"success\":false,\"errors\":[\"Wrong signature\"],\"errorCodes\":[17987]}", $response->toJson());
    }

    public function testSuccessPayRequest()
    {
        $response = new Ulink_PaymentResponse();
        $response->setAmount(new Ulink_Money("23.50"));
        $response->setCurrency("EUR");
        $response->setTimestamp(123);
        $response->setClientTransactionId(456);
        $response->setSuccess(true);
        $response->setTest(true);

        $this->assertEquals("{\"type\":\"pay-response\",\"timestamp\":123,\"response-url\":null,\"back-url\":null,\"id\":456,\"data\":{\"amount\":\"23.50\",\"currency\":\"EUR\"},\"success\":true,\"test\":true,\"errors\":[],\"errorCodes\":[]}", $response->toJson());
    }

    public function testFailedPayRequest()
    {
        $response = new Ulink_PaymentResponse();
        $response->setAmount(new Ulink_Money("23.50"));
        $response->setCurrency("EUR");
        $response->setTimestamp(123);
        $response->setClientTransactionId(456);
        $response->setSuccess(false);
        $response->setTest(false);
        $response->addError("Wrong signature");
        $response->addErrorCode(17987);

        $this->assertEquals("{\"type\":\"pay-response\",\"timestamp\":123,\"response-url\":null,\"back-url\":null,\"id\":456,\"data\":{\"amount\":\"23.50\",\"currency\":\"EUR\"},\"success\":false,\"test\":false,\"errors\":[\"Wrong signature\"],\"errorCodes\":[17987]}", $response->toJson());
    }

    public function testCreateRequestWithOrderFromJson()
    {
        $json = "{\"type\":\"pay-response\",\"timestamp\":123,\"id\":456,\"data\":{\"amount\":\"23.50\",\"currency\":\"EUR\"},\"success\":true,\"test\":true,\"errors\":[\"Wrong signature\"],\"errorCodes\":[17987]}";

        $response = Ulink_RequestFactory::createFromJson($json);
        $this->assertEquals(Ulink_PaymentResponse::clazz(), get_class($response));
        $this->assertEquals(123, $response->getTimestamp());

        $paymentResponse = $response;
        $this->assertEquals(new Ulink_Money("23.50"), $paymentResponse->getAmount());
        $this->assertEquals("EUR", $paymentResponse->getCurrency());
        $this->assertEquals(123, $paymentResponse->getTimestamp());
        $this->assertTrue($paymentResponse->isSuccess());
        $this->assertTrue($paymentResponse->isTest());
        $this->assertEquals(1, count($paymentResponse->getErrors()));
        $errors = $paymentResponse->getErrors();
        $this->assertEquals("Wrong signature", $errors[0]);
        $this->assertEquals(1, count($paymentResponse->getErrorCodes()));
        $codes = $paymentResponse->getErrorCodes();
        $this->assertEquals(17987, $codes[0]);
    }
}
