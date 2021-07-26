<?php
/**
 * Created by IntelliJ IDEA
 * User: jichen.zhou@eeoa.com
 * Date: 2021/7/26
 * Time: 8:02 下午
 */
<?
php
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
     * @param string $class
     * @param array $params
     * @return mixed|object
     * @throws ReflectionException
     */
    public function make(string $class, array $params = [])
    {
        if (isset($this->binds[$class])) {
            return ($this->binds[$class])->call($this, $this, ...$params);
        }

        return $this->binds[$class] = $this->resolve($class, $params);
    }

    /**
     * Get object by reflection
     *
     * @param $abstract
     * @param $request_params
     * @return object
     * @throws \ReflectionException
     */
    protected function resolve($abstract, $request_params)
    {
        // 获取反射对象
        $constructor = (new ReflectionClass($abstract))->getConstructor();
        // 构造函数未定义，直接实例化对象
        if (is_null($constructor)) {
//  如果没有构造函数，则直接返回实 $abstract 的例化
            return new $abstract;
        }
        // 获取构造函数参数
        $parameters = $constructor->getParameters();
        $arguments = [];
        foreach ($parameters as $parameter) {
            // 获得参数的类型提示类
            $paramClassName = $parameter->getClass()->getName();
            // 参数没有类型提示类，抛出异常
            if (is_null($paramClassName)) {
                throw new Exception('Fail to get instance by reflection');
            }
            // 实例化参数 $paramClassName 参数没有绑定的情况下，还是会回掉到 resolve 函数，但是总会有不需要类实例为参数的类，为节点，则一步步走出来。
// 但是这种情况下是使用与实例传递的是类的情况，而不适用于其他参数 如果在 Bread 中添加一个构造函数，你就会发现报错
//不过    $constructor = (new ReflectionClass($abstract))->getConstructor(); 就是限制的查看构造函数的处理。
            $arguments[] = $this->make($paramClassName);
        }

        return new $abstract(...$arguments);
    }
}

$container = new Container();
try {
    $hambuger = $container->make(Hamburger::class);
} catch (ReflectionException $e) {
}
$hambuger->getName();