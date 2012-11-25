if(!InstinctBbcodeBundle)
{
    var InstinctBbcodeBundle = {};
}

(function()
{ // début de scope local
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

    InstinctBbcodeBundle.Utils.Selection.prototype = {
        selText: "",
        textBefore: "",
        textAfter: "",
        element: null,
        isEdit: false,

        getText: function()
        {
            if(window.getSelection)
            { // all browsers, except IE before version 9
                if(document.activeElement
                    && (document.activeElement.tagName.toLowerCase() == "textarea" || document.activeElement.tagName
                        .toLowerCase() == "input"))
                {
                    this.isEdit = true;
                    this.element = document.activeElement;
                    var text = this.element.value;
                    this.selText = text.substring(this.element.selectionStart,
                        this.element.selectionEnd);
                    this.textBefore = text.substring(0,
                        this.element.selectionStart);
                    this.textAfter = text.substring(this.element.selectionEnd,
                        this.element.textLength);
                }
                else
                {
                    this.element = window.getSelection();
                    this.selText = this.element.toString();
                }
            }
            else if(document.selection.createRange)
            { // Internet Explorer
                this.element = document.selection.createRange();
                this.selText = this.element.text;
            }
            return this.selText;
        },

        replaceBy: function(text)
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
