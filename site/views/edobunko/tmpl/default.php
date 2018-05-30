<?php
/** 
* @package     Joomla.Administrator 
* @subpackage  com_edobunko
* 
* @copyright   Copyright (C) 2017 Koray Birenheide 
*/ 

// No direct access to this file
defined('_JEXEC') or die('Restricted access'); 
?>
<h1><?php echo JText::_('COM_EDOBUNKO_EDOBUNKO_SEARCH_TITLE'); ?></h1>
<form action="index.php" method="post">
   <input name="searchword" type="text"  />
   <input type="submit" value="Search" />
   <input type="hidden" name="task" value="search" />
   <input type="hidden" name="option" value="com_edobunko" />
</form>