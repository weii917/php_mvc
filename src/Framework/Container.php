<?php

declare(strict_types=1);

namespace Framework;

use Closure;
use ReflectionClass;
use ReflectionNamedType;

class Container
{

    private array $registry = [];

    public function set(string $name, Closure $value): void
    {
        $this->registry[$name] = $value;
    }


    public function get(string $class_name): object
    {

        if (array_key_exists($class_name, $this->registry)) {
            return $this->registry[$class_name]();
        }

        $reflector = new ReflectionClass($class_name);

        $constructor = $reflector->getConstructor();

        $dependencies = [];
        if ($constructor === null) {

            return new $class_name;
        }

        foreach ($constructor->getParameters() as $parameter) {
            $type = $parameter->getType();

            if ($type === null) {
                exit("Constructor parameter'{$parameter->getName()}'
                    in the $class_name class
                    has no type declaration");
            }

            if (!($type instanceof ReflectionNamedType)) {
                exit("Constructor parameter '{$parameter->getName()}'
                        in the $class_name class is an invalid type:'$type'
                        - only single named types supported");
            }

            if ($type->isBuiltin()) {
                exit("Unable to resolve constructor parameter
                    '{$parameter->getName()}'
                    of type '$type' in the $class_name class");
            }

            // 每一個得到的type class在執行一次得到當沒有$constructor === null將會new class
            $dependencies[] = $this->get((string) $type);
        }


        return new $class_name(...$dependencies);
    }
}
