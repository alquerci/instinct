if(!InstinctBbcodeBundle)
{
    var InstinctBbcodeBundle = {};
}

(function()
{
    InstinctBbcodeBundle.Tag = function(name, hasContent, hasAttr, attrPattern,
        attrList)
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
    };

    InstinctBbcodeBundle.Tag.prototype =
    {
        name: "", // required
        hasContent: true, // Optional
        hasAttr: false, // Optional
        attrPattern: "", // Optional
        attrList: null, // Optional {name:value, ...}
        buildBbcode: function(content)
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
                $.each(this.attrList, function(attr, value){
                    value = prompt(attr, value);
                    attributes = attributes.replace("%"+attr+"%", '"'+value+'"');
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
