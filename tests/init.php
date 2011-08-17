<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Alex
 * Date: 6/24/11
 * Time: 12:32 PM
 * To change this template use File | Settings | File Templates.
 */

spl_autoload_register(function($className)
    {
        $path = str_replace(array("_", "\\"), "/", $className);
        require_once '../src/' . $path . ".php";
    });

