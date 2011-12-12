<?php

/**
 * @author Alex Rudakov <alexandr.rudakov@modera.net>
 * @author Cravler <http://github.com/cravler>
 */
abstract class Ulink_AbstractRequest implements Ulink_Request
{
    protected $timestamp;
    protected $clientTransactionId;
    
    protected $goBackUrl;
    protected $responseUrl;

    public function getGoBackUrl()
    {
        return $this->goBackUrl;
    }

    public function setGoBackUrl($goBackUrl)
    {
        $this->goBackUrl = $goBackUrl;
    }

    public function getResponseUrl()
    {
        return $this->responseUrl;
    }

    public function setResponseUrl($responseUrl)
    {
        $this->responseUrl = $responseUrl;
    }

    public function getTimestamp()
    {
        if ($this->timestamp > 0) {
            return $this->timestamp;
        }
        return time();
    }

    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;
    }

    public function toJson()
    {
        $data = $this->getJsonData();
        if (isset($data['data']) && is_array($data['data']) && !count($data['data'])) {
            $data['data'] = new stdClass();
        }
        return json_encode($data);
    }

    protected function getJsonData()
    {
        $data = array(
            'type'         => $this->getType(),
            'timestamp'    => $this->getTimestamp(),
            'response-url' => $this->getResponseUrl(),
            'back-url'     => $this->getGoBackUrl(),
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
}
