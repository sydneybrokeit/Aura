<html>
<head>
  <title>Aura|New</title>
  <link rel="stylesheet" type="text/css" href="/Aura/css/main.css">
  <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.1.1.min.js"></script>
</head>
<body>
  <div class="wrapper" id="forms">
    <h1 class="page-title">New Label</h1>

  <form action="." method="POST" class="template-selector">
  Category:  <select name="template" id="template" onchange="this.form.submit()">
      <option disabled selected value> -- select an option -- </option>
      <?php
$types = json_decode(file_get_contents("items.json"), true);
foreach ($types["items"] as $field => $type) {
	echo "<option name='template' value=" .$type.">" .ucwords($field)."</option>";
}

?>
    </select>
</form>


<?php
date_default_timezone_set('UTC');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	if (isset($_POST["template"]) && !empty($_POST["template"])) {
		setupPageFromTemplate(parseTemplate($_POST["template"]));
	}
}
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
	if (isset($_GET["success"]) && !empty($_GET["success"])) {
		if ($_GET["success"] == "true" && isset($_GET["sku"]) && !empty($_GET["sku"])) {
			echo"<h1>Success! SKU: ". $_GET["sku"] . "</h1>";
		} else {
			if (isset($_GET["error"]) && !empty($_GET["error"])){
				echo"<h1>Error: " . $_GET["error"] . "</h1>";
			}else{
				echo"<h1>Uh oh! The SKU was unable to be saved.</h1>";
			}

		}
	}
}


function setupPageFromTemplate($template)
{
	basicFormsInserting($template);
	echo "<input type='submit' value='Submit'>
    </form>";
}
function basicFormsInserting($inserted)
{
	$template = parseMasterTemplate();
	$name = $template['meta']['template_name'];
	$category = $template['meta']['category'];
	$inherited = null;
	if ($inserted['meta']['inherit']){
		$inherited = $inserted['meta']['inherit'];
	}
	echo "<h2>Template: " . ucwords(str_replace(".json", "", $_POST["template"])) ."</h2><form action='submit.php' method='post'>";
	foreach ($template['fields'] as $field => $type) {
		if (is_array($type) && $type["type"] == "radio") {
			echo "<h3>" . ucwords($field) . ":</h3>";
			foreach ($type["options"] as $condition) {
				echo "<input type=" . $type["type"] . " name=". strtolower($field) . " value=" . strtolower($condition) .">" . $condition ."<br>";
			}
			echo "<br>";
		} else if ( $type == "insertion"){
				if($inherited != null){
					htmlFromTemplate(parseTemplate($inherited));
				}
				htmlFromTemplate($inserted);
			} else {
			if ($type != "insertion"){
				echo ucwords($field) . ":<br>";

				$name = str_replace(" ", "_", $field);
				if ($type != "date") {

					echo "<input type=". $type ." name=". $name ."><br>";

				} else {
					echo "<input id='date' type=". $type ." name=". $name ." value=" .  date('Y-m-d') ."><br>";
				}
			}
		}
	}
}

function basicForms()
{
	$template = parseMasterTemplate();
	$name = $template['meta']['template_name'];
	$category = $template['meta']['category'];
	echo "<h2>Template: " . ucwords(str_replace(".json", "", $_POST["template"])) ."</h2><form action='submit.php' method='post'>";
	foreach ($template['fields'] as $field => $type) {
		if (is_array($type) && $type["type"] == "radio") {
			echo "<h3>" . ucwords($field) . ":</h3>";
			foreach ($type["options"] as $condition) {
				echo "<input type=" . $type["type"] . " name=". strtolower($field) . " value=" . strtolower($condition) .">" . $condition ."<br>";
			}
			echo "<br>";
		} else {
			echo ucwords($field) . ":<br>";
			$name = str_replace(" ", "_", $field);
			if ($type != "date") {
				echo "<input type=". $type ." name=". $name ."><br>";
			} else {
				echo "<input id='date' type=". $type ." name=". $name ." value=" .  date('Y-m-d') ."><br>";
			}
		}
	}
}
function htmlFromTemplate($template){
	foreach ($template['fields'] as $field => $type) {
		if (is_array($type) && $type["type"] == "radio") {
			echo "<h4>" . ucwords($field) . ":</h4>";
			foreach ($type["options"] as $condition) {
				echo "<input type=" . $type["type"] . " name=". strtolower($field) . " value=" . strtolower($condition) .">" . $condition ."<br>";
			}
			echo "<br>";
		} else {
			echo ucwords($field) . ":<br>";
			$name = str_replace(" ", "_", $field);
			if ($type != "date") {
				echo "<input type=". $type ." name=". $name ."><br>";
			} else {
				echo "<input id='date' type=". $type ." name=". $name ." value=" .  date('Y-m-d') ."><br>";
			}
		}
	}
}
function parseTemplate($file)
{
	return  json_decode(file_get_contents("../templates/" . $file), true);
}

function parseMasterTemplate()
{
	return  json_decode(file_get_contents("../templates/master.json"), true);
}
?>
<a class="back" href="../">Home</a>
</div>
