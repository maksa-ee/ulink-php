<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Alex
 * Date: 6/24/11
 * Time: 12:03 PM
 * To change this template use File | Settings | File Templates.
 */

namespace Ulink;

class AuthRequest extends AbstractRequest implements Response {

    public function getType() {
        return "auth";
    }


    protected function getJsonData() {
        $data = parent::getJsonData();
        $data['data'] = array();
        return $data;
    }

    public static function createFromJson($jsonData)
    {

    }
}
