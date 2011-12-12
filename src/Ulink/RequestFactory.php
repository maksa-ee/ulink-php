<?php

/**
 * @author Alex Rudakov <alexandr.rudakov@modera.net>
 */
class Ulink_RequestFactory
{
    public static function createFromJson($json)
    {
        $jsonData = json_decode($json);

        $type = $jsonData->type;
        if ($type == "auth") {
            $request = Ulink_AuthRequest::createFromJson($jsonData);
        } else if ($type == "pay") {
            $request = Ulink_PaymentRequest::createFromJson($jsonData);
        } else if ($type == "auth-response") {
            $request = Ulink_AuthResponse::createFromJson($jsonData);
        } else if ($type == "pay-response") {
            $request = Ulink_PaymentResponse::createFromJson($jsonData);
        } else {
            throw new Exception("type should be one of auth or pay. Given: " + $type);
        }
        $request->setTimestamp(intval($jsonData->timestamp));
        return $request;
    }
}
