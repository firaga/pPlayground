<?php

/**
 * Created by IntelliJ IDEA
 * User: jichen.zhou@eeoa.com
 * Date: 2022/11/10
 * Time: 17:18
 */

//Closure::bindTo how it's work?
//https://stackoverflow.com/questions/39884308/closurebindto-how-its-work
class A
{
    protected $value = 100;
}

$a = new A;
$closure = function () { echo $this->value; };
$binding = $closure->bindTo($a, "A"); /// scope is now A class
$binding();  //succ

$second_binding = $closure->bindTo($a, 'static'); //scope is not still A class
$second_binding(); // error with access issues
