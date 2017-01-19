// not sure why we need multiple, but ¯\_(ツ)_/¯
$('#submit').attr("disabled", "disabled");
$('#untestable').click(function () {
    if ($(this).attr('checked') == false) {
        $('#submit').attr("disabled", "disabled");
    } else {
        $('#submit').removeAttr('disabled');
    }
});
$('#submit').attr("disabled", "disabled");
$('#parts').click(function () {
    if ($(this).attr('checked') == false) {
        $('#submit').attr("disabled", "disabled");
    } else {
        $('#submit').removeAttr('disabled');
    }
});

$('#tested/reset').click(function () {
    if ($(this).attr('checked') == false) {
        $('#submit').attr("disabled", "disabled");
    } else {
        $('#submit').removeAttr('disabled');
    }
});
