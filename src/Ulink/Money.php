<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Alex
 * Date: 6/24/11
 * Time: 12:25 PM
 * To change this template use File | Settings | File Templates.
 */

namespace Ulink;

class Money
{
    private $amount;
    const SCALE = 2;

    /**
     * @param string
     */
    public function __construct($amount)
    {
        $this->amount = $amount;
    }

    public function add(Money $another)
    {
        return new Money(bcadd($this->amount, $another->amount, self::SCALE));
    }

    public function multiply($factor)
    {
        $factor = (string) $factor;
        return new Money(bcmul($this->amount, $factor, self::SCALE));
    }

    public function __toString()
    {
        return $this->amount;
    }
}
