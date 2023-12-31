<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Thumbrise\OpResult\Reflector;

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
        $class = Reflector::class;


        $result = Reflector::getCallInfo([['class' => Reflector::class, 'function' => 'getCallInfo']]);


        $this->assertEquals($line, $result['line']);
        $this->assertEquals($function, $result['function']);
        $this->assertEquals($class, $result['class']);
    }
}