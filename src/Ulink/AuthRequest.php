<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Alex
 * Date: 6/24/11
 * Time: 12:03 PM
 * To change this template use File | Settings | File Templates.
 */

namespace Ulink;

class AuthRequest extends AbstractRequest {

    public function getType() {
        return "auth";
    }


    protected function getJsonData() {
        return new \stdClass();
    }

    public static function createFromJson($jsonData)
    {

    }
}
