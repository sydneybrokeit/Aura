// not sure why we need multiple, but ¯\_(ツ)_/¯
$('#submit').hide();
$('#false-submit').attr("disabled", "disabled");
$('#untestable').click(function () {
    if ($(this).attr('checked') == false) {
        $('#false-submit').attr("disabled", "disabled");
    } else {
        $('#false-submit').removeAttr('disabled');
    }
});
$('#false-submit').attr("disabled", "disabled");
$('#parts').click(function () {
    if ($(this).attr('checked') == false) {
        $('#false-submit').attr("disabled", "disabled");
    } else {
        $('#false-submit').removeAttr('disabled');
    }
});

$('#testedreset').click(function () {
    if ($(this).attr('checked') == false) {
        $('#false-submit').attr("disabled", "disabled");
    } else {
        $('#false-submit').removeAttr('disabled');
    }
});
$('#false-submit').click(function () {
  $('#hidden-notice').css("visibility", "visible");
  $('#submit').show();
  $('#false-submit').hide();
});
