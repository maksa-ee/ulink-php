<?php

namespace Ulink;

/**
 * @author Alex Rudakov <alexandr.rudakov@modera.net>
 */
class Order
{
    /**
     * @var OrderItem[]
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

    public function addItem(OrderItem $item)
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
        $order = new Order();
        foreach($jsonData as $item) {
            $orderItem = new OrderItem($item->name, $item->descr, new Money($item->price), $item->qty);
            $order->addItem($orderItem);
        }
        return $order;
    }
}
