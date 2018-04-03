<?php

declare(strict_types=1);

namespace Test;

use Calculator\Model\CalculatorLogic;
use Nette;
use Tester;
use Tester\Assert;

$container = require __DIR__ . '/bootstrap.php';

/**
 * Class CalculatorTest
 * @package Test
 * @covers \Calculator\Model\CalculatorLogic
 */
class CalculatorTest extends Tester\TestCase
{
    /** @var CalculatorLogic */
    private $calculatorLogic;

    /**
     * CalculatorTest constructor.
     * @param Nette\DI\Container $container
     */
    public function __construct(Nette\DI\Container $container)
    {
        $this->calculatorLogic = $container->getByType(CalculatorLogic::class);
    }

    /**
     * @return array
     */
    public function provideCalculate(): array
    {
        return [
            ['2 * 2.5', 5],
            ['2 * 2.5 * 3', 15],
            ['2 * 2.5 * 3 / 5', 3],
            ['2 * (2.5 * 3) / 5', 3],
            ['2 + (2 + 3) * 2 - 5', 7],
            ['0.5', 0.5],
            ['0,5', 0.5],
            ['2/4', 0.5],
            ['2\4', 0.5],
            ['-6 + 5 * ((4 / 2) + -3) - 20', -31],
            [' ( 1 ) ', 1],
            ['1', 1],
            [' 1 ', 1],
//            ['+1', 1],
            ['-1', -1],
            ['-1', -1],
            ['–1', -1],
            ['5 + 5*5 + 5 + 5*5+5+5*5', 90],
            ['-5 + -5 * -5 + 5 + -5*-5+5+-5*-5', 80],
        ];
    }

    /**
     * @return array
     */
    public function provideCalculateExceptions(): array
    {
        return [
            ['5/0', 'Division by zero'],
            ['2 * (2.5 * 3', 'Wrong usage of brackets'],
            ['2 * 2.5) * 3', 'Wrong usage of brackets'],
            ['2 * a', 'Wrong formula: "2 * a"'],
            ['5 + (2 * a)', 'Wrong formula: "2 * a"'],
            ['- 1', 'Wrong formula: "- 1"'],
            ['+1', 'Wrong formula: "+1"'],
            ['5 + +1', 'Wrong formula: "5 + +1"'],
            ['((()))', 'Empty expression'],
            ['6 * ((26 \ 2) + -3) – 20)', 'Wrong usage of brackets'],
        ];
    }

    /**
     * @covers       \Calculator\Model\CalculatorLogic::calculate()
     * @dataProvider provideCalculate
     * @param string $formula
     * @param float $expected
     */
    public function testCalculate(string $formula, float $expected)
    {
        Assert::equal($expected, $this->calculatorLogic->calculate($formula));
    }

    /**
     * @covers       \Calculator\Model\CalculatorLogic::calculate()
     * @dataProvider provideCalculateExceptions
     * @param string $formula
     * @param string $message
     * @throws \Calculator\Exception\CalculatorException
     */
    public function testCalculateExceptions(string $formula, string $message)
    {
        Assert::exception(
            $this->calculatorLogic->calculate($formula),
            \Calculator\Exception\CalculatorException::class,
            $message
        );
    }
}


$test = new CalculatorTest($container);
$test->run();
