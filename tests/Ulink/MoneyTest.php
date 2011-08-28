<?php

namespace Ulink;

/**
 * @author Alex Rudakov <alexandr.rudakov@modera.net>
 */
class MoneyTest extends \PHPUnit_Framework_TestCase
{
    public function testMoneyRepresentationAsAStringIncludesDecimals()
    {
        $money = new Money('10.00');
        $this->assertEquals('10.00', (string) $money);
    }

    public function testMoneyAmountsCanBeAddedTogether()
    {
        $money = new Money('10.45');
        $finalMoney = $money->add(new Money('21.55'));
        $this->assertEquals('32.00', (string) $finalMoney);
    }

    public function testMoneyCanBeMultipliedForAFactor()
    {
        $money = new Money('54.46');
        $finalMoney = $money->multiply(100);
        $this->assertEquals('5446.00', (string) $finalMoney);
    }

    /**
     * This forces to use bc_*() functions.
     * Of course we probably don't need such large numbers for Money,
     * but arbitrary precision reflects on the single hundreths.
     */
    public function testMoneyCanBeMultipliedForAFactorAndMaintainPrecision()
    {
        $money = new Money('54.46');
        $finalMoney = $money->multiply('100000000000000000');
        $this->assertEquals('5446000000000000000.00', (string) $finalMoney);
    }
}
