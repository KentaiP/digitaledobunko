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
 * Edobunko Model
 *
 * @since  0.0.1
 */
 
class EdobunkoModelEdobunko extends JModelItem
{
	/**	 
	* @var object item	 
	*/	
	
	protected $item; 
	
	/**	 
	* Method to auto-populate the model state.	 
	*	 
	* This method should only be called once per instantiation and is designed	 
	* to be called on the first call to the getState() method unless the model	 
	* configuration flag to ignore the request is set.	 
	*	 
	* Note. Calling getState in this method will result in recursion.	 
	*	 
	* @return	void	 
	* @since	2.5	 
	*/	
	
	protected function populateState()	
		{	
			// Get the document id		
			$jinput = JFactory::getApplication()->input;		
			$id     = $jinput->get('id', 1, 'INT');		
			$this->setState('document.id', $id); 		
			
			// Load the parameters.		
			$this->setState('params', JFactory::getApplication()->getParams());		
			parent::populateState();	
		}
		
		
	/**
	 * Method to get a table object, load it if necessary.
	 *
	 * @param   string  $type    The table name. Optional.
	 * @param   string  $prefix  The class prefix. Optional.
	 * @param   array   $config  Configuration array for model. Optional.
	 *
	 * @return  JTable  A JTable object
	 *
	 * @since   1.6
	 */
	public function getTable($type = 'Edobunko', $prefix = 'EdobunkoTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}
 
	/**	 
	 * Get the document
	 * @return object The document to be displayed to the user
	 */
	 
	public function getItem()
	{
		if (!isset($this->item)) 
		{
			$id    = $this->getState('document.id');
			$db    = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('h.title, h.params, c.title as category')
				  ->from('#__edobunko as h')
				  ->leftJoin('#__categories as c ON h.catid=c.id')
				  ->where('h.id=' . (int)$id);
			$db->setQuery((string)$query);
 
			if ($this->item = $db->loadObject()) 
			{
				// Load the JSON string
				$params = new JRegistry;
				$params->loadString($this->item->params, 'JSON');
				$this->item->params = $params;
 
				// Merge global params with item params
				$params = clone $this->getState('params');
				$params->merge($this->item->params);
				$this->item->params = $params;
			}
		}
		return $this->item;
	}
}

?>