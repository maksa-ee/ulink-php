<?php


/**
 * @author Alex Rudakov <alexandr.rudakov@modera.net>
 */
class Ulink_KeyPair
{
    private $privateKey;
    private $publicKey;

    public function __construct($privkey, $pubkey)
    {
        $this->privateKey = $privkey;
        $this->publicKey  = $pubkey;
    }

    public function setPrivateKey($privateKey)
    {
        $this->privateKey = $privateKey;
    }

    public function getPrivateKey()
    {
        return $this->privateKey;
    }

    public function setPublicKey($publicKey)
    {
        $this->publicKey = $publicKey;
    }

    public function getPublicKey()
    {
        return $this->publicKey;
    }
}
