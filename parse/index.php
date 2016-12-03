<html>
<head>
<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.1.1.min.js"></script>
</head>
<body>
  <form action="/" method="POST">
    <select name="template" id="template" onchange="this.form.submit()">
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


function setupPageFromTemplate($template)
{
  basicForms();
}
function basicForms(){
  $template = parseMasterTemplate();
  $name = $template['meta']['template_name'];
  $category = $template['meta']['category'];
  echo "<h1>" .$name."</h1><form>";
  foreach ($template['fields'] as $field => $type) {
      if (is_array($type) && $type["type"] == "radio") {
          echo "<h2>" . ucwords($field) . ":</h2>";
          foreach ($type["options"] as $condition) {
              echo "<input type=" . $type["type"] . " name=". strtolower($field) . " value=" . strtolower($condition) .">" . $condition ."<br>";
          }
          echo "<br>";
      } else {
          echo ucwords($field) . ":<br>";
          if ($type != "date") {
              echo "<input type=". $type ." name=". $field ."><br>";
          } else {
              echo "<input id='date' type=". $type ." name=". $field ." value=" .  date('Y-m-d') ."><br>";
          }
      }
  }
  echo "<br><input type='submit' name='done'><br></form>";
}
function parseTemplate($file)
{
    return  json_decode(file_get_contents("templates/" . $file), true);
}

function parseMasterTemplate()
{
    return  json_decode(file_get_contents("templates/master.json"), true);
}
