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
 * Edobunko Component Controller
 *
 * @since  0.0.1
 */
class EdobunkoControllerEdocumentviewer extends JControllerLegacy
{
	
	function saveoverlay()
	{
   
	$jinput = JFactory::getApplication()->input;
	$getnewoverlay = $jinput->get('docoverlay', '', '');
	$documentid = $jinput->get('id', '', '');
	$menurouter = $jinput->get('menurouter', '', '');
	
	$overlays = explode("§explode§", $getnewoverlay);
	
	$db = JFactory::getDbo();
	
	$page = 1;
	
	foreach ($overlays as $overlay)
	{
		$query = $db->getQuery(true);	
		$fields = array(
		$db->quoteName('overlay') . ' = ' . $db->quote($overlay)
		);
		$conditions = array(
		$db->quoteName('parentid') . ' = ' . $documentid,
		$db->quoteName('page') . ' = ' . $page
		);
		
		$query->update($db->quoteName('#__edobunko_pages'))->set($fields)->where($conditions);
 
		// Set the query using our newly populated query object and execute it.
		$db->setQuery($query);	
		
		$db->execute();
		
		if ($db->getErrorNum()) {
        JError::raiseWarning(500, $db->getErrorMsg());
		}
	
	$page++;
	}

	$this->setRedirect($menurouter);
	#$this->redirect();

	}


}

?>