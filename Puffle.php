<?php

//////PUFFLE SWF Dowloader MADE BY BUNNY GREEN

define('REMOTE_URL', 'http://origin.clubpenguin.com/');

define('PUFFLE_PAPER', 'play/v2/content/global/puffle/paper/');
define('PUFFLE_SPRITES_DIG', 'play/v2/content/global/puffle/sprites/dig/');
define('PUFFLE_SPRITES_IGLOO', 'play/v2/content/global/puffle/sprites/igloo/');
define('PUFFLE_SPRITES_WALK', 'play/v2/content/global/puffle/sprites/walk/');

function fetchAndDecode($remote_url) {
	$data = file_get_contents($remote_url);
	
	return json_decode($data, true);
}

function downloadFile($remote_url, $local_uri) {
	if(file_exists($local_uri) === false) {
		echo "Downloading $remote_url..";
		$curl = curl_init($remote_url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_FRESH_CONNECT, true);
		
		$data = curl_exec($curl);
		
		$status_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		curl_close($curl);
		
		if($status_code == 200) {
			echo "Downloaded\nLocal: $local_uri\n";
			if(is_dir($directory = str_replace(REMOTE_URL, "", dirname($remote_url))) === false) {
				mkdir($directory, 0777, true);
			}
			
			if(is_dir($directory = dirname($local_uri)) === false) {
				echo "Creating $directory\n";
				mkdir($directory, 0777, true);
			}
			
			file_put_contents($local_uri, $data);
		} else {
			echo "does not exist or corrupted file\n";
		}
	}
}

$defined_constants = get_defined_constants(true);
$media_directories = $defined_constants["user"];

foreach($media_directories as $media_directory) {
	if(is_dir($media_directory) === false) {
		echo "Creating $media_directory\n";
		mkdir($media_directory, 0777, true);
	}
}

$puffles = fetchAndDecode("http://media1.clubpenguin.com/play/en/web_service/game_configs/puffles.json");
foreach($puffles as $puffle) {
	$lc_description = strtolower($puffle["description"]);
	
	$dig_path = sprintf("puffle_%s_dig.swf", $lc_description);
	$sprite_path = sprintf("puffle_%s_igloo.swf", $lc_description);
	$walk_path = sprintf("puffle_%s_walk.swf", $lc_description);
	$paper_path = sprintf("puffle_%s_paper.swf", $lc_description);
	
	downloadFile(REMOTE_URL . PUFFLE_SPRITES_DIG . $dig_path, PUFFLE_SPRITES_DIG . $dig_path);
	downloadFile(REMOTE_URL . PUFFLE_SPRITES_IGLOO . $sprite_path, PUFFLE_SPRITES_IGLOO . $sprite_path);
	downloadFile(REMOTE_URL . PUFFLE_SPRITES_WALK . $walk_path, PUFFLE_SPRITES_WALK . $walk_path);
	downloadFile(REMOTE_URL  .PUFFLE_PAPER . $paper_path, PUFFLE_PAPER . $paper_path);
}
$wild_puffles = array(
	array("black", 1000),
	array("purple", 1001),
	array("red", 1002),
	array("blue", 1003),
	array("yellow", 1004),
	array("pink", 1005),
	array("blue", 1006),
	array("orange", 1007),
	array("crystal",1023),
	array("ghost", 1022),
	
	
);
foreach($wild_puffles as $wild_puffle) {
	list($type, $sub_type) = $wild_puffle;
	
	$walk_file = sprintf("puffle_%s%d_walk.swf", $type, $sub_type);
	$dig_file = sprintf("puffle_%s%d_dig.swf", $type, $sub_type);
	$igloo_file = sprintf("puffle_%s%d_igloo.swf", $type, $sub_type);
	$paper_file = sprintf("puffle_%s%d_paper.swf", $type, $sub_type);
	
	downloadFile(REMOTE_URL . PUFFLE_SPRITES_WALK . $walk_file, PUFFLE_SPRITES_WALK . $walk_file);
	downloadFile(REMOTE_URL . PUFFLE_SPRITES_DIG . $dig_file, PUFFLE_SPRITES_DIG . $dig_file);
	downloadFile(REMOTE_URL . PUFFLE_SPRITES_IGLOO . $igloo_file, PUFFLE_SPRITES_IGLOO . $igloo_file);
	downloadFile(REMOTE_URL . PUFFLE_PAPER . $paper_file, PUFFLE_PAPER . $paper_file);
}
$party_puffles = array(
	array("snowman",1021),
	array("crystal",1023),
	array("ghost", 1022),
	
	
);
foreach($party_puffles as $party_puffle) {
	list($type, $sub_type) = $party_puffle;
	
	$walk_file = sprintf("puffle_%s%d_walk.swf", $type, $sub_type);
	$dig_file = sprintf("puffle_%s%d_dig.swf", $type, $sub_type);
	$igloo_file = sprintf("puffle_%s%d_igloo.swf", $type, $sub_type);
	$paper_file = sprintf("puffle_%s%d_paper.swf", $type, $sub_type);
	
	downloadFile(REMOTE_URL . PUFFLE_SPRITES_WALK . $walk_file, PUFFLE_SPRITES_WALK . $walk_file);
	downloadFile(REMOTE_URL . PUFFLE_SPRITES_DIG . $dig_file, PUFFLE_SPRITES_DIG . $dig_file);
	downloadFile(REMOTE_URL . PUFFLE_SPRITES_IGLOO . $igloo_file, PUFFLE_SPRITES_IGLOO . $igloo_file);
	downloadFile(REMOTE_URL . PUFFLE_PAPER . $paper_file, PUFFLE_PAPER . $paper_file);
}

?>
