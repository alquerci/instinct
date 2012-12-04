if(!InstinctBbcodeBundle)
{
    var InstinctBbcodeBundle = {};
}

InstinctBbcodeBundle.tags =
[
    new InstinctBbcodeBundle.Tag("b"),
    new InstinctBbcodeBundle.Tag("i"),
    new InstinctBbcodeBundle.Tag("u"),
    new InstinctBbcodeBundle.Tag("s"),
    new InstinctBbcodeBundle.Tag("sup"),
    new InstinctBbcodeBundle.Tag("sub"),
    new InstinctBbcodeBundle.Tag("left"),
    new InstinctBbcodeBundle.Tag("center"),
    new InstinctBbcodeBundle.Tag("right"),
    new InstinctBbcodeBundle.Tag("justify"),
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
    new InstinctBbcodeBundle.Tag("code"),

    new InstinctBbcodeBundle.Tag("size", true, true, "=%size%",
    {
        size: "12"
    },
    {
        size:
        [
            "8", "10", "12", "14", "16", "18"
        ],
    }),
    new InstinctBbcodeBundle.Tag("color", true, true, "=%color%",
    {
        color: "Blue",
    },
    {
        color:
        [
            "Blue", 'Black', 'Gold', "Green", 'Orange', 'Red', 'Silver',
            'White'
        ],
    }),
    new InstinctBbcodeBundle.Tag("font", true, true, "=%font%",
    {
        font: "Arial",
    },
    {
        font:
        [
            "Arial", 'Verdana', 'Times', "Courier", 'Georgia'
        ],
    }),
    new InstinctBbcodeBundle.Tag("video", true, true, "=%host%",
    {
        host: "youtube"
    },
    {
        host:
        [
            "youtube", "vimeo", "veoh", "liveleak", "dailymotion", "myspace",
            'wegame', 'collegehumor'
        ],
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
