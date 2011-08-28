<?php

namespace Ulink;

/**
 * @author Alex Rudakov <alexandr.rudakov@modera.net>
 */
class TransportPacket
{
    private $request;
    private $signature;
    private $clientId;

    public function setClientId($clientId)
    {
        $this->clientId = $clientId;
    }

    public function getClientId()
    {
        return $this->clientId;
    }

    public function setRequest($request)
    {
        $this->request = $request;
    }

    public function getRequest()
    {
        return $this->request;
    }

    public function setSignature($signature)
    {
        $this->signature = $signature;
    }

    public function getSignature()
    {
        return $this->signature;
    }

    public function toJson()
    {
        return "ulink:" . Protocol::VERSION . ":" . $this->getClientId() . ":" . $this->getRequest() . ":" . base64_encode($this->getSignature());
    }

    public static function createFromJson($json)
    {
        $parts = explode(':', $json);
        $packet = new TransportPacket();
        $packet->setClientId($parts[2]);
        $packet->setRequest($parts[3]);
        $packet->setSignature(base64_decode($parts[4]));
        return $packet;
    }

    public function validateAgainstKey($publicKey)
    {
        return CryptoUtils::isValidRSASignature(
            $this->getRequest(),
            $this->getSignature(),
            $publicKey
        );
    }

}
