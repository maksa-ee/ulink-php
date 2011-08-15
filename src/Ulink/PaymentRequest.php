<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Alex
 * Date: 6/24/11
 * Time: 12:04 PM
 * To change this template use File | Settings | File Templates.
 */

namespace Ulink;

class PaymentRequest extends AbstractRequest {

    private $amount;
    private $currency;
    private $order;


    public function setAmount(Money $amount)
    {
        $this->amount = $amount;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function setCurrency($currency)
    {
        $this->currency = $currency;
    }

    public function getCurrency()
    {
        return $this->currency;
    }

    public function setOrder(Order $order)
    {
        $this->order = $order;
    }

    public function getOrder()
    {
        return $this->order;
    }

    public function getType() {
        return "pay";
    }

    protected function getJsonData() {
        $data = array(
            'amount' => (string)$this->getAmount(),
            'currency' => $this->getCurrency(),
        );
        if ($this->order) {
            $data['order'] = $this->order->getJsonData();
        }
        return $data;
    }
    
    public static function createFromJson($jsonData)
    {
        $request = new PaymentRequest();
        $request->setAmount(new Money($jsonData->amount));
        $request->setCurrency($jsonData->currency);
        if (isset($jsonData->order) && $jsonData->order) {
            $request->setOrder(Order::createFromJson($jsonData->order));
        }
        return $request;
    }
}
