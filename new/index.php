<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>
<head>
    <title>Aura|New</title>
    <link rel="stylesheet" type="text/css" href="../css/main.css">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo str_replace(basename($_SERVER['PHP_SELF']), '', $_SERVER['REQUEST_URI']); ?>../images/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="<?php echo str_replace(basename($_SERVER['PHP_SELF']), '', $_SERVER['REQUEST_URI']); ?>../images/favicons/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo str_replace(basename($_SERVER['PHP_SELF']), '', $_SERVER['REQUEST_URI']); ?>../images/favicons/favicon-16x16.png">
    <link rel="shortcut icon" href="<?php echo str_replace(basename($_SERVER['PHP_SELF']), '', $_SERVER['REQUEST_URI']); ?>../images/favicons/favicon.ico" type="image/x-icon">
    <link rel="icon" href="<?php echo str_replace(basename($_SERVER['PHP_SELF']), '', $_SERVER['REQUEST_URI']); ?>i../mages/favicons/favicon.ico" type="image/x-icon">
    <script src="../js/jquery-3.1.1.min.js" type="text/javascript">
</script>
</head>

<body>

    <div class="container">
        <div class="header">
            <a href="../"><img class="page-title" src="../images/AuraLogo.png"></a>

            <div class="action">
                <h1 class="page-title">New Label</h1>
		
		<! Template Dropdown Generation >
                <form action="." method="post">
                    Category: <select name="template" onchange="this.form.submit()">
                        <option disabled selected value="">
                            Choose a template
                        </option><?php
                                            $types = json_decode(file_get_contents('../templates/items.json'), true);
                                            foreach ($types['items'] as $field => $type) {
                                                echo "<option name='template' value=".$type.'>'. ucwords($field).'</option>';
                                            }

                                            ?>
                    </select>
                </form>
            </div>
        </div>

        <div class="wrapper" id="forms">
            <?php
                            global $templateName;
                        date_default_timezone_set('UTC');
                        #Process templates if POST request
                        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                            if (isset($_POST['template']) && !empty($_POST['template'])) {
                                setupPageFromTemplate(parseTemplate($_POST['template']));
                            }
                        }
			#Display success/error messages
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
			# Setup Page From Template
                        function setupPageFromTemplate($template)
                        {
                            basicFormsInserting($template);
                            echo "<input class='submit-button' type='submit' value='Submit'></form>";
                        }
		 	# Basic Forms Inserting (function)
                        function basicFormsInserting($inserted)
                        {
                           
                
                            $template = parseMasterTemplate();
                            $name = $inserted['meta']['template_name'];
                        
                             session_start();

                             $_SESSION['name']=$name;
                            $category = $inserted['meta']['category'];
                            $inherited = null;
                            if (isset($inserted['meta']['inherit'])) {
                                $inherited = $inserted['meta']['inherit'];
                            }
                            echo '<form id="template" class="template" action="submit.php" method="post"><input type="hidden" value='.$name.' name="category">';
                           
                            foreach ($template['fields'] as $field => $type) {
                                if (is_array($type) && $type['type'] == 'radio') {
                                    echo '<div class="'.$type['type'].'"><label class="field-title">'.$field.'</label>';
                                    foreach ($type['options'] as $condition) {
                                        echo '<div class="tooltip radio-option">';
                                        if (isset($template['tooltips'][strtolower($condition)]) && in_array($condition, $type['reason']) == false) {
                                            echo '<span class="tooltiptext tooltip-right">'.$template['tooltips'][strtolower($condition)].'</span>';
                                            echo '<input type='.$type['type'].' name='.strtolower($field).' value='.strtolower($condition).'>'.$condition;
                                        } else {
                                            echo '<span class="tooltiptext tooltip-right tooltip-extra">'.$template['tooltips'][strtolower($condition)].'</span>';
                                            echo '<input type='.$type['type'].' name='.strtolower($field).' value='.strtolower($condition).'>'.$condition;

                                            echo '<div class="reveal-if-active"><input type=text name="condition_reason" class="reason-field"  placeholder="Reason"></div>';
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
                                        echo '<label class="field-title">'.$field.':</label>';

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
			#Create HTML from Template (function)
                        function htmlFromTemplate($template)
                        {
                            foreach ($template['fields'] as $field => $type) {
                                if (is_array($type) && $type['type'] == 'radio') {
                                    echo '<div class="'.$type['type'].'"><h3>'.$field.':</h3>';
                                    foreach ($type['options'] as $condition) {
                                        echo '<div class="tooltip">';
                                        if (isset($template['tooltips'][strtolower($condition)]) && in_array($condition, $type['condition_reason']) == false) {
                                            echo '<span class="tooltiptext tooltip-right">'.$template['tooltips'][strtolower($condition)].'</span>';
                                            echo '<input class='.$name.' type='.$type['type'].' name='.strtolower($field).' value='.strtolower($condition).'>'.$condition;
                                        } else {
                                            echo '<span class="tooltiptext tooltip-right tooltip-extra">'.$template['tooltips'][strtolower($condition)].'</span>';
                                            echo '<input class='.$name.' type='.$type['type'].' name='.strtolower($field).' value='.strtolower($condition).'>'.$condition;

                                            echo '<div class="reveal-if-active"><input class="reason-field" type=text name="condition_reason"  placeholder="Reason"></div>';
                                        }
                                        echo '</div>';
                                    }
                                    echo '</div>';
                                } else {
                                    echo '<div class="tooltip form-option">';
                                    echo '<label class="field-title">'.$field.':</label>';
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
			#Get List of Printers	 
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
    </div>
</body>
</html>
