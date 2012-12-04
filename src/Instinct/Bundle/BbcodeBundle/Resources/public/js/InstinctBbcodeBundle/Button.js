if(!InstinctBbcodeBundle)
{
    var InstinctBbcodeBundle = {};
}

(function()
{
    InstinctBbcodeBundle.Button = function(tag)
    {
        this.tag = tag;
        this.html = '';
        this.element = null;
        this.className = 'instinct_bbcode_button_-' + this.tag.name + '-';
    };

    InstinctBbcodeBundle.Button.prototype =
    {
        html: "",
        tag: "",
        className: "",
        element: null,
        getHtml: function()
        {
            var html = "";
            var className = this.className; 
            html = '<div class="instinct_bbcode_button ' + className
                + '">';
            if(this.tag.options != null)
            {
                html += '<select>';
                html += '<option>';
                html += this.tag.name;
                html += '</option>';
                $.each(this.tag.options, function(attr, options)
                {
                    html += '<optgroup label="' + attr + '">';
                    for( var value in options)
                    {
                        html += '<option value="' + options[value] + '">';
                        html += options[value];
                        html += '</option>';
                    }
                    html += '</optgroup>';
                });
                html += '</select>';
            }
            html += "</div>";
            this.html = html;
            return html;
        },
        registerEvents: function(target)
        {
            var button = null;
            var tag = this.tag;
            
            if(tag.options == null)
            {
                button = this.element;
            }
            else
            {
                button = this.element.find("option");
            }
            
            button.click(function()
            {
                target.focus();
                var selObj = new InstinctBbcodeBundle.Utils.Selection();
                var text = selObj.getText();
                
                // console.log(text);
                if(tag.options != null)
                {
                    var attrList = {};                    
                    var attr = $(this).parent().attr('label');
                    var value = $(this).attr('value');
                    attrList[attr] = value;
                    selObj.replaceBy(tag.buildBbcode(text, attrList));
                }
                else if(tag.hasContent)
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
