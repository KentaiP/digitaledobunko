<?php
/** 
* @package     Joomla.Administrator 
* @subpackage  com_edobunko
* 
* @copyright   Copyright (C) 2017 Koray Birenheide 
*/ 

// No direct access to this file
defined('_JEXEC') or die('Restricted access'); 

//$jqueryurl = JUri::base(true) . '/components/com_edobunko/models/jsscripts/jquery.js';
$juiurl = JUri::base(true) . '/components/com_edobunko/models/jsscripts/jqueryui/jquery-ui.js';
$juiurlcss = JUri::base(true) . '/components/com_edobunko/models/jsscripts/jqueryui/jquery-ui.css';
$jscolor = JUri::base(true) . '/components/com_edobunko/models/jsscripts/jscolor.min.js';
$fabricurl = JUri::base(true) . '/components/com_edobunko/models/jsscripts/fabric/fabric.adapted.js';
$seamainurl = JUri::base(true) . '/components/com_edobunko/models/jsscripts/openseadragon/openseadragon.min.js';
$sea2url = JUri::base(true) . '/components/com_edobunko/models/jsscripts/openseadragon/seadragonsvgoverlay.js';
$sea3url = JUri::base(true) . '/components/com_edobunko/models/jsscripts/openseadragon/bigtext.js';
$sea4url = JUri::base(true) . '/components/com_edobunko/models/jsscripts/openseadragon/seadragonfabric.js';
$sea5url = JUri::base(true) . '/components/com_edobunko/models/jsscripts/openseadragon/openseadragon-fabricjs-overlay.js';
$edobunko = JUri::base(true) . '/components/com_edobunko/models/css/edobunko.css';
$edoiconurl = JUri::base(true) . '/components/com_edobunko/models/css/icons';
$googleicons = 'https://fonts.googleapis.com/icon?family=Material+Icons';
$googlefontskokoro = 'https://fonts.googleapis.com/earlyaccess/kokoro.css';
$googlefontshannari = 'https://fonts.googleapis.com/earlyaccess/hannari.css';
$googlefontsawarbarimincho = 'https://fonts.googleapis.com/earlyaccess/sawarabimincho.css';
$segmenter = JUri::base(true) . '/components/com_edobunko/models/jsscripts/tiny_segmenter-0.2.js';
$bootstrapjs = JUri::base(true) . '/components/com_edobunko/models/jsscripts/bootstrap/js/bootstrap.min.js';
$bootstrapcss = JUri::base(true) . '/components/com_edobunko/models/jsscripts/bootstrap/css/bootstrap.min.css';
$bootstrapcsstheme = JUri::base(true) . '/components/com_edobunko/models/jsscripts/bootstrap/css/bootstrap-theme.min.css';
$rangycore = JUri::base(true) . '/components/com_edobunko/models/jsscripts/rangy/rangy-core.js';
$rangyclassapplier = JUri::base(true) . '/components/com_edobunko/models/jsscripts/rangy/rangy-classapplier.js';
$rangyhighlighter = JUri::base(true) . '/components/com_edobunko/models/jsscripts/rangy/rangy-highlighter.js';

//$viewerurl = JUri::base(true) . '/components/com_edobunko/models/jsscripts/viewer.js';

$document = JFactory::getDocument();
JHtml::_('jquery.framework');
//$document->addScript($jqueryurl);
$document->addStyleSheet($edobunko);
$document->addStyleSheet($googlefontskokoro);
$document->addStyleSheet($googlefontshannari);
$document->addStyleSheet($googlefontsawarbarimincho);
$document->addScript($juiurl);
$document->addStyleSheet($juiurlcss);
$document->addStyleSheet($googleicons);
$document->addStyleSheet($bootstrapcss);
$document->addStyleSheet($bootstrapcsstheme);
$document->addScript($jscolor);
$document->addScript($fabricurl);
$document->addScript($seamainurl);
$document->addScript($sea2url);
$document->addScript($sea3url);
$document->addScript($sea4url);
$document->addScript($sea5url);
$document->addScript($segmenter);
$document->addScript($bootstrapjs);
$document->addScript($rangycore);
$document->addScript($rangyclassapplier);
$document->addScript($rangyhighlighter);

//$document->addScript($viewerurl);

