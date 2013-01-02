<?php

class Bootstrap_Form extends Zend_Form
{

    /**
     * Override the base form constructor.
     *
     * @param null $options            
     */
    public function __construct ($options = null)
    {
        /*
         * $this->getView()->addHelperPath( 'Bootstrap/View/Helper', 'Bootstrap_View_Helper' );
         */
        $this->addPrefixPath('Bootstrap_Form_Element', 
                'Bootstrap/Form/Element', 'element');
        
        /*
         * $this->addElementPrefixPath( 'Bootstrap_Form_Decorator',
         * 'Bootstrap/Form/Decorator', 'decorator' );
         * $this->addDisplayGroupPrefixPath( 'Bootstrap_Form_Decorator',
         * 'Bootstrap/Form/Decorator' );
         */
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
                 ->addDecorator('HtmlTag', array())
                 ->addDecorator('Form', array('class' => 'form-horizontal'));
        }
        return $this;
    }
    
    /**
     * Add a new element
     *
     * $element may be either a string element type, or an object of type
     * Zend_Form_Element. If a string element type is provided, $name must be
     * provided, and $options may be optionally provided for configuring the
     * element.
     *
     * If a Zend_Form_Element is provided, $name may be optionally provided,
     * and any provided $options will be ignored.
     *
     * The element will be added as normal, but then will be tested as a file type
     * in which case the form encoding type will be set.
     *
     * @param  string|Zend_Form_Element $element
     * @param  string $name
     * @param  array|Zend_Config $options
     * @throws Zend_Form_Exception on invalid element
     * @return Zend_Form
     */
    public function addElement($element, $name = null, $options = null)
    {
        parent::addElement($element, $name, $options);
        if (is_string($element)) {
            $elem = $this->_elements[$name];
        } elseif ($element instanceof Zend_Form_Element) {
            $elem = $element;
        }
        // If the element is a file, set the enctype
        if ($elem instanceof Bootstrap_Form_Element_File ||
            $elem instanceof Zend_Form_Element_File ){
            $this->setEnctype(Zend_Form::ENCTYPE_MULTIPART);
        }
        return $this;
    }
}
