<?php
/**
 * @author Alex Rudakov <alexandr.rudakov@modera.net>
 */
class Ulink_Money
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

    public function add(Ulink_Money $another)
    {
        return new Ulink_Money(bcadd($this->amount, $another->amount, self::SCALE));
    }

    public function multiply($factor)
    {
        $factor = (string) $factor;
        return new Ulink_Money(bcmul($this->amount, $factor, self::SCALE));
    }

    public function __toString()
    {
        return (string) $this->amount;
    }
}
