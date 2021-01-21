<?php
$context = [
    'p' => 0,
    'r' => 'hello',
];
$a = function ($context) {
    echo "a start" . PHP_EOL;
    $context['p']++;
    echo "a end" . PHP_EOL;
};
$b = function ($context) {
    echo "b start" . PHP_EOL;
    $context['p']++;
    echo "b end" . PHP_EOL;
};
$stack = [$b, $a];
while ($r = array_pop($stack)) {
    $r($context);
}
