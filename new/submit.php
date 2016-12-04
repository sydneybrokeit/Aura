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
	$root = $_SERVER["DOCUMENT_ROOT"] . "/";
	$settings = json_decode(file_get_contents($root . "config.json"), true);
	if($settings["printMethod"]){
		header("location: /modules/print/?sku=" . $sku);
	}else{
		header("location: index.php?success=false&error='crap" . $settings);
	}


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
