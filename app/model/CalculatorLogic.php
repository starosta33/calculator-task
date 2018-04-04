<?php
declare(strict_types=1);

namespace Calculator\Model;

use Calculator\Exception\CalculatorException;

/**
 * Class CalculatorLogic
 * @package Calculator\Model
 */
class CalculatorLogic
{
    const NUMBER_REGEX = '\s*([\-\-\–]?\d+\.?\d*)\s*';
    const MULTIPLICATION_AND_DIVISION_REGEX = self::NUMBER_REGEX . '([\\\\\/\*])' . self::NUMBER_REGEX;
    const ADDITION_AND_SUBTRACTION_REGEX = self::NUMBER_REGEX . '([\+\-\–])' . self::NUMBER_REGEX;

    /**
     * @param string $formula
     * @return float
     * @throws CalculatorException
     */
    public function calculate(string $formula): float
    {
        $formula = trim($formula);
        if (empty($formula)) {
            throw new CalculatorException('Empty expression');
        }
        $formula = str_replace(',', '.', $formula);
        $formula = str_replace('–', '-', $formula);

        //evaluate the brackets with the highest priority
        $offset = 0;
        while (($startPosition = strpos($formula, '(', $offset)) !== false) {
            $endPosition = $this->findClosingBracket($partialFormula = substr($formula, $startPosition + 1));
            $partialFormula = substr($partialFormula, 0, $endPosition);
            $result = (string)$this->calculate($partialFormula);
            $formula = str_replace('(' . $partialFormula . ')', $result, $formula);
            $offset += strlen($result);
        }
        if (strpos($formula, ')') !== false) {
            throw new CalculatorException('Wrong usage of brackets');
        }

        //evaluate * and / with medium priority
        while (preg_match('/' . self::MULTIPLICATION_AND_DIVISION_REGEX . '/', $formula, $matches)) {
            $operand1 = $matches[1];
            $operand2 = $matches[3];
            if ($matches[2] == '*') {
                $result = $operand1 * $operand2;
            } else {
                if ($operand2 == 0) {
                    throw new CalculatorException('Division by zero');
                }
                $result = $operand1 / $operand2;
            }
            $formula = str_replace(trim($matches[0]), $result, $formula);
        }

        //evaluate + and - with lowest priority
        while (preg_match('/' . self::ADDITION_AND_SUBTRACTION_REGEX . '/', $formula, $matches)) {
            $operand1 = $matches[1];
            $operand2 = $matches[3];
            $result = $matches[2] == '+' ? $operand1 + $operand2 : $operand1 - $operand2;
            $formula = str_replace(trim($matches[0]), $result, $formula);
        }

        if (preg_match('/^' . self::NUMBER_REGEX . '$/', $formula)) {
            return (float)$formula;
        }

        throw new CalculatorException(sprintf('Wrong formula: "%s"', $formula));
    }

    /**
     * @param $text
     * @return int
     * @throws CalculatorException
     */
    private function findClosingBracket($text): int
    {
        $openingBrackets = 0;
        for ($i = 0; $i < strlen($text); $i++) {
            switch ($text[$i]) {
                case '(' :
                    $openingBrackets++;
                    break;
                case ')' :
                    if ($openingBrackets-- == 0) {
                        return $i;
                    }
                    break;
            }
        }

        throw new CalculatorException('Wrong usage of brackets');
    }
}
