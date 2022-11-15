<?php
//https://www.php.net/manual/en/function.array-reduce.php
//https://learnku.com/articles/5206/the-use-of-php-built-in-function-array-reduce-in-laravel


//func
function carry()
{
    /**
     * accumulator
     * value
     */
    return function ($acc, $item) {
        return $acc."-".$item;
    };
}

//闭包和字符串调用方法实现的区别
// 闭包方法返回闭包函数在array_reduce内部执行,非闭包实现应为array_reduce函数内部使用字符串拉到方法地址执行
function carry2($acc, $item)
{
    return $acc."-".$item;
}


$a = ["Dog", "Cat", "Horse"];
print_r(array_reduce($a, carry(), 5).chr(10));
print_r(array_reduce($a, 'carry2', 5). chr(10));
