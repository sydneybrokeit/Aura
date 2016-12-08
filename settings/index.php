<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 3.2//EN">

<html>
<head>
    <title>Aura|Settings</title>
</head>

<body>
    <h2>Settings</h2>

    <h4>Environment status:</h4>

    <p><?php
include('settings.php');
use Aura\Settings as Settings;
global $settings;
$settings = new Settings;

if ($settings::getProd() == true){
	echo("Soldier, this is a production environment, if you screw up, its on you.");

}else{
	echo("Go bananas, but write a nice commit message.");

}

?></p>

    <h4>Document root:</h4>

    <p><?php echo($settings::getRoot()); ?></p>

      <h4>Print method: </h4>

    <p><?php echo($settings::getPrintMethod()); ?></p>
</body>
</html>
