<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Alex
 * Date: 6/24/11
 * Time: 6:26 PM
 * To change this template use File | Settings | File Templates.
 */

namespace Ulink;

class KeyPair {

    private $privateKey;
    private $publicKey;

    public function __construct($privkey, $pubkey) {
        $this->privateKey = $privkey;
        $this->publicKey = $pubkey;
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
