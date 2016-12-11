<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN">

<html>
<head>
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo str_replace(basename($_SERVER['PHP_SELF']), '', $_SERVER['REQUEST_URI']); ?>images/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="<?php echo str_replace(basename($_SERVER['PHP_SELF']), '', $_SERVER['REQUEST_URI']); ?>images/favicons/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo str_replace(basename($_SERVER['PHP_SELF']), '', $_SERVER['REQUEST_URI']); ?>images/favicons/favicon-16x16.png">
    <link rel="shortcut icon" href="<?php echo str_replace(basename($_SERVER['PHP_SELF']), '', $_SERVER['REQUEST_URI']); ?>images/favicons/favicon.ico" type="image/x-icon">
    <link rel="icon" href="<?php echo str_replace(basename($_SERVER['PHP_SELF']), '', $_SERVER['REQUEST_URI']); ?>images/favicons/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="<?php echo str_replace(basename($_SERVER['PHP_SELF']), '', $_SERVER['REQUEST_URI']); ?>css/main.css">

    <title>Aura</title>
</head>

<body>
    <div class="container">
        <div class="header" id="home">
             <a href="."><img class="page-title" src="images/AuraLogo.png"></a>

            <div class="action">
                <div class="links">
                    <a href="new">New</a> <a href="results">Search</a>
                </div>
            </div>
            <div class="quote">
	     
            <script type="text/javascript" src="https://www.brainyquote.com/link/quotear.js"></script>
            </div>

            <div class="footer">
                <a href="https://github.com/hschreck/Aura/issues">Support</a>
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
                                                date_default_timezone_set('America/Chicago');

                                                function date_compare($a, $b)
                                                {
                                                    $f1 = json_decode(file_get_contents('results/data/'. $a), true);
                                                    $f2 = json_decode(file_get_contents('results/data/'. $b), true);
                                                    $t1 = strtotime($f1['Date']);
                                                    $t2 = strtotime($f2['Date']);

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

                                                if(empty($files) == false){

                                                    usort($files, 'date_compare');  
                                                    $files = array_slice($files, 0, 4, true);
                                                echo '<tr><td class="table-header">SKU</td><td class="table-header">Information</td><td class="table-header">Brand</td>';
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
                                                        echo "<td class='model'>Model: ".$jsondata['Model'].', Date: '. $jsondata["Date"]."</td><td class='brand'>".$jsondata['Brand'].'</td>';
                                                        echo '</tr></a>';
                                                    }
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
