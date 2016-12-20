<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>
<head>
      <link rel="stylesheet" type="text/css" href="../../css/main.css">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo str_replace(basename($_SERVER['PHP_SELF']), '', $_SERVER['REQUEST_URI']); ?>../images/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="<?php echo str_replace(basename($_SERVER['PHP_SELF']), '', $_SERVER['REQUEST_URI']); ?>../images/favicons/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo str_replace(basename($_SERVER['PHP_SELF']), '', $_SERVER['REQUEST_URI']); ?>../images/favicons/favicon-16x16.png">
    <link rel="shortcut icon" href="<?php echo str_replace(basename($_SERVER['PHP_SELF']), '', $_SERVER['REQUEST_URI']); ?>../images/favicons/favicon.ico" type="image/x-icon">
    <link rel="icon" href="<?php echo str_replace(basename($_SERVER['PHP_SELF']), '', $_SERVER['REQUEST_URI']); ?>../images/favicons/favicon.ico" type="image/x-icon">

    <title>Aura|<?php
    if (isset($_GET['sku'])) {
        $uppersku = strtoupper($_GET['sku'])
        echo $uppersku;
    }?></title>
</head>

<body>
    <div class="container">
                <div class="header" id="home">
            <a href="../../"><img class="page-title" src="../../images/AuraLogo.png"></a>

            <div class="action">
                <h2 class="page-title">Search</h2>

                <form action="../result" method="get" class="search">
                    <input type="text" name="sku" placeholder="search"> <input type="submit" name="Submit">
                </form>
            </div>

            <div class="footer">
                <a href="../../">Home</a>
            </div>
        </div>

        <div class="wrapper">
            <div class="inner-wrapper">
            <?php
            if (isset($_GET['sku'])) {
                $jsondata = json_decode(file_get_contents('../data/'.$uppersku.'.json'), true);

                echo "<h1 class='result-title'>Result: ".$uppersku.'</h1>';
                echo "<table class='results_properties'>";
                foreach ($jsondata as $key => $value) {
                    $keyID = $key;
                    $key = str_replace('_', ' ', $key);
                    if ($keyID == 'Power_Adaptor') {
                        $value = str_replace('on', 'Yes', $value);
                        $value = str_replace('off', 'No', $value);
                    }

                    echo "<tr><td class='property_name' id='".$keyID."'>".ucwords($key).":</td><td class='property_value' id='".$keyID."'>".$value.'</td></tr>';
                }

                echo '</table>';
            }

            ?>
        </div>
      </div>
    </div>
</body>
</html>
