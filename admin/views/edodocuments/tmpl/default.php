<?php
/** 
* @package     Joomla.Administrator 
* @subpackage  com_edobunko
* 
* @copyright   Copyright (C) 2017 Koray Birenheide 
*/ 

// No direct access to this file
defined('_JEXEC') or die('Restricted access'); 

JHtml::_('formbehavior.chosen', 'select'); 
$listOrder     = $this->escape($this->filter_order);
$listDirn      = $this->escape($this->filter_order_Dir); 
?>
<form action="<?php echo JRoute::_('index.php?option=com_edobunko'); ?>" method="post" id="adminForm" name="adminForm">
	<div class="row-fluid">		
		<div class="span6">			
			<?php echo JText::_('COM_EDOBUNKO_EDODOCUMENTS_FILTER'); ?>			
			<?php				
				echo JLayoutHelper::render(					
					'joomla.searchtools.default',					
					array('view' => $this)				
				);			
			?>	
			<?php //echo $this->sidebar ?>	
		</div>	
	</div>
	<table class="table table-striped table-hover">
		<thead>
		<tr>
			<th width="1%"><?php echo JText::_('COM_EDOBUNKO_NUM'); ?></th>
			<th width="2%">
				<?php echo JHtml::_('grid.checkall'); ?>
			</th>
			<th width="90%">
				<?php echo JHtml::_('grid.sort', 'COM_EDOBUNKO_EDOBUNKO_NAME', 'title', $listDirn, $listOrder) ;?>
			</th>
			<th width="5%">
				<?php echo JHtml::_('grid.sort', 'COM_EDOBUNKO_PUBLISHED', 'published', $listDirn, $listOrder); ?>
			</th>
			<th width="2%">
				<?php echo JHtml::_('grid.sort', 'COM_EDOBUNKO_ID', 'id', $listDirn, $listOrder); ?>
			</th>
		</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="5">
					<?php echo $this->pagination->getListFooter(); ?>
				</td>
			</tr>
		</tfoot>
		<tbody>
			<?php if (!empty($this->items)) : ?>
				<?php foreach ($this->items as $i => $row) : 
					$link = JRoute::_('index.php?option=com_edobunko&task=edobunko.edit&id=' . $row->id);
				?>
 
					<tr>
						<td>
							<?php echo $this->pagination->getRowOffset($i); ?>
						</td>
						<td>
							<?php echo JHtml::_('grid.id', $i, $row->id); ?>
						</td>
						<td>
							<a href="<?php echo $link; ?>" title="<?php echo JText::_('COM_EDOBUNKO_EDIT_EDOBUNKO'); ?>">
							<?php echo $row->title; ?>
						</td>
						<td align="center">
							<?php echo JHtml::_('jgrid.published', $row->published, $i, 'edodocuments.', true, 'cb'); ?>
						</td>
						<td align="center">
							<?php echo $row->id; ?>
						</td>
					</tr>
				<?php endforeach; ?>
			<?php endif; ?>
		</tbody>
	</table>
	<input type="hidden" name="option" value="com_edobunko" />
	<input type="hidden" name="task" value=""/>	
	<input type="hidden" name="boxchecked" value="0"/>	
	<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>"/>	
	<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>"/>
	<?php echo JHtml::_('form.token'); ?>
</form>