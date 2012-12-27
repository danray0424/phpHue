<?php

$bridge = '192.168.1.138';
$key = '16e909913bb833b728dbdbc554f95eb';

require('pest-master/PestJSON.php');


// Registers your script with your Hue hub
function register() {
	global $bridge, $key;

	$pest = new Pest("http://$bridge/api");
	$data = json_encode(array('username' => 'abcd1234', 'devicetype' => 'Ray Solutions Scripts'));
	$result = $pest->post('', $data);
	return "$result\n";
}

// Returns a big array of the state of either a single light, or all your lights
function getLightState($lightid = false) { 
	global $bridge, $key;
	$targets = array();
	$result = array();

	if (! is_array($lightid)) {
		$targets[] = $lightid;
	} else {
		$targets = $lightid;
	}

	if (!$lightid) {	
		$pest = new Pest("http://$bridge/api/$key/");

		$result = json_decode($pest->get('lights'), true);
		$targets = array_keys($result);

	}


	foreach ($targets as $id) {

		$pest = new PEST("http://$bridge/api/$key/");
		$deets = json_decode($pest->get("lights/$id"), true);
		$state = $deets['state'];
		
		$result[$id] = $state;

	}
	return $state;
}

// Returns an array of the light numbers in the system
function getLightIdsList() {
	$state = getLightState(false);
	return array_keys($state);
}

// sets the alert state of a single light. 'select' blinks once, 'lselect' blinks repeatedly, 'none' turns off blinking
function alertLight($target, $type = 'select') {
		global $bridge, $key;
		$pest = new Pest("http://$bridge/api/$key/");
		$data = json_encode(array("alert" => $type));
		echo $data;
		$result = $pest->put("lights/$target/state", $data);

		return $result;
}

// function for setting the state property of one or more lights
function setLight($lightid, $input) {
	global $bridge, $key;
	$pest = new Pest("http://$bridge/api/$key/");
	$data = json_encode($input);

	if (is_array($lightid)) {
		foreach ($lightid as $id) {
			$pest = new Pest("http://$bridge/api/$key/");
			$result = $pest->put("lights/$id/state", $data);
		}
	} else {
		$result = $pest->put("lights/$lightid/state", $data);
	}
	return $result;
}

// gin up a random color
function getRandomColor() {
	$return = array();

	$return['hue'] = rand(0, 65535);
	$return['sat'] = rand(0,254);
	$return['bri'] = rand(0,254);

	return $return;
}

?>
