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
class JFormFieldEdocumentviewer extends JFormFieldList
{
	/**
	 * The field type.
	 *
	 * @var         string
	 */
	protected $type = 'Edocumentviewer';
 
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
		$titles = $db->loadObjectList();
		$options  = array();
		
		foreach ($titles as $title)
		{
			$optionshtml = '<option value="'. $title->id .'">'. $title->title .'</option>';
		}
 
		return $optionshtml;
	}
}
?>