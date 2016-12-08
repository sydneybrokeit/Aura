<?php
	use Aura\Settings as Settings;
	include ('../../settings/settings.php');
	

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
	if (isset($_GET["sku"]) && !empty($_GET["sku"])) {
		directPrinting($_GET["sku"]);
	}
}

function directPrinting($sku){
	$settings = new Settings;
	if($settings->getPrintMethod() == "System"){
		header("location: systemPrinting.php?sku=" . $sku);
	}else{
		header("location: barcodeWeb.php?sku=" . $sku);
	}
}
if (!isset($_GET["sku"]) && empty($_GET["sku"])) {
	$settings = new Settings;
	header("location: " , $settings->getRoot());
	
}

?>
