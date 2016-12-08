<?php

namespace Aura;
class Settings{
	public function getPrintMethod(){
		$settings = json_decode(file_get_contents("config.json"), true);
		if($settings['printMethod'] == "system"){
			return "System";
		}else{
			return "Web";
		}
	}
	public function getProd(){
		if (file_exists(".production.env")){
			// Production environment, be careful

			return true;
		}else if (file_exists(".devel.env")){
				// Development! Break everything with GUSTO!

				return false;
			}else{
				return true;
			}
	}
	public function getRoot(){
		$settings = json_decode(file_get_contents("config.json"), true);
		$me = new Settings;
		$root = str_replace("/var/www/html", "", $_SERVER["DOCUMENT_ROOT"]);
		if($me->getProd() == true){
			return $root . $settings['productionPath'];
		}else{
			return $root . $settings['develPath'];
		}
	}
}




?>