<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN">

<html>
<head>
    <link rel="stylesheet" type="text/css" href="/css/main.css">

    <title>Aura</title>
</head>

<body>
    <div class="wrapper">
        <h1 class="page-title">Aura</h1>

        <div class="links">
            <a href="/new">New</a> <a href="/results">Search</a>
        </div>

        <div class="recent">
            <h3>Recent SKUs:</h3>

            <ul>
                <?php
$path    = 'results/data';
$files = scandir($path);
$files = array_diff(scandir($path), array('.', '..'));
$files = array_slice($files, -3, 3, true);

foreach ($files as $key => $value) {

	$sku = str_replace(".json", "", $value);
	$jsondata = json_decode(file_get_contents("results/data/" . $sku . ".json"), true);

	if($jsondata["brand"] == ""){
		$jsondata["brand"] = "Not supplied";
	}
	if($jsondata["model"] == ""){
		$jsondata["model"] = "Not supplied";
	}
	echo "<a href='results/result/index.php?sku=" . $sku . "'><li>" . $sku . ". Brand: " . $jsondata['brand'] . ". Model:" .$jsondata['model'] ."</li></a>";
}
?>
            </ul>
        </div>
        <div class="modules">
            <h3>Modules:</h3>

            <ul>
                <?php
if ($handle = opendir('modules/')) {
	$blacklist = array('.', '..', 'somedir', 'somefile.php');
	while (false !== ($file = readdir($handle))) {
		if (!in_array($file, $blacklist)) {
			$jsondata = json_decode(file_get_contents("modules/" . $file . "/meta.json"), true);

	


			echo "<p>" . $jsondata["name"] . " (v" . $jsondata["version"] . ", " . $jsondata["author"] . ")</p>";
		}
	}
	closedir($handle);
}                ?>
            </ul>
        </div>

    </div>
</body>
</html>
