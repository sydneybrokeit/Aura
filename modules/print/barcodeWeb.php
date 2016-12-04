<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
	if (isset($_GET["sku"]) && !empty($_GET["sku"])) {
		sendSku($_GET["sku"]);
	}
}



function sendSKU($sku)
{
	$printer = "Stage1";
	echo '<script>
            var http = new XMLHttpRequest();
            var url = "http://10.0.2.252/printer/aura.php";
            var params = "sku='.$sku.'&printer=' . $printer . '";
            http.open("POST", url, true);

            //Send the proper header information along with the request
            http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

            http.onreadystatechange = function() {//Call a function when the state changes.
            if(http.readyState == 4 && http.status == 200) {
                alert(http.responseText);
            }
        }
        http.send(params);
		window.location.href = "/new/index.php?success=true&sku=' .$sku .'";
        </script>';
}

?>