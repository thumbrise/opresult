<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Thumbrise\OpResult\Error;

class ErrorTest extends TestCase
{
    /**
     * @test
     */
    public function wrap()
    {
        $code3 = 'Какой то внутренний код уровня 3';
        $error3 = Error::make('Что то пошло не так на уровне 3', $code3);

        $code2 = 'Какой то внутренний код уровня 2';
        $error2 = $error3->wrap('Что то пошло не так на уровне 2', $code2);

        $code1 = 'Конечный код';
        $error1 = $error2->wrap('И правда что-то не так', $code1);


        $this->assertTrue($error1->is($code1));
        $this->assertTrue($error1->is($code2));
        $this->assertTrue($error1->is($code3));
    }
}