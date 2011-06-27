<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Alex
 * Date: 6/24/11
 * Time: 12:04 PM
 * To change this template use File | Settings | File Templates.
 */

namespace Ulink;

interface Request {

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
}
