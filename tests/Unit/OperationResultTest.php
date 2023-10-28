<?php

namespace Tests\Unit;

use OpResult\OperationResult;
use PHPUnit\Framework\TestCase;

class OperationResultTest extends TestCase
{
    /**
     * @test
     */
    public function withError()
    {
        $code3 = 'Какой то внутренний код уровня 3';
        $result3 = OperationResult::error('Что то пошло не так на уровне 3', $code3);

        $code2 = 'Какой то внутренний код уровня 2';
        $result2 = $result3->withError('Что то пошло не так на уровне 2', $code2);

        $code1 = 'Конечный код';
        $result1 = $result2->withError('И правда что-то не так', $code1);


        $this->assertTrue($result1->isError($code1));
        $this->assertTrue($result1->isError($code2));
        $this->assertTrue($result1->isError($code3));

        dd($result3);
    }
}