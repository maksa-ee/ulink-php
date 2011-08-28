<?php

namespace Ulink;

/**
 * @author Alex Rudakov <alexandr.rudakov@modera.net>
 */
class AuthRequest extends AbstractRequest implements Response
{
    public function getType()
    {
        return "auth";
    }

    protected function getJsonData()
    {
        $data = parent::getJsonData();
        $data['data'] = array();
        return $data;
    }

    public static function createFromJson($jsonData)
    {
    }
}
