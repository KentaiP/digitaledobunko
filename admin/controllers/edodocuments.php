<?php
/** 
* @package     Joomla.Administrator 
* @subpackage  com_edobunko
* 
* @copyright   Copyright (C) 2017 Koray Birenheide 
*/ 

// No direct access to this file
defined('_JEXEC') or die('Restricted access'); 
 
/**
 * EdoBunko Controller
 *
 * @since  0.0.1
 */
class EdobunkoControllerEdoDocuments extends JControllerAdmin
{
	/**
	 * Proxy for getModel.
	 *
	 * @param   string  $name    The model name. Optional.
	 * @param   string  $prefix  The class prefix. Optional.
	 * @param   array   $config  Configuration array for model. Optional.
	 *
	 * @return  object  The model.
	 *
	 * @since   1.6
	 */
	 
	public function getModel($name = 'Edobunko', $prefix = 'EdobunkoModel', $config = array('ignore_request' => true))
	{
		$model = parent::getModel($name, $prefix, $config);
 
		return $model;
	}
	
	public function add() 
	{
		
		echo "test";
		
		$title = JText::_('COM_EDOBUNKO_MANAGER_EDODOCUMENTS');
		JToolBarHelper::title($title);
		
		
	}
}
?>