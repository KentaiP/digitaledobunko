DROP TABLE IF EXISTS `#__edobunko`;
 
CREATE TABLE `#__edobunko` (
	`id`       INT(11)     NOT NULL AUTO_INCREMENT,
	`title` VARCHAR(255) NOT NULL,
	`location` VARCHAR(255) NOT NULL,
	`overlay` MEDIUMTEXT NOT NULL,
	`published` tinyint(4) NOT NULL DEFAULT '1',
	PRIMARY KEY (`id`)
)
	ENGINE =MyISAM
	AUTO_INCREMENT =0
	DEFAULT CHARSET =utf8;
 
INSERT INTO `#__edobunko` (`title`, `location`, `overlay`) VALUES
('Testscan', 'images/edobunko/deepzoom/testscan', '{"objects":[{"type":"i-text","originX":"left","originY":"top","left":1984.24,"top":896.2,"width":56,"height":210.09,"fill":"#000","stroke":null,"strokeWidth":1,"strokeDashArray":null,"strokeLineCap":"butt","strokeLineJoin":"miter","strokeMiterLimit":10,"scaleX":1,"scaleY":1,"angle":0,"flipX":false,"flipY":false,"opacity":1,"shadow":null,"visible":true,"clipTo":null,"backgroundColor":"","fillRule":"nonzero","globalCompositeOperation":"source-over","transformMatrix":null,"skewX":0,"skewY":0,"text":"ちくや","fontSize":56,"fontWeight":"normal","fontFamily":"Times New Roman","fontStyle":"","lineHeight":1.16,"textDecoration":"","textAlign":"left","textBackgroundColor":"","charSpacing":0,"styles":{}},{"type":"i-text","originX":"left","originY":"top","left":3061.81,"top":731.07,"width":57.7,"height":734.5,"fill":"#000","stroke":null,"strokeWidth":1,"strokeDashArray":null,"strokeLineCap":"butt","strokeLineJoin":"miter","strokeMiterLimit":10,"scaleX":1,"scaleY":1,"angle":0,"flipX":false,"flipY":false,"opacity":1,"shadow":null,"visible":true,"clipTo":null,"backgroundColor":"","fillRule":"nonzero","globalCompositeOperation":"source-over","transformMatrix":null,"skewX":0,"skewY":0,"text":"test","fontSize":130,"fontWeight":"normal","fontFamily":"Times New Roman","fontStyle":"","lineHeight":"1.0","textDecoration":"","textAlign":"left","textBackgroundColor":"","charSpacing":0,"styles":{}},{"type":"i-text","originX":"left","originY":"top","left":969.94,"top":1295.66,"width":127.47,"height":734.5,"fill":"#000","stroke":null,"strokeWidth":1,"strokeDashArray":null,"strokeLineCap":"butt","strokeLineJoin":"miter","strokeMiterLimit":10,"scaleX":1,"scaleY":1,"angle":0,"flipX":false,"flipY":false,"opacity":1,"shadow":null,"visible":true,"clipTo":null,"backgroundColor":"","fillRule":"nonzero","globalCompositeOperation":"source-over","transformMatrix":null,"skewX":0,"skewY":0,"text":"な\\nく\\nさ\\nめ","fontSize":130,"fontWeight":"normal","fontFamily":"Times New Roman","fontStyle":"","lineHeight":"1.0","textDecoration":"","textAlign":"left","textBackgroundColor":"","charSpacing":0,"styles":{}}]}');