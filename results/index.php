<head>
  <link rel="stylesheet" type="text/css" href="/css/main.css">
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
$path    = 'data';
$files = scandir($path);
$files = array_diff(scandir($path), array('.', '..'));

foreach ($files as $key => $value) {
    $sku = str_replace(".json", "", $value);
    echo "<a href='result/index.php?sku=" . $sku . "'><li>" . $sku . "</li></a>";
}
?>
</ul>
<a class="back" href="../">Home</a>

</div>
</body>
