$.fn.myTextEditor = function(options) {		    
    var settings = $.extend({
        width : "600px",
        height : "350px"
    }, options);

    return this.each(function() {
       	var $this = $(this).hide();

	   	var containerDiv = $("<div/>", {
	       	css : {
	           	width  : settings.width,
	           	height : settings.height,
	           	border : "1px solid #ccc",
	           	margin : "0 auto",
	           	"font-family" : "Arial, Verdana"
	       	}
	   	});

	   	$this.after(containerDiv); 

	   	var editor = $("<iframe/>",{
	       	frameborder : "0",
	       	css : {
	           	width : settings.width,
	           	height : settings.height
	       	}
	   	}).appendTo(containerDiv).get(0);
	   
	   	editor.contentWindow.document.open();
	   	editor.contentWindow.document.close();
	   	editor.contentWindow.document.designMode = "on";

	   	var buttonPane = $("<div/>",{
		    "class" : "editor-btns",
		    css : {
		        width : settings.width,
		        height : "20px"
		    }
		}).prependTo(containerDiv);
		
		var btnBold = $("<button/>",{
			class : "bold btn btn-inverse",					    
		    text  : "Bold",
		    data  : {
		        commandName : "bold"
		    },
		    click : addBold 
		}).appendTo(buttonPane);

		var btnItalic = $("<button/>",{
			class   : "italic btn btn-inverse",					    
		    text : "Italic",
		    data : {
		        commandName : "italic"
		    },
		    click : execCommand 
		}).appendTo(buttonPane);

		var btnUnderline = $("<button/>",{
			class   : "underline btn btn-inverse",					    
		    text : "Underline",
		    data : {
		        commandName : "underline"
		    },
		    click : execCommand 
		}).appendTo(buttonPane);

		var btnCode = $("<button/>",{
			class   : "code btn btn-inverse",					    
		    text : "Code",
		    data : {
		        commandName : "underline"
		    },
		    click : addCode 
		}).appendTo(buttonPane);

		function addBold(e) {
			$(this).toggleClass("selected");
		    
		    var contentWindow = editor.contentWindow;
		    var content = contentWindow.document.body.innerHTML;					    
		    
			var value1 = '<strong>';
			var value2 = '</strong>';

    		var startPos = contentWindow.selectionStart;
    		var endPos = contentWindow.selectionEnd;
    		var scrollTop = contentWindow.scrollTop;			    				    			    	

    		content = content.substring(0, startPos) + value1 + content.substring(endPos, content.length) + value2;
    
    		contentWindow.selectionStart = startPos + value1.length;
    		contentWindow.selectionEnd = startPos + value2.length;
    		contentWindow.scrollTop = scrollTop;
    	
		    contentWindow.document.body.innerHTML = content;
		    
		    contentWindow.focus();
		    //contentWindow.document.execCommand($(this).data("commandName"), false, "");
		    contentWindow.focus();

		    return false;			
		}

		function addCode(e) {
			$(this).toggleClass("selected");
		    
		    var contentWindow = editor.contentWindow;
		    var content = contentWindow.document.body.innerHTML;					    

		    
			var value1 = '<div class="code">Write your code...';
			var value2 = '</div>';

    		var startPos = contentWindow.selectionStart;
    		var endPos = contentWindow.selectionEnd;
    		var scrollTop = contentWindow.scrollTop;			    				    			    	

    		content = content.substring(0, startPos) + value1 + content.substring(endPos, content.length) + value2;
    
    		contentWindow.selectionStart = startPos + value1.length;
    		contentWindow.selectionEnd = startPos + value2.length;
    		contentWindow.scrollTop = scrollTop;
    	
		    contentWindow.document.body.innerHTML = content;
		    
		    contentWindow.focus();
		    //contentWindow.document.execCommand($(this).data("commandName"), false, "");
		    contentWindow.focus();

		    return false;
		}

		function execCommand(e) {
		    $(this).toggleClass("selected");
		    
		    var contentWindow = editor.contentWindow;
		    
		    contentWindow.focus();
		    contentWindow.document.execCommand($(this).data("commandName"), false, "");
		    contentWindow.focus();

		    return false;
		}
    });
} 			

$(function(){
    $("textarea").myTextEditor();

    $("iframe").contents().find('body').css({'font-family' : 'Arial, Verdana', 'font-size' : '0.85em', 'color' : '#333'});			    
});			

$(document).on("keydown", "#editor", function(e){ 
		var keyCode = e.keyCode || e.which;   				

    if(keyCode == 9) {
    	var html = $('#editor').val();
    	var myValue = "\t";
    	var startPos = $('#editor')[0].selectionStart;
    	var endPos = $('#editor')[0].selectionEnd;
    	var scrollTop = $('#editor')[0].scrollTop;			    				    			    	

    	var content = html.substring(0, startPos) + myValue + html.substring(endPos, html.length);

    	$('#editor').focus();

    	$('#editor')[0].selectionStart = startPos + myValue.length;
    	$('#editor')[0].selectionEnd = startPos + myValue.length;
    	$('#editor')[0].scrollTop = scrollTop;

    	$('#editor').val(content);

    	e.preventDefault();
    }			
});