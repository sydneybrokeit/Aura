<?php

$root = str_replace(basename($_SERVER['PHP_SELF']), '', $_SERVER['REQUEST_URI']);
$settings = json_decode(file_get_contents($root.'config.json'), true);

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['sku']) && !empty($_GET['sku'])) {
        if ($settings['printMethod'] == 'system') {
            systemPrint($_GET['sku']);
        } else {
            barcodeWeb($_GET['sku'], 'Stage1');
        }
    }
}

function systemPrint($sku)
{
    header('location: systemPrinting.php?sku='.$sku);
}
function barcodeWeb($sku, $printer)
{
    header('location: barcodeWeb.php?sku='.$sku.'&printer='.$printer);
}

if (!isset($_GET['sku']) && empty($_GET['sku'])) {
    header('location: '.$root);
}
