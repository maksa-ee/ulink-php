<?php

/**
 * @author Alex Rudakov <alexandr.rudakov@modera.net>
 */
class Ulink_CryptoUtilsTest extends PHPUnit_Framework_TestCase
{
//
//    /**
//     * @test
//     */
//    public function generateKeyPair() {
//
//        $pair = CryptoUtils::generateRSAKeyPair();
//        assertNotNull($pair->getPrivate());
//        assertNotNull($pair->getPublic());
//
//        assertTrue(substr($pair->getPrivate(),0,31) == "-----BEGIN RSA PRIVATE KEY-----");
//        assertTrue(substr($pair->getPublic(),0,26) == "-----BEGIN PUBLIC KEY-----");
//    }

    /**
     * @test
     */
    public function readAndVerifyWithRealKeysKey()
    {
        // You can get a simple private/public key pair using:
        // openssl genrsa 512 >private_key.txt
        // openssl rsa -pubout <private_key.txt >public_key.txt


        $privKey = <<<EOD
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

        $pubKey = <<<EOD
-----BEGIN PUBLIC KEY-----
MFwwDQYJKoZIhvcNAQEBBQADSwAwSAJBANDiE2+Xi/WnO+s120NiiJhNyIButVu6
zxqlVzz0wy2j4kQVUC4ZRZD80IY+4wIiX2YxKBZKGnd2TtPkcJ/ljkUCAwEAAQ==
-----END PUBLIC KEY-----
EOD;

        $pair = new Ulink_KeyPair($privKey, $pubKey);

        $myData = "foobarbaz";

        $this->assertNotNull($pair->getPrivateKey());

        $signatrue = Ulink_CryptoUtils::sign($myData, $pair->getPrivateKey());

        $this->assertNotNull($signatrue);

        $this->assertTrue(Ulink_CryptoUtils::isValidRSASignature("foobarbaz", $signatrue, $pair->getPublicKey()));
        $this->assertFalse(Ulink_CryptoUtils::isValidRSASignature("foo", $signatrue, $pair->getPublicKey()));


        $sealed = Ulink_CryptoUtils::seal($myData, $pair->getPublicKey());

        $opened = Ulink_CryptoUtils::unseal($sealed, $pair->getPrivateKey());

        $this->assertNotEquals($myData, $sealed);
        $this->assertEquals($myData, $opened);
    }

    /**
     * @Test
     * @return void
     */
    public function testUnsealFromJava()
    {
        $privateKey =  <<<EOD
-----BEGIN RSA PRIVATE KEY-----
MIICXgIBAAKBgQCr6s9ae6uMrAdXUNpxRcBfHUMp61jkIMbRcirjn6W02JVaoyyl
AA7LHSqs1iIrSsK0bCaWONajmKqFfFXEb2NrSywXEyzPHeFEYE2wHHHcvbKkIyF6
hi2lXTTPvtxw1GUTae089XJnwLlbZ9uoMpIB7sG9TGRpuDDNE6CG2kxmCwIDAQAB
AoGAfbz+rYI4RWno8J7tNd27RpXDctx0Jl4mrDehUNyKOQwTqLghxgiVyU7q0IDJ
evpyD73uNv8ZVYwqY/k9Ta/eeP5wlv1o82ITFkrEsSvMy55R0KnABffEo4Lbpv5i
G+5jiFq5Bo570ggk+4WtNvD21JHUVX0SEZaMPqpym7sOeTkCQQDgTxJqlyRkYWhT
CWVo5O/ouxqmN+x5g16ZLM7FokISmn925mDRv7wzDR318tRhbO0VIDQA4ZT+FcGI
LnLYhti1AkEAxDTOypWb98afgQthdLHnCrg7mEkZBfLS/wT3NzpaFC0D7wDOrC9i
rbTvxTYOp82TOyNmthFG5ihIpRyq1SM7vwJBAKOMA7mEChzGiPJCX5ZjlijygzO+
gsT2a/rzGLAw5kv6KgXfY6iLTAVNAxNYwlFmwlYs7L3XvHKmGj3Y4BPP/iECQQC0
r7D0LRzJ7Fc9Xn6sGZ0caRcwobhymvEmOqtzZ8BGrkHeGw840BZ+w46/PY33iECb
CHnxFy4EjHqB20mTKHQ/AkEAsgxTePttK36TdiX8QuS8/cxZ47tQp5QzxGCP4VpA
+mK4mmUsA22Y24xbGGPy6ekgUQSxL46zil2m+QHV2w0sMg==
-----END RSA PRIVATE KEY-----
EOD;

        $sealed = 'HOQnoFwOjZoU@QeR2pU68ShpGDoipKCPWWlu28ih8vjUkI4oftMD6qgP9sa0KN8QTlcw1QLWpbvnkZIKxJ5wu12AXtgv6EdIjuvS+GNT4BcWGZz7cadTwtB5JADO8FZMKcEsShO9v1gjrJaobUZxBp5Y0roJJt0zG+feUsAlzHzswVfJ+ieEavTo=';
        $opened = Ulink_CryptoUtils::unseal($sealed, $privateKey);

        $this->assertEquals("foobarbaz", $opened);
    }
}