$app = JFactory::getApplication();
$menu = $app->getMenu();
$menurouteitem = $menu->getActive();
?>

<div class="edocumenteditwrapper">
<h1><?php echo $this->item->title; ?> <Button title="<?php echo JText::_('COM_EDOBUNKO_EDOCUMENTVIEWER_SAVE'); ?>" class="btngreensingle" onclick='saveoverlay()'><i class="material-icons md-24" >save</i></button>
</h1>
<div>
<button title="<?php echo JText::_('COM_EDOBUNKO_EDOCUMENTVIEWER_WHITEOVER_DESC'); ?>" class="btngreenleft" onclick="overlayopa(-5)"><i class="material-icons md-18" >layers</i><i class="material-icons md-18" >remove</i></button><div id='overlayslider' style="width: 8vw; display: inline-block;"> </div><button title="<?php echo JText::_('COM_EDOBUNKO_EDOCUMENTVIEWER_WHITEOVER_PLUS_DESC'); ?>" class="btngreenright" onclick="overlayopa(5)"><i class="material-icons md-18" >add</i></button>
</div>

<?php
if ($this->item->type == "document")
{
?>
<style>
.mapeditview 
{
display: none;
}
</style>
<?php
}
if ($this->item->type == "map")
{
?>
<style>
.documenteditview 
{
display: none;
}
</style>
<?php
}
?>

<div class="mapeditview">
<button type="button" id="btnRoof">Press here to start Draw</button>
<label style="color:blue"><b>Press double click to close shape and stop</b></label>
<button title="<?php echo JText::_('COM_EDOBUNKO_EDOCUMENTVIEWER_DELETELINE_DESC'); ?>" class="btngreensingle" onclick="deleteObject()" style="margin-left: 5px;"><i class="material-icons md-18" >delete_sweep</i></button>
</div>

