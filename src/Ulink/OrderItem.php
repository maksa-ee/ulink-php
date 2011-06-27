<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Alex
 * Date: 6/24/11
 * Time: 12:04 PM
 * To change this template use File | Settings | File Templates.
 */

namespace Ulink;

class OrderItem {

    private $name;
    private $description;
    private $quantity;
    private $oneItemPrice;

    public function __construct($name, $description, Money $oneItemPrice, $quantity = 1)
    {
        $this->name = $name;
        $this->description = $description;
        $this->oneItemPrice = $oneItemPrice;
        $this->quantity = $quantity;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setOneItemPrice($oneItemPrice)
    {
        $this->oneItemPrice = $oneItemPrice;
    }

    public function getOneItemPrice()
    {
        return $this->oneItemPrice;
    }

    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }

    public function getJsonData() {
        return array(
            'name' => $this->getName(),
            'descr' => $this->getDescription(),
            'qty' => $this->getQuantity(),
            'price' => (string) $this->getOneItemPrice()
        );
    }
}