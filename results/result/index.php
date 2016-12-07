<head>
  <link rel="stylesheet" type="text/css" href="/Aura/css/main.css">
  <title>Aura|<?php
  if (isset($_GET["sku"])) {
      echo $_GET["sku"];
  }?></title>
</head>
<body>
  <div class="wrapper">

<?php
if (isset($_GET["sku"])) {
      $jsondata = json_decode(file_get_contents("../data/" . $_GET["sku"] . ".json"), true);

        echo "<h1 class='page-title'>Result: " . $_GET["sku"] . "</h1>";
      echo "<table class='results_properties'>";
      foreach ($jsondata as $key=>$value) {
          $keyID = $key;
          $key = str_replace("_", " ", $key);
          $value = str_replace("on", "Yes", $value);
          $value = str_replace("off", "No", $value);
          echo "<tr><td class='property_name' id='" . $keyID . "'>"  . ucwords($key) . ":</td><td class='property_value' id='" . $keyID . "'>" . $value . "</td></tr>";
      }

      echo "</table>";
  }

?>
<a class="back" href="../">Back</a>
</div>
</body>
