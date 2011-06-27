<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Alex
 * Date: 6/24/11
 * Time: 12:28 PM
 * To change this template use File | Settings | File Templates.
 */

namespace Ulink;

class TransportPacketTest extends \PHPUnit_Framework_TestCase {

    public function testToJsonFunction() {
        $signature = "=signature=";
        $encodedSignature = base64_encode($signature);

        $packet = new TransportPacket();
        $packet->setRequest("{bar:\"foo\"}");
        $packet->setSignature($signature);
        $packet->setClientId(15);

        $this->assertEquals(
                "ulink:" . Protocol::VERSION . ":15:{bar:\"foo\"}:" . $encodedSignature,
                $packet->toJson()
        );
    }

    public function testCreateFromJson() {

        $signature = "=signature=";
        $encodedSignature = base64_encode($signature);

        $packet = TransportPacket::createFromJson('ulink:0.9:15:foobar:'.$encodedSignature);
        $this->assertEquals('foobar', $packet->getRequest());
        $this->assertEquals('=signature=', $packet->getSignature());
        $this->assertEquals(15, $packet->getClientId());
    }
}
