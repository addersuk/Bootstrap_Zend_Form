<?php
class Bootstrap_Form_Vertical extends Bootstrap_Form
{
    public function loadDefaultDecorators ()
    {
        if ($this->loadDefaultDecoratorsIsDisabled()) {
            return $this;
        }
    
        $decorators = $this->getDecorators();
        if (empty($decorators)) {
            $this->addDecorator('FormElements')
            ->addDecorator('HtmlTag', array(
    
            ))
            ->addDecorator('Form', array(
                'class' => 'form-vertical'
            ));
        }
        return $this;
    }
}