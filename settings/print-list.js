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



var saveclass = null;

function savePrinter(cookieValue)
{
    var sel = document.getElementById('printer');

    saveclass = saveclass ? saveclass : document.body.className;
    document.body.className = saveclass + ' ' + sel.value;

    setCookie('printer', cookieValue, 365);
}

function setCookie(name,value,days) {
    if (days) {
        var date = new Date();
        date.setTime(date.getTime()+(days*24*60*60*1000));
        var expires = "; expires="+date.toGMTString();
    }
    else var expires = "";
    document.cookie = name+"="+value+expires+"; path=../; domain=10.0.2.232";
    console.log(document.cookie)
}

function getCookie(name) {
  var nameEQ = name + "=";
  var ca = document.cookie.split(';');
  for(var i = 0; i < ca.length; i++) {
    var c = ca[i];
    while (c.charAt(0) == ' ') c = c.substring(1, c.length);
    if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
  }
  return null;
}
