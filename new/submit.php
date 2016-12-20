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
date_default_timezone_set('America/Chicago');
header('Access-Control-Allow-Origin: *');
function generateRandomString($length = 12)/*{{{*/
{
    //To change length of SKU, adjust length above
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; ++$i) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }

    return $randomString;
}/*}}}*/
//send SKU to printer/*{{{*/
function sendSKU($printer, $sku)
{
    header('location: '.str_replace(basename($_SERVER['PHP_SELF']), '', $_SERVER['REQUEST_URI']).'../modules/print/?sku='.$sku);
}/*}}}*/
function returnWithError($error = 'None')/*{{{*/
{
    echo $error;
    //echo '<script>window.location.href = "index.php?success=false&error='.$error.'"; </script>';
}/*}}}*/
$sku = generateRandomString(12);
$filename = '../results/data/'.$sku.'.json';
$clean = $_POST;
$clean['Date'] = date('Y-m-d', time());
//Remove blanks in the POSTed data/*{{{*/
foreach ($_POST as $key => $value) {
    if ($value == '') {
        unset($clean[$key]);
    }
}/*}}}*/

//Save file and print SKU/*{{{*/
if (file_put_contents($filename, json_encode($clean))) {
    if (isset($_POST['printer'])) {
        setcookie('printer', $_POST['printer']);
        sendSKU($_POST['printer'], $sku);
    } else {
        sendSKU('None', $sku);
    }
}/*}}}*/
?>
    </table>
</body>
</html>
