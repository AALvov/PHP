<?php

spl_autoload_register(function ($class_name) {
    include_once './entities/' . $class_name . '.php';
});
