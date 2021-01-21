<?php
//栈式调用
$carry = function ($stack, $pipe) {
    echo 'carry ' . $pipe . PHP_EOL;
    var_dump($stack);
    return function (...$arg) use ($stack, $pipe) {
        echo "carry closure start " . $pipe . PHP_EOL;
//        echo "carry closure run arg = " . var_export($arg, true) . PHP_EOL;
        $stack($arg);
        echo "carry closure end " . $pipe . PHP_EOL;
    };

};

$default = function ($a = 'default') {
    echo "default func" . PHP_EOL;
};
$pips = [
    'apple',
    'banana',
    'candy',
    'doctor',
];

$first = array_reduce(($pips), $carry, $default);
$first(1, 2, 3);