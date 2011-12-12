<?php

/**
 * @author Alex Rudakov <alexandr.rudakov@modera.net>
 */
class Ulink_TransportPacketTest extends PHPUnit_Framework_TestCase
{
    public function testToJsonFunction()
    {
        $signature = "=signature=";
        $encodedSignature = base64_encode($signature);

        $packet = new Ulink_TransportPacket();
        $packet->setRequest("{bar:\"foo\"}");
        $packet->setSignature($signature);
        $packet->setClientId(15);

        $this->assertEquals(
            "ulink:" . Ulink_Protocol::VERSION . ":15:{bar:\"foo\"}:" . $encodedSignature,
            $packet->toJson()
        );
    }

    public function testCreateFromJson()
    {
        $signature = "=signature=";
        $encodedSignature = base64_encode($signature);

        $packet = Ulink_TransportPacket::createFromJson('ulink:0.9:15:foobar:'.$encodedSignature);
        $this->assertEquals('foobar', $packet->getRequest());
        $this->assertEquals('=signature=', $packet->getSignature());
        $this->assertEquals(15, $packet->getClientId());
    }
}
