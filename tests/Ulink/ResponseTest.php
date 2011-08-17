<?php
/**
 * Date: 8/17/11
 * Time: 10:57 AM
 * @author Alex Rudakov <alexandr.rudakov@modera.net>
 */
namespace Ulink;


/**
 * @group response
 */
class ResponseTest extends \PHPUnit_Framework_TestCase {


    
    public function testSuccessAuthResponse() {

        $response = new AuthResponse();
        $response->setSuccess(true);
        $response->setTimestamp(123);
        $response->setClientTransactionId(456);
        $this->assertEquals("{\"type\":\"auth-response\",\"timestamp\":123,\"id\":456,\"data\":{},\"success\":true,\"errors\":[],\"errorCodes\":[]}", $response->toJson());
    }

    
    public function testFailedAuthResponse() {

        $response = new AuthResponse();
        $response->setSuccess(false);
        $response->setTimestamp(123);
        $response->setClientTransactionId(456);
        $response->addError("Wrong signature");
        $response->addErrorCode(17987);
        $this->assertEquals("{\"type\":\"auth-response\",\"timestamp\":123,\"id\":456,\"data\":{},\"success\":false,\"errors\":[\"Wrong signature\"],\"errorCodes\":[17987]}", $response->toJson());
    }

    
    public function testSuccessPayRequest() {
        $request = new PaymentResponse();
        $request->setAmount(new Money("23.50"));
        $request->setCurrency("EUR");
        $request->setTimestamp(123);
        $request->setClientTransactionId(456);
        $request->setSuccess(true);

        $this->assertEquals("{\"type\":\"pay-response\",\"timestamp\":123,\"id\":456,\"data\":{\"amount\":\"23.50\",\"currency\":\"EUR\"},\"success\":true,\"errors\":[],\"errorCodes\":[]}", $request->toJson());
    }

    
    public function testFailedPayRequest() {
        $response = new PaymentResponse();
        $response->setAmount(new Money("23.50"));
        $response->setCurrency("EUR");
        $response->setTimestamp(123);
        $response->setClientTransactionId(456);
        $response->setSuccess(false);
        $response->addError("Wrong signature");
        $response->addErrorCode(17987);

        $this->assertEquals("{\"type\":\"pay-response\",\"timestamp\":123,\"id\":456,\"data\":{\"amount\":\"23.50\",\"currency\":\"EUR\"},\"success\":false,\"errors\":[\"Wrong signature\"],\"errorCodes\":[17987]}", $response->toJson());
    }

    
    public function testCreateRequestWithOrderFromJson() {
        $json = "{\"type\":\"pay-response\",\"timestamp\":123,\"id\":456,\"data\":{\"amount\":\"23.50\",\"currency\":\"EUR\"},\"success\":true,\"errors\":[\"Wrong signature\"],\"errorCodes\":[17987]}";

        $response = RequestFactory::createFromJson($json);
        $this->assertEquals(PaymentResponse::clazz(), get_class($response));
        $this->assertEquals(123, $response->getTimestamp());

        $paymentResponse = $response;
        $this->assertEquals(new Money("23.50"), $paymentResponse->getAmount());
        $this->assertEquals("EUR", $paymentResponse->getCurrency());
        $this->assertEquals(123, $paymentResponse->getTimestamp());
        $this->assertTrue($paymentResponse->isSuccess());
        $this->assertEquals(1, count($paymentResponse->getErrors()));
        $errors = $paymentResponse->getErrors();
        $this->assertEquals("Wrong signature", $errors[0]);
        $this->assertEquals(1, count($paymentResponse->getErrorCodes()));
        $codes = $paymentResponse->getErrorCodes();
        $this->assertEquals(17987, $codes[0]);
    }

}
