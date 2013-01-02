<?php 
class Bootstrap_Form_Utils
{

	public static function isError($element)
	{
		if ($element->hasErros()) {
			return 'error';
		} 
		return '';
	 }
}