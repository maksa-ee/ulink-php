<?php

namespace Ulink;

/**
 * @author Alex Rudakov <alexandr.rudakov@modera.net>
 */
class RequestFactory
{
    public static function createFromJson($json)
    {
        $jsonData = json_decode($json);

        $type = $jsonData->type;
        if ($type == "auth") {
            $request = AuthRequest::createFromJson($jsonData);
        } else if ($type == "pay") {
            $request = PaymentRequest::createFromJson($jsonData);
        } else if ($type == "auth-response") {
            $request = AuthResponse::createFromJson($jsonData);
        } else if ($type == "pay-response") {
            $request = PaymentResponse::createFromJson($jsonData);
        } else {
            throw new \Exception("type should be one of auth or pay. Given: " + $type);
        }
        $request->setTimestamp(intval($jsonData->timestamp));
        return $request;
    }
}
