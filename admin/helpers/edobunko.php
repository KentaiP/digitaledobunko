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
 * Edobunko component helper.
 *
 * @param   string  $submenu  The name of the active view.
 *
 * @return  void
 *
 * @since   1.6
 */
abstract class EdobunkoHelper extends JHelperContent
{
	/**
	 * Configure the Linkbar.
	 *
	 * @return Bool
	 */
 
	public static function addSubmenu($submenu) 
	{
		JHtmlSidebar::addEntry(
			JText::_('COM_EDOBUNKO_SUBMENU_MESSAGES'),
			'index.php?option=com_edobunko&view=edodocuments',
			$submenu == 'edodocuments'
		);
 
		JHtmlSidebar::addEntry(
			JText::_('COM_EDOBUNKO_SUBMENU_CATEGORIES'),
			'index.php?option=com_categories&view=categories&extension=com_edobunko',
			$submenu == 'categories'
		);
 
		// Set some global property
		$document = JFactory::getDocument();
		
		$document->addStyleDeclaration('.icon-edobunko ' .
										'{background-image: url(../media/com_edobunko/images/degijaplogo.jpg);}');
		
		if ($submenu == 'categories') 
		{
			$document->setTitle(JText::_('COM_EDOBUNKO_ADMINISTRATION_CATEGORIES'));
		}
	}
	
		/**	 
		* Get the actions	 
		*/	
		public static function getActions()	
			{			
			// Log usage of deprecated function
			try
			{
				JLog::add(
					sprintf('%s() is deprecated. Use JHelperContent::getActions() with new arguments order instead.', __METHOD__),
					JLog::WARNING,
					'deprecated'
				);
			}
			catch (RuntimeException $exception)
			{
				// Informational log only
			}

			// Get list of actions
			return JHelperContent::getActions('com_edobunko');
				
			}
}
?>