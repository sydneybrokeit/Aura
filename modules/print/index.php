<?php


if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['sku']) && !empty($_GET['sku'])) {
        $settings = json_decode(file_get_contents('http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME']).'/../../config.json'), true);
        if ($settings['printMethod'] == 'system') {
            systemPrint($_GET['sku']);
        } else {
            barcodeWeb($_GET['sku'], 'Stage1');
        }
    }
}

function systemPrint($sku)
{
    echo 'system';
    header('location: systemPrinting.php?sku='.$sku);
}
function barcodeWeb($sku, $printer)
{
    header('location: barcodeWeb.php?sku='.$sku.'&printer='.$printer);
}

if (!isset($_GET['sku']) && empty($_GET['sku'])) {
    header('location: '.$root);
}
