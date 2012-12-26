#!/usr/bin/php
<?php

require("hue.php");

$args = getopt('l:h:s:b:t:');
if (isset($args['l'])) {
	$light = $args['l'];
} else {
	$light = array(1, 2, 3);
}

$fields = array('h' => 'hue', 's' => 'sat', 'b' => 'bri', 't' => 'ct');
$command = array();
foreach ($fields as $name => $value) {
	if (isset($args[$name])) {
		$command[$value] = 1 * $args[$name];
		if ($name == 'h'){
			$command['hue'] = 182 * $args['h'];
		}
	}
}

$result = setLight($light, $command);

echo "$result\n";

?>