if(!InstinctBbcodeBundle)
{
    var InstinctBbcodeBundle = {};
}

(function()
{
    InstinctBbcodeBundle.Button = function(tag)
    {
        this.tag = tag;
        this.html = '<div class="instinct_bbcode_button instinct_bbcode_button_-'
            + this.tag.name + '-"></div>';
        this.element = null;
    };

    InstinctBbcodeBundle.Button.prototype =
    {
        html: "",
        tag: "",
        className: "",
        element: null,
        registerEvents: function(target)
        {
            var tag = this.tag;
            this.element.click(function()
            {
                target.focus();
                var selObj = new InstinctBbcodeBundle.Utils.Selection();
                var text = selObj.getText();
                // console.log(text);
                if(tag.hasContent == true)
                {
                    selObj.replaceBy(tag.buildBbcode(text));
                }
                else
                {
                    target.append(tag.buildBbcode());
                }
            });
        },
    };

    var self = InstinctBbcodeBundle.Button;
})();
