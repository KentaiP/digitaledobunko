<?php
/** 
* @package     Joomla.Administrator 
* @subpackage  com_edobunko
* 
* @copyright   Copyright (C) 2017 Koray Birenheide 
*/ 
// No direct access to this file
defined('_JEXEC') or die('Restricted access'); 

// Get an instance of the controller prefixed by Edobunko
$controller = JControllerLegacy::getInstance('Edobunko'); 

// Perform the Request task
$input = JFactory::getApplication()->input;
$controller->execute($input->getCmd('task')); 

// Redirect if set by the controller
$controller->redirect();