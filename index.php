

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN">

<html>
<head>
    <link rel="stylesheet" type="text/css" href="<?php echo str_replace(basename($_SERVER['PHP_SELF']), '', $_SERVER['REQUEST_URI']); ?>css/main.css">

    <title>Aura</title>
</head>

<body>
    <div class="wrapper">
        <h1 class="page-title">Aura</h1>

        <div class="links">
            <a href="new">New</a> <a href="results">Search</a>
        </div>

        <div class="recent">
            <h3>Recent SKUs:</h3>

            <table>
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
	return  '<img src="data:image/png;base64,'.base64_encode($generator->getBarcode($sku, $generator::TYPE_CODE_93)).'"><br>' . $sku;
}
$path = 'results/data';
$files = scandir($path);
$files = array_diff(scandir($path), array('.', '..'));

usort($files, 'date_compare');
$files = array_slice($files, 0, 4, true);

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
		echo "<td class='barcode'>" . generateBarcodeFrom($sku) . "</td>";
		echo "<td class='info'><a href='results/result/index.php?sku=".$sku."'>". "" .' Brand: '.$jsondata['Brand'].'. Model: '.$jsondata['Model'].'</a></td>';
		echo '</tr>';
	}
}
?>
            </table>
        </div>
        <div class="modules">
            <h3>Modules:</h3>

            <ul>
                <?php
if ($handle = opendir('modules/')) {
	$blacklist = array('.', '..', 'somedir', 'somefile.php');
	while (false !== ($file = readdir($handle))) {
		if (!in_array($file, $blacklist)) {
			$jsondata = json_decode(file_get_contents('modules/'.$file.'/meta.json'), true);

			echo '<p>'.$jsondata['name'].' (v'.$jsondata['version'].', '.$jsondata['author'].')</p>';
		}
	}
	closedir($handle);
}                ?>
            </ul>
        </div>

    </div>
</body>
</html>
