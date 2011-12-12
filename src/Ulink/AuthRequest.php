<?php

/**
 * @author Alex Rudakov <alexandr.rudakov@modera.net>
 */
class Ulink_AuthRequest extends Ulink_AbstractRequest implements Ulink_Response
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

    public static function clazz()
    {
        return __CLASS__;
    }
}