<div class="documenteditview">
	<div>
	<div title="<?php echo JText::_('COM_EDOBUNKO_EDOCUMENTVIEWER_NEWLINE_DESC'); ?>" id="insertline1wrap"><input type='text' value='&#x30BB;&#x30EA;&#x30D5;' id="insertline1" onchange="updatefuri();"/></div><Button title="<?php echo JText::_('COM_EDOBUNKO_EDOCUMENTVIEWER_NEWLINE_ICON'); ?>" class="btngreenright" id="addline" onclick="addline();"><i class="material-icons md-18" style="transform: rotate(90deg);">playlist_add</i></button><button title="<?php echo JText::_('COM_EDOBUNKO_EDOCUMENTVIEWER_EDITLINE_DESC'); ?>" class="btngreensingle" onclick="startfabricedit()" style="margin-left: 5px;"><i class="material-icons md-18" >edit</i></button><button title="<?php echo JText::_('COM_EDOBUNKO_EDOCUMENTVIEWER_DELETELINE_DESC'); ?>" class="btngreensingle" onclick="deleteObject()" style="margin-left: 5px;"><i class="material-icons md-18" >delete_sweep</i></button><button title="<?php echo JText::_('COM_EDOBUNKO_EDOCUMENTVIEWER_FURI_DESC'); ?>" class="btngreenleft" onclick="editoverlay('furigana', 'set', jQuery('#furiganaline1').val());"style="margin-left: 5px;"><i class="material-icons md-18" style="transform: rotate(90deg);">short_text</i></button><input type='text' value='&#x30BB;&#x30EA;&#x30D5;' id="furiganaline1"/>
	</div>
	<div class="texteditwrap">
		<div id="fontfamilywrap" class="selectwrap" title="<?php echo JText::_('COM_EDOBUNKO_EDOCUMENTVIEWER_FONTFAMILY_DESC'); ?>">
		<select id="fontfamilyselect" onchange="editoverlay('fontFamily', 'set', jQuery('#fontfamilyselect').val());" >
		<option value="Hannari" style="font-family: Hannari;">Hannari (はんなり明朝)</option>
		<option value="Sawarabi Mincho" style="font-family: Sawarabi Mincho;">Sawarabi Mincho (さわらび明朝)</option>
		<option value="Kokoro" style="font-family: Kokoro;">Kokoro (こころ明朝)</option>
		<option value="Times New Roman" style="font-family: Times New Roman;" selected="true">Times New Roman</option> 
		</select>
		</div>
		<div class="buttongroup">
		<button title="<?php echo JText::_('COM_EDOBUNKO_EDOCUMENTVIEWER_LINESPACE_DESC'); ?>" class="btnlableleft "><i class="material-icons md-18" >format_line_spacing</i></button><button class="btngreenmid" onclick="editoverlay('lineHeight', '+-', 0.05);"><i class="material-icons md-18" >add</i></button><button class="btngreenright" onclick="editoverlay('lineHeight', '+-', -0.05);"><i class="material-icons md-18" >remove</i></button> 
		</div>
		<div class="buttongroup">
			<div id="colorsetwrap"><input title="<?php echo JText::_('COM_EDOBUNKO_EDOCUMENTVIEWER_COLORPICKER_DESC'); ?>" type='text' class="jscolor" value='000000' id='colorset'/></div><button title="<?php echo JText::_('COM_EDOBUNKO_EDOCUMENTVIEWER_COLORSETTER_DESC'); ?>" class="btngreenright" onclick="editoverlay('fill', 'set', '#' + jQuery('#colorset').val());"><i class="material-icons md-18">format_color_text</i></button>
		</div>
		<div class="buttongroup">	
			<button title="<?php echo JText::_('COM_EDOBUNKO_EDOCUMENTVIEWER_FONTPLUS_ICON'); ?>" class="btngreenleft" onclick="editoverlay('fontSize', '+-', 2);"><i class="material-icons md-18" >format_size</i></button><button title="<?php echo JText::_('COM_EDOBUNKO_EDOCUMENTVIEWER_FONTMINUS_ICON'); ?>" class="btngreenright" onclick="editoverlay('fontSize', '+-', -2);"><i class="material-icons md-18" >text_fields</i></button>
		</div>
		<div class="buttongroup">
			<button title="<?php echo JText::_('COM_EDOBUNKO_EDOCUMENTVIEWER_ROTATELEFT_ICON'); ?>" class="btngreenleft" onclick="editoverlay('angle', '+-', 2);"><i class="material-icons md-18" >rotate_right</i></button><button title="<?php echo JText::_('COM_EDOBUNKO_EDOCUMENTVIEWER_ROTATERIGHT_ICON'); ?>" class="btngreenright" onclick="editoverlay('angle', '+-', -2);"><i class="material-icons md-18" >rotate_left</i></button>
		</div>
		<div class="buttongroup">
			<button class="btngreenleft" onclick="editoverlay('skewX', '+-', -2);"><i class="material-icons md-18" >remove</i></button><button title="<?php echo JText::_('COM_EDOBUNKO_EDOCUMENTVIEWER_SKEWHORIZONTAL_DESC'); ?>" class="btnlablemid"><i class="material-icons md-18" >style</i></button><button class="btngreenright" onclick="editoverlay('skewX', '+-', 2);"><i class="material-icons md-18" >add</i></button>
		</div>
		<div class="buttongroup">
			<button class="btngreenleft" onclick="editoverlay('skewY', '+-', -2);"><i class="material-icons md-18" >remove</i></button><button title="<?php echo JText::_('COM_EDOBUNKO_EDOCUMENTVIEWER_SKEWVERTICAL_DESC'); ?>" class="btnlablemid"><i class="material-icons md-18" style="transform: rotate(90deg);" >style</i></button><button class="btngreenright" onclick="editoverlay('skewY', '+-', 2);"><i class="material-icons md-18" >add</i></button>
		</div>
	</div>

	<div class="texteditwrap">
		<div class="buttongroup">
		<button title="<?php echo JText::_('COM_EDOBUNKO_EDOCUMENTVIEWER_IDCHANGE_DESC'); ?>" class="btnlableleft "><i class="material-icons md-18" style="transform: rotate(90deg);">format_line_spacing</i></button><button class="btngreenmid" onclick="idup(1)"><i class="material-icons md-18" style="transform: rotate(90deg);">file_download</i></button><button class="btngreenright" onclick="idup(-1)"><i class="material-icons md-18" style="transform: rotate(90deg);">file_upload</i></button> 
		</div>
		<div class="buttongroup">	
			<button title="<?php echo JText::_('COM_EDOBUNKO_EDOCUMENTVIEWER_LINEBREAK_DESC'); ?>" class="btnlableleft "><i class="material-icons md-18" style="transform: rotate(90deg);">wrap_text</i></button><button title="<?php echo JText::_('COM_EDOBUNKO_EDOCUMENTVIEWER_IDCHANGECHECKBOX_DESC'); ?>" class="btngreenright" onclick="switchbreak();"><i class="material-icons md-18" id="breakcheckbox" >check_box_outline_blank</i></button>
		</div>
		<div class="buttongroup">	
			<button title="<?php echo JText::_('COM_EDOBUNKO_EDOCUMENTVIEWER_IDTOGGLE_DESC'); ?>" class="btnlableleft "><i class="material-icons md-18" style="transform: rotate(90deg);">storage</i></button><button title="<?php echo JText::_('COM_EDOBUNKO_EDOCUMENTVIEWER_IDTOGGLEBOX_DESC'); ?>" class="btngreenright" onclick="switchids();"><i class="material-icons md-18" id="idtogglecheckbox" >check_box</i></button>
		</div>
		<div class="buttongroup">	
			<button title="<?php echo JText::_('COM_EDOBUNKO_EDOCUMENTVIEWER_DISPLAY_DESC'); ?>" class="btnlableleft "><i class="material-icons md-18">visibility</i></button><button title="<?php echo JText::_('COM_EDOBUNKO_EDOCUMENTVIEWER_DISPLAYTOGGLEBOX_DESC'); ?>" class="btngreenright" onclick="toggleobject();"><i class="material-icons md-18" id="displaytogglecheckbox" >check_box</i></button>
		</div>
		<div class="buttongroup">	
			<button title="<?php echo JText::_('COM_EDOBUNKO_EDOCUMENTVIEWER_MULTISELECT'); ?>" class="btnlableleft "><i class="material-icons md-18">flip_to_back</i></button><button title="<?php echo JText::_('COM_EDOBUNKO_EDOCUMENTVIEWER_MULTISELECT_DESC'); ?>" class="btngreenright" onclick="togglemulti();"><i class="material-icons md-18" id="multitogglecheckbox" >check_box_outline_blank</i></button>
		</div>
	</div>
	</div>
	
	<div class="edocumentviewcenter">
		<div class="edocumentviewwrapper">
			<div class="zoomthumbwrapper">
				<div id="openseadragon1" class="documentzoomwrapper"></div>
				<div class="thumbswitch">
				<button id="teithumbswitch" onclick="teithumbswitch();">TEI</button>
				</div>
				<div class="thumb-wrapper" id="pagesthumb">
				<div teitype="persName" class="teithumbwrap" style="background: url('<?php echo JUri::base(true) . '/components/com_edobunko/models/css/images/' ?>persname.png'); background-size: 100% 100%;">
					</div>
					<div teitype="placeName" teisub="notag" class="teithumbwrap" style="background: url('<?php echo JUri::base(true) . '/components/com_edobunko/models/css/images/' ?>placename.png'); background-size: 100% 100%;">
					</div>
					<div teitype="name" teisub="notag" class="teithumbwrap" style="background: url('<?php echo JUri::base(true) . '/components/com_edobunko/models/css/images/' ?>generalname.png'); background-size: 100% 100%;">
					</div>
					<div teitype="span" teisub="figure" class="teithumbwrap" style="background: url('<?php echo JUri::base(true) . '/components/com_edobunko/models/css/images/' ?>figure.png'); background-size: 100% 100%;">
					</div>
					<div teitype="span" teisub="custom" class="teithumbwrap" style="background: url('<?php echo JUri::base(true) . '/components/com_edobunko/models/css/images/' ?>custom.png'); background-size: 100% 100%;">
					</div>
				</div>
				<div class="teitype">
				<input style="display: none; background: #91CAFF; text-align: center; height: 100%; width: 100%;" value="<?php echo JText::_('COM_EDOBUNKO_EDOCUMENTVIEWER_TEI_TEITYPEBOXDEFUALT'); ?>" id="teisubinput" onchange="setteisub();"/>
				</div>
				<div class="teislot">
				
				</div>
			</div>
			<div class="plaintextwrapper">
			<div class="textswitchbutton">
				<button id="plaintextswitchleft" onclick="plaintextswitch('left');" class="btnlableleft"><?php echo JText::_('COM_EDOBUNKO_EDOCUMENTVIEWER_PLAINTEXT_BUTTON'); ?></button><button id="plaintextswitchcenter" onclick="plaintextswitch('mid');" class="btngreenmid"><?php echo JText::_('COM_EDOBUNKO_EDOCUMENTVIEWER_SEGTEXT_BUTTON'); ?></button><button class="btngreenright" id="plaintextswitchright" onclick="plaintextswitch('right');" ><?php echo JText::_('COM_EDOBUNKO_EDOCUMENTVIEWER_TEITEXT_BUTTON'); ?></button>
				<a title="<?php echo JText::_('COM_EDOBUNKO_EDOCUMENTVIEWER_TEITEXT_EXTDISPLAY'); ?>" href="<?php echo JUri::getInstance() . "?format=xml";?>" id="teidirect" target="_blank"><Button class="btngreensingle"><i class="material-icons md-12" >launch</i></button></a>
				<a href="<?php echo JUri::getInstance() . "?format=xml&download=1";?>" id="teidl" target="_blank"><Button title="<?php echo JText::_('COM_EDOBUNKO_EDOCUMENTVIEWER_TEITEXT_EXTDL'); ?>" class="btngreensingle"><i class="material-icons md-12" >file_download</i></button></a>
				<button title="<?php echo JText::_('COM_EDOBUNKO_EDOCUMENTVIEWER_JISHO_TOGGLE'); ?>" class="btngreenleft" onclick="toggletranslation()" id="jishobutton"><i class="material-icons md-12" >local_library</i></button><button id="popupbutton" title="<?php echo JText::_('COM_EDOBUNKO_EDOCUMENTVIEWER_NO_POPOVER'); ?>" class="btnlablemid" onclick="closepopup()"><i class="material-icons md-12" >pause</i></button><button id="commentbutton" title="<?php echo JText::_('COM_EDOBUNKO_EDOCUMENTVIEWER_COMMENT_TOGGLE'); ?>" class="btngreenright" onclick="togglecomment()"><i class="material-icons md-12" >speaker_notes</i></button>	
				<button title="<?php echo JText::_('COM_EDOBUNKO_EDOCUMENTVIEWER_IDSHUFFLE'); ?>"class="btngreensingle" id="resort" onclick="idresort();"><i class="material-icons md-12" >shuffle</i></button>
				
			</div>
			<div class="teiselectionmaker">
			<button onclick="buildinlinerange(-1,false,false,false)" >←</button><input id="selectionrangemakerlower" type="text" style="text-align: center;" size="1" value="0"/><button onclick="buildinlinerange(1,false,false,false)" >→</button>Construct In-Text Selection for Word Tagging<button onclick="buildinlinerange(false,-1,false,false)" >←</button><input id="selectionrangemakerupper" type="text" style="text-align: center;" size="1" value="0"/><button onclick="buildinlinerange(false,1,false,false)" >→</button>
			</div>
			<div id="plaintext"></div>
			<div id="teitext"></div>
			<div id="segtext"></div>
			</div>
		</div>
	</div>

