<?php

class Bootstrap_Helpers {

	public static function getClasses($tag)
    {
    	if ($tag->getElement()->hasErrors()) {
    		return 'control-group error';
    	} else {
			return 'control-group';
    	}
    }
}
