<?php

namespace App\Classes;

abstract class AbstractEnum {

    public static function getAll() {
        $reflector = new ReflectionClass(get_called_class());

        return $reflector->getConstants();
    }

}
