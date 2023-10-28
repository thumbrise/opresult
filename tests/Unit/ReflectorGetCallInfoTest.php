<?php

namespace Tests\Unit;

use JetBrains\PhpStorm\NoReturn;
use OpResult\Reflector;
use PHPUnit\Framework\TestCase;

/**
 * !!! При модификации теста, стоит обратить внимание на переменные $line, $function, $class.
 */
class ReflectorGetCallInfoTest extends TestCase
{
    /**
     * @test
     */
    #[NoReturn] public function selfAnalysis()
    {
        $line = 24;
        $function = 'getCallInfo';
        $class = 'OpResult\Reflector';


        $result = Reflector::getCallInfo(Reflector::class, ['getCallInfo']);


        $this->assertEquals($line, $result['line']);
        $this->assertEquals($function, $result['function']);
        $this->assertEquals($class, $result['class']);
    }
}