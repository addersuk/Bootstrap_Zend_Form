<?php

class Bootstrap_Form_DisplayGroup extends Zend_Form_DisplayGroup
{
    public function init()
    {
        //$this->addPrefixPath('Bootstrap_Form_Element', 'Bootstrap/Form/Element', 'element');
    }
    
    /**
     * Load default decorators
     *
     * @return Zend_Form_DisplayGroup
     */
    public function loadDefaultDecorators ()
    {
        if ($this->loadDefaultDecoratorsIsDisabled()) {
            return $this;
        }

        $decorators = $this->getDecorators();
        if (empty($decorators)) {
            $this->addDecorator('FormElements')
                ->addDecorator('Fieldset')
                ->addDecorator(array('row' => 'HtmlTag'),array('tag' => 'div','class' => 'control-group'));

        }
        return $this;
    }
    
    /**
     * Add element to stack, and update enctype if necessary
     *
     * @param  Zend_Form_Element $element
     * @return Zend_Form_DisplayGroup
     */
    public function addElement(Zend_Form_Element $element)
    {
        // If the element is a file, set the enctype
        if ($element instanceof Bootstrap_Form_Element_File ||
            $element instanceof Zend_Form_Element_File ){
            $this->setAttrib('enctype', Zend_Form::ENCTYPE_MULTIPART);
        }
        parent::addElement($element);
        
        return $this;
    }
}
