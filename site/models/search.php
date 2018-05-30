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
 
class EdobunkoModelSearch extends JModelItem
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
			//$jinput = JFactory::getApplication()->input;		
			//$id     = $jinput->get('id', 1, 'INT');		
			//$this->setState('document.id', $id); 		
			
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
	 
	public function getSearchDocuments()
	{	
		if (!isset($this->search)) 
		{
			$keyword = JRequest::getVar('searchword','');
			$searchscope = JRequest::getVar('scope','');
			$doctype = JRequest::getVar('doctype','');
			
			if($keyword != null OR ($doctype != "any" AND $doctype != null))
			{
			$this->search->scope = $searchscope;	
			
			$sift = null;
			$siftfull = '1 = 0';
			
				if ($this->search->scope == "title")
				{
					$sift = 'h.title LIKE "%' . $keyword . '%"';
				}
				elseif ($this->search->scope == "meta")
				{
					$sift = 'h.publicationStmt LIKE "%' . $keyword . '%" 
								OR h.sourceDesc LIKE "%' . $keyword . '%"';
				}
				elseif ($this->search->scope == "full")
				{
					$sift = '(replace(d.overlay, "[cbr]", "")) LIKE "%\"text\":\"%' . $keyword . '%\",%"';
				}
				elseif ($this->search->scope == "all")
				{
					$sift = 'h.title LIKE "%' . $keyword . '%"
								OR h.publicationStmt LIKE "%' . $keyword . '%" 
								OR h.sourceDesc LIKE "%' . $keyword . '%"
								OR (replace(d.overlay, "[cbr]", "")) LIKE "%\"text\":\"%' . $keyword . '%\",%"';
				}
				
				$db    = JFactory::getDbo();
				$query = $db->getQuery(true);
				$query->select('d.id, d.parentid, d.page, d.overlay, h.title as edoctitle, h.id as edocid, h.params as edocparams, h.type as edoctype, h.publicationStmt as edocpublicationStmt, h.sourceDesc as edocsourceDesc, h.location as edolocation, c.title as category')
					  ->from('#__edobunko_pages as d')
					  ->leftJoin('#__edobunko as h ON d.parentid=h.id')
					  ->leftJoin('#__categories as c ON h.catid=c.id')
					  ->where($sift);
					  
				$db->setQuery((string)$query);
				
				$this->search->titles = $db->loadObjectList();
			
			}
			else
			{
				$this->search = null;
			}
		}
		return $this->search;
	}
}

?>