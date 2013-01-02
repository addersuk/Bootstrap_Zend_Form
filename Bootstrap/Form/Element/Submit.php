<?php

class Bootstrap_Form_Element_Submit extends Bootstrap_Form_Element_Xhtml
{

    /**
     * Default view helper to use
     * 
     * @var string
     */
    public $helper = 'formSubmit';

    /**
     * Constructor
     *
     * @param string|array|Zend_Config $spec
     *            Element name or configuration
     * @param string|array|Zend_Config $options
     *            Element value or configuration
     * @return void
     */
    public function __construct($spec, $options = null)
    {
        if (is_string($spec) && ((null !== $options) && is_string($options))) {
            $options = array('label' => $options);
        }

        if (!isset($options['ignore'])) {
            $options['ignore'] = true;
        }

        parent::__construct($spec, $options);
    }

    /**
     * Return label
     *
     * If no label is present, returns the currently set name.
     *
     * If a translator is present, returns the translated label.
     *
     * @return string
     */
    public function getLabel()
    {
        $value = parent::getLabel();
        if (null === $value) {
            $value = $this->getName();
        }
        return $value;
    }

    /**
     * Has this submit button been selected?
     *
     * @return bool
     */
    public function isChecked ()
    {
        $value = $this->getValue();
        
        if (empty($value)) {
            return false;
        }
        if ($value != $this->getLabel()) {
            return false;
        }
        
        return true;
    }

    public function isValid($value, $context = null)
    {
        $value = $this->getValue();

        if ((('' === $value) || (null === $value))
            && !$this->isRequired()
            && $this->getAllowEmpty()
        ) {
            return true;
        }

        if ($this->isRequired()
            && $this->autoInsertNotEmptyValidator()
            && !$this->getValidator('NotEmpty'))
        {
            $validators = $this->getValidators();
            $notEmpty   = array('validator' => 'NotEmpty', 'breakChainOnFailure' => true);
            array_unshift($validators, $notEmpty);
            $this->setValidators($validators);
        }

        // Find the correct translator. Zend_Validate_Abstract::getDefaultTranslator()
        // will get either the static translator attached to Zend_Validate_Abstract
        // or the 'Zend_Translate' from Zend_Registry.
        if (Zend_Validate_Abstract::hasDefaultTranslator() &&
            !Zend_Form::hasDefaultTranslator())
        {
            $translator = Zend_Validate_Abstract::getDefaultTranslator();
            if ($this->hasTranslator()) {
                // only pick up this element's translator if it was attached directly.
                $translator = $this->getTranslator();
            }
        } else {
            $translator = $this->getTranslator();
        }

        $this->_messages = array();
        $this->_errors   = array();
        $result          = true;
        $isArray         = $this->isArray();
        foreach ($this->getValidators() as $key => $validator) {
            if (method_exists($validator, 'setTranslator')) {
                if (method_exists($validator, 'hasTranslator')) {
                    if (!$validator->hasTranslator()) {
                        $validator->setTranslator($translator);
                    }
                } else {
                    $validator->setTranslator($translator);
                }
            }

            if (method_exists($validator, 'setDisableTranslator')) {
                $validator->setDisableTranslator($this->translatorIsDisabled());
            }

            if ($isArray && is_array($value)) {
                $messages = array();
                $errors   = array();
                if (empty($value)) {
                    if ($this->isRequired()
                        || (!$this->isRequired() && !$this->getAllowEmpty())
                    ) {
                        $value = '';
                    }
                }
                foreach ((array)$value as $val) {
                    if (!$validator->isValid($val, $context)) {
                        $result = false;
                        if ($this->_hasErrorMessages()) {
                            $messages = $this->_getErrorMessages();
                            $errors   = $messages;
                        } else {
                            $messages = array_merge($messages, $validator->getMessages());
                            $errors   = array_merge($errors,   $validator->getErrors());
                        }
                    }
                }
                if ($result) {
                    continue;
                }
            } elseif ($validator->isValid($value, $context)) {
                continue;
            } else {
                $result = false;
                if ($this->_hasErrorMessages()) {
                    $messages = $this->_getErrorMessages();
                    $errors   = $messages;
                } else {
                    $messages = $validator->getMessages();
                    $errors   = array_keys($messages);
                }
            }

            $result          = false;
            $this->_messages = array_merge($this->_messages, $messages);
            $this->_errors   = array_merge($this->_errors,   $errors);

            if ($validator->zfBreakChainOnFailure) {
                break;
            }
        }

        // If element manually flagged as invalid, return false
        if ($this->_isErrorForced) {
            return false;
        }

        return $result;
    }
    
    /**
     * Default decorators
     *
     * Uses only 'Submit' decorators by default.
     *
     * @return Zend_Form_Element_Submit
     */
    public function loadDefaultDecorators()
    {
        if ($this->loadDefaultDecoratorsIsDisabled()) {
            return $this;
        }

        $decorators = $this->getDecorators();
        if (empty($decorators)) {
                 $this->addDecorator('Tooltip')
                      ->addDecorator('ViewHelper')
                      ->addDecorator('HtmlTag', array( 'tag' => 'div','class' => 'controls',
                            'id' => array('callback' => array(get_class($this),'resolveElementId'))
                    ));
                    
        }
        return $this;
    }
}
