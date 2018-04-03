<?php
declare(strict_types=1);

namespace Calculator\Forms\Rendering;

use Nette\Forms\Rendering\DefaultFormRenderer;
use Nette\Utils\Html;

/**
 * Class CustomFormRenderer
 * @package Calculator\Forms\Rendering
 */
class CustomFormRenderer extends DefaultFormRenderer
{
    /**
     * copy pasted from DefaultFormRender with a small fix
     * @see DefaultFormRenderer::renderBegin()
     *
     * @return string
     */
    public function renderBegin(): string
    {
        $this->counter = 0;

        foreach ($this->form->getControls() as $control) {
            $control->setOption('rendered', false);
        }

        if ($this->form->isMethod('get')) {
            $el = clone $this->form->getElementPrototype();
            $query = parse_url($el->action, PHP_URL_QUERY);
            $el->action = str_replace("?$query", '', $el->action);
            $s = '';

            //fixed here - casted $query to string
            foreach (preg_split('#[;&]#', (string)$query, -1, PREG_SPLIT_NO_EMPTY) as $param) {
                $parts = explode('=', $param, 2);
                $name = urldecode($parts[0]);
                if (!isset($this->form[$name])) {
                    $s .= Html::el('input', ['type' => 'hidden', 'name' => $name, 'value' => urldecode($parts[1])]);
                }
            }
            return $el->startTag() . ($s ? "\n\t" . $this->getWrapper('hidden container')->setHtml($s) : '');

        } else {
            return $this->form->getElementPrototype()->startTag();
        }
    }


}