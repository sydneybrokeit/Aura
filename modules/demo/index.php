<?php
$root = $_SERVER["DOCUMENT_ROOT"] . "/";
$settings = json_decode(file_get_contents($root . "config.json"), true);

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
	if (isset($_GET["sku"]) && !empty($_GET["sku"])) {
		echo $_GET["sku"];
	}
}


if (!isset($_GET["sku"]) && empty($_GET["sku"])) {
	header("location: /");
	
}

?>