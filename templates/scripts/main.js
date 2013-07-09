$(document).ready(function() {

	// this converts images in the bodycopy to have captions under them
	$("#bodycopy p img[alt]").each(function() {
		var $img = $(this); 
		var width = $img.width();	
		var imgClass = $img.attr('class'); 
		var $div = $("<div />")
			.attr('class', 'image_caption ' + imgClass)
			.css('width', width + 'px'); 
		$img.wrap($div).removeClass(imgClass); 
		$div.append($("<small>" + $img.attr('alt') + "</small>")); 
	}); 

}); 
