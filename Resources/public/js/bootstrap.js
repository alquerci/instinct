var InstinctBbcodeBundle = {}; // on déclare un namespace
(function(){ // début de scope local
	InstinctBbcodeBundle.Utils = InstinctBbcodeBundle.Utils || {};
		
	// construct
	InstinctBbcodeBundle.Utils.Selection = function()
	{
		this.selText = "";
		this.textBefore = "";
		this.textAfter = "";
		this.element = null;
		this.isEdit = false;
	};
	
	InstinctBbcodeBundle.Utils.Selection.prototype = 
	{
			selText:"",
			textBefore:"",
			textAfter:"",
			element:null,
			isEdit:false,
				
			getText:function()
			{
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
			            this.selText = text.substring(document.activeElement.selectionStart, 
			                                      document.activeElement.selectionEnd);
			            this.textBefore = text.substring(0, this.element.selectionStart);
			            this.textAfter = text.substring(this.element.selectionEnd, this.element.textLength);
			        }
			        else 
			        {
			            var selRange = window.getSelection();
			            this.selText = selRange.toString();
			            this.element = selRange;
			        }
			    }
			    else if (document.selection.createRange) 
			    { // Internet Explorer
			            var range = document.selection.createRange();
			            this.selText = range.text;
			            this.element = range;			        
			    }
			    return this.selText;
			},
			
			replaceBy:function(text)
			{
				if(this.isEdit)
				{
					this.element.value = this.textBefore + text + this.textAfter;
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
	textarea.css("height", "300px");
	textarea.before('<div class="instinct_bbcode_bold"></div>');
	$('.instinct_bbcode_bold').click(function(document) {
		textarea.focus();
		var selObj = new InstinctBbcodeBundle.Utils.Selection();
		var text = selObj.getText();
		console.log(text);
		if(text != '')
		{
			selObj.replaceBy('[b]'+text+'[/b]');
		}
	});
	textarea.before('<div class="instinct_bbcode_underline"></div>');
	$('.instinct_bbcode_underline').click(function(document) {
		textarea.focus();
		var selObj = new InstinctBbcodeBundle.Utils.Selection();
		var text = selObj.getText();
		console.log(text);
		if(text != '')
		{
			selObj.replaceBy('[u]'+text+'[/u]');
		}
	});
	
});