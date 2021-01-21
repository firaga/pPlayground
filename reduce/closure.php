<?php
//func
function carry()
{
    /**
     * accumulator
     * value
     */
    return function ($acc, $item) {
        return $acc . "-" . $item;
    };
}

$a = ["Dog", "Cat", "Horse"];
print_r(array_reduce($a, carry(), 5));