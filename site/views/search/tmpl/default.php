<?php
/** 
* @package     Joomla.Administrator 
* @subpackage  com_edobunko
* 
* @copyright   Copyright (C) 2017 Koray Birenheide 
*/ 

// No direct access to this file
defined('_JEXEC') or die('Restricted access'); 
jimport( 'joomla.methods' );

$document = JFactory::getDocument();

$style = '.indentleft15 {
	margin-left: 15px;
	}';
	
$document->addStyleDeclaration( $style );

$edosearch = JUri::base(true) . '/components/com_edobunko/models/css/search.css';

$document->addStyleSheet($edosearch);

?>
<h1><?php echo JText::_('COM_EDOBUNKO_SEARCH_TITLE'); ?></h1>
<form action="" method="post">
   <input name="searchword" type="text"  />
   <input type="submit" value="Search" />
   <p>
   <span class="indentleft15">
	   <select name="doctype" value="any">
			<option value="any" selected><?php echo JText::_('COM_EDOBUNKO_SEARCH_DOCTYPE_ANY'); ?></option>
			<option value="document"><?php echo JText::_('COM_EDOBUNKO_SEARCH_DOCTYPE_DOCUMENTS'); ?></option>
			<option value="map"><?php echo JText::_('COM_EDOBUNKO_SEARCH_DOCTYPE_MAPS'); ?></option>
			<option value="picture"><?php echo JText::_('COM_EDOBUNKO_SEARCH_DOCTYPE_PICTURES'); ?></option>
	   </select>
   </span>
   <span class="indentleft15"><?php echo JText::_('COM_EDOBUNKO_SEARCH_GETTITLES'); ?>:</span> <input type="radio" name="scope" value="title" checked="checked" />
   <span class="indentleft15"><?php echo JText::_('COM_EDOBUNKO_SEARCH_GETMETA'); ?>:</span> <input type="radio" name="scope" value="meta" />
   <span class="indentleft15"><?php echo JText::_('COM_EDOBUNKO_SEARCH_GETFULLTEXT'); ?>:</span> <input type="radio" name="scope" value="full" />
   <span class="indentleft15"><?php echo JText::_('COM_EDOBUNKO_SEARCH_GETANY'); ?>:</span> <input type="radio" name="scope" value="all" />
   </p>
   <input type="hidden" name="task" value="search" />
   <input type="hidden" name="option" value="com_edobunko" />
</form>

<?php 

if($this->search != null)
{
	$keyword = JRequest::getVar('searchword','');
	
	echo "<div class='results'>";
		echo "<table>";
		echo "<tbody>";
			echo "<tr class='resulttitlecard'>";
				echo "<td>";				
					echo JText::_('COM_EDOBUNKO_SEARCH_DOCTHUMB');
				echo "</td>";
				echo "<td>";
					echo JText::_('COM_EDOBUNKO_SEARCH_PAGETHUMB');	
				echo "</td>";
				echo "<td style='width: 100%;'>";
					echo JText::_('COM_EDOBUNKO_SEARCH_FULLRESULT');
				echo "</td>";
			echo "</tr>";
	
	$titlepool = array();
	
	foreach ($this->search->titles as $Edocument)
	{
	if (!in_array($Edocument->edoctitle, $titlepool) OR $this->search->scope != "title") 
		{
			
			if($this->search->scope == "title")
			{
				array_push($titlepool, $Edocument->edoctitle);
			}
			
			$overlaytojson = json_decode($Edocument->overlay);

				echo "<tr class='result'>";
					echo "<td>";
						echo "<a href='". JRoute::_("index.php?option=com_edobunko&view=edocumentviewer&title=". $Edocument->edocid, false) ."' title='". $Edocument->edoctitle ."'>";
							echo "<img src='" . JURI::base() . $Edocument->edolocation . '/Working Data/p1_files/t200.jpg' . "'/>" ;
						echo "</a>";
					echo "</td>";
					echo "<td>";
						echo "<a href='". JRoute::_("index.php?option=com_edobunko&view=edocumentviewer&title=". $Edocument->edocid, false) ."&page=". $Edocument->page ."' title='". $Edocument->edoctitle ."'>";
							echo "<img src='" . JURI::base() . $Edocument->edolocation . '/Working Data/p' . $Edocument->page . '_files/t200.jpg' . "'/>" ;
						echo "</a>";
					echo "</td>";
					echo "<td style='vertical-align: top;'>";
						echo "<a href='". JRoute::_("index.php?option=com_edobunko&view=edocumentviewer&title=". $Edocument->edocid, false) ."&page=". $Edocument->page ."'>". $Edocument->edoctitle ." (";
						echo JText::_('COM_EDOBUNKO_SEARCH_PAGE');
						echo " " . $Edocument->page . ")</a><br><b>";
						echo JText::_('COM_EDOBUNKO_SEARCH_OCCURENCES');
						echo ": </b>";
						if ($this->search->scope == ("full" OR "all"))
							{
								echo "[";
								$i = 0;
								foreach ($overlaytojson->objects as $line)
								{
									$getline = str_replace("[cbr]", "", $line->text);
									if ($this->search->scope == ("full" OR "all") AND strpos($getline, $keyword ) !== false) 
									{
										if($i != 0)
										{
										echo "...";	
										}
										
										echo str_replace($keyword, "<span style='color: red;'>". $keyword . "</span>", $getline);
										
										echo "...";
									
									}	
								}
							echo "]";
							}
					echo "</td>";
				echo "</tr>";
		}
	}
	
		echo "</tbody>";
		echo "</table>";
	echo "</div>";
}
?>