window.onload = function() {
    var request = new XMLHttpRequest();

    var selectForm = document.getElementById('printer');
    console.log(selectForm);
    var contentType = "application/x-www-form-urlencoded; charset=utf-8";

    request.open("GET", 'http://10.0.2.232/printer/printers.php', true);
    request.timeout = 2000;
    request.setRequestHeader('Content-type', contentType);
    console.log('print class loaded');
    if (request.overrideMimeType) request.overrideMimeType(contentType);

    request.onload = function(e) {
        if (request.readyState === 4 && request.status === 200) {

            lines = request.responseText.split('\n')

            for (var i = 0; i < lines.length; i++) {
                var d = lines[i];
                if (d != "") {
                    console.log(lines);
                    selectForm.options.add(new Option(d, d));
                }
            }
            for (var i = 0; i < selectForm.options.length; i++) {
                var d = selectForm.options[i];


                if (getCookie("printer") == d.text) {
                    console.log("cookie printer " + d.text);
                    selectForm.selectedIndex = i;
                }



            }


        }
    };

    // exception handling
    try {
        request.send(null);
    } catch (e) {
        console.log(e);
    }
};

function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}
