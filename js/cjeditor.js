$(document).on("ready", function(){
	editorFrame.document.designMode = 'on';

	$("#editorFrame").contents().find('body').css({'font-family' : 'Arial, Verdana', 'font-size' : '0.85em', 'color' : '#333'});

	$($("#editorFrame").contents()).on("keydown", function(e) {
    	var keyCode = e.keyCode || e.which;    	

    	if(keyCode == 9) {
    		editorFrame.document.execCommand('Indent', false, null);
    	}

    	if(keyCode == 13) { 
    		$("#editorFrame").contents().find('body').html($("#editorFrame").contents().find('body').html().replace(/<div>(.*)<\/div>/g, "<p>$1</p>"));
    	}
    });       


	$('#bold').on("click", function(){
		editorFrame.document.execCommand('Bold', false, null);

		$("#editorFrame").contents().find('body').html($("#editorFrame").contents().find('body').html().replace("<b>", "<strong>"));		
	});

	$('#italic').on("click", function(){
		editorFrame.document.execCommand('Italic', false, null);

		$("#editorFrame").contents().find('body').html($("#editorFrame").contents().find('body').html().replace("<i>", "<em>"));
	});

	$('#underline').on("click", function(){
		editorFrame.document.execCommand('underline', false, null);		
	});

	$('#ul').on("click", function(){
		editorFrame.document.execCommand('InsertUnorderedList', false, null);		
	});

	$('#ol').on("click", function(){
		editorFrame.document.execCommand('InsertOrderedList', false, null);
	});

	$('#link').on("click", function(){
		var URL = prompt("URL for this link", "http://");

		editorFrame.document.execCommand('CreateLink', false, URL);
	});

	$('#unlink').on("click", function(){
		editorFrame.document.execCommand('Unlink', false, null);
	});	

	$('#image').on("click", function(){
		var image = prompt("Image URL", "");

		if(image != null) {	
			editorFrame.document.execCommand('InsertImage', false, image);
		}
	});
});
