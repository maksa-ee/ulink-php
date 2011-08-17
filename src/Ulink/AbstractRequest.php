<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Alex
 * Date: 6/24/11
 * Time: 12:03 PM
 * To change this template use File | Settings | File Templates.
 */

namespace Ulink;
 
abstract class AbstractRequest implements Request {

    protected $timestamp;
    protected $clientTransactionId;

    public function getTimestamp() {
        if ($this->timestamp > 0) {
            return $this->timestamp;
        }
        return time();
    }

    public function setTimestamp($timestamp) {
        $this->timestamp = $timestamp;
    }

    public function toJson() {
        $data = $this->getJsonData();
        if (isset($data['data']) && is_array($data['data']) && !count($data['data'])) {
            $data['data'] = new \stdClass();
        }
        return json_encode($data);
    }

    protected function getJsonData() {

        $data = array(
                    'type' => $this->getType(),
                    'timestamp' => $this->getTimestamp()
               );
        if ($this->getClientTransactionId()) {
            $data['id'] = $this->getClientTransactionId();
        }
        return $data;
    }

    public function setClientTransactionId($clientTransactionId)
    {
        $this->clientTransactionId = $clientTransactionId;
    }

    public function getClientTransactionId()
    {
        return $this->clientTransactionId;
    }

    public static function clazz()
    {
        return get_called_class();
    }
}
