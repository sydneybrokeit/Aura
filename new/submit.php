<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 3.2//EN">

<html>
<head>
    <title></title>
</head>

<body>
    <table>
        <?php

error_reporting(E_ALL | E_STRICT);

ini_set('display_errors', 'On');

header('Access-Control-Allow-Origin: *');
function generateRandomString($length = 19)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; ++$i) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }

    return $randomString;
}

function sendSKU($printer, $sku)
{
    $settings = json_decode(file_get_contents('../config.json'), true);
    if ($settings['printMethod'] == 'barcodeWeb') {
        header('location: '.str_replace(basename($_SERVER['PHP_SELF']), '', $_SERVER['REQUEST_URI']).'../modules/print/?sku='.$sku);
    } else {
        header('location: index.php?success=false&error='.$settings);
    }
}
function returnWithError($error = 'None')
{
    echo '<script>window.location.href = "index.php?success=false&error='.$error.'"; </script>';
}
$sku = generateRandomString(15);
$filename = '../results/data/'.$sku.'.json';
$clean = $_POST;
foreach ($_POST as $key => $value) {
    if ($value == '') {
        unset($clean[$key]);
    }
}
if (file_put_contents($filename, json_encode($clean))) {
    if (isset($_POST['printer'])) {
        setcookie('printer', $_POST['printer']);
        sendSKU($_POST['printer'], $sku);
    } else {
        sendSKU('None', $sku);
    }
}
?>
    </table>
</body>
</html>
