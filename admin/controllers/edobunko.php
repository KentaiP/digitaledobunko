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
 * Edobunko Controller
 *
 * @package     Joomla.Administrator
 * @subpackage  com_edobunko
 * @since       0.0.9
 */
class EdobunkoControllerEdobunko extends JControllerForm
{
	/**	
	* Implement to allowAdd or not	
	*	
	* Not used at this time (but you can look at how other components use it....)	
	* Overwrites: JControllerForm::allowAdd	
	*	
	* @param array $data	
	* @return bool	
	*/	
	protected function allowAdd($data = array())	
	{		
	return parent::allowAdd($data);	
	}	
	
	/**	
	* Implement to allow edit or not	
	* Overwrites: JControllerForm::allowEdit	
	*	
	* @param array $data	
	* @param string $key	
	* @return bool	
	*/	
	protected function allowEdit($data = array(), $key = 'id')	
	{		
	$id = isset( $data[ $key ] ) ? $data[ $key ] : 0;		if( !empty( $id ) )		
		{			
			return JFactory::getUser()->authorise( "core.edit", "com_edobunko.document." . $id );		
		}	
	}
	
	public function apply()
	{
		$title = JText::_('COM_EDOBUNKO_MANAGER_EDODOCUMENTS');
		JToolBarHelper::title($title);
		
	}
	
	
	public function remove($key = null, $urlVar = null) {
		$return = parent::remove($key, $urlVar);
		$this->setRedirect(JRoute::_('index.php?option=com_edobunko&view=edodocuments'));
		return $return;
	}
	
	public function cancel($key = null, $urlVar = null) {
		$return = parent::cancel($key, $urlVar);
		$this->setRedirect(JRoute::_('index.php?option=com_edobunko&view=edodocuments'));
		return $return;
	}
	
	public function save($key = null, $urlVar = null) {
		$return = parent::save($key, $urlVar);
		$this->setRedirect(JRoute::_('index.php?option=com_edobunko&view=edodocuments'));
		return $return;
	}
	

}
?>