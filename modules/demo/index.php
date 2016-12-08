<?php
$root = $_SERVER["DOCUMENT_ROOT"] . "/";


if ($_SERVER['REQUEST_METHOD'] === 'GET') {
	if (isset($_GET["sku"]) && !empty($_GET["sku"])) {
		echo $_GET["sku"];
	}
}


if (!isset($_GET["sku"]) && empty($_GET["sku"])) {
	header("location: /");
	
}

?>