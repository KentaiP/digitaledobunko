<?php
/** 
* @package     Joomla.Administrator 
* @subpackage  com_edobunko
* 
* @copyright   Copyright (C) 2017 Koray Birenheide 
*/ 

// No direct access to this file
defined('_JEXEC') or die('Restricted access'); 

$document = JFactory::getDocument();

JHtml::_('jquery.framework');
$app = JFactory::getApplication();

$jinput = JFactory::getApplication()->input;
$dl = $jinput->get('download');

if ($dl == 1)
	{
		JResponse::setHeader('Content-Type', 'application/octet-stream');
		JResponse::setHeader('Content-Disposition', 'attachment;filename="title.xml"');
	}

	echo $this->viewxml;
	
?>