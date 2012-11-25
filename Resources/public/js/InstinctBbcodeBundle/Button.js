if(!InstinctBbcodeBundle)
{
    var InstinctBbcodeBundle = {};
}

(function()
{
    InstinctBbcodeBundle.Button = function(code)
    {
        this.code = code;
        this.html = '<div class="instinct_bbcode_button instinct_bbcode_button_-'
            + this.code + '-"></div>';
        this.element = null;
    };

    InstinctBbcodeBundle.Button.prototype = {
        html: "",
        code: "",
        className: "",
        element: null,
        registerEvents: function(target)
        {
            var code = this.code;
            this.element.click(function()
            {
                target.focus();
                var selObj = new InstinctBbcodeBundle.Utils.Selection();
                var text = selObj.getText();
                // console.log(text);
                if(text == '')
                {
                    text = prompt('');
                    if(text == null)
                    {
                        text = '';
                    }
                }

                if(text != '')
                {
                    selObj.replaceBy('[' + code + ']' + text + '[/' + code
                        + ']');
                }
            });
        },
    };

    var self = InstinctBbcodeBundle.Button;
})();
