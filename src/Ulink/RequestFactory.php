<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Alex
 * Date: 6/26/11
 * Time: 7:51 PM
 * To change this template use File | Settings | File Templates.
 */

namespace Ulink;

class RequestFactory {

    public static function createFromJson($json) {

        $jsonData = json_decode($json);

        $type = $jsonData->type;
        if ($type == "auth") {
            $request = AuthRequest::createFromJson($jsonData->data);
        } else if ($type == "pay") {
            $request = PaymentRequest::createFromJson($jsonData->data);
        } else {
            throw new JSONException("type should be one of auth or pay. Given: " + $type);
        }
        $request->setTimestamp(intval($jsonData->timestamp));
        return $request;
    }
}