</div>
	
<div class="bleach" id="example-overlay"></div>
<form method="post" action="<?php echo JUri::base(true); ?>/index.php?option=com_edobunko" name="saveoverview" id="saveoverview">
<input type="hidden" value="<?php echo $this->item->id; ?>" name="id"/>
<input type="hidden" value='<?php echo $this->item->overlay; ?>' name="docoverlay" id="overlayinput"/>
<input type="hidden" value="<?php echo JUri::getInstance()->getPath() . "/?" . JUri::getInstance()->getQuery(); ?>" name="menurouter"/>
<input type="hidden" name="option" value="com_edobunko" />
<input type="hidden" name="task" value="edocumentviewer.saveoverlay" />
</form>
<div class="notetip" id="jishonote"><div class="notetiptextwrapper"><h3><a title="<?php echo JText::_('COM_EDOBUNKO_EDOCUMENTVIEWER_JISHO_CHECKLINK_DESC'); ?>" href="http://www.jisho.org" id="jishodirect" target="_blank"><Button class="btngreensingle"><i class="material-icons md-12" >launch</i></button></a><a style="margin-left: 5px;" title="<?php echo JText::_('COM_EDOBUNKO_EDOCUMENTVIEWER_JISHO_DESC'); ?>" href="http://www.jisho.org" target="_blank">Jisho.org</a> <?php echo JText::_('COM_EDOBUNKO_EDOCUMENTVIEWER_JISHO_ENTRIES'); ?> </h3><div class="notetiptext draggcancel"></div></div><i class="material-icons dragable" title="<?php echo JText::_('COM_EDOBUNKO_EDOCUMENTVIEWER_JISHO_DRAGGABLE_DESC'); ?>">open_with</i></div>
<div class="notetip" id="commentnote" style="overflow: hidden;"><h2 style="width: 100%; max-height: 20%;"><?php echo JText::_('COM_EDOBUNKO_EDOCUMENTVIEWER_COMMENT'); ?></h2><textarea onchange="setcomment();" class="commentnotetext draggcancel" style="width: 100%; height: 70%;"></textarea><button style="width: 100%; height: 10%;"><?php echo JText::_('COM_EDOBUNKO_EDOCUMENTVIEWER_COMMIT'); ?></button></div>
<script type="text/javascript">

