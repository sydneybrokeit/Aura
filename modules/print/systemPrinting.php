<?php

$root = 'http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME']).'/../../';
include $root.'php-barcode-generator/src/BarcodeGenerator.php';
include $root.'php-barcode-generator/src/BarcodeGeneratorPNG.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['sku']) && !empty($_GET['sku'])) {
        generateBarcodeFrom($_GET['sku']);
    }
}

function generateBarcodeFrom($sku)
{
    $generator = new \Picqer\Barcode\BarcodeGeneratorPNG();
    echo '<body style="text-align: center" onload="window.print()"><img src="data:image/png;base64,'.base64_encode($generator->getBarcode($sku, $generator::TYPE_CODE_93)).'"><br><meta http-equiv="refresh" content="1; url=/new/?success=true&sku='.$sku.'" />';
    echo  $sku;
}
