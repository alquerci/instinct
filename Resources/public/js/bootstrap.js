if(!InstinctBbcodeBundle)
{
    var InstinctBbcodeBundle = {};
}

InstinctBbcodeBundle.tags =
[
    new InstinctBbcodeBundle.Tag("b"), new InstinctBbcodeBundle.Tag("i"),
    new InstinctBbcodeBundle.Tag("i"), new InstinctBbcodeBundle.Tag("s"),
    new InstinctBbcodeBundle.Tag("code"),
    new InstinctBbcodeBundle.Tag("center"),
    new InstinctBbcodeBundle.Tag("quote"),
    new InstinctBbcodeBundle.Tag("url", true, true, "=%url%",
    {
        url: "http://"
    }),
    new InstinctBbcodeBundle.Tag("email", true, true, "=%email%",
    {
        email: "email@domain.com"
    }),
    new InstinctBbcodeBundle.Tag("img"),
    new InstinctBbcodeBundle.Tag("video", true, true, "=%host%",
    {
        host: "youtube"
    }),
];

$(function()
{
    var buttons = new Array();

    for( var int = 0; int < InstinctBbcodeBundle.tags.length; int++)
    {
        buttons[int] = new InstinctBbcodeBundle.Button(
            InstinctBbcodeBundle.tags[int]);
    }

    $('textarea').each(function()
    {
        var target = $(this);
        var toolbar = new InstinctBbcodeBundle.Toolbar(target, buttons);
        toolbar.build();
    });
});
