<?php

/**
 * @author Alex Rudakov <alexandr.rudakov@modera.net>
 */
function maksa_autoload($className)
{
    $path = str_replace(array("_", "\\"), "/", $className);
    $filename = '../src/' . $path . ".php";
    if (file_exists($filename)) {
        require_once $filename;
        return class_exists($className, false);
    } else {
        return false;
    }
}
spl_autoload_register('maksa_autoload');

