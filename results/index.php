<head>
  <link rel="stylesheet" type="text/css" href="/Aura/css/main.css">
  <title>Aura|SKUs</title>
</head>
<body>
  <div class="wrapper">
<form action="result/" method="GET">
<input type="text" name="sku" placeholder="search">
<input type="submit" name="Submit">
</form>

<h2>SKUs:</h2>
<ul>

<?php
$path = 'data';
$files = scandir($path);
$files = array_diff(scandir($path), array('.', '..'));

foreach ($files as $key => $value) {
    if (strpos($value, '.json')) {
        $sku = str_replace('.json', '', $value);
        $jsondata = json_decode(file_get_contents('./data/'.$sku.'.json'), true);

        if ($jsondata['Brand'] == '') {
            $jsondata['Brand'] = 'Not supplied';
        }
        if ($jsondata['Model'] == '') {
            $jsondata['Model'] = 'Not supplied';
        }
        echo "<a href='result/index.php?sku=".$sku."'><li>".$sku.'. Brand: '.$jsondata['Brand'].'. Model:'.$jsondata['Model'].'</li></a>';
    }
}
?>
</ul>
<a class="back" href="../">Home</a>

</div>
</body>
