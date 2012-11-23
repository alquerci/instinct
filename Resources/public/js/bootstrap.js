var InstinctBbcodeBundle = {}; // on déclare un namespace
(function(){ // début de scope local
	InstinctBbcodeBundle.Utils = InstinctBbcodeBundle.Utils || {};
		
	// construct
	InstinctBbcodeBundle.Utils.Selection = function()
	{
	};
	
	InstinctBbcodeBundle.Utils.Selection.prototype = 
	{
			text:"",
			element:null,
			isEdit:false,
				
			getText:function()
			{
			    var selText = "";
			    if (window.getSelection)
			    {  // all browsers, except IE before version 9
			        if (document.activeElement && 
			                (document.activeElement.tagName.toLowerCase() == "textarea" || 
			                 document.activeElement.tagName.toLowerCase() == "input")
			           	) 
			        {
			        	this.element = document.activeElement;
			        	this.isEdit = true;
			            var text = document.activeElement.value;
			            selText = text.substring (document.activeElement.selectionStart, 
			                                      document.activeElement.selectionEnd);
			        }
			        else 
			        {
			            var selRange = window.getSelection();
			            selText = selRange.toString();
			            this.element = selRange;
			        }
			    }
			    else if (document.selection.createRange) 
			    { // Internet Explorer
			            var range = document.selection.createRange();
			            selText = range.text;
			            this.element = range;			        
			    }
			    this.text = selText;
			    return selText;
			},
			
			setText:function(text)
			{
				if(this.isEdit)
				{
					this.element.value = text;
				}
				else
				{
					this.element.text = text;
				}
			}
	};	
	
	// trick JavaScript pour émuler le self:: en PHP : 
	// on utilise une variable locale
	var self = InstinctBbcodeBundle.Utils.Selection;
})();


$(function(document){
	var textarea = $('textarea');
	textarea.css("width", "100%");
//	textarea.before('<textarea class="instinct_bbcode">'+textarea.text()+'</textarea>');
//	
	textarea.mouseup(function(document) {
		var selObj = new InstinctBbcodeBundle.Utils.Selection();
		var text = selObj.getText();
		console.log(text);	
		selObj.setText('[b]'+text+'[/b]');
	});
});