if(!InstinctBbcodeBundle)
{
    var InstinctBbcodeBundle = {};
}

(function()
{
    InstinctBbcodeBundle.Toolbar = function(target, buttons)
    {
        this.buttons = buttons;
        this.target = target;
        this.className = "instinct_bbcode_toolbar";
        this.element = null;
    };

    InstinctBbcodeBundle.Toolbar.prototype =
    {
        buttons : null,
        element : null,
        target : null,
        className : "",
        build : function()
        {
            this.target.before('<div class="' + this.className + '"></div>');
            this.element = this.target.prev();
            var button = null;
            for( var int = 0; int < this.buttons.length; int++)
            {
                button = this.buttons[int];
                this.element.append(button.html);
                button.element = this.element.find(':last-child');
                button.registerEvents(this.target);
            }
        },
    };

    var self = InstinctBbcodeBundle.Toolbar;
})();
