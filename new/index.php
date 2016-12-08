<html>
<head>
  <title>Aura|New</title>
  <link rel="stylesheet" type="text/css" href="<?php echo str_replace(basename($_SERVER['PHP_SELF']), '', $_SERVER['REQUEST_URI']); ?>../css/main.css">
  <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.1.1.min.js"></script>

</head>
<body>
  <div class="wrapper" id="forms">
    <div class="header">
    <h1 class="page-title">Create a new label</h1>

  <form action="." method="POST" class="template-selector">
  Category:  <select name="template" id="template" onchange="this.form.submit()">
      <option disabled selected value> -- select an option -- </option>
      <?php
$types = json_decode(file_get_contents('../templates/items.json'), true);
foreach ($types['items'] as $field => $type) {
    echo "<option name='template' value=".$type.'>'.ucwords($field).'</option>';
}

?>
    </select>
</form>

</div>

<?php
date_default_timezone_set('UTC');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['template']) && !empty($_POST['template'])) {
        setupPageFromTemplate(parseTemplate($_POST['template']));
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['success']) && !empty($_GET['success'])) {
        if ($_GET['success'] == 'true' && isset($_GET['sku']) && !empty($_GET['sku'])) {
            echo'<h1>Success! SKU: '.$_GET['sku'].'</h1>';
        } else {
            if (isset($_GET['error']) && !empty($_GET['error'])) {
                echo'<h1>Error: '.$_GET['error'].'</h1>';
            } else {
                echo'<h1>Uh oh! The SKU was unable to be saved.</h1>';
            }
        }
    }
}

function setupPageFromTemplate($template)
{
    basicFormsInserting($template);
    echo "<input class='submit-button' type='submit' value='Submit'>
    <a class='back' href='../'>Home</a></form>";
}
function basicFormsInserting($inserted)
{
    $template = parseMasterTemplate();
    $name = $inserted['meta']['template_name'];
    $category = $inserted['meta']['category'];
    $inherited = null;
    if ($inserted['meta']['inherit']) {
        $inherited = $inserted['meta']['inherit'];
    }
    echo '<form id="template" class="template" action="submit.php" method="post"><input type="hidden" value='.$name.' name="category">';
    echo '<label class="field-title">Template: </label><p class="template-title">'.$name.'</p>';
    foreach ($template['fields'] as $field => $type) {
        if (is_array($type) && $type['type'] == 'radio') {
            echo '<div class="'.$type['type'].'"><label class="field-title">'.ucwords($field).'</label>';
            foreach ($type['options'] as $condition) {
                echo '<div class="tooltip radio-option">';
                if (isset($template['tooltips'][strtolower($condition)]) && in_array($condition, $type['reason']) == false) {
                    echo '<span class="tooltiptext tooltip-right">'.$template['tooltips'][strtolower($condition)].'</span>';
                    echo '<input type='.$type['type'].' name='.strtolower($field).' value='.strtolower($condition).'>'.$condition;
                } else {
                    echo '<span class="tooltiptext tooltip-right tooltip-extra">'.$template['tooltips'][strtolower($condition)].'</span>';
                    echo '<input type='.$type['type'].' name='.strtolower($field).' value='.strtolower($condition).'>'.$condition;

                    echo '<div class="reveal-if-active"><input type=text name=reason class="reason-field"  placeholder="Reason"></div>';
                }
                echo '</div>';
            }
            echo '</div>';
        } elseif ($type == 'insertion') {
            if ($inherited != null) {
                htmlFromTemplate(parseTemplate($inherited));
            }
            htmlFromTemplate($inserted);
        } else {
            if ($type != 'insertion') {
                echo '<div class="tooltip form-option">';
                echo '<label class="field-title">'.ucwords($field).':</label>';

                $name = str_replace(' ', '_', $field);

                if ($type == 'textarea') {
                    if (isset($template['tooltips'][$name])) {
                        echo ' <span class="tooltiptext 2 tooltip-right">'.$template['tooltips'][$name].'</span>';
                    }
                    echo '<textarea class="'.$name.'" cols="50" rows="10" name='.$name.'></textarea>';
                } elseif ($type == 'date') {
                    echo "<input id='date' type=".$type.' name='.$name.' value='.date('Y-m-d').'>';
                } else {
                    if (isset($template['tooltips'][$name])) {
                        echo ' <span class="tooltiptext tooltip-right">'.$template['tooltips'][$name].'</span>';
                    }
                    echo '<input class='.$name.' type='.$type.' name='.$name.'>';
                }
                echo '</div>';
            }
        }
    }
    getPrint();
}

function htmlFromTemplate($template)
{
    foreach ($template['fields'] as $field => $type) {
        if (is_array($type) && $type['type'] == 'radio') {
            echo '<div class="'.$type['type'].'"><h3>'.ucwords($field).':</h3>';
            foreach ($type['options'] as $condition) {
                echo '<div class="tooltip">';
                if (isset($template['tooltips'][strtolower($condition)]) && in_array($condition, $type['reason']) == false) {
                    echo '<span class="tooltiptext tooltip-right">'.$template['tooltips'][strtolower($condition)].'</span>';
                    echo '<input class='.$name.' type='.$type['type'].' name='.strtolower($field).' value='.strtolower($condition).'>'.$condition;
                } else {
                    echo '<span class="tooltiptext tooltip-right tooltip-extra">'.$template['tooltips'][strtolower($condition)].'</span>';
                    echo '<input class='.$name.' type='.$type['type'].' name='.strtolower($field).' value='.strtolower($condition).'>'.$condition;

                    echo '<div class="reveal-if-active"><input class="reason-field" type=text name=reason  placeholder="Reason"></div>';
                }
                echo '</div>';
            }
            echo '</div>';
        } else {
            echo '<div class="tooltip form-option">';
            echo '<label class="field-title">'.ucwords($field).':</label>';
            $name = str_replace(' ', '_', $field);

            if ($type != 'date') {
                if (isset($template['tooltips'][$name])) {
                    echo ' <span class="tooltiptext tooltip-right">'.$template['tooltips'][$name].'</span>';
                }
                echo '<input class='.$name.' type='.$type.' name='.$name.'>';
            } else {
                echo "<input id='date' type=".$type.' name='.$name.' value='.date('Y-m-d').'>';
            }
            echo '</div>';
        }
    }
}
function getPrint()
{
    $settings = json_decode(file_get_contents('../config.json'), true);
    if ($settings['printMethod'] != 'system' && $settings['allowPrintDropdown'] == true) {
        echo '<script src="print-list.js"></script><p>Printer: <select style="transform: rotate(90deg);" id="printer" name="printer">

                    </select></p>';
    }
}
function parseTemplate($file)
{
    return  json_decode(file_get_contents('../templates/'.$file), true);
}

function parseMasterTemplate()
{
    return  json_decode(file_get_contents('../templates/master.json'), true);
}
?>
</div>
