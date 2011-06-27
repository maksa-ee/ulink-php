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
         return json_encode(array(
                    'type' => $this->getType(),
                    'timestamp' => $this->getTimestamp(),
                    'data' => $this->getJsonData()
               ));
    }

    abstract protected function getJsonData();
}
