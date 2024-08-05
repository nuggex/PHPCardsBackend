<?php

define('ROOT_DIR', dirname(__FILE__));
const WEBROOT_DIR = ROOT_DIR . '/webroot/';
/**
 * Autoload classes from /classes/ directory. If namespaces are used then create matching subdirectory structure.
 */
function AutoLoad($className): void
{
    $file = ROOT_DIR . '/classes/' . str_replace("\\", DIRECTORY_SEPARATOR, $className) . '.php';
    if (is_file($file)) {
        require_once($file);
    } else {
        $file = ROOT_DIR . '/include/' . $className . '.php';
        if (is_file($file)) {
            require_once($file);
        } else {
            echo "$file not found\n";
        }
    }
}

spl_autoload_register('AutoLoad');
