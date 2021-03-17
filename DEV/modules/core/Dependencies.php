<?php


namespace App\Core;


class Dependencies
{
    /**
     * Return a list of classes can be used like a dependency.
     *
     * @return string[]
     */
    public static function dependencies()
    {
        return [
            'App\Core\Request',
            'App\Service\User'
        ];
    }

    /**
     * Get dependencies from a class constructor.
     *
     * @param $class
     *
     * @return mixed
     *
     * @throws \ReflectionException
     */
    public static function getClassDependencies($class)
    {
        /** @var mixed $dependencies Dependencies to load on class loading. */
        $dependencies = [];

        $reflexionClass = new \ReflectionClass($class);
        $classParameters = $reflexionClass->getConstructor()->getParameters();

        foreach ($classParameters as $param)
        {
            $name = $param->getClass()->name;

            if (in_array($name, self::dependencies())) {
                array_push($dependencies, new $name());
            }
        }

        return $dependencies;
    }
}
