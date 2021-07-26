<?php
/**
 * Created by IntelliJ IDEA
 * User: jichen.zhou@eeoa.com
 * Date: 2021/7/26
 * Time: 7:51 下午
 */


class Bread
{
}


class Hamburger
{
    protected $materials;

    public function __construct(Bread $bread)
    {
        $this->materials = [$bread];
    }


    /**
     * 测试函数
     */
    public function getName()
    {
        echo '111';
    }

}


class Container
{
    /**
     * @var Closure[]
     */
    public $binds = [];

    /**
     * Bind class by closure.
     *
     * @param string $class
     * @param Closure $closure
     * @return $this
     */
    public function bind(string $class, Closure $closure): Container
    {
        $this->binds[$class] = $closure;

        return $this;
    }

    /**
     * Get object by class
     *
     * @param string $class
     * @param array $params
     * @return object
     */
    public function make(string $class, array $params = [])
    {
        if (isset($this->binds[$class])) {
            //  或者 if (array_key_exists($class,$this->binds)) {
            return ($this->binds[$class])->call($this, $this, ...$params);
        }

        return new $class(...$params);
    }
}

$container = new Container();

$container->bind(Hamburger::class, function (Container $container) {
    //  此时使用 make 得到i的是    return new $class(...$params); 也就是返回的 Bread 类的实例，因为没有 bind Bread 这个类
    $bread = $container->make(Bread::class);
    /** @var Bread $bread */
    return new Hamburger($bread);
});


//
echo '<pre>';
echo '$container类';
print_r($container);
echo '<hr>';

echo 'Hamburger参数值<br>';
print_r(($container->binds['Hamburger'])->call($container, $container)); // 直接使用类名或者类都可以
echo '或者<br>';
print_r(($container->binds[Hamburger::class])->call($container, $container));
echo '<hr>';
echo 'Hamburger 的闭包 <br>';
print_r(($container->binds[Hamburger::class]));