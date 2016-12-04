<?php
$root = $_SERVER["DOCUMENT_ROOT"] . "/";
$settings = json_decode(file_get_contents($root . "config.json"), true);

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
	if (isset($_GET["sku"]) && !empty($_GET["sku"])) {
		directPrinting($_GET["sku"]);
	}
}

function directPrinting($sku){
	if($settings['printMethod'] == "system"){
		header("location: systemPrinting.php?sku=" . $sku);
	}else{
		header("location: barcodeWeb.php?sku=" . $sku);
	}
}
if (!isset($_GET["sku"]) && empty($_GET["sku"])) {
	header("location: /");
	
}

?>