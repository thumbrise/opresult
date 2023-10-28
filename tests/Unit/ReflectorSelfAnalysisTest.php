<?php

namespace Tests\Unit;

use OpResult\Reflector;
use PHPUnit\Framework\TestCase;

/**
 * !!! При модификации теста, стоит обратить внимание на переменные $line, $function, $class.
 */
class ReflectorSelfAnalysisTest extends TestCase
{
    /**
     * @test
     */
    public function selfAnalysis()
    {
        $line = 23;
        $function = 'getCallInfo';
        $class = 'OpResult\Reflector';


        $result = Reflector::getCallInfo([['class' => Reflector::class, 'function' => 'getCallInfo']]);


        $this->assertEquals($line, $result['line']);
        $this->assertEquals($function, $result['function']);
        $this->assertEquals($class, $result['class']);
    }
}