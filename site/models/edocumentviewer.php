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
 * Edobunko Model
 *
 * @since  0.0.1
 */
 
class EdobunkoModelEdocumentviewer extends JModelItem
{
	/**	 
	* @var object item	 
	*/	
	
	protected $item; 
	
	/**	 
	* Method to auto-populate the model state.	 
	*	 
	* This method should only be called once per instantiation and is designed	 
	* to be called on the first call to the getState() method unless the model	 
	* configuration flag to ignore the request is set.	 
	*	 
	* Note. Calling getState in this method will result in recursion.	 
	*	 
	* @return	void	 
	* @since	2.5	 
	*/	
	
	protected function populateState()	
		{	
			// Get the document id		
			$jinput = JFactory::getApplication()->input;		
			$id     = $jinput->get('id', 1, 'INT');		
			$this->setState('document.id', $id); 		
			
			// Load the parameters.		
			$this->setState('params', JFactory::getApplication()->getParams());		
			parent::populateState();	
		}
		
		
	/**
	 * Method to get a table object, load it if necessary.
	 *
	 * @param   string  $type    The table name. Optional.
	 * @param   string  $prefix  The class prefix. Optional.
	 * @param   array   $config  Configuration array for model. Optional.
	 *
	 * @return  JTable  A JTable object
	 *
	 * @since   1.6
	 */
	public function getTable($type = 'Edobunko', $prefix = 'EdobunkoTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}
 
	/**	 
	 * Get the document
	 * @return object The document to be displayed to the user
	 */
	 
	public function getItem()
	{
		if (!isset($this->item)) 
		{
			$jinput = JFactory::getApplication()->input;
			$id    = $jinput->get('title', 1, 'INT');
			$db    = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('h.id, h.publicationStmt, h.sourceDesc, h.title, h.type, h.location, h.overlay, h.params, c.title as category')
				  ->from('#__edobunko as h')
				  ->leftJoin('#__categories as c ON h.catid=c.id')
				  ->where('h.id=' . (int)$id);
			$db->setQuery((string)$query);
 
			if ($this->item = $db->loadObject()) 
			{
				// Load the JSON string
				$params = new JRegistry;
				$params->loadString($this->item->params, 'JSON');
				$this->item->params = $params;
 
				// Merge global params with item params
				$params = clone $this->getState('params');
				$params->merge($this->item->params);
				$this->item->params = $params;
			}
		}
		return $this->item;
	}
	
	 public function getTeiconverted()
	{
		if (!isset($this->item)) 
		{
			$jinput = JFactory::getApplication()->input;
			$id    = $jinput->get('title', 1, 'INT');
			$db    = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('h.id, h.publicationStmt, h.sourceDesc, h.title, h.type, h.location, h.overlay, h.params, c.title as category')
				  ->from('#__edobunko as h')
				  ->leftJoin('#__categories as c ON h.catid=c.id')
				  ->where('h.id=' . (int)$id);
			$db->setQuery((string)$query);
 
			if ($this->item = $db->loadObject()) 
			{
				// Load the JSON string
				$params = new JRegistry;
				$params->loadString($this->item->params, 'JSON');
				$this->item->params = $params;
 
				// Merge global params with item params
				$params = clone $this->getState('params');
				$params->merge($this->item->params);
				$this->item->params = $params;
			}
		}
		
		if (!isset($this->pages)) 
		{
			$jinput = JFactory::getApplication()->input;
			$id    = $jinput->get('title', 1, 'INT');
			$db    = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('h.id, h.page, h.overlay, h.published, h.parentid, h.params')
				  ->from('#__edobunko_pages as h')
				  ->where('h.parentid=' . (int)$this->item->id)
				  ->order('h.page ASC');
			$db->setQuery((string)$query);
			$inspectquery = $query;
			$this->pages = $db->loadObjectList();

		}
		
		$getdata = $this->item;
		$getpagedata = $this->pages;
		
		$teihead = '<?xml version="1.0" encoding="UTF-8"?> 				
					<?xml-model href="http://www.tei-c.org/release/xml/tei/custom/schema/relaxng/tei_all.rng" 
								type="application/xml" schematypens="http://relaxng.org/ns/structure/1.0"?> 				
							<?xml-model href="http://www.tei-c.org/release/xml/tei/custom/schema/relaxng/tei_all.rng" type="application/xml" 			schematypens="http://purl.oclc.org/dsdl/schematron"?> 				
							<TEI xmlns="http://www.tei-c.org/ns/1.0"> 				  
							<teiHeader> 					  
								<fileDesc> 						 
									<titleStmt> 							
										<title>'. $getdata->title .'</title> 						 
									</titleStmt> 						 
									<publicationStmt> 							
										<p class="tei-center">'. $getdata->publicationStmt .'</p> 						
									</publicationStmt> 						 
									<sourceDesc> 							
										<p class="tei-center">'. $getdata->sourceDesc .'</p> 						 
									</sourceDesc> 					  
								</fileDesc> 				  
							</teiHeader>'; 				  
							
		$teitext  = '<text>';
		
		foreach ($getpagedata as $page)
		{
			
		$jsonoverlay =  json_decode ($page->overlay);	

		$teitext  .= '<page>';
	
		foreach ($jsonoverlay as $object)
			{
				
				foreach ($object as $contents)
				{
					if ($contents->tei == "notag")
					{
					$teitext   .= str_replace("[cbr]","", $contents->text);
					}
					else
					{
						if ($contents->teisub == "notag")
						{
						$temp  	  	= str_replace("[cbr]","", $contents->text);
						$teitext   .= "<" . $contents->tei . ">" . $temp . "</". $contents->tei .">";
						}
						else
						{
						$temp  	  	= str_replace("[cbr]","", $contents->text);
						$teitext   .= "<" . $contents->tei . " type=\"". $contents->teisub . "\">" . $temp . "</". $contents->tei .">";	
						}
					}
				}
			}
			
		$teitext  .= '</page>';	
		}
		
		$teitext .= '</text>';
		
		$teifoot  = '</TEI>';
		
		
		$setxml = $teihead . $teitext . $teifoot;
		
		return $setxml;
		
	}
	
    public function getViewer()
	{
		if (!isset($this->item)) 
		{
			$jinput = JFactory::getApplication()->input;
			$id    = $jinput->get('title', 1, 'INT');
			$db    = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('h.id, h.publicationStmt, h.sourceDesc, h.title, h.location, h.overlay, h.params, c.title as category')
				  ->from('#__edobunko as h')
				  ->leftJoin('#__categories as c ON h.catid=c.id')
				  ->where('h.id=' . (int)$id);
			$db->setQuery((string)$query);
 
			if ($this->item = $db->loadObject()) 
			{
				// Load the JSON string
				$params = new JRegistry;
				$params->loadString($this->item->params, 'JSON');
				$this->item->params = $params;
 
				// Merge global params with item params
				$params = clone $this->getState('params');
				$params->merge($this->item->params);
				$this->item->params = $params;
			}
			
		}
		
			$parentid    = $this->item->id;
			$db    = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('h.id, h.page, h.published, h.overlay')
				  ->from('#__edobunko_pages as h')
				  ->where('h.parentid=' . $parentid)
				  ->order('(h.page + 0) ASC');
			$db->setQuery((string)$query);
 
			$this->pages = $db->loadObjectList();
		
		$getdata = $this->item;
		
		$setscript = '
		
		var teihead = \'<?xml version="1.0" encoding="UTF-8"?> 				<?xml-model href="http://www.tei-c.org/release/xml/tei/custom/schema/relaxng/tei_all.rng" type="application/xml" schematypens="http://relaxng.org/ns/structure/1.0"?> 				<?xml-model href="http://www.tei-c.org/release/xml/tei/custom/schema/relaxng/tei_all.rng" type="application/xml" 					schematypens="http://purl.oclc.org/dsdl/schematron"?> 				<TEI xmlns="http://www.tei-c.org/ns/1.0"> 				  <teiHeader> 					  <fileDesc> 						 <titleStmt> 							<title>'. $getdata->title .'</title> 						 </titleStmt> 						 <publicationStmt> 							<p class="tei-center">'. $getdata->publicationStmt .'</p> 						 </publicationStmt> 						 <sourceDesc> 							<p class="tei-center">'. $getdata->sourceDesc .'</p> 						 </sourceDesc> 					  </fileDesc> 				  </teiHeader> 				  <text>\';
		var teifoot = \'  </text> 				</TEI>\';
		var teibody;
		
		jQuery(".notetip").draggable({
		  addClasses: false,
		  cancel: ".draggcancel",
		});	
		

		function toggletranslation ()
		{

		jQuery(function ()
					{
					jQuery("[data-toggle=\"popover\"]").popover("hide");
					
					jQuery("[data-toggle=\"popover\"]")
						.popover({
							trigger: "manual", 
							container: "body", 
							html: true,
							animation: true
						})
						.click(function(e) {
							jQuery(".popover").not(this).hide();
							jQuery(this).popover("show");
							e.preventDefault();
						});
						
					jQuery(".vertical")
						.popover("disable")
					});
		
		jQuery(".vertical").each(function() 
			{
				jQuery(this).attr("data-content", jQuery(this).attr("jisho-content"));
			});	
			
			
				jQuery("#jishobutton").removeClass("btngreenleft");
				jQuery("#jishobutton").addClass("btnlableleft");
				
				jQuery("#popupbutton").removeClass("btnlablemid");
				jQuery("#popupbutton").addClass("btngreenmid");
				
				jQuery("#commentbutton").removeClass("btnlableright");
				jQuery("#commentbutton").addClass("btngreenright");
			
				jQuery(".vertical").popover("enable");
		}
		
			
			
		function fold(input, lineSize, lineArray) {
			lineArray = lineArray || [];
			if (input.length <= lineSize) {
				lineArray.push(input);
				return lineArray;
			}
			lineArray.push(input.substring(0, lineSize));
			var tail = input.substring(lineSize);
			return fold(tail, lineSize, lineArray);
			}	
			
		var getJSON = function(url) {
		  return new Promise(function(resolve, reject) {
			var xhr = new XMLHttpRequest();
			xhr.open("get", url, true);
			xhr.responseType = "json";
			xhr.onload = function() {
			  var status = xhr.status;
			  if (status == 200) {
				resolve(xhr.response);
			  } else {
				reject(status);
			  }
			};
			xhr.send();
		  });
		};

		function sortByColumn(a, colIndex){

					a.sort(sortFunction);

					function sortFunction(a, b) {
						if (a[colIndex] === b[colIndex]) {
							return 0;
						}
						else {
							return (a[colIndex] < b[colIndex]) ? -1 : 1;
						}
					}

					return a;
				}	
			
		var viewer = OpenSeadragon({
				id: "openseadragon1",
				tileSources: [';
				
			$i = 0;
			foreach ($this->pages as $page)
			{
			if($i != 0)
				{
				$setscript .= ", ";
				}
			$setscript .= "\"" . JURI::base() . $this->item->location . "/Working Data/p" . $page->page . ".xml\"";
			$i++;
			}
				
$setscript .=	'],
				sequenceMode: true,
				prefixUrl: "'. JURI::base() . 'images/seadragon/",
				overlays: [{
					id: "example-overlay",
					x: 0, 
					y: 0, 
					width: 2, 
					height: 2,
					className: "bleach"
				}]
			});

		viewer.addHandler("page", function (obj) {
				
				if(jQuery("#teithumbswitch").text() == "NAV")
				{
					teithumbswitch();
				}
				
				loadoverlay[prevpage] =  JSON.stringify(overlay.fabricCanvas().toJSON(["id", "pairing", "break", "tei", "teisub", "furigana", "display", "comment", "section"])).split("\\\n").join("[cbr]");
				
				loadoverlay[obj.page] = loadoverlay[obj.page].split("[cbr]").join("\\\n");

				castcanvas.loadFromJSON(loadoverlay[obj.page], castcanvas.renderAll.bind(castcanvas),function(o,object){
				console.log(o,object);
				});
			
			prevpage = obj.page;
			calculateplaintext();			
			
			
			});	
			
		function gotopage(page)
		{
			page--;	
			viewer.goToPage(page);	
				
		}
			
		viewer.addHandler("update-viewport", function() {
			
			jQuery("#example-overlay").show();
			
		});
		var edobunkothumb;
		
		';
		
		$i = 0;
			foreach ($this->pages as $page)
			{
					
				$setscript .= '
					edobunkothumb = "<div class=\"indexthumbs\" onmouseover=\"jQuery(\'#pagethumb' . $page->page . ' img\').css(\'opacity\', \'1\');\" onmouseout=\"jQuery(\'#pagethumb' . $page->page . ' img\').css(\'opacity\', \'0.7\');\"onclick=\"gotopage(' . $page->page . ');\" id=\"pagethumb' . $page->page . '\" style=\"cursor: pointer; width: 95%; border: 1px solid grey; margin: 3px auto;\"><img style=\"width: 100%; opacity: 0.7\" src=\"' . JURI::base() . $this->item->location . '/Working Data/p' . $page->page . '_files/t200.jpg\" /></div>"; 
					jQuery("#pagesthumb").append(edobunkothumb);
				';				
				
				$i++;
				
			}
			
$setscript .= '
				var overlay = viewer.fabricjsOverlay({scale: 5000}); 

				var text = new fabric.IText("", { fontSize: 0, left: 0, top: 0,  fill: "#000" });

				overlay.fabricCanvas().add(text);
				
				var castcanvas = overlay.fabricCanvas();
				var loadoverlay = [
			';

			$i = 0;
			foreach ($this->pages as $page)
			{
			if($i != 0)
				{
				$setscript .= ", ";
				}
			$setscript .= "'" . $page->overlay . "'";
			$i++;
			}

			
$setscript .= '];
			var prevpage = 0;
			loadoverlay[0] = loadoverlay[0].split("[cbr]").join("\\\n");
			castcanvas.loadFromJSON(loadoverlay[0], castcanvas.renderAll.bind(castcanvas),function(o,object){
			object.setCoords();
			console.log(o,object);

			});
			
			var active = "none";
			
			overlay.fabricCanvas().on("object:selected", function(o) {
				
				buildinlinerange(false,false,parseInt(0),false);
				buildinlinerange(false,false,false,parseInt(0));	
				
				var analyze = overlay.fabricCanvas().getActiveObject().get("text");
				
				active = "line" + overlay.fabricCanvas().getActiveObject().get("id");
				
				if(multiselect == false)
				{	
				jQuery(".vertical").removeClass("selectedline");
				jQuery(".vertical").attr("fabricstate", "inactive");
				}
	
				jQuery("#line" + overlay.fabricCanvas().getActiveObject().get("id")).toggleClass("selectedline");
																						  
				jQuery("#line" + overlay.fabricCanvas().getActiveObject().get("id")).attr("fabricstate", "active");
				
				jQuery.getJSON("'. JURI::base() . '/components/com_edobunko/models/httprequests/scrape.php?query=" + analyze,
				function(data) {
					
					var entryja;
					var entryse;
					var i, j;
					
				jQuery("#colorset").val(overlay.fabricCanvas().getActiveObject().get("fill").substring(1));
				jQuery("#colorset").css("background", overlay.fabricCanvas().getActiveObject().get("fill"))
							
				  }
				);
				
			jQuery("#fontfamilyselect").val(overlay.fabricCanvas().getActiveObject().get("fontFamily"));
			
			if (overlay.fabricCanvas().getActiveObject().get("break") == true)
				{
				jQuery("#breakcheckbox").html("check_box");	
				}
				else
				{
				jQuery("#breakcheckbox").html("check_box_outline_blank");	
				}	
			
			jQuery("#teiselect").val(overlay.fabricCanvas().getActiveObject().get("tei"));
			jQuery("#teiselect2").val(overlay.fabricCanvas().getActiveObject().get("teisub"));
			
			if (overlay.fabricCanvas().getActiveObject().get("tei") == "notag")
				{
				jQuery("#teisecondarywrap").hide();	
				jQuery("#linecustomtei").hide();
				
				}
				else
				{
					jQuery("#teisecondarywrap").show();	
					jQuery("#linecustomtei").hide();				
					

					if ( overlay.fabricCanvas().getActiveObject().get("teisub") != ("notag" || "figure" || "general"))
					{
					jQuery("#linecustomtei").val(overlay.fabricCanvas().getActiveObject().get("teisub"));

					jQuery("#linecustomtei").show();
					jQuery("#teiselect2").val("custom");		
						
					}
					else
					{
					jQuery("#linecustomtei").hide();	
					}
				}
			
			jQuery("#furiganaline1").val(overlay.fabricCanvas().getActiveObject().get("furigana"));
			jQuery("#insertline1").val(overlay.fabricCanvas().getActiveObject().get("text"));
						
			
			var display = overlay.fabricCanvas().getActiveObject().get("display");
			
			if (display == false)
				{
				jQuery("#displaytogglecheckbox").html("check_box_outline_blank");
				}
			else
				{
				jQuery("#displaytogglecheckbox").html("check_box");
				}
			
			var getcomment = overlay.fabricCanvas().getActiveObject().get("comment");
				
			jQuery(".commentnotetext").val(getcomment);	
			
			if (overlay.fabricCanvas().getActiveObject().get("tei") == "name")
			{
			 var teithumb = "generalname";	
			}
			else
			{
			 var teithumb = overlay.fabricCanvas().getActiveObject().get("tei").toLowerCase();
			 
			 if(teithumb == "span")
			 {
				if (overlay.fabricCanvas().getActiveObject().get("teisub") == "figure")
												{
												teithumb = "figure";		
												}
												else
												{
												teithumb = "custom";		
												} 
			 }
			}
			
			jQuery(".teislot").empty();
				if (teithumb != "notag")
				{	
				jQuery(".teislot").append("<img src=\"' . JUri::base(true) . '/components/com_edobunko/models/css/images/' . '" + 	teithumb +".png\" style=\"cursor: url(' . JUri::base(true) . '/components/com_edobunko/models/css/icons/' . 'delcursor.png), no-drop; margin-top: 2%; border: 1px solid grey;\" height=\"96%\" onclick=\"removetei();\" />");
				
				jQuery("#teisubinput").val(teithumb = overlay.fabricCanvas().getActiveObject().get("teisub"));
				}
				
			/* UNIMPLEMENTED: OCR proof-of-concept
			
			var centerocrguideline = (((overlay.fabricCanvas().getActiveObject().get("width") / 2) - 7.5) * overlay.fabricCanvas().getActiveObject().get("scaleX")) + overlay.fabricCanvas().getActiveObject().get("left");
				
			var ocrguideline = new fabric.Rect({
                    width: 15,
                    height: overlay.fabricCanvas().getActiveObject().get("height"),
                    fill: "blue",
                    opacity: 0.8,
                    left: centerocrguideline,
                    top: overlay.fabricCanvas().getActiveObject().get("top"),
					scaleX: overlay.fabricCanvas().getActiveObject().get("scaleX"),
					scaleY: overlay.fabricCanvas().getActiveObject().get("scaleY"),
					skewX: overlay.fabricCanvas().getActiveObject().get("skewX"),
					skewY: overlay.fabricCanvas().getActiveObject().get("skewY"),
					flipX: overlay.fabricCanvas().getActiveObject().get("flipX"),
					flipY: overlay.fabricCanvas().getActiveObject().get("flipY"),
					angle: overlay.fabricCanvas().getActiveObject().get("angle"),
					skewY: overlay.fabricCanvas().getActiveObject().get("skewY"),
					pairid: overlay.fabricCanvas().getActiveObject().get("id")
					
				});
				
				overlay.fabricCanvas().add(ocrguideline);
			*/
			
			var getstate = jQuery("#teithumbswitch").html();
			
						if (getstate == "NAV")	
						{	
						
							var getsel = rangy.getSelection();
							
							if (getsel.toString() != "")
									{
									var activeline = jQuery(".selectedline");
									var activeid = activeline.attr("id");
									var activecontent = activeline.html().replace(/\r?\n|\r/g,"");
									
									acgtivelinerg = new RegExp(activecontent); 
									
									var checky = getsel.inspect();
									checky = checky.replace("[WrappedSelection\(Ranges: \[WrappedRange(", "");
									checky = checky.replace(/\r?\n|\r/g,"");
									checky = checky.replace(/\)\]\)(.*)/g, "");						
									checky = checky.replace(/\)\], \[Wrapped(.*)/g, "");																
									checky = checky.replace(acgtivelinerg, "start");
									checky = checky.replace(acgtivelinerg, "end");
									
									var selectiondata = jQuery.parseJSON("{" + checky + "}");

								String.prototype.replaceAt=function(index, r) {
								var a = this.split("");
								a[index] = a[index] + r;
								return a.join("");
													}
									
									for (var i = 0, n = new Blob([activecontent]).size; i < n; i++) 
										{
											if (activecontent.charCodeAt( i ) > 255) 
											{ 
											activecontent = activecontent.replaceAt(i, "#"); 
											}
										}
											
									var seg1 = activecontent.substring(0, selectiondata.start);
									var seg2 = activecontent.substring(selectiondata.start, selectiondata.end);
									var seg3 = activecontent.substring(selectiondata.end, activecontent.length);
									
									var formatted = seg1 + "<span=\"color: blue;\">" + seg2 + "</span>" + seg3;
									formatted = formatted.replace(/#/g,"");
									
									/*alert(formatted);
									
									alert( fromselection );									
									alert( activecontent );
									alert( getsel.toString().replace(/\r?\n|\r/g,""));
									alert( selectiondata.start + " / " + selectiondata.end );
									alert( activecontent.substring( selectiondata.start, selectiondata.end ) );*/
									}
						} 
			});
			
			overlay.fabricCanvas().on("object:modified", function(o) {

			jQuery("#furiganaline1").val(overlay.fabricCanvas().getActiveObject().get("furigana"));
			jQuery("#insertline1").val(overlay.fabricCanvas().getActiveObject().get("text"));
			
			jQuery("[data-toggle=\"popover\"]").popover("hide");
			jQuery("#jishobutton").removeClass("btnlableleft");
				jQuery("#jishobutton").addClass("btngreenleft");
				
				jQuery("#popupbutton").removeClass("btngreenmid");
				jQuery("#popupbutton").addClass("btnlablemid");
				
				jQuery("#commentbutton").removeClass("btnlableright");
				jQuery("#commentbutton").addClass("btngreenright");
			
			loadoverlay[prevpage] =  JSON.stringify(overlay.fabricCanvas().toJSON(["id", "pairing", "break", "tei", "teisub", "furigana", "display", "comment", "section"])).split("\\\n").join("[cbr]");
			
			calculateplaintext();

			});

			function startfabricedit()
			{
				overlay.fabricCanvas().getActiveObject().enterEditing();
			}
			
			function stopfabricedit()
			{
				overlay.fabricCanvas().getActiveObject().exitEditing();
			}
			
			overlay.fabricCanvas().on("mouse:down", function (evt) {
				stopfabricedit();
			});
			
			
			String.prototype.insert = function (index, string) {
            // This insert function courtesy Base33:
            // http://stackoverflow.com/questions/4313841/javascript-how-can-i-insert-a-string-at-a-specific-index
            if (index > 0)
                return this.substring(0, index) + string + this.substring(index, this.length);
            else
						return string + this;
				};

				function rubyGen(inputtext) 
				{
					var outputtext = "";
					for (i=0; i<inputtext.length; i++) {
						if (inputtext[i] == "(") {
							outputtext = outputtext.insert(outputtext.length-1, "<ruby><rb>");
							outputtext += "</rb><rp>" + inputtext[i] + "</rp><rt>";
						} else if (inputtext[i] == ")") {
							outputtext += "</rt><rp>" + inputtext[i] + "</rp></ruby>";	
						} else {
							outputtext += inputtext[i];
						}
					}				
					return outputtext;
				}
				
			function filter_array(test_array) 
			{
				var index = -1,
					arr_length = test_array ? test_array.length : 0,
					resIndex = -1,
					result = [];

				while (++index < arr_length) {
					var value = test_array[index];

					if (value) {
						result[++resIndex] = value;
					}
				}

				return result;
			}
			
			var popuppoulate = "none";
			var multiselect = false;
			
			function togglemulti()
			{
				  
			  if (multiselect == true)
				{
				jQuery("#multitogglecheckbox").html("check_box_outline_blank");
				jQuery(".vertical").removeClass("selectedline");
				}
				else
				{
				jQuery("#multitogglecheckbox").html("check_box");
				}
			
			   multiselect = !multiselect;
			
			}
			
			function editoverlay(variable, changetype, value)
			{
		
				var selectedlines = jQuery(".selectedline").length;
					
				if (selectedlines == 1)
				{
					if (changetype == "set")
					{	
						overlay.fabricCanvas().getActiveObject().set(variable, value);	
						castcanvas.renderAll();	
				    }
					else if (changetype == "+-")
					{
						var setto = overlay.fabricCanvas().getActiveObject().get(variable);
						setto = setto + value;
						overlay.fabricCanvas().getActiveObject().set(variable, setto);	
						castcanvas.renderAll();	
					}

				}
				else
				{
					if (changetype == "set")
					{	
						jQuery(".selectedline").each(function() {
							
							var id = jQuery(this).attr("id"); 	
							
							id = id.substring(4);
							
							overlay.fabricCanvas().forEachObject(function(obj)
							{	

								if(id == obj.get("id"))
								{
									obj.set(variable, value);
									castcanvas.renderAll();	
								}
							
							});
						
						});
				    }
					else if (changetype == "+-")
					{
					jQuery(".selectedline").each(function() {
					
							var id = jQuery( this ).attr("id"); 	
							id = id.substring(4);
							
							overlay.fabricCanvas().forEachObject(function(obj)
							{	

								if(id == obj.get("id"))
								{
									var setto = obj.get(variable);
									setto = setto + value;
									obj.set(variable, setto);
									castcanvas.renderAll();	
								}
							
							});
						
						});
						
						var setto = overlay.fabricCanvas().getActiveObject().get(variable);
						setto = setto + value;
						overlay.fabricCanvas().getActiveObject().set(variable, setto);	
					}
				}
				if(variable == "furigana")
				{
				calculateplaintext();
				}
				
				overlay.fabricCanvas().renderAll();
			}
			
			function removetei()
			{
				jQuery("<div></div>").appendTo("body")
							.html("<div><h6>' . JText::_('COM_EDOBUNKO_EDOCUMENTVIEWER_CONFIRM_TEIDEL') . '</h6></div>")
							.dialog({
								modal: true, title: "' . JText::_('COM_EDOBUNKO_EDOCUMENTVIEWER_CONFIRM_TEIDELTITLE') . '", zIndex: 10000, autoOpen: true,
								width: "auto", resizable: false,
								buttons: {
									Yes: function () {
										overlay.fabricCanvas().getActiveObject().set("tei", "notag");
										jQuery(".teislot").empty();
										jQuery("#teisubinput").val("notag");
										calculateplaintext();
										
										jQuery(this).dialog("close");
										
									},
									No: function () {                                                                 
										jQuery(this).dialog("close");
									}
								},
								close: function (event, ui) {
									jQuery(this).remove();
								}
							});
				
			}
			
			function makeittei(newteitype, newteisub)
			{
				
			}
			
			function jishocall(vocab, url, id, segid, storetext)
			{

					var parsetip;	
					var settip = [];
					var fulltip = [];
					var result;
					var address = "http://www.jisho.org/search/" + storetext;
					jQuery.getJSON("'. JURI::base() . '/components/com_edobunko/models/httprequests/scrape.php?query=" + vocab,
									function(data) {
										
										var entryja;
										var entryse;
										var i, j;										
									
									for (i = 0, len = data.data.length; i < len; i++) 
										{
										
										
										  entryja = data.data[i].japanese[0];
										  
										  entryse = data.data[i].senses[0];

										  parsetip = parsetip + "<strong>" + entryja.word + "</strong> (" + entryja.reading + ")" + " " + entryse.english_definitions + "<br/>";	
										
										if (i === 2)
											{
											break;
											}
										}
										
									settip.push(parsetip);
									
									var cleanup = filter_array(settip);
										cleanup = cleanup.join("<br/><br/>");
										cleanup = cleanup.split(undefined).join("");
										cleanup = cleanup.split("undefined").join("");
										cleanup = cleanup.split(NaN).join("");
										cleanup = cleanup.split("NaN").join("");
										cleanup = cleanup.split(",").join(", "); 
										
										if (jQuery("#line" + id).attr("jisho-content") != undefined)
										{
										jQuery("#line" + id).attr("jisho-content", jQuery("#line" + id).attr("jisho-content") + "<br/>" + cleanup);	
										}
										else
										{
										var jisholink = "<a target=\"_blank\" href=\"" + address + "\">" + "Jisho.org <i class=\"material-icons md-12\" >launch</i>" + "</a>";
										jQuery("#line" + id).attr("jisho-content", jisholink + "<br/>" + cleanup);	
										}
										
										
										
													
									});	
				
	
			}
			
			var vertical = ".vertical";
			var hidestring = "hide";
			var magnetizer = "discharged";
			var magnetizerF = "discharged";
			var buildselection = [0,0];
						
			function calculateplaintext()
			{
				
					var plaintext = "<div class=\"text-line\">";
					var segtext = "";
					var plaintextarray = [[], [], [], [], [], [], [], [], []];
					jQuery("#plaintext").empty();
					jQuery("#teitext").empty();
					var i = 0;
					overlay.fabricCanvas().forEachObject(function(obj)
						{	
						plaintextarray[i] = [];
						plaintextarray[i]["id"] = obj.get("id");
						plaintextarray[i]["pairing"] = obj.get("pairing");
						plaintextarray[i]["text"] = obj.get("text");
						plaintextarray[i]["furigana"] = obj.get("furigana");
						plaintextarray[i]["break"] = obj.get("break");
						plaintextarray[i]["tei"] = obj.get("tei");
						plaintextarray[i]["teisub"] = obj.get("teisub");
						plaintextarray[i]["display"] = obj.get("display");
						plaintextarray[i]["section"] = obj.get("display");

						var getstate = jQuery("#teithumbswitch").html();
							
								if (getstate == "TEI")	
								{
									plaintextarray[i]["formedtext"] = rubyGen(obj.get("furigana"));
								}
								else
								{
									plaintextarray[i]["formedtext"] = obj.get("text");
								}
						
						i++;
						});
						
						var plaintextarray = sortByColumn(plaintextarray, "id");
						var teiformat = "";
						var gettooltip = "";
						
						
						
						var genericCloseBtnHtml = "<button class=\'btngreensingle2pad closepop\' style=\'float: right;\' onclick=\'jQuery(vertical).popover(hidestring);\' ><i class=\'material-icons md-12\'>clear</i></button>";
						for(var i = 0; i < plaintextarray.length; i++) 
							{
							if (plaintextarray[i]["tei"] == "span")
							{
								if (plaintextarray[i]["teisub"] == "figure")
								{
								var teimark = "figure";
								}
								else
								{
								var teimark = "special";
								}
							}
							else
							{
								var teimark = plaintextarray[i]["tei"];
							}
							
							if(jQuery("#teithumbswitch").text() == "NAV")
							{
								teimark = teimark + " tei" + teimark + "Style";								
							}
								
								if (plaintextarray[i]["display"] == true && plaintextarray[i]["pairing"] <= plaintextarray[i]["id"])
								{
								 if (magnetizer != "discharged")
								 {							  	 
									 plaintextarray[i]["text"] = magnetizer + plaintextarray[i]["text"];
									 plaintextarray[i]["furigana"] = magnetizerF + plaintextarray[i]["furigana"];
									 magnetizer = "discharged";
									 magnetizerF = "discharged";
								 }
									if (plaintextarray[i]["break"] == true)
									{
										plaintext = plaintext + "</div>" + "<div class=\"text-line\" >" + "<input onfocus=\"jQuery(this).css({color: \'000\', background: \'#b5e4f2\'});\" onblur=\"jQuery(this).css({color: \'grey\', background: \'white\'});\"  id=\"inputid" + plaintextarray[i]["id"] + "\" type=\"text\" onclick=\"selectobject(" + plaintextarray[i]["id"] + "); \" style=\"" + idboxstate + "\" class=\"horizontal\" value=\"" + plaintextarray[i]["id"] + "\">"+ "<div data-content=\"\" onclick=\"selectobject(" + plaintextarray[i]["id"] + "); \" data-placement=\"top\" data-toggle=\"popover\" data-original-title=\"<strong>" + plaintextarray[i]["text"] + genericCloseBtnHtml + "</strong>\" class=\"vertical tei" + teimark + "\" class=\"plaintextclass\" id=\"line" + plaintextarray[i]["id"] + "\">" +  plaintextarray[i]["formedtext"] + "</div>";		
									}
									else
									{
										plaintext = plaintext + "<input onfocus=\"jQuery(this).css({color: \'000\', background: \'#b5e4f2\'});\" onblur=\"jQuery(this).css({color: \'grey\', background: \'white\'});\" id=\"inputid" + plaintextarray[i]["id"] + "\" type=\"text\" onclick=\"selectobject(" + plaintextarray[i]["id"] + "); \" style=\"" + idboxstate + "\" class=\"horizontal\" value=\"" + plaintextarray[i]["id"] + "\">"+ "<div data-content=\"\" onclick=\"selectobject(" + plaintextarray[i]["id"] + "); \" data-placement=\"top\" data-toggle=\"popover\" data-original-title=\"<strong>" + plaintextarray[i]["text"] + genericCloseBtnHtml + "</strong>\"   onclick=\"selectobject(" + plaintextarray[i]["id"] + ");\" class=\"vertical tei" + teimark + "\" id=\"line" + plaintextarray[i]["id"] + "\" \">" + plaintextarray[i]["formedtext"] + "</div>";		
									}
									
									if (plaintextarray[i]["tei"] == "notag")
									{	
										teiformat = teiformat + plaintextarray[i]["text"];
									}
									else
									{
										var overtext = plaintextarray[i]["text"];
										
										String.prototype.replaceAt=function(index, r) {
											var a = this.split("");
											a[index] = a[index] + r;
											return a.join("");
													}
										
										var tagsections = plaintextarray[i]["tei"];
										
										tagsections = tagsections.split("|");
										tagsections = tagsections.sort(function(a, b){return b-a}); 
										
										var formatted = overtext;
										
										tagsections.forEach(function(item, index)
										{
											var segpoints = item.split(",");																
											for (var i = 0, n = new Blob([overtext]).size; i < n; i++) 
											{
												if (overtext.charCodeAt( i ) > 255) 
												{ 
												overtext = overtext.replaceAt(i, "#"); 
												}
											}
												
											var seg1 = overtext.substring(0, segpoints[0]);
											var seg2 = overtext.substring(segpoints[0], segpoints[1]);
											var seg3 = overtext.substring(segpoints[1], overtext.length);
											
											var formatted = seg1 + "<span=\"color: blue;\">" + seg2 + "</span>" + seg3;
											formatted = formatted.replace(/#/g,"");
																						
											
										}										
										);
										
										teiformat = teiformat + formatted;
									}
								}	
								else
								{
									if(plaintextarray[i]["display"] == true)
									{
										
									if (magnetizer != "discharged")
										{
										magnetizer = magnetizer + plaintextarray[i]["text"];
										magnetizerF = magnetizerF + plaintextarray[i]["furigana"];
										}
									else
										{
										magnetizer = plaintextarray[i]["text"];	
										magnetizerF = plaintextarray[i]["furigana"];	
										}
									
									}
									
								}
								
								if(plaintextarray[i]["text"] != null)
								{	
								segtext = segtext + plaintextarray[i]["text"];
								var storetext = plaintextarray[i]["text"];
								}
								else
								{
								var storetext = "";
								}
							
							
								var segmenter = new TinySegmenter(); 
								
								
								
								var formattedtext = storetext.replace(/\n/g, "");
								
								var segs = segmenter.segment(formattedtext);
								
								var segcount = 0;
								
								for (val of segs) 
								{
									
								var setid = plaintextarray[i]["id"];
									
								jishocall(val, false, setid, segcount, storetext);

								segcount++;
		
								}	
								
								
							
							}
					
					var segmenter = new TinySegmenter(); 

					var segs = segmenter.segment(segtext);

					segtext = segs.join("|");			
					plaintext = plaintext + "</div>";
					teibody = teihead + teiformat + teifoot;
					
					var plaintextwidth = plaintextarray.length * 48;
					plaintext = "<div style=\"position: absolute; right: 0; width: " + plaintextwidth + "px;\">" + plaintext + "</div>";
					
					jQuery("#segtext").html(segtext);					
					jQuery("#plaintext").html(plaintext);
					jQuery("#teitext").html(teibody);
					
					
					
			}
			
			function idresort()
			{
			var warning = false;	
			var idpool = [];
			overlay.fabricCanvas().forEachObject(function(obj)
						{	
						if (obj.get("id") == obj.get("pairing"))
							{								
							var newid = jQuery("#inputid" + obj.get("id")).val();
							if (jQuery.inArray(newid, idpool) !== -1)
								{								
								obj.set("id", newid);
								}

							idpool.push(newid);
							}
							
						});
			
			if(idpool.every(function(elem, i, array){return array.lastIndexOf(elem) === i}) == false)
							{
								jQuery("<div></div>").appendTo("body")
									.html("<div><h6>' . JText::_('COM_EDOBUNKO_EDOCUMENTVIEWER_IDSORTEXCEPTION') . '</h6></div>")
									.dialog({
										modal: true, title: "' . JText::_('COM_EDOBUNKO_EDOCUMENTVIEWER_WARNING') . '", zIndex: 10000, autoOpen: true,
										width: "auto", resizable: false,
										buttons: {
											OK: function () {jQuery(this).dialog("close");},
										},
										close: function (event, ui) {
											jQuery(this).remove();
										}
									});
							}
							
			calculateplaintext();	
			
			}
			
			function toggleobject()
			{
			var display = overlay.fabricCanvas().getActiveObject().get("display");
			
			if (display == true)
				{
				overlay.fabricCanvas().getActiveObject().set("display", false);
				jQuery("#displaytogglecheckbox").html("check_box_outline_blank");
				}
			else
				{
				overlay.fabricCanvas().getActiveObject().set("display", true);
				jQuery("#displaytogglecheckbox").html("check_box");
				}
				
			calculateplaintext();	
			
			}
			
			function addline() 
			{
				
			var toadd = jQuery("#insertline1").val();
			var arrayOfLines = fold(toadd, 1);
			var toadd = arrayOfLines.join("\\n");
			var setlineheight = jQuery("#insertline2").val();
			var setfill = "#" + jQuery("#colorset").val();
			var setfuri = jQuery("#furiganaline1").val();
			var activefontfamily = jQuery("#fontfamilyselect").val();
			var idtogglestate = jQuery("#idtogglecheckbox").html();
				if (idtogglestate == "check_box_outline_blank")
					{
						var idboxstate = "display: none;";
					}
					
			var amountcheck = 1;
			overlay.fabricCanvas().forEachObject(function(obj)
				{
				amountcheck++;
				});
			
			text = new fabric.IText(toadd, {id: amountcheck, pairing: amountcheck, break: true, tei: "notag", teisub: "notag", furigana: setfuri, display: true, fontSize: 130, left: 0, top: 0,  fill: setfill, lineHeight: 1.13, angle: 0, fontFamily: activefontfamily, fontWeight: "normal", opacity: 1, skewX: 0, skewY: 0});
					overlay.fabricCanvas().add(text);
			jQuery("[data-toggle=\"popover\"]").popover("hide");
			jQuery("#jishobutton").removeClass("btnlableleft");
				jQuery("#jishobutton").addClass("btngreenleft");
				
				jQuery("#popupbutton").removeClass("btngreenmid");
				jQuery("#popupbutton").addClass("btnlablemid");
				
				jQuery("#commentbutton").removeClass("btnlableright");
				jQuery("#commentbutton").addClass("btngreenright");
			
			loadoverlay[prevpage] =  JSON.stringify(overlay.fabricCanvas().toJSON(["id", "pairing", "break", "tei", "teisub", "furigana", "display", "comment", "section"])).split("\\\n").join("[cbr]");
			
			calculateplaintext();
			}
			
			var idtogglestate = jQuery("#idtogglecheckbox").html();
				if (idtogglestate == "check_box_outline_blank")
					{
						var idboxstate = "display: none;";
					}
			calculateplaintext();
			
			function togglecomment ()
			{
				jQuery(function ()
					{
					jQuery("[data-toggle=\"popover\"]").popover("hide");
					jQuery("[data-toggle=\"popover\"]")
						.popover({
							trigger: "manual", 
							container: "body", 
							html: true,
							animation: true
						})
						.click(function(e) {
							jQuery(".popover").not(this).hide();
			
							jQuery(this).popover("show"); 
							e.preventDefault();
						});
						
					jQuery(".vertical")
						.popover("disable")
					});
				
				overlay.fabricCanvas().forEachObject(function(obj)
				{	
					var comment = "<textarea id=\"commentarea" + obj.get("id") + "\" onchange=\"setcomment(" + obj.get("id") + ");\">" + obj.get("comment") + "</textarea><br/><button>' . JText::_('COM_EDOBUNKO_EDOCUMENTVIEWER_COMMIT') . '</button>";										
					jQuery("#line" + obj.get("id")).attr("data-content", comment);

				});
				
				jQuery("#jishobutton").removeClass("btnlableleft");
				jQuery("#jishobutton").addClass("btngreenleft");
				
				jQuery("#popupbutton").removeClass("btnlablemid");
				jQuery("#popupbutton").addClass("btngreenmid");
				
				jQuery("#commentbutton").removeClass("btngreenright");
				jQuery("#commentbutton").addClass("btnlableright");
				
				jQuery(".vertical").popover("enable");
				
				
			}
			
			function closepopup ()
			{
				jQuery("#jishobutton").removeClass("btnlableleft");
				jQuery("#jishobutton").addClass("btngreenleft");
				
				jQuery("#popupbutton").removeClass("btngreenmid");
				jQuery("#popupbutton").addClass("btnlablemid");
				
				jQuery("#commentbutton").removeClass("btnlableright");
				jQuery("#commentbutton").addClass("btngreenright");
				
				jQuery(".vertical").popover("disable");
			}
			
			function setteisub()
			{	
			var teisubtag = jQuery("#teisubinput").val();

			castcanvas.getActiveObject().set("teisub", teisubtag);

			if (overlay.fabricCanvas().getActiveObject().get("tei") == "name")
			{
			 var teithumb = "generalname";	
			}
			else
			{
			 var teithumb = overlay.fabricCanvas().getActiveObject().get("tei").toLowerCase();
			 
			 if(teithumb == "span")
			 {
				if (overlay.fabricCanvas().getActiveObject().get("teisub") == "figure")
												{
												teithumb = "figure";		
												}
												else
												{
												teithumb = "custom";		
												} 
				
			 }
			}
			
			jQuery(".teislot").empty();
				if (teithumb != "notag")
				{	
				jQuery(".teislot").append("<img src=\"' . JUri::base(true) . '/components/com_edobunko/models/css/images/' . '" + 	teithumb +".png\" style=\"cursor: url(' . JUri::base(true) . '/components/com_edobunko/models/css/icons/' . 'delcursor.png), no-drop; margin-top: 2%; border: 1px solid grey;\" height=\"96%\" onclick=\"removetei();\" />");
				
				jQuery("#teisubinput").val(teithumb = overlay.fabricCanvas().getActiveObject().get("teisub"));
				}
			}
			
			function updatefuri()
			{
				jQuery("#furiganaline1").val(jQuery("#insertline1").val());
			}
			
			function idup(adjust)
			{
				var castcanvas = overlay.fabricCanvas();
				var getid = castcanvas.getActiveObject().get("id");	
				var getpairing = castcanvas.getActiveObject().get("pairing");
				
				if (getid == getpairing)
				{	
					var adjustid = getid + adjust;
					var idtogglestate = jQuery("#idtogglecheckbox").html();
					if (idtogglestate == "check_box_outline_blank")
						{
							var idboxstate = "display: none;";
						}

					warned = false;

						overlay.fabricCanvas().forEachObject(function(obj)
							{	
							if (obj.get("id") == adjustid && warned == false)
								{
									if (obj.get("pairing") != obj.get("id"))
									{
										if(obj.get("id") > obj.get("pairing"))
										{
										var upper = obj.get("id");	
										var lower = obj.get("pairing");
										
										}
										else
										{
										var lower = obj.get("id");	
										var upper = obj.get("pairing");	
										}

											overlay.fabricCanvas().forEachObject(function(obj2)
											{

												if (obj2.get("pairing") == lower)
													{
													obj2.set("id", lower - adjust);										
													}
													if (obj2.get("pairing") == upper)
													{
													obj2.set("id", upper - adjust);
													}
																				
											});
											
											overlay.fabricCanvas().forEachObject(function(obj2)
											{
												if (obj2.get("id") == (upper - adjust))
												{
												obj2.set("pairing", lower - adjust);
												}
												if (obj2.get("id") == (lower - adjust))
												{
												obj2.set("pairing", upper - adjust);
												}
											});
										
										if (adjust > 0)
										{
										castcanvas.getActiveObject().set("id", upper);	
										castcanvas.getActiveObject().set("pairing", upper);	
										}
										else
										{
										castcanvas.getActiveObject().set("id", lower);	
										castcanvas.getActiveObject().set("pairing", lower);
										}
									}
									else
									{
									obj.set("id", getid);
									obj.set("pairing", getid);
									castcanvas.getActiveObject().set("id", adjustid);	
									castcanvas.getActiveObject().set("pairing", adjustid);								
									
									}						
								}
							else if (adjustid == 0 && warned == false)
								{
									jQuery("<div></div>").appendTo("body")
									.html("<div><h6>' . JText::_('COM_EDOBUNKO_EDOCUMENTVIEWER_CONFIRM_IDTOLOW') . '</h6></div>")
									.dialog({
										modal: true, title: "' . JText::_('COM_EDOBUNKO_EDOCUMENTVIEWER_WARNING') . '", zIndex: 10000, autoOpen: true,
										width: "auto", resizable: false,
										buttons: {
											OK: function () {jQuery(this).dialog("close");},
										},
										close: function (event, ui) {
											jQuery(this).remove();
										}
									});
								warned = true;
								
								}
							});
				
		
					calculateplaintext();
					jQuery("#line" + overlay.fabricCanvas().getActiveObject().get("id")).toggleClass("selectedline");
				}
				else
				{
					jQuery("<div></div>").appendTo("body")
							.html("<div><h6>' . JText::_('COM_EDOBUNKO_EDOCUMENTVIEWER_CONFIRM_NOIDSWAP') . '</h6></div>")
							.dialog({
								modal: true, title: "' . JText::_('COM_EDOBUNKO_EDOCUMENTVIEWER_WARNING') . '", zIndex: 10000, autoOpen: true,
								width: "auto", resizable: false,
								buttons: {
									OK: function () {jQuery(this).dialog("close");},
								},
								close: function (event, ui) {
									jQuery(this).remove();
								}
							});
				}
			}
			
			function switchbreak()
			{
				var idtogglestate = jQuery("#idtogglecheckbox").html();
				if (idtogglestate == "check_box_outline_blank")
					{
						var idboxstate = "display: none;";
					}
					
				if (overlay.fabricCanvas().getActiveObject().get("break") == true)
				{
				overlay.fabricCanvas().getActiveObject().set("break", false);
				jQuery("#breakcheckbox").html("check_box_outline_blank");	
				}
				else
				{
				overlay.fabricCanvas().getActiveObject().set("break", true);
				jQuery("#breakcheckbox").html("check_box");	
				}

				calculateplaintext();
			}
			
			function setcomment(id)
			{
				var comment = jQuery("#commentarea" + id).val();
				overlay.fabricCanvas().forEachObject(function(obj)
					{	
					if (obj.get("id") == id)
						{
						obj.set("comment", comment);					
						}
					});
				jQuery("[data-toggle=\"popover\"]").popover("hide");
				
				jQuery("#jishobutton").removeClass("btnlableleft");
				jQuery("#jishobutton").addClass("btngreenleft");
				
				jQuery("#popupbutton").removeClass("btngreenmid");
				jQuery("#popupbutton").addClass("btnlablemid");
				
				jQuery("#commentbutton").removeClass("btnlableright");
				jQuery("#commentbutton").addClass("btngreenright");
				
				togglecomment();
			}
			
			function switchids()
			{
				if (jQuery("#idtogglecheckbox").html() == "check_box")
				{
				jQuery("#idtogglecheckbox").html("check_box_outline_blank");	
				}
				else
				{
				jQuery("#idtogglecheckbox").html("check_box");	
				}
			
				jQuery(".horizontal").toggle();
			}
			
			function jsonify()
			{
				alert(JSON.stringify(overlay.fabricCanvas().toJSON()));		
			}
			
			/* function fromjson()
			{
			var castcanvas = overlay.fabricCanvas();
			var jtest = deepzoomoverlay;	
			jtest = jQuery("#insertline1").val();
			jtest.split("\n").join("\\n");
			castcanvas.loadFromJSON(jtest, castcanvas.renderAll.bind(castcanvas),function(o,object){
			console.log(o,object)
			}); 
			
			}*/
			
			function selectobject(oid)
			{
			var i = 0;
			overlay.fabricCanvas().forEachObject(function(obj)
					{	
					if (obj.get("id") == oid)
						{
						overlay.fabricCanvas().setActiveObject(obj);
						
						}
					});
			i++;		
			}			
		
			
			function buildinlinerange(changelower,changeupper,setlower,setupper)
			{
			
				if (changelower !== false)
				{	
					buildselection[0] = buildselection[0] + changelower;
					if (buildselection[0] >= 0)
					{
						jQuery("#selectionrangemakerlower").val(buildselection[0]);
					}
					else
					{
						buildselection[0] = 0;	
					}
				}
				if (changeupper !== false)
				{
					buildselection[1] = buildselection[1] + changeupper;
					if (buildselection[1] >= 0)
					{
						jQuery("#selectionrangemakerupper").val(buildselection[1]);
					}
					else
					{
						buildselection[1] = 0;	
					}						
				}
				if (setlower !== false)
				{	
					if (isNaN(setlower) !== true && setlower >= 0)
					{
					buildselection[0] = parseInt(setlower);					
					}
					jQuery("#selectionrangemakerlower").val(buildselection[0]);
				}
				if (setupper !== false)
				{
					if (isNaN(setupper) !== true && setupper >= 0)
					{
					buildselection[1] = parseInt(setupper);
					}
					jQuery("#selectionrangemakerupper").val(buildselection[1]);
				}	
			}
			
			function teithumbswitch()
			{
			var getstate = jQuery("#teithumbswitch").html();
			jQuery(".teiselectionmaker").toggle();
				if (getstate == "TEI")	
				{
					
					jQuery(".thumb-wrapper").animate({
												height: "390px"}, 500
												);
					jQuery(".teislot").css("border", "1px solid grey");
					jQuery("#teisubinput").css("display", "inline");
					jQuery(".teitype").animate({
												height: "27px"}, 500
												);
					jQuery(".teislot").animate({
												height: "147px"}, 500
												);
				
					jQuery("#teithumbswitch").html("NAV");
				}
				else{
					jQuery(".thumb-wrapper").animate({
												height: "569px"}, 500
												);
					jQuery(".teislot").css("border", "0px");
					jQuery("#teisubinput").css("display", "none");
					jQuery(".teislot").animate({
												height: "0px"}, 500
												);
					jQuery(".teitype").animate({
												height: "0px"}, 500
												);
					jQuery("#teithumbswitch").html("TEI");
				}
					
				jQuery(".teithumbwrap").toggle();
				jQuery(".indexthumbs").toggle();
				
				jQuery(".teipersName").toggleClass("teipersNameStyle");
				jQuery(".teiplaceName").toggleClass("teiplaceNameStyle");
				jQuery(".teiname").toggleClass("teinameStyle");
				jQuery(".teifigure").toggleClass("teifigureStyle");
				jQuery(".teispecial").toggleClass("teispecial");
				
				calculateplaintext();
			}

			function newguideline()
			{
			var castcanvas = overlay.fabricCanvas();
			castcanvas.add(new fabric.Line({
				left: 170,
				top: 150,
				fill: "red",
				width: 50,
				height: 500,
			}));
			}
			
			function saveoverlay()
			{
				loadoverlay[prevpage] =  JSON.stringify(overlay.fabricCanvas().toJSON(["id", "pairing", "break", "tei", "teisub", "furigana", "display", "comment", "section"])).split("\\\n").join("[cbr]");
				
				var arrayLength = loadoverlay.length;
				for (var i = 0; i < arrayLength; i++) {
					loadoverlay[i] = loadoverlay[i].split("\\\n").join("[cbr]");
				}
				
				jQuery("#overlayinput").val(loadoverlay.join("§explode§"));
				jQuery("#saveoverview").submit();
			}
			
			// select all objects
			function deleteObject(){
				
				var castcanvas = overlay.fabricCanvas();
				var activeObject = castcanvas.getActiveObject();
				if (activeObject) {
					if (confirm("Are you sure?")) {
						castcanvas.remove(activeObject);
					}
				}
				var idtogglestate = jQuery("#idtogglecheckbox").html();
				if (idtogglestate == "check_box_outline_blank")
					{
						var idboxstate = "display: none;";
					}
				calculateplaintext();
			
			
			}
			
			function plaintextswitch(side)
			{
				if (side == "left")
				{
				jQuery("#plaintextswitchleft").addClass( "btnlableleft");
				jQuery("#plaintextswitchleft").removeClass( "btngreenleft");
				jQuery("#plaintextswitchright").removeClass( "btnlableright");
				jQuery("#plaintextswitchright").addClass( "btngreenright");
				jQuery("#plaintextswitchcenter").removeClass( "btnlablemid");
				jQuery("#plaintextswitchcenter").addClass( "btngreenmid");
				
				jQuery("#plaintext").show("slow");
				jQuery("#teitext").hide("slow");
				jQuery("#teidirect").hide("slow");
				jQuery("#teidl").hide("slow");
				jQuery("#segtext").hide("slow");
				
				jQuery("#jishobutton").show("slow");
				jQuery("#popupbutton").show("slow");
				jQuery("#commentbutton").show("slow");
				}
				
				if (side == "mid")
				{
				jQuery("#plaintextswitchleft").removeClass( "btnlableleft");
				jQuery("#plaintextswitchleft").addClass( "btngreenleft");
				jQuery("#plaintextswitchright").removeClass( "btnlableright");
				jQuery("#plaintextswitchright").addClass( "btngreenright");
				jQuery("#plaintextswitchcenter").addClass( "btnlablemid");
				jQuery("#plaintextswitchcenter").removeClass( "btngreenmid");
				
				jQuery("#plaintext").hide("slow");
				jQuery("#teitext").hide("slow");
				jQuery("#teidirect").hide("slow");
				jQuery("#teidl").hide("slow");
				jQuery("#segtext").show("slow");
				
				jQuery("#jishobutton").hide("slow");
				jQuery("#popupbutton").hide("slow");
				jQuery("#commentbutton").hide("slow");
				
				}
				
				if (side == "right")
				{
				jQuery("#plaintextswitchleft").removeClass( "btnlableleft");
				jQuery("#plaintextswitchleft").addClass( "btngreenleft");
				jQuery("#plaintextswitchright").addClass( "btnlableright");
				jQuery("#plaintextswitchright").removeClass( "btngreenright");
				jQuery("#plaintextswitchcenter").removeClass( "btnlablemid");
				jQuery("#plaintextswitchcenter").addClass( "btngreenmid");
				
				jQuery("#plaintext").hide("slow");
				jQuery("#teitext").show("slow");
				jQuery("#teidirect").show("slow");
				jQuery("#teidl").show("slow");
				jQuery("#segtext").hide("slow");
				
				jQuery("#jishobutton").hide("slow");
				jQuery("#popupbutton").hide("slow");
				jQuery("#commentbutton").hide("slow");
				}
				
			}
			
			jQuery( "#overlayslider" ).slider({
									step: 0.05,
									value: 0.7,
									max: 1,
									min: 0,
									change: function( event, ui ) {												
									
									jQuery( "#example-overlay" ).css("opacity", ui.value);
									
									if(ui.value == 0)
										{	
										jQuery(".lower-canvas").hide();	
										}
										else
										{
										jQuery(".lower-canvas").show();		
										}	
									}
									});
									
			
			viewer.addHandler("resize", function(target, info) {
			overlay.fabricCanvas().resize();
			});

			function overlayopa (adjustopa) 
			{
			var newopa = jQuery( "#overlayslider" ).slider("value") + (adjustopa/100);	
			jQuery( "#overlayslider" ).slider("value", newopa);	
			}
			
			//Mapfunctions
			
			var startPoint = new fabric.Point(0, 0);

				var polygonPoints = [];
				var lines = [];
				var isDrawing = false;

				//
				document.getElementById("btnRoof").onclick = function () {
				  if (isDrawing) {
					finalize();    
				  }
				  else {
					isDrawing = true;
				  }
				};

				//
				fabric.util.addListener(window, "dblclick", function () { 
				  if (isDrawing) {
					finalize();    
				  }
				});

				//
				fabric.util.addListener(window, "keyup", function (evt) { 
				  if (evt.which === 13 && isDrawing) {
					finalize();    
				  }
				});

				overlay.fabricCanvas().on("mouse:down", function (evt) {
				  if (isDrawing) {
					var _mouse = this.getPointer(evt.e);    
					var _x = _mouse.x;
					var _y = _mouse.y;
					var line = new fabric.Line([_x, _y, _x, _y], {
					  strokeWidth: 1,
					  selectable: false,
					  stroke: "red"
					});

					polygonPoints.push(new fabric.Point(_x, _y));
					lines.push(line);
					
					this.add(line);
					this.selection = false;
				  }
				  
				});
					
				overlay.fabricCanvas().on("mouse:move", function (evt) {
				  if (lines.length && isDrawing) {  
					var _mouse = this.getPointer(evt.e);    
					lines[lines.length-1].set({
					  x2: _mouse.x,
					  y2: _mouse.y
					}).setCoords();
					this.renderAll();
				  }
				});

				//
				function finalize () {
					isDrawing = false;

				  lines.forEach(function (line) {
					line.remove();
				  });

				  overlay.fabricCanvas().add(makePolygon()).renderAll();
				  overlay.fabricCanvas().selection = true;
				  lines.length = 0;
				  polygonPoints.length = 0;
				}

				//
				function makePolygon () {

				  var left = fabric.util.array.min(polygonPoints, "x");
				  var top = fabric.util.array.min(polygonPoints, "y");

				  polygonPoints.push(new fabric.Point(polygonPoints[0].x, polygonPoints[0].y));

				  return new fabric.Polygon(polygonPoints.slice(), {
					left: left,
					top: top,
					fill: "rgba(255,0,0,.5)",
					stroke: "black"
				  });
				}

			';
			
			return $setscript;
				
		}

}

?>