if(!InstinctBbcodeBundle)
{
    var InstinctBbcodeBundle = {};
}

(function()
{
    InstinctBbcodeBundle.Tag = function(name, hasContent, hasAttr, attrPattern,
        attrList, options)
    {
        this.name = name; // required

        if(typeof hasContent === "undefined")
        {
            this.hasContent = true;
        }
        else
        {
            this.hasContent = hasContent;
        }

        if(typeof hasAttr === "undefined")
        {
            this.hasAttr = false;
        }
        else
        {
            this.hasAttr = hasAttr;
        }

        if(typeof attrPattern === "undefined")
        {
            this.attrPattern = "";
        }
        else
        {
            this.attrPattern = attrPattern;
        }

        if(typeof attrList === "undefined")
        {
            this.attrList = null;
        }
        else
        {
            this.attrList = attrList;
        }

        if(typeof options === "undefined")
        {
            this.options = null;
        }
        else
        {
            this.options = options;
        }
    };

    InstinctBbcodeBundle.Tag.prototype =
    {
        name: "", // required
        hasContent: true, // Optional
        hasAttr: false, // Optional
        attrPattern: "", // Optional
        attrList: null, // Optional {name:value, ...}
        options: null, // Optional {attr:[option1, ...], ...}
        buildBbcode: function(content, attrList)
        {
            if(this.hasContent === false)
            {
                return '[' + this.name + '/]';
            }
            
            var bbcode = "";
            var attributes = "";

            if(typeof content === "undefined")
            {
                content = "";
            }

            if(typeof attrList === "undefined")
            {
                attrList = null;
            }
            
            if(content == '')
            {
                content = prompt('TYPE CONTENT:'); // TODO languages
                if(content == null)
                {
                    content = '';
                }
            }

            if(this.hasAttr == true)
            {
                attributes = this.attrPattern;

                if(attrList !== null)
                {
                    $.each(attrList, function(attr, value){
                        attributes = attributes.replace("%"+attr+"%", '"'+value+'"');
                    });
                }
                $.each(this.attrList, function(attr, value){
                    if(attributes.match("%"+attr+"%"))
                    {
                        value = prompt(attr, value);
                        attributes = attributes.replace("%"+attr+"%", '"'+value+'"');
                    }
                });
            }

            if(content != '')
            {
                bbcode = '[' + this.name + attributes + ']' + content + '[/'
                    + this.name + ']';
            }

            return bbcode;
        },
    };

    var self = InstinctBbcodeBundle.Tag;
})();
