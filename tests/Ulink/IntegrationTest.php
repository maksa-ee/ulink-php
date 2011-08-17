<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Alex
 * Date: 6/25/11
 * Time: 2:49 PM
 * To change this template use File | Settings | File Templates.
 */

namespace Ulink;
 
class IntegrationTest extends \PHPUnit_Framework_TestCase {

    private function getPublicKeyPem() {
        return  <<<EOD
-----BEGIN PUBLIC KEY-----
MFwwDQYJKoZIhvcNAQEBBQADSwAwSAJBANDiE2+Xi/WnO+s120NiiJhNyIButVu6
zxqlVzz0wy2j4kQVUC4ZRZD80IY+4wIiX2YxKBZKGnd2TtPkcJ/ljkUCAwEAAQ==
-----END PUBLIC KEY-----
EOD;
    }
    private function getPrivateKeyPem() {
        return <<<EOD
-----BEGIN RSA PRIVATE KEY-----
MIIBOgIBAAJBANDiE2+Xi/WnO+s120NiiJhNyIButVu6zxqlVzz0wy2j4kQVUC4Z
RZD80IY+4wIiX2YxKBZKGnd2TtPkcJ/ljkUCAwEAAQJAL151ZeMKHEU2c1qdRKS9
sTxCcc2pVwoAGVzRccNX16tfmCf8FjxuM3WmLdsPxYoHrwb1LFNxiNk1MXrxjH3R
6QIhAPB7edmcjH4bhMaJBztcbNE1VRCEi/bisAwiPPMq9/2nAiEA3lyc5+f6DEIJ
h1y6BWkdVULDSM+jpi1XiV/DevxuijMCIQCAEPGqHsF+4v7Jj+3HAgh9PU6otj2n
Y79nJtCYmvhoHwIgNDePaS4inApN7omp7WdXyhPZhBmulnGDYvEoGJN66d0CIHra
I2SvDkQ5CmrzkW5qPaE2oO7BSqAhRZxiYpZFb5CI
-----END RSA PRIVATE KEY-----
EOD;
    }

    /**
     * @test
     * @return void
     */
    public function testPaymentOut() {

        $privKey = $this->getPrivateKeyPem();
        $pubKey = $this->getPublicKeyPem();


        $order = new Order();
        $order->addItem(new OrderItem("Milk","Puhlqj ez", new Money("25.90")));
        $order->addItem(new OrderItem("Mja4ik","Puhlqj mja4", new Money("9.00")));

        $request = new PaymentRequest();
        $request->setAmount(new Money("34.90"));
        $request->setCurrency(Request::CURRENCY_EURO);
        $request->setOrder($order);

        $requestJson = $request->toJson();
        $requestJson = CryptoUtils::seal($requestJson, $pubKey);
        $packet = new TransportPacket();
        $packet->setRequest($requestJson);
        $signature = CryptoUtils::sign($requestJson, $privKey);

        $packet->setSignature($signature);
        $packet->setClientId(15);

        $rawData = $packet->toJson();

        $packet = TransportPacket::createFromJson($rawData);
        $this->assertNotNull($packet);

        $this->assertEquals(15, $packet->getClientId());

        $this->assertEquals($requestJson, $packet->getRequest());
        $this->assertEquals($signature, $packet->getSignature());
        $this->assertNotNull($packet->getSignature());

        $this->assertTrue($packet->validateAgainstKey($pubKey));

        $request = RequestFactory::createFromJson(
                    CryptoUtils::unseal($packet->getRequest(), $privKey)
                );
        $this->assertType('Ulink\PaymentRequest', $request);

        $paymentRequest = $request;
        $this->assertEquals("34.90", (string)$paymentRequest->getAmount());
        $this->assertEquals("EUR", $paymentRequest->getCurrency());

        $order = $paymentRequest->getOrder();
        $this->assertNotNull($order);
        $this->assertEquals(2, count($order->getItems()));

        $items = $order->getItems();
        $orderItem1 = $items[0];
        $orderItem2 = $items[1];

        $this->assertEquals("Milk", $orderItem1->getName());
        $this->assertEquals("Puhlqj ez", $orderItem1->getDescription());
        $this->assertEquals("25.90", (string)$orderItem1->getOneItemPrice());

        $this->assertEquals("Mja4ik", $orderItem2->getName());
        $this->assertEquals("Puhlqj mja4", $orderItem2->getDescription());
        $this->assertEquals("9.00", (string)$orderItem2->getOneItemPrice());
    }

    public function testPaymentIn() {

        $privKey = $this->getPrivateKeyPem();
        $pubKey = $this->getPublicKeyPem();

        $rawData = 'ulink:0.9:15:XKXvKJpR1iZZiTyYfctuDbnnIAj8WDaCtS9EbYlZxTKdUM9fbfdWWrcg7Lt7k5EuWxP8ai3q1lLe8tNeXKNaTURmFHjWs0WFObssqjKPW0LOxtqEfFPmZ88M1IkjrlYGV1UDKq/vbbdN2d2VVjv1poQr3aW9sXq4UKgUcVsM1irA0bswreyo32UMat62UVQa/jO1ktpc0cxv5CEny75zY0s1RS+9s8orFX6uQPRJOpFRQ2vRlUWjrnwdhdQrBtqzInml09Cs9MiZEaLcHTCrLUBIVJ4h@SgiRRv+oOinM3vA9aDOsfTGjzLePXWRD/ahmryLYEMpK84F4lV2uZAJflxjFDI6+sjX1DGq0vNDE0RUOLw5aSw==:onccukVgVf1T+cyA2CfExPdRVYefv9PnDjdcYC6ak7/f/xt2NC7VoZ6Odg3SxLQe1LA0sR+GkyqwRFXc1BaZqg==';

        $packet = TransportPacket::createFromJson($rawData);
        $this->assertNotNull($packet);

        $this->assertEquals(15, $packet->getClientId());

        $this->assertNotNull($packet->getSignature());

        $this->assertTrue($packet->validateAgainstKey($pubKey));

        $request = RequestFactory::createFromJson(
                    CryptoUtils::unseal($packet->getRequest(), $privKey)
                );
        $this->assertType('Ulink\PaymentRequest', $request);

        $paymentRequest = $request;
        $this->assertEquals("34.90", (string)$paymentRequest->getAmount());
        $this->assertEquals("EUR", $paymentRequest->getCurrency());

        $order = $paymentRequest->getOrder();
        $this->assertNotNull($order);
        $this->assertEquals(2, count($order->getItems()));

        $items = $order->getItems();
        $orderItem1 = $items[0];
        $orderItem2 = $items[1];

        $this->assertEquals("Milk", $orderItem1->getName());
        $this->assertEquals("Puhlqj ez", $orderItem1->getDescription());
        $this->assertEquals("25.90", (string)$orderItem1->getOneItemPrice());

        $this->assertEquals("Mja4ik", $orderItem2->getName());
        $this->assertEquals("Puhlqj mja4", $orderItem2->getDescription());
        $this->assertEquals("9.00", (string)$orderItem2->getOneItemPrice());
    }
}
