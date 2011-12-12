<?php

/**
 * @author Alex Rudakov <alexandr.rudakov@modera.net>
 */
class Ulink_Order
{
    /**
     * @var Ulink_OrderItem[]
     */
    protected $items = array();

    public function setItems($items)
    {
        $this->items = $items;
    }

    public function getItems()
    {
        return $this->items;
    }

    public function addItem(Ulink_OrderItem $item)
    {
        $this->items[] = $item;
    }

    public function getJsonData()
    {
        $data = array();
        foreach($this->items as $item) {
            $data[] = $item->getJsonData();
        }
        return $data;
    }

    public static function createFromJson($jsonData)
    {
        $order = new Ulink_Order();
        foreach($jsonData as $item) {
            $orderItem = new Ulink_OrderItem($item->name, $item->descr, new Ulink_Money($item->price), $item->qty);
            $order->addItem($orderItem);
        }
        return $order;
    }
}
