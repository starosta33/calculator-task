<?php
declare(strict_types=1);

namespace Calculator\Presenters;


use Calculator\Exception\CalculatorException;
use Calculator\Forms\IInputFormFactory;
use Calculator\Forms\InputForm;
use Calculator\Model\CalculatorLogic;

/**
 * Class HomepagePresenter
 * @package Calculator\Presenters
 */
class HomepagePresenter extends BasePresenter
{
    /**
     * @var IInputFormFactory
     * @inject
     */
    public $inputFormFactory;

    /**
     * @var CalculatorLogic
     * @inject
     */
    public $calculatorLogic;

    public function actionDefault(): void
    {
        $this->redirect('test');
    }

    /**
     * @param string|null $value
     */
    public function renderTest(string $value = null): void
    {
        $this->template->formula = $value;

        $result = null;
        if (!is_null($value) && trim($value) !== '') {
            try {
                $result = $this->calculatorLogic->calculate($value);
            } catch (CalculatorException $exception) {
                $this->flashMessage(sprintf('Calculation error: %s', $exception->getMessage()), 'error');
            }
        }
        $this->template->result = $result;
    }

    /**
     * @return InputForm
     */
    public function createComponentInputForm(): InputForm
    {
        $form = $this->inputFormFactory->create();
        $form->setAction($this->link('this'));
        $form->setDefaults($this->getParameters());

        return $form;
    }
}
