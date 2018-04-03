<?php
declare(strict_types=1);

namespace Calculator\Forms;

/**
 * Interface IInputFormFactory
 * @package Calculator\Forms
 */
interface IInputFormFactory
{
    /**
     * @return InputForm
     */
    public function create(): InputForm;
}
