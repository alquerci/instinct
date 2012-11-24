if(!InstinctBbcodeBundle)
{
    var InstinctBbcodeBundle = {};
}

InstinctBbcodeBundle.tags = ["b", "i", "u", "s", "code", "center", "quote"];

$(function()
{
    var buttons = new Array();

    for( var int = 0; int < InstinctBbcodeBundle.tags.length; int++)
    {
        buttons[int] =
            new InstinctBbcodeBundle.Button(InstinctBbcodeBundle.tags[int]);
    }

    $('textarea').each(function()
    {
        var target = $(this);
        var toolbar = new InstinctBbcodeBundle.Toolbar(target, buttons);
        toolbar.build();
    });
});
