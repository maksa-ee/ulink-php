<?php

namespace Ulink;

/**
 * @author Alex Rudakov <alexandr.rudakov@modera.net>
 */
interface Request
{
    const CURRENCY_EURO = "EUR";
    const CURRENCY_US_DOLLAR = "USD";

    /**
     * @return short alias for request type
     */
    public function getType();

    /**
     * Converts request to json string
     */
    public function toJson();

    public function getGoBackUrl();
    public function getResponseUrl();
}
