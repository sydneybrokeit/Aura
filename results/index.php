<head>
  <link rel="stylesheet" type="text/css" href="../css/main.css">
  <title>Aura|SKUs</title>
</head>
<body>
	  <div class="container">
  <div class="wrapper">
	  
	    <div class="header" id="home">
   <img class="page-title" src="../images/AuraLogo.png">
     <h2 class="page-title">Search</h1>

   <form action="result/" method="GET">
<input type="text" name="sku" placeholder="search">
<input type="submit" name="Submit">
</form>

    <div class="footer">
      <a href="../">Home</a>
    </div>
  </div>
  

<h2>SKUs:</h2>
<table class="recent">
    <?php


include '../php-barcode-generator/src/BarcodeGenerator.php';
include '../php-barcode-generator/src/BarcodeGeneratorPNG.php';
date_default_timezone_set('America/Chicago');
function date_compare($a, $b)
{
	$f1 = json_decode(file_get_contents('data/'. $a), true);
	$f2 = json_decode(file_get_contents('data/'. $b), true);
	$t1 = strtotime($f1['Date']);
	$t2 = strtotime($f2['Date']);

	return $t2 - $t1;
}

function generateBarcodeFrom($sku)
{
    $generator = new \Picqer\Barcode\BarcodeGeneratorPNG();

    return  '<img src="data:image/png;base64,'.base64_encode($generator->getBarcode($sku, $generator::TYPE_CODE_93)).'"><br>'.$sku;
}
$path = 'data';
$files = scandir($path);
$files = array_diff(scandir($path), array('.', '..'));

usort($files, 'date_compare');
$files = array_slice($files, 0, 4, true);
echo '<tr><td class="header">SKU</td><td class="header">Information</td><td class="header">Brand</td>';
foreach ($files as $key => $value) {
    if (strpos($value, '.json')) {
        echo '<tr>';
        $sku = str_replace('.json', '', $value);
        $jsondata = json_decode(file_get_contents('data/'.$sku.'.json'), true);

        if ($jsondata['Brand'] == '') {
            $jsondata['Brand'] = 'Not supplied';
        }
        if ($jsondata['Model'] == '') {
            $jsondata['Model'] = 'Not supplied';
        }
        echo "<td class='barcode'><div class='barcode'>".generateBarcodeFrom($sku).'</div></td>';
        echo "<td class='model'>".$jsondata['Model'].', '.$jsondata['Date']."</td><td class='brand'>".$jsondata['Brand'].'</td>';
        echo '</tr>';
    }
}
?>
</table>


</div>
</div>
</body>
