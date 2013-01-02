<?php

class Bootstrap_Form_Element extends Zend_Form_Element
{
	
    /**
     * Load default decorators
     *
     * @return Zend_Form_Element
     */
    public function loadDefaultDecorators ()
    {
        if ($this->loadDefaultDecoratorsIsDisabled()) {
            return $this;
        }
        
        $makeImg = function($content, $element, array $options) {
        	return '<img src="/images/' . $options['img'] . '" class="' . $options['class'] . ' " alt=""/> ';
        };
        
        $decorators = $this->getDecorators();
        if (empty($decorators)) {
            $this->addDecorator('ViewHelper')
                ->addDecorator('Errors', array('class' => 'help-inline'))
                ->addDecorator('Description', array('class' => 'help-block'))
                ->addDecorator('HtmlTag', array( 'tag' => 'div','class' => 'controls',
                           		 'id' => array(
                                    'callback' => array(get_class($this),'resolveElementId'
                                    )
                            )
                    ))
                ->addDecorator('Label', array('class' => 'control-label'))
                ->addDecorator(array('row' => 'HtmlTag'),array('tag' => 'div','class' => array( 'callback' => array('Bootstrap_Helpers', 'getClasses'))));
        }
        return $this;
    }
    
    public function render(Zend_View_Interface $view = null)
    {
    	if ($this->hasErrors()) {
    	    $this->class = (null == $this->class) ? 'error' : $this->class.' error'; 
    	}
        if ($this->_isPartialRendering) {
            return '';
        }

        if (null !== $view) {
            $this->setView($view);
        }

        $content = '';
        foreach ($this->getDecorators() as $decorator) {
            $decorator->setElement($this);
            $content = $decorator->render($content);
        }
        return $content;
    }
}
