<?php

namespace OpResult;

class Reflector
{
    /**
     * @param class-string $classname
     * @param array $functions
     * @return array|null
     */
    public static function getCallInfo(string $classname, array $functions): ?array
    {
        $trace = debug_backtrace(! DEBUG_BACKTRACE_PROVIDE_OBJECT | DEBUG_BACKTRACE_IGNORE_ARGS);

        foreach ($trace as $info) {
            if ($info['class'] != $classname) {
                continue;
            }
            if (in_array($info['function'], $functions)) {
                return $info;
            }
        }

        return null;
    }
}