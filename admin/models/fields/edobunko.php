<?php
/** 
* @package     Joomla.Administrator 
* @subpackage  com_edobunko
* 
* @copyright   Copyright (C) 2017 Koray Birenheide 
*/ 

// No direct access to this file
defined('_JEXEC') or die('Restricted access'); 
 
JFormHelper::loadFieldClass('list');
 
/**
 * Edobunko Form Field class for the Edobunko component
 *
 * @since  0.0.1
 */
class JFormFieldEdobunko extends JFormFieldList
{
	/**
	 * The field type.
	 *
	 * @var         string
	 */
	protected $type = 'Edobunko';
 
	/**
	 * Method to get a list of options for a list input.
	 *
	 * @return  array  An array of JHtml options.
	 */
	protected function getOptions()
	{
		$db    = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select('#__edobunko.id as id,#__edobunko.title,#__categories.title as category,catid');
		$query->from('#__edobunko');
		$query->leftJoin('#__categories on catid=#__categories.id');		
		
		// Retrieve only published items		
		$query->where('#__edobunko.published = 1');
		$db->setQuery((string) $query);
		$title = $db->loadObjectList();
		$options  = array();
 
		if ($documents)
		{
			foreach ($documents as $document)
			{
				$options[] = JHtml::_('select.option', $document->id, $document->title .				        
				($document->catid ? ' (' . $document->category . ')' : ''));
			}
		}
 
		$options = array_merge(parent::getOptions(), $options);
 
		return $options;
	}
}
?>