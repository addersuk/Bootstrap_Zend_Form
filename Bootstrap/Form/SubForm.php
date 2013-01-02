<?php

class Bootstrap_Form_SubForm extends Zend_Form_SubForm
{

    /**
     * Whether or not form elements are members of an array
     * 
     * @var bool
     */
    protected $_isArray = true;

    /**
     * Override the base form constructor.
     *
     * @param null $options            
     */
    public function __construct ($options = null)
    {
        $this->addPrefixPath('Bootstrap_Form_Element', 
                'Bootstrap/Form/Element', 'element');
        
        $this->setDefaultDisplayGroupClass(
                'Bootstrap_Form_DisplayGroup');
        $this->loadDefaultDecorators();
        
        parent::__construct($options);
    }

    public function loadDefaultDecorators ()
    {
        if ($this->loadDefaultDecoratorsIsDisabled()) {
            return $this;
        }
        
        $decorators = $this->getDecorators();
        if (empty($decorators)) {
            $this->addDecorator('FormElements')
                 ->addDecorator('HtmlTag', array('tag' => 'div'));
        }
        return $this;
    }
}
