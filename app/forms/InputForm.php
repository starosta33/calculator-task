<?php
declare(strict_types=1);

namespace Calculator\Forms;

use Calculator\Forms\Rendering\CustomFormRenderer;
use Nette;
use Nette\Application\UI\Form;

/**
 * Class InputForm
 * @package Calculator\Forms
 */
class InputForm extends Form
{
    use Nette\SmartObject;

    const FIELD_INPUT = 'value';
    const SEND_BUTTON = 'send';
    const FORMULA_REGEX = '^[\d\s\(\)*\\\\\/\-\+\-\–\.,]+$';

    /**
     * InputForm constructor.
     * @param CustomFormRenderer $customFormRenderer
     */
    public function __construct(CustomFormRenderer $customFormRenderer)
    {
        parent::__construct();

        $this->setMethod(self::GET);
        $this->setRenderer($customFormRenderer);

        $this->addTextArea(self::FIELD_INPUT, 'Input formula', 50, 2)
            ->setRequired(true)
            ->addRule(self::PATTERN, 'Formula contains illegal characters...', self::FORMULA_REGEX);

        $this->addSubmit(self::SEND_BUTTON, 'Calculate');
    }
}
