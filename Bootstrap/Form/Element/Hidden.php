<?php

class Bootstrap_Form_Element_Hidden extends Bootstrap_Form_Element_Xhtml
{

    /**
     * Use formHidden view helper by default
     * 
     * @var string
     */
    public $helper = 'formHidden';
    
    public function loadDefaultDecorators()
    {
        if ($this->loadDefaultDecoratorsIsDisabled()) {
            return $this;
        }

        $decorators = $this->getDecorators();
        if (empty($decorators)) {
            $this->addDecorator('ViewHelper'); 
        }
        return $this;
    }
}
