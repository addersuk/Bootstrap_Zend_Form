<?php

class Bootstrap_Form_Element_MultiCheckbox extends Bootstrap_Form_Element_Multi
{
	
	public function init() 
	{
		$this->setAttrib('label_class', 'checkbox');
	}	
    /**
     * Use formMultiCheckbox view helper by default
     * 
     * @var string
     */
    public $helper = 'formMultiCheckbox';

    /**
     * MultiCheckbox is an array of values by default
     * 
     * @var bool
     */
    protected $_isArray = true;
}
