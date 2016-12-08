var request = new XMLHttpRequest();

var selectForm = document.getElementById('printer')
   var contentType = "application/x-www-form-urlencoded; charset=utf-8";
   
request.open("GET", 'http://10.0.2.232/printer/printers.php', true);
request.timeout = 2000;
request.setRequestHeader('Content-type', contentType);

if (request.overrideMimeType) request.overrideMimeType(contentType);

request.onload = function(e) {
    if (request.readyState === 4 && request.status === 200) {

        lines = request.responseText.split('\n')

        for (var i = 0; i < lines.length; i++) {
            var d = lines[i];
            selectForm.options.add(new Option(d, d))
        }

        if (window.location.hash) {
            var hash = window.location.hash.substring(1); //Puts hash in variable, and removes the # character
            document.getElementById('sku').value = hash;
            hash = true;
        } else {

            chrome.tabs.executeScript({
                code: "window.getSelection().toString();"
            }, function(selection) {
                document.getElementById('sku').value = selection[0];
            });
        }
        for (var i = 0; i < selectForm.options.length; i++) {
            var d = selectForm.options[i];


            if (getCookie("printer") == d.text) {
                console.log("cookie printer " + d.text);
                selectForm.selectedIndex = i;
            }



        }


    } else {
        changeTagName(selectForm, 'img');
        document.getElementById("button").disabled = true;
    }
};
