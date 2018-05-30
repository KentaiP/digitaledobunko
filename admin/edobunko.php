<?php
/** 
* @package     Joomla.Administrator 
* @subpackage  com_edobunko
* 
* @copyright   Copyright (C) 2017 Koray Birenheide 
*/ 

// No direct access to this file
defined('_JEXEC') or die('Restricted access'); 

// Access check: is this user allowed to access the backend of this component?
if (!JFactory::getUser()->authorise('core.manage', 'com_edobunko')) 
{
	throw new Exception(JText::_('JERROR_ALERTNOAUTHOR'));
}

// Set some global property
$document = JFactory::getDocument();

$document->addStyleDeclaration('.icon-edobunko {background-image: url(../media/com_edobunko/images/degijaplogo.jpg);}'); 
 
// Access check: is this user allowed to access the backend of this component?
if (!JFactory::getUser()->authorise('core.manage', 'com_edobunko'))
{	
	throw new Exception(JText::_('JERROR_ALERTNOAUTHOR'));
}  
 
// Require helper file
JLoader::register('EdobunkoHelper', JPATH_COMPONENT . '/helpers/edobunko.php');  
 
// Get an instance of the controller prefixed by Edobunko
$controller = JControllerLegacy::getInstance('Edobunko');
 
// Perform the Request task
$controller->execute(JFactory::getApplication()->input->get('task'));
 
// Redirect if set by the controller
$controller->redirect();
?>