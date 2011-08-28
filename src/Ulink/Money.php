<?php

namespace Ulink;

/**
 * @author Alex Rudakov <alexandr.rudakov@modera.net>
 */
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
        return (string) $this->amount;
    }
}
