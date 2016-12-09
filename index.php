

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN">

<html>
<head>
    <link rel="stylesheet" type="text/css" href="<?php echo str_replace(basename($_SERVER['PHP_SELF']), '', $_SERVER['REQUEST_URI']); ?>css/main.css">

    <title>Aura</title>
</head>

<body>
  <div class="container">
  <div class="header" id="home">
    <h1 class="page-title">Aura</h1>

    <div class="links">
        <a href="new">New</a> <a href="results">Search</a>
    </div>
    <div class="footer">
      <p>
        Support: Yell at Harold for help</p>
    </div>
  </div>
    <div class="wrapper">


      <div class="inner-wrapper">
        <div class="recent">
            <h3>Recent SKUs:</h3>

            <table class="recent">
                <?php


include 'php-barcode-generator/src/BarcodeGenerator.php';
include 'php-barcode-generator/src/BarcodeGeneratorPNG.php';

function date_compare($a, $b)
{
    $t1 = strtotime($a['date']);
    $t2 = strtotime($b['date']);

    return $t2 - $t1;
}
function generateBarcodeFrom($sku)
{
    $generator = new \Picqer\Barcode\BarcodeGeneratorPNG();

    return  '<img src="data:image/png;base64,'.base64_encode($generator->getBarcode($sku, $generator::TYPE_CODE_93)).'"><br>'.$sku;
}
$path = 'results/data';
$files = scandir($path);
$files = array_diff(scandir($path), array('.', '..'));

usort($files, 'date_compare');
$files = array_slice($files, 0, 4, true);
echo '<tr><a href="results/result/?"><td class="header">SKU</td><td class="header">Information</td><td class="header">Brand</td>';
foreach ($files as $key => $value) {
    if (strpos($value, '.json')) {
        echo '<tr>';
        $sku = str_replace('.json', '', $value);
        $jsondata = json_decode(file_get_contents('results/data/'.$sku.'.json'), true);

        if ($jsondata['Brand'] == '') {
            $jsondata['Brand'] = 'Not supplied';
        }
        if ($jsondata['Model'] == '') {
            $jsondata['Model'] = 'Not supplied';
        }
        echo "<td class='barcode'><div class='barcode'>".generateBarcodeFrom($sku).'</div></td>';
        echo "<td class='model'>".$jsondata['Model'].', '.$jsondata['condition']."</td><td class='brand'>".$jsondata['Brand'].'</td>';
        echo '</tr></a>';
    }
}
?>
            </table>
        </div>

      </div>

    </div>
  </div>
</body>
</html>