<?php 
echo $this->viewerscript;
?>

jQuery(function(){

jQuery.widget.bridge('uibutton', jQuery.ui.button);
jQuery.widget.bridge('uitooltip', jQuery.ui.tooltip);
	
jQuery(".teithumbwrap").draggable({
								helper: "clone",
								start: function(e, ui)
										 {
										  jQuery(ui.helper).css("width", "93px");
										  jQuery(ui.helper).css("height", "140px");
										  jQuery(ui.helper).css("padding-top", "0");
										  jQuery(".teislot").css("background", "#FFFEA3");
										 },
								stop: function(e, ui)
										 {
										 var teislotstatecheck = jQuery(".teislot").css("background-color");
									
										 if(teislotstatecheck == "rgb(173, 255, 205)")
											{
											var newteitype = jQuery(ui.helper).attr("teitype");
											var newteisub = jQuery(ui.helper).attr("teisub");
											
											jQuery("#teisubinput").val(newteisub);
											
											teithumb = newteitype.toLowerCase();
											if (teithumb == "span")
											{
												if (newteisub == "figure")
												{
												teithumb = "figure";		
												}
												else
												{
												teithumb = "custom";		
												}
												
											}
											if (teithumb == "name")
											{
											teithumb = "generalname";	
											}
											
											makeittei(newteitype, newteisub);

											jQuery(".teislot").empty();											
											jQuery(".teislot").append("<img src=\"<?php echo JUri::base(true); ?>/components/com_edobunko/models/css/images/" + teithumb +".png\" style=\"cursor: url(<?php echo JUri::base(true); ?>/components/com_edobunko/models/css/icons/delcursor.png), no-drop; margin-top: 2%; border: 1px solid grey;\" height=\"96%\" onclick=\"removetei();\" />");
											
											jQuery("#line" + overlay.fabricCanvas().getActiveObject().get("id")).addClass("tei" + teithumb + "Style");
											calculateplaintext();
											}
										  
										  jQuery(".teislot").css("background", "#fff");
										 }
							});	

jQuery(".teislot").droppable({
								over: function( event, ui ) {
															if (active == "none")
																{
																jQuery(".teislot").css("background", "#FF3538");
																}														
																else
																{
																jQuery(".teislot").css("background", "rgb(173, 255, 205)");
																}
															},
								out:  function( event, ui ) {
																jQuery(".teislot").css("background", "#FFFEA3");
															}
															
							});								
	
jQuery( "body" ).uitooltip({
  classes: {
    "ui-tooltip": "ui-corner-all ui-widget-shadow tooltipdimensions"
  },
  items: ':not(.vertical)',
  content: function () {
        return this.getAttribute("title");
    },
  position: {
        my: "center bottom-20", // the "anchor point" in the tooltip element
        at: "center top", // the position of that anchor point relative to selected element
	}
	});

<?php

if(JRequest::getVar('page','') != null)
	{
	echo "gotopage(". JRequest::getVar('page','') .");";
	}

?>	
	
				jQuery("#selectionrangemakerlower").on("change keyup paste input", function() 
				{
					buildinlinerange(false,false,jQuery(this).val(),false);
				});
				jQuery("#selectionrangemakerupper").on("change keyup paste input", function() 
				{
					buildinlinerange(false,false,false,jQuery(this).val());
				});	
	
});

</script>
