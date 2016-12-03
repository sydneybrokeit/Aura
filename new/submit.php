<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 3.2//EN">

<html>
<head>
    <title></title>
</head>

<body>
    <table>
        <?php

error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 'On');

header('Access-Control-Allow-Origin: *');
function generateRandomString($length = 19)
{
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$charactersLength = strlen($characters);
	$randomString = '';
	for ($i = 0; $i < $length; $i++) {
		$randomString .= $characters[rand(0, $charactersLength - 1)];
	}
	return $randomString;
}

function sendSKU($printer = "Stage1", $sku)
{
	echo '<script>
            var http = new XMLHttpRequest();
            var url = "http://10.0.2.252/printer/aura.php";
            var params = "sku='.$sku.'&printer=Stage1";
            http.open("POST", url, true);

            //Send the proper header information along with the request
            http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

            http.onreadystatechange = function() {//Call a function when the state changes.
            if(http.readyState == 4 && http.status == 200) {
                alert(http.responseText);
            }
        }
        http.send(params);
        window.location.href = "index.php?success=true&sku=' .$sku .'";
        </script>';
}
function returnWithError($error = "None"){
	echo '<script>window.location.href = "index.php?success=false&error='. $error . '"; </script>';
}
$sku = generateRandomString(15);
$filename = "../results/data/" . $sku . ".json";



if(file_put_contents($filename, json_encode($_POST))){
	
	sendSKU("Stage1", $sku);
}else{
	returnWithError(is_writable($filename));
	echo $filename;
	echo "File not writable";
}


?>
    </table>
</body>
</html>
