jQuery( document ).ready(function() {
var viewer = OpenSeadragon({
        id: "openseadragon1",
        tileSources: "https://houseki.de/edobunko/images/edobunko/deepzoom/test/test.xml",
		overlays: [{
            id: 'example-overlay',
            x: 0, 
            y: 0, 
            width: 1, 
            height: 1,
            className: 'bleach'
        }]
    });
	
var overlay = viewer.fabricjsOverlay(); 

	var text = new fabric.IText("", { fontSize: 56, left: 1984.2439677703876, top: 896.1985059402691,  fill: '#000' });

	overlay.fabricCanvas().add(text);
    var castcanvas = overlay.fabricCanvas();
	var loadoverlay = '{"objects":[{"type":"i-text","originX":"left","originY":"top","left":1984.24,"top":896.2,"width":56,"height":210.09,"fill":"#000","stroke":null,"strokeWidth":1,"strokeDashArray":null,"strokeLineCap":"butt","strokeLineJoin":"miter","strokeMiterLimit":10,"scaleX":1,"scaleY":1,"angle":0,"flipX":false,"flipY":false,"opacity":1,"shadow":null,"visible":true,"clipTo":null,"backgroundColor":"","fillRule":"nonzero","globalCompositeOperation":"source-over","transformMatrix":null,"skewX":0,"skewY":0,"text":"ちくや","fontSize":56,"fontWeight":"normal","fontFamily":"Times New Roman","fontStyle":"","lineHeight":1.16,"textDecoration":"","textAlign":"left","textBackgroundColor":"","charSpacing":0,"styles":{}},{"type":"i-text","originX":"left","originY":"top","left":3061.81,"top":731.07,"width":57.7,"height":734.5,"fill":"#000","stroke":null,"strokeWidth":1,"strokeDashArray":null,"strokeLineCap":"butt","strokeLineJoin":"miter","strokeMiterLimit":10,"scaleX":1,"scaleY":1,"angle":0,"flipX":false,"flipY":false,"opacity":1,"shadow":null,"visible":true,"clipTo":null,"backgroundColor":"","fillRule":"nonzero","globalCompositeOperation":"source-over","transformMatrix":null,"skewX":0,"skewY":0,"text":"test","fontSize":130,"fontWeight":"normal","fontFamily":"Times New Roman","fontStyle":"","lineHeight":"1.0","textDecoration":"","textAlign":"left","textBackgroundColor":"","charSpacing":0,"styles":{}},{"type":"i-text","originX":"left","originY":"top","left":969.94,"top":1295.66,"width":127.47,"height":734.5,"fill":"#000","stroke":null,"strokeWidth":1,"strokeDashArray":null,"strokeLineCap":"butt","strokeLineJoin":"miter","strokeMiterLimit":10,"scaleX":1,"scaleY":1,"angle":0,"flipX":false,"flipY":false,"opacity":1,"shadow":null,"visible":true,"clipTo":null,"backgroundColor":"","fillRule":"nonzero","globalCompositeOperation":"source-over","transformMatrix":null,"skewX":0,"skewY":0,"text":"nakusame","fontSize":130,"fontWeight":"normal","fontFamily":"Times New Roman","fontStyle":"","lineHeight":"1.0","textDecoration":"","textAlign":"left","textBackgroundColor":"","charSpacing":0,"styles":{}}]}';	
	loadoverlay.split("\n").join("\\n");
	castcanvas.loadFromJSON(loadoverlay, castcanvas.renderAll.bind(castcanvas),function(o,object){
    console.log(o,object)
	});
	
	overlay.fabricCanvas().on('object:modified', function(o) {

    var text1 = overlay.fabricCanvas().item(0).getTop() + " - " + overlay.fabricCanvas().item(0).getLeft();
	
    });
	
	function addline() 
	{
		
	var toadd = jQuery("#insertline1").val();
	toadd = toadd.replace(/(.{1})/g, "jQuery1\n");
	
	var setlineheight = jQuery("#insertline2").val();
	
	var text = new fabric.IText(toadd, { fontSize: 130, left: 0, top: 0,  fill: '#000', lineHeight: '1' });
	overlay.fabricCanvas().add(text);
	
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
	
	function lminus()
	{
	var castcanvas = overlay.fabricCanvas();
	var getlineheight = castcanvas.getActiveObject().get('lineHeight');
	getlineheight = getlineheight - 0.05;
	castcanvas.getActiveObject().set('lineHeight', getlineheight);	
	castcanvas.renderAll();
	}	
	
	function lplus()
	{
	var castcanvas = overlay.fabricCanvas();
	var getlineheight = castcanvas.getActiveObject().get('lineHeight');
	getlineheight = getlineheight + 0.05;
	castcanvas.getActiveObject().set('lineHeight', getlineheight);	
	castcanvas.renderAll();	
	}	
	
	function setcolor()
	{
	var castcanvas = overlay.fabricCanvas();
	var colorset = jQuery("#colorset").val();
	castcanvas.getActiveObject().set('fill', colorset);	
	castcanvas.renderAll();	
	}	
	
	jQuery( '#overlayslider' ).slider({
							step: 0.05,
							value: 0.7,
							max: 1,
							min: 0,
                            change: function( event, ui ) {												
							
							jQuery( '#example-overlay' ).css("opacity", ui.value);
							
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
							
	
	viewer.addHandler('resize', function(target, info) {
	fabricviewer.resize();
	});

});
