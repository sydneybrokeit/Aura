<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>
<head>
    <link rel="stylesheet" type="text/css" href="/Aura/css/main.css">

    <title>Aura|<?php
if (isset($_GET["sku"])) {
	echo $_GET["sku"];
}?></title>
</head>

<body>
    <div class="container">
        <div class="header" id="home">
            <img class="page-title" src="../../images/AuraLogo.png">

            <h2 class="page-title">Search</h2>

            <form action="../result" method="get" class="search">
                <input type="text" name="sku" placeholder="search"> <input type="submit" name="Submit">
            </form>

            <div class="footer">
                <a href="../../">Home</a>
            </div>
        </div>

        <div class="wrapper">
            <?php
if (isset($_GET["sku"])) {
	$jsondata = json_decode(file_get_contents("../data/" . $_GET["sku"] . ".json"), true);

	echo "<h1 class='result-title'>Result: " . $_GET["sku"] . "</h1>";
	echo "<table class='results_properties'>";
	foreach ($jsondata as $key=>$value) {
		$keyID = $key;
		$key = str_replace("_", " ", $key);
		if ($keyID == "Power_Adaptor"){
			$value = str_replace("on", "Yes", $value);
			$value = str_replace("off", "No", $value);
		}

		echo "<tr><td class='property_name' id='" . $keyID . "'>"  . ucwords($key) . ":</td><td class='property_value' id='" . $keyID . "'>" . $value . "</td></tr>";
	}

	echo "</table>";
}

?>
        </div>
    </div>
</body>
</html>
