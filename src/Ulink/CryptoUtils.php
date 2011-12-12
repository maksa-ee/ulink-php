<?php
/**
 * @author Alex Rudakov <alexandr.rudakov@modera.net>
 */
class Ulink_CryptoUtils
{
    public static function generateRSAKeyPair()
    {
        $res = openssl_pkey_new(); // will work only with properly configured openssl.cnf

        $privkey = "";

        // Get private key
        openssl_pkey_export($res, $privkey);

        // Get public key
        $pubkey=openssl_pkey_get_details($res);
        $pubkey=$pubkey["key"];

        return new Ulink_KeyPair($privkey, $pubkey);
    }

    public static function sign($data, $privateKey)
    {
        $binary_signature = "";
        $pkeyid = openssl_get_privatekey($privateKey);
        if (openssl_sign($data, $binary_signature, $privateKey, OPENSSL_ALGO_SHA1)) {
            return $binary_signature;
//            openssl_free_key($pkeyid);
        } else {
//            openssl_free_key($pkeyid);
            return null;
        }
    }

    public static function isValidRSASignature($data, $signatrue, $publicKey)
    {
        $result = openssl_verify($data, $signatrue, $publicKey, OPENSSL_ALGO_SHA1);

        return $result == 1;
    }

    public static function seal($myData, $publicKey)
    {
        openssl_seal($myData, $sealed, $ekeys, array($publicKey));

        $sealed = base64_encode($sealed);
        $Xevk = base64_encode($ekeys[0]);

        return $sealed . '@' . $Xevk;
    }

    public static function unseal($sealed, $privateKey)
    {
        list($sealed, $Xevk) = explode('@', $sealed);
        openssl_open(base64_decode($sealed), $opened, base64_decode($Xevk), $privateKey) or die(openssl_error_string());
        return $opened;
    }
}
