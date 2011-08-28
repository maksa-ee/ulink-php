<?php

/**
 * @author Alex Rudakov <alexandr.rudakov@modera.net>
 */
spl_autoload_register(function($className)
{
    $path = str_replace(array("_", "\\"), "/", $className);
    require_once '../src/' . $path . ".php";
});

