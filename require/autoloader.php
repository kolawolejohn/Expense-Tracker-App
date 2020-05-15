<?php

spl_autoload_register('myAutoloader');

function myAutoloader($classname){
    $path = "classes/";
    $extension = ".php";
    $fullpath = $path . $classname . $extension;

    require_once $fullpath;
}