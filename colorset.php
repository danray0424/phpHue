#!/usr/bin/php
<?php

require("hue.php");

$args = getopt('l:h:s:b:t:o:');


// if we didn't get a -l parameter, build an array of all lights 
if (isset($args['l'])) {
	$light = $args['l'];
} else {
	$light = getLightIdsList();
}

// clean up other inputs
// the hue interface will keep numeric parms within range for us, just sanitize the
// types for clean json encoding, and do the math on the hue input.
$fields = array('l' => 'lights', 'h' => 'hue', 's' => 'sat', 'b' => 'bri', 't' => 'ct', 'o' => 'on');
$command = array();
foreach ($fields as $name => $value) {
	if (isset($args[$name])) {
        
        if ($name == 'o') {
            $command[$value] = (bool)$args[$name];
        }
		elseif ($name == 'h'){
			$command['hue'] = 182 * $args['h'];
            $command['on'] = true;
		}
        else {
            $command[$value] = (int)$args[$name];
            $command['on'] = true;
        } 
	}
}



$result = setLight($light, $command);

echo "$result\n";

?>
