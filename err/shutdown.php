<?php
/**
 * Created by IntelliJ IDEA
 * User: jichen.zhou@eeoa.com
 * Date: 2021/5/8
 * Time: 5:02 下午
 */


function shutdownFunction()
{
    echo "shutdownFunction is called \n";
}

function shutdownFunction2()
{
    echo "shutdownFunction2 is called \n";
}

function errorHandlerFunction()
{
    echo "errorHandlerFunction is called \n";
}

function errorHandlerFunction2()
{
    echo "errorHandlerFunction2 is called \n";
}

//顺序调用
register_shutdown_function('shutdownFunction');
register_shutdown_function('shutdownFunction2');
//多个覆盖,只有最后一个执行
set_error_handler('errorHandlerFunction');
set_error_handler('errorHandlerFunction2');

//echo "foo\n"; // scenario 1 no errors
echo $undefinedVar; //scenario 2 error is triggered
//undefinedFunction(); //scenario 3 Fatal error is triggered
//throw new \Exception(); //scenario 4 exception is thrown